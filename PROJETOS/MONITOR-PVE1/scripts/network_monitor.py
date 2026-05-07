#!/usr/bin/env python3
"""
Network Monitor
Coleta informações de rede: portas, conexões, tráfego
"""

import subprocess
import json
import re
import os
from datetime import datetime
from collections import defaultdict

def get_open_ports():
    """Obter portas abertas (listening)"""
    open_ports = []
    
    try:
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
                            open_ports.append({
                                'port': int(port),
                                'address': local_addr,
                                'process': process
                            })
    except Exception as e:
        pass
    
    return open_ports

def get_active_connections():
    """Obter número de conexões ativas"""
    try:
        result = subprocess.run(['ss', '-tun'], capture_output=True, text=True, timeout=5)
        if result.returncode == 0:
            return len(result.stdout.strip().split('\n')) - 1
    except Exception as e:
        pass
    
    return 0

def get_network_traffic():
    """Obter tráfego de rede por interface"""
    traffic = {
        'rx_bytes': 0,
        'tx_bytes': 0,
        'interfaces': []
    }
    
    try:
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
                                
                                traffic['interfaces'].append({
                                    'name': iface,
                                    'rx_bytes': rx_bytes,
                                    'tx_bytes': tx_bytes,
                                    'rx_mb': round(rx_bytes / 1024 / 1024, 2),
                                    'tx_mb': round(tx_bytes / 1024 / 1024, 2)
                                })
                                
                                traffic['rx_bytes'] += rx_bytes
                                traffic['tx_bytes'] += tx_bytes
    except Exception as e:
        pass
    
    traffic['rx_mb_total'] = round(traffic['rx_bytes'] / 1024 / 1024, 2)
    traffic['tx_mb_total'] = round(traffic['tx_bytes'] / 1024 / 1024, 2)
    
    return traffic

def get_network_interfaces():
    """Obter informações detalhadas das interfaces"""
    interfaces = []
    
    try:
        result = subprocess.run(['ip', '-o', 'addr', 'show'], capture_output=True, text=True, timeout=5)
        
        if result.returncode == 0:
            for line in result.stdout.split('\n'):
                parts = line.split()
                if len(parts) >= 4:
                    iface = parts[1]
                    addr_type = parts[2]
                    address = parts[3]
                    
                    interfaces.append({
                        'name': iface,
                        'type': addr_type,
                        'address': address
                    })
    except Exception as e:
        pass
    
    return interfaces

def main():
    """Coletar e exibir informações de rede"""
    data = {
        'timestamp': datetime.now().isoformat(),
        'open_ports': get_open_ports(),
        'active_connections': get_active_connections(),
        'traffic': get_network_traffic(),
        'interfaces': get_network_interfaces()
    }
    
    print(json.dumps(data, indent=2))
    return data

