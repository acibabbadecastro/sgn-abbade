#!/usr/bin/env python3
"""
Monitor PVE1 - Dashboard Backend
Flask API para monitoramento em tempo real do Proxmox PVE1
"""

from flask import Flask, jsonify, send_file
import subprocess
import json
import os
import sqlite3
from datetime import datetime
import re
from collections import deque
import threading

app = Flask(__name__)
DB_PATH = os.path.join(os.path.dirname(__file__), 'monitor.db')

# Histórico de tráfego de rede em memória (últimos 5 minutos)
# Estrutura: deque com timestamp e dados por porta
NETWORK_TRAFFIC_HISTORY = deque(maxlen=150)  # 150 * 2s = 5 minutos
TRAFFIC_HISTORY_LOCK = threading.Lock()

# Picos de tráfego por porta (histórico da sessão)
PORT_PEAKS = {}
PEAKS_LOCK = threading.Lock()

# Alertas de segurança recentes
SUSPICIOUS_ALERTS = deque(maxlen=50)
ALERTS_LOCK = threading.Lock()

def get_db():
    """Conectar ao banco SQLite"""
    conn = sqlite3.connect(DB_PATH)
    conn.row_factory = sqlite3.Row
    return conn

def init_db():
    """Inicializar banco de dados"""
    conn = get_db()
    cursor = conn.cursor()
    
    # Tabela para histórico de hardware
    cursor.execute('''
        CREATE TABLE IF NOT EXISTS hardware_history (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
            cpu_usage REAL,
            ram_usage REAL,
            disk_usage REAL,
            temperature REAL
        )
    ''')
    
    # Tabela para histórico de containers
    cursor.execute('''
        CREATE TABLE IF NOT EXISTS container_history (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
            ct_id INTEGER,
            status TEXT,
            cpu_usage REAL,
            ram_usage REAL
        )
    ''')
    
    conn.commit()
    conn.close()

@app.route('/')
def index():
    """Servir o frontend"""
    return send_file('index.html')

@app.route('/api/hardware')
def api_hardware():
    """
    Retorna estatísticas de hardware:
    - CPU usage
    - RAM usage
    - Disco usage
    - Temperatura (se disponível)
    - GPU status
    """
    try:
        # CPU
        cpu_usage = 0.0
        with open('/proc/stat', 'r') as f:
            line = f.readline()
            parts = line.split()
            if parts[0] == 'cpu':
                user, nice, system, idle = map(int, parts[1:5])
                total = user + nice + system + idle
                cpu_usage = round(((total - idle) / total) * 100, 2) if total > 0 else 0.0
        
        # RAM
        ram_usage = 0.0
        ram_total = 0
        ram_available = 0
        with open('/proc/meminfo', 'r') as f:
            for line in f:
                if line.startswith('MemTotal:'):
                    ram_total = int(line.split()[1])
                elif line.startswith('MemAvailable:'):
                    ram_available = int(line.split()[1])
        if ram_total > 0:
            ram_usage = round(((ram_total - ram_available) / ram_total) * 100, 2)
        
        # Disco
        disk_usage = 0.0
        result = subprocess.run(['df', '-h', '/'], capture_output=True, text=True)
        if result.returncode == 0:
            lines = result.stdout.strip().split('\n')
            if len(lines) >= 2:
                parts = lines[1].split()
                if len(parts) >= 5:
                    disk_usage = float(parts[4].replace('%', ''))
        
        # Temperatura (tentar lm-sensors)
        temperature = None
        try:
            result = subprocess.run(['sensors'], capture_output=True, text=True, timeout=5)
            if result.returncode == 0:
                # Procurar por Core 0 ou Tdie
                for line in result.stdout.split('\n'):
                    if 'Core 0' in line or 'Tdie' in line or 'Tctl' in line:
                        match = re.search(r'\+?(\d+\.\d+)°C', line)
                        if match:
                            temperature = float(match.group(1))
                            break
        except:
            pass
        
        # GPU (AMD RX 580)
        gpu_info = {'available': False, 'usage': None, 'memory': None, 'temp': None}
        try:
            result = subprocess.run(['rocm-smi', '--showalluse'], capture_output=True, text=True, timeout=5)
            if result.returncode == 0:
                gpu_info['available'] = True
                # Parse output do rocm-smi
                for line in result.stdout.split('\n'):
                    if 'GPU use' in line:
                        match = re.search(r'(\d+)%', line)
                        if match:
                            gpu_info['usage'] = int(match.group(1))
                    if 'GPU memory' in line:
                        match = re.search(r'(\d+)/(\d+)', line)
                        if match:
                            gpu_info['memory'] = f"{match.group(1)}/{match.group(2)} MB"
                    if 'Temperature' in line:
                        match = re.search(r'(\d+)C', line)
                        if match:
                            gpu_info['temp'] = int(match.group(1))
        except:
            # Tentar via /sys/class/drm
            try:
                if os.path.exists('/sys/class/drm/card0/device/hwmon'):
                    hwmon_dir = os.listdir('/sys/class/drm/card0/device/hwmon')[0]
                    temp_file = f'/sys/class/drm/card0/device/hwmon/{hwmon_dir}/temp1_input'
                    if os.path.exists(temp_file):
                        with open(temp_file, 'r') as f:
                            gpu_info['temp'] = int(f.read().strip()) / 1000
                            gpu_info['available'] = True
            except:
                pass
        
        data = {
            'timestamp': datetime.now().isoformat(),
            'cpu': cpu_usage,
            'ram': ram_usage,
            'disk': disk_usage,
            'temperature': temperature,
            'gpu': gpu_info
        }
        
        # Salvar no histórico
        try:
            conn = get_db()
            cursor = conn.cursor()
            cursor.execute('''
                INSERT INTO hardware_history (cpu_usage, ram_usage, disk_usage, temperature)
                VALUES (?, ?, ?, ?)
            ''', (cpu_usage, ram_usage, disk_usage, temperature))
            conn.commit()
            conn.close()
        except:
            pass
        
        return jsonify(data)
    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/api/containers')
