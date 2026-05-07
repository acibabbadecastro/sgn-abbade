#!/usr/bin/env python3
"""
Hardware Stats Collector
Coleta estatísticas de CPU, RAM, Disco e Temperatura
"""

import subprocess
import json
import re
import os
from datetime import datetime

def get_cpu_usage():
    """Obter uso de CPU"""
    try:
        with open('/proc/stat', 'r') as f:
            line = f.readline()
            parts = line.split()
            if parts[0] == 'cpu':
                user, nice, system, idle = map(int, parts[1:5])
                total = user + nice + system + idle
                return round(((total - idle) / total) * 100, 2) if total > 0 else 0.0
    except Exception as e:
        return 0.0

def get_ram_usage():
    """Obter uso de RAM"""
    try:
        ram_total = 0
        ram_available = 0
        with open('/proc/meminfo', 'r') as f:
            for line in f:
                if line.startswith('MemTotal:'):
                    ram_total = int(line.split()[1])
                elif line.startswith('MemAvailable:'):
                    ram_available = int(line.split()[1])
        
        if ram_total > 0:
            return round(((ram_total - ram_available) / ram_total) * 100, 2)
        return 0.0
    except Exception as e:
        return 0.0

def get_disk_usage():
    """Obter uso de disco"""
    try:
        result = subprocess.run(['df', '-h', '/'], capture_output=True, text=True)
        if result.returncode == 0:
            lines = result.stdout.strip().split('\n')
            if len(lines) >= 2:
                parts = lines[1].split()
                if len(parts) >= 5:
                    return float(parts[4].replace('%', ''))
        return 0.0
    except Exception as e:
        return 0.0

def get_temperature():
    """Obter temperatura do sistema"""
    try:
        # Tentar lm-sensors
        result = subprocess.run(['sensors'], capture_output=True, text=True, timeout=5)
        if result.returncode == 0:
            for line in result.stdout.split('\n'):
                if 'Core 0' in line or 'Tdie' in line or 'Tctl' in line:
                    match = re.search(r'\+?(\d+\.\d+)°C', line)
                    if match:
                        return float(match.group(1))
        
        # Tentar via sys/class/thermal
        for i in range(10):
            temp_file = f'/sys/class/thermal/thermal_zone{i}/temp'
            if os.path.exists(temp_file):
                with open(temp_file, 'r') as f:
                    temp = int(f.read().strip()) / 1000
                    if 0 < temp < 150:  # Temperatura razoável
                        return temp
    except Exception as e:
        pass
    
    return None

def get_gpu_info():
    """Obter informações da GPU AMD"""
    gpu_info = {
        'available': False,
        'usage': None,
        'memory': None,
        'temp': None
    }
    
    try:
        # Tentar rocm-smi
        result = subprocess.run(['rocm-smi', '--showalluse'], capture_output=True, text=True, timeout=5)
        if result.returncode == 0:
            gpu_info['available'] = True
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
        pass
    
    # Tentar via sys/class/drm
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
    
    return gpu_info

def main():
    """Coletar e exibir estatísticas de hardware"""
    data = {
        'timestamp': datetime.now().isoformat(),
        'cpu': get_cpu_usage(),
        'ram': get_ram_usage(),
        'disk': get_disk_usage(),
        'temperature': get_temperature(),
        'gpu': get_gpu_info()
    }
    
    print(json.dumps(data, indent=2))
    return data

if __name__ == '__main__':
    main()