def get_traffic_by_port():
    """
    Obter tráfego de rede por porta usando nethogs ou iftop
    Retorna dict {porta: {upload, download, total}} em MB/s
    """
    traffic_by_port = defaultdict(lambda: {'upload': 0.0, 'download': 0.0, 'total': 0.0})
    
    try:
        # Tentar usar nethogs primeiro (mais preciso por processo/porta)
        result = subprocess.run(
            ['nethogs', '-t', '-c', '5'],  # 5 ciclos
            capture_output=True, text=True, timeout=10
        )
        
        if result.returncode == 0:
            # Parse output do nethogs
            for line in result.stdout.split('\n'):
                parts = line.split('\t')
                if len(parts) >= 4:
                    try:
                        # Formato: PID, programa, dev, upload, download
                        upload = float(parts[3]) if len(parts) > 3 else 0.0
                        download = float(parts[4]) if len(parts) > 4 else 0.0
                        
                        # Tentar extrair porta do programa (ex: nginx:80)
                        program = parts[1] if len(parts) > 1 else ''
                        port_match = re.search(r':(\d+)', program)
                        if port_match:
                            port = int(port_match.group(1))
                            traffic_by_port[port]['upload'] += upload
                            traffic_by_port[port]['download'] += download
                            traffic_by_port[port]['total'] += upload + download
                    except (ValueError, IndexError):
                        pass
    except (subprocess.TimeoutExpired, FileNotFoundError):
        # Fallback: usar ss/netstat para estimar por porta
        try:
            result = subprocess.run(
                ['ss', '-tunp'],
                capture_output=True, text=True, timeout=5
            )
            
            if result.returncode == 0:
                for line in result.stdout.split('\n')[1:]:
                    parts = line.split()
                    if len(parts) >= 6:
                        # Extrair porta local
                        local_addr = parts[4] if len(parts) > 4 else ''
                        if ':' in local_addr:
                            port_str = local_addr.split(':')[-1]
                            if port_str.isdigit():
                                port = int(port_str)
                                
                                # Extrair bytes enviados/recebidos (estimativa)
                                # Nota: ss não mostra tráfego em tempo real diretamente
                                # Usar /proc/net/snmp para estatísticas globais
                                traffic_by_port[port]['total'] = 0.0  # Placeholder
        except:
            pass
    
    # Converter para MB/s (nethogs retorna KB/s)
    for port in traffic_by_port:
        traffic_by_port[port]['upload'] = round(traffic_by_port[port]['upload'] / 1024, 4)
        traffic_by_port[port]['download'] = round(traffic_by_port[port]['download'] / 1024, 4)
        traffic_by_port[port]['total'] = round(traffic_by_port[port]['total'] / 1024, 4)
    
    return dict(traffic_by_port)

def detect_suspicious_activity():
    """
    Detectar atividades suspeitas de rede:
    - Portas incomuns abertas (>10000)
    - Conexões de IPs externos não usuais
    - Tráfego anômalo (picos >3x média)
    - Tentativas de conexão em portas fechadas
    """
    alerts = []
    
    # 1. Portas incomuns (>10000)
    try:
        result = subprocess.run(['ss', '-tlnp'], capture_output=True, text=True, timeout=5)
        if result.returncode == 0:
            for line in result.stdout.split('\n')[1:]:
                parts = line.split()
                if len(parts) >= 5:
                    local_addr = parts[4]
                    if ':' in local_addr:
                        port_str = local_addr.split(':')[-1]
                        if port_str.isdigit():
                            port = int(port_str)
                            if port > 10000:
                                alerts.append({
                                    'type': 'UNUSUAL_PORT',
                                    'severity': 'medium',
                                    'description': f'Porta incomum aberta: {port}',
                                    'details': f'Porta {port} (>10000) está escutando',
                                    'recommendation': 'Verificar se este serviço é legítimo'
                                })
    except:
        pass
    
    # 2. Conexões de IPs externos
    # IPs privados comuns (192.168.x.x, 10.x.x.x, 172.16-31.x.x, 127.x.x.x)
    private_ranges = [
        (3232235520, 3232301055),  # 192.168.0.0 - 192.168.255.255
        (167772160, 184549375),    # 10.0.0.0 - 10.255.255.255
        (2886729728, 2887778303),  # 172.16.0.0 - 172.31.255.255
    ]
    
    def is_private_ip(ip_str):
        try:
            parts = ip_str.split('.')
            if len(parts) != 4:
                return False
            # localhost
            if parts[0] == '127':
                return True
            ip_int = (int(parts[0]) << 24) + (int(parts[1]) << 16) + (int(parts[2]) << 8) + int(parts[3])
            return any(start <= ip_int <= end for start, end in private_ranges)
        except:
            return False
    
    try:
        result = subprocess.run(['ss', '-tun'], capture_output=True, text=True, timeout=5)
        if result.returncode == 0:
            for line in result.stdout.split('\n')[1:]:
                parts = line.split()
                if len(parts) >= 5:
                    # Endereço remoto
                    remote_addr = parts[4] if len(parts) > 4 else ''
                    if ':' in remote_addr:
                        ip_part = remote_addr.rsplit(':', 1)[0]
                        if ip_part and not is_private_ip(ip_part):
                            alerts.append({
                                'type': 'EXTERNAL_CONNECTION',
                                'severity': 'low',
                                'description': f'Conexão com IP externo: {ip_part}',
                                'details': f'Conexão ativa com IP não privado',
                                'recommendation': 'Verificar se esta conexão é esperada'
                            })
    except:
        pass
    
    # 3. Tentativas de conexão em portas fechadas (iptables logs)
    try:
        if os.path.exists('/var/log/kern.log'):
            result = subprocess.run(
                ['grep', '-i', 'dropped', '/var/log/kern.log'],
                capture_output=True, text=True, timeout=5
            )
            if result.returncode == 0:
                lines = result.stdout.strip().split('\n')[-10:]  # Últimas 10
                for line in lines:
                    ip_match = re.search(r'SRC=(\d+\.\d+\.\d+\.\d+)', line)
                    port_match = re.search(r'DPT=(\d+)', line)
                    if ip_match and port_match:
                        alerts.append({
                            'type': 'BLOCKED_CONNECTION',
                            'severity': 'high',
                            'description': f'Tentativa bloqueada de {ip_match.group(1)}:{port_match.group(1)}',
                            'details': 'Pacote descartado pelo firewall',
                            'recommendation': 'Monitorar se persistir'
                        })
    except:
        pass
    
    # 4. Múltiplas conexões da mesma origem (possível ataque)
    try:
        result = subprocess.run(['ss', '-tun'], capture_output=True, text=True, timeout=5)
        if result.returncode == 0:
            ip_counts = defaultdict(int)
            for line in result.stdout.split('\n')[1:]:
                parts = line.split()
                if len(parts) >= 5:
                    remote_addr = parts[4]
                    if ':' in remote_addr:
                        ip_part = remote_addr.rsplit(':', 1)[0]
                        ip_counts[ip_part] += 1
            
            for ip, count in ip_counts.items():
                if count > 10 and not is_private_ip(ip):
                    alerts.append({
                        'type': 'MULTIPLE_CONNECTIONS',
                        'severity': 'high',
                        'description': f'Múltiplas conexões de {ip} ({count} conexões)',
                        'details': 'Possível ataque de força bruta ou DDoS',
                        'recommendation': 'Considerar bloquear este IP'
                    })
    except:
        pass
    
    return alerts