def api_containers():
    """
    Retorna status dos containers Proxmox (CT 100-112)
    Usa o comando 'pct' do Proxmox
    """
    containers = []
    
    try:
        # Listar todos os containers
        result = subprocess.run(['pct', 'list'], capture_output=True, text=True, timeout=10)
        
        if result.returncode == 0:
            lines = result.stdout.strip().split('\n')
            
            # Pular cabeçalho
            for line in lines[1:]:
                parts = line.split()
                if len(parts) >= 4:
                    ct_id = int(parts[0])
                    
                    # Filtrar apenas CTs 100-112
                    if 100 <= ct_id <= 112:
                        status = parts[1]
                        name = parts[2] if len(parts) > 2 else f'CT{ct_id}'
                        
                        # Tentar pegar CPU e RAM usage
                        cpu_usage = 0.0
                        ram_usage = 0.0
                        
                        try:
                            status_result = subprocess.run(
                                ['pct', 'status', str(ct_id)],
                                capture_output=True, text=True, timeout=5
                            )
                            if status_result.returncode == 0:
                                for sline in status_result.stdout.split('\n'):
                                    if 'cpu' in sline.lower():
                                        match = re.search(r'cpu\s*[:=]\s*(\d+\.?\d*)', sline, re.IGNORECASE)
                                        if match:
                                            cpu_usage = float(match.group(1))
                                    if 'mem' in sline.lower():
                                        match = re.search(r'mem\s*[:=]\s*(\d+\.?\d*)', sline, re.IGNORECASE)
                                        if match:
                                            ram_usage = float(match.group(1))
                        except:
                            pass
                        
                        containers.append({
                            'id': ct_id,
                            'name': name,
                            'status': status,
                            'cpu': cpu_usage,
                            'ram': ram_usage
                        })
        
        # Ordenar por ID
        containers.sort(key=lambda x: x['id'])
        
        # Salvar no histórico
        try:
            conn = get_db()
            cursor = conn.cursor()
            for ct in containers:
                cursor.execute('''
                    INSERT INTO container_history (ct_id, status, cpu_usage, ram_usage)
                    VALUES (?, ?, ?, ?)
                ''', (ct['id'], ct['status'], ct['cpu'], ct['ram']))
            conn.commit()
            conn.close()
        except:
            pass
        
        return jsonify({
            'timestamp': datetime.now().isoformat(),
            'containers': containers
        })
    
    except Exception as e:
        return jsonify({'error': str(e), 'containers': []}), 500

@app.route('/api/network')
def api_network():
    """
    Retorna informações de rede:
    - Portas abertas
    - Conexões ativas
    - Tráfego de rede
    - Velocidade da internet (speedtest)
    """
    try:
        # Portas abertas (listening)
        open_ports = []
        result = subprocess.run(['ss', '-tlnp'], capture_output=True, text=True, timeout=5)
        if result.returncode == 0:
            for line in result.stdout.split('\n')[1:]:
                parts = line.split()
                if len(parts) >= 5:
                    local_addr = parts[4]
                    if ':' in local_addr:
                        port = local_addr.split(':')[-1]
                        if port.isdigit():
                            process = parts[-1] if len(parts) > 5 else 'unknown'
                            open_ports.append({'port': int(port), 'address': local_addr, 'process': process})
        
        # Conexões ativas
        active_connections = 0
        result = subprocess.run(['ss', '-tun'], capture_output=True, text=True, timeout=5)
        if result.returncode == 0:
            active_connections = len(result.stdout.strip().split('\n')) - 1
        
        # Tráfego de rede (bytes recebidos/transmitidos)
        network_traffic = {'rx': 0, 'tx': 0, 'interfaces': []}
        if os.path.exists('/proc/net/dev'):
            with open('/proc/net/dev', 'r') as f:
                for line in f:
                    if ':' in line:
                        parts = line.split(':')
                        iface = parts[0].strip()
                        if iface not in ['lo', 'face']:
                            stats = parts[1].split()
                            if len(stats) >= 9:
                                rx_bytes = int(stats[0])
                                tx_bytes = int(stats[8])
                                network_traffic['interfaces'].append({
                                    'name': iface,
                                    'rx_bytes': rx_bytes,
                                    'tx_bytes': tx_bytes
                                })
                                network_traffic['rx'] += rx_bytes
                                network_traffic['tx'] += tx_bytes
        
        # Speedtest (último resultado do histórico ou executar novo)
        speedtest = None
        speedtest_file = os.path.join(os.path.dirname(__file__), 'speedtest.json')
        if os.path.exists(speedtest_file):
            try:
                with open(speedtest_file, 'r') as f:
                    data = json.load(f)
                    # Verificar se não é muito antigo (max 1 hora)
                    if datetime.fromisoformat(data.get('timestamp', '1970-01-01')) > datetime.now():
                        speedtest = data
            except:
                pass
        
        return jsonify({
            'timestamp': datetime.now().isoformat(),
            'open_ports': open_ports,
            'active_connections': active_connections,
            'traffic': network_traffic,
            'speedtest': speedtest
        })
    
    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/api/security')
def api_security():
    """
    Retorna informações de segurança:
    - Falhas SSH
    - IPs bloqueados (fail2ban)
    - Status do firewall
    - Alertas recentes
    """
    try:
        # Falhas SSH (últimas 100 linhas do auth.log)
        ssh_failures = []
        auth_logs = ['/var/log/auth.log', '/var/log/secure']
        
        for log_file in auth_logs:
            if os.path.exists(log_file):
                try:
                    result = subprocess.run(
                        ['grep', '-i', 'failed password', log_file],
                        capture_output=True, text=True, timeout=5
                    )
                    if result.returncode == 0:
                        lines = result.stdout.strip().split('\n')[-20:]  # Últimas 20
                        for line in lines:
                            # Extrair IP
                            ip_match = re.search(r'from\s+(\d+\.\d+\.\d+\.\d+)', line)
                            if ip_match:
                                ssh_failures.append({
                                    'ip': ip_match.group(1),
                                    'timestamp': line[:15] if len(line) > 15 else line
                                })
                except:
                    pass
        
        # IPs bloqueados pelo fail2ban
        blocked_ips = []
        try:
            result = subprocess.run(
                ['fail2ban-client', 'status', 'sshd'],
                capture_output=True, text=True, timeout=5
            )
            if result.returncode == 0:
                for line in result.stdout.split('\n'):
                    if 'Currently banned' in line:
                        match = re.search(r':\s*(\d+)', line)
                        if match:
                            blocked_ips.append({'source': 'fail2ban-sshd', 'count': int(match.group(1))})
        except:
            pass
        
        # Firewall status (iptables/nftables)
        firewall = {'active': False, 'rules_count': 0}
        try:
            result = subprocess.run(['iptables', '-L', '-n'], capture_output=True, text=True, timeout=5)
            if result.returncode == 0:
                firewall['active'] = True
                firewall['rules_count'] = len(result.stdout.strip().split('\n')) - 3  # Subtrair cabeçalhos
        except:
            pass
        
        # Alertas recentes (dmesg)
        alerts = []
        try:
            result = subprocess.run(['dmesg', '-l', 'err,crit,alert'], capture_output=True, text=True, timeout=5)
            if result.returncode == 0:
                lines = result.stdout.strip().split('\n')[-10:]  # Últimos 10 alertas
                for line in lines:
                    alerts.append(line)
        except:
            pass
        
        return jsonify({
            'timestamp': datetime.now().isoformat(),
            'ssh_failures': ssh_failures,
            'blocked_ips': blocked_ips,
            'firewall': firewall,
            'alerts': alerts
        })
    
    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/api/speedtest', methods=['POST'])
def api_speedtest():
    """Executar speedtest e salvar resultado"""
    try:
        result = subprocess.run(['speedtest', '--json'], capture_output=True, text=True, timeout=60)
        
        if result.returncode == 0:
            data = json.loads(result.stdout)
            speedtest_data = {
                'timestamp': datetime.now().isoformat(),
                'download': data.get('download', 0) / 1_000_000,  # Mbps
                'upload': data.get('upload', 0) / 1_000_000,  # Mbps
                'ping': data.get('ping', 0)
            }
            
            # Salvar em arquivo
            speedtest_file = os.path.join(os.path.dirname(__file__), 'speedtest.json')
            with open(speedtest_file, 'w') as f:
                json.dump(speedtest_data, f)
            
            return jsonify(speedtest_data)
        else:
            return jsonify({'error': 'Speedtest failed'}), 500
    
    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/api/history/hardware')