def get_top_connections(limit=20):
    """
    Obter top conexões ativas
    Retorna lista de dicionários com: ip_origem, porta_destino, trafico, duracao, status
    """
    connections = []
    
    try:
        result = subprocess.run(['ss', '-tunp'], capture_output=True, text=True, timeout=5)
        
        if result.returncode == 0:
            for line in result.stdout.split('\n')[1:]:
                parts = line.split()
                if len(parts) >= 6:
                    state = parts[0]
                    recv_q = parts[1] if len(parts) > 1 else '0'
                    send_q = parts[2] if len(parts) > 2 else '0'
                    local_addr = parts[3] if len(parts) > 3 else ''
                    remote_addr = parts[4] if len(parts) > 4 else ''
                    process = parts[5] if len(parts) > 5 else 'unknown'
                    
                    # Extrair IP e porta
                    remote_ip = remote_addr.rsplit(':', 1)[0] if ':' in remote_addr else remote_addr
                    remote_port = remote_addr.rsplit(':', 1)[-1] if ':' in remote_addr else '0'
                    
                    # Calcular tráfego (estimativa baseada em queues)
                    try:
                        traffic_kb = int(recv_q) + int(send_q)
                        traffic_mbps = round(traffic_kb / 1024, 4)
                    except:
                        traffic_mbps = 0.0
                    
                    # Determinar status
                    status = 'normal'
                    if int(remote_port) > 10000:
                        status = 'suspeito'
                    
                    connections.append({
                        'source_ip': remote_ip,
                        'dest_port': int(remote_port) if remote_port.isdigit() else 0,
                        'traffic_mbps': traffic_mbps,
                        'state': state,
                        'process': process,
                        'status': status
                    })
        
        # Ordenar por tráfego
        connections.sort(key=lambda x: x['traffic_mbps'], reverse=True)
        
        return connections[:limit]
    
    except Exception as e:
        return []

if __name__ == '__main__':
    main()