def api_history_hardware():
    """Retornar histórico de hardware (últimas 24h)"""
    try:
        conn = get_db()
        cursor = conn.cursor()
        cursor.execute('''
            SELECT * FROM hardware_history 
            WHERE timestamp >= datetime('now', '-24 hours')
            ORDER BY timestamp DESC
            LIMIT 288  -- 288 * 5min = 24h
        ''')
        rows = cursor.fetchall()
        conn.close()
        
        history = []
        for row in rows:
            history.append({
                'timestamp': row['timestamp'],
                'cpu': row['cpu_usage'],
                'ram': row['ram_usage'],
                'disk': row['disk_usage'],
                'temperature': row['temperature']
            })
        
        return jsonify(history)
    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/api/network/traffic')
def api_network_traffic():
    """
    Retorna tráfego de rede por porta em tempo real:
    - Top 10 portas por tráfego
    - Histórico dos últimos 5 minutos
    - Picos de tráfego por porta
    """
    try:
        # Importar funções do script network_monitor
        import sys
        sys.path.insert(0, os.path.join(os.path.dirname(__file__), 'scripts'))
        from network_monitor import get_traffic_by_port, get_top_connections
        
        # Coletar tráfego atual por porta
        traffic_by_port = get_traffic_by_port()
        
        # Atualizar picos
        with PEAKS_LOCK:
            for port, data in traffic_by_port.items():
                if port not in PORT_PEAKS:
                    PORT_PEAKS[port] = {'upload': 0, 'download': 0, 'total': 0}
                PORT_PEAKS[port]['upload'] = max(PORT_PEAKS[port]['upload'], data.get('upload', 0))
                PORT_PEAKS[port]['download'] = max(PORT_PEAKS[port]['download'], data.get('download', 0))
                PORT_PEAKS[port]['total'] = max(PORT_PEAKS[port]['total'], data.get('total', 0))
        
        # Adicionar ao histórico
        with TRAFFIC_HISTORY_LOCK:
            NETWORK_TRAFFIC_HISTORY.append({
                'timestamp': datetime.now().isoformat(),
                'ports': traffic_by_port
            })
        
        # Preparar dados para o gráfico de linhas (últimos 5 minutos)
        history_data = []
        with TRAFFIC_HISTORY_LOCK:
            for entry in list(NETWORK_TRAFFIC_HISTORY)[-150:]:
                history_data.append(entry)
        
        # Preparar dados de picos
        peaks_data = []
        with PEAKS_LOCK:
            for port, peak in PORT_PEAKS.items():
                peaks_data.append({
                    'port': port,
                    'upload': peak['upload'],
                    'download': peak['download'],
                    'total': peak['total']
                })
        peaks_data.sort(key=lambda x: x['total'], reverse=True)
        
        # Top conexões
        top_connections = get_top_connections(limit=20)
        
        return jsonify({
            'timestamp': datetime.now().isoformat(),
            'current_traffic': traffic_by_port,
            'history': history_data,
            'peaks': peaks_data,
            'top_connections': top_connections
        })
    
    except Exception as e:
        return jsonify({'error': str(e)}), 500

@app.route('/api/network/suspicious')
def api_network_suspicious():
    """
    Retorna alertas de segurança de rede:
    - Portas incomuns abertas (>10000)
    - Conexões de IPs externos não usuais
    - Tráfego anômalo (picos >3x média)
    - Tentativas de conexão em portas fechadas
    """
    try:
        import sys
        sys.path.insert(0, os.path.join(os.path.dirname(__file__), 'scripts'))
        from network_monitor import detect_suspicious_activity
        
        alerts = detect_suspicious_activity()
        
        # Adicionar alertas recentes ao histórico
        with ALERTS_LOCK:
            for alert in alerts:
                SUSPICIOUS_ALERTS.append({
                    'timestamp': datetime.now().isoformat(),
                    **alert
                })
        
        # Retornar últimos 50 alertas
        with ALERTS_LOCK:
            recent_alerts = list(SUSPICIOUS_ALERTS)
        
        return jsonify({
            'timestamp': datetime.now().isoformat(),
            'current_alerts': alerts,
            'recent_alerts': recent_alerts,
            'alert_count': len(alerts)
        })
    
    except Exception as e:
        return jsonify({'error': str(e)}), 500

if __name__ == '__main__':
    init_db()
    app.run(host='0.0.0.0', port=5000, debug=False)
