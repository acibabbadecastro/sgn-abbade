#!/usr/bin/env python3
"""
Container Status Collector
Coleta status dos containers Proxmox (CT 100-112)
"""

import subprocess
import json
import re
from datetime import datetime

def get_container_status(ct_id):
    """Obter status de um container específico"""
    try:
        result = subprocess.run(
            ['pct', 'status', str(ct_id)],
            capture_output=True, text=True, timeout=5
        )
        
        if result.returncode == 0:
            status_info = {
                'id': ct_id,
                'status': 'unknown',
                'cpu': 0.0,
                'ram': 0.0
            }
            
            for line in result.stdout.split('\n'):
                line = line.strip()
                
                # Status (running/stopped)
                if line.startswith('status:'):
                    status_info['status'] = line.split(':')[1].strip()
                
                # CPU usage
                if 'cpu' in line.lower():
                    match = re.search(r'cpu\s*[:=]\s*(\d+\.?\d*)', line, re.IGNORECASE)
                    if match:
                        status_info['cpu'] = float(match.group(1))
                
                # RAM usage
                if 'mem' in line.lower():
                    match = re.search(r'mem\s*[:=]\s*(\d+\.?\d*)', line, re.IGNORECASE)
                    if match:
                        status_info['ram'] = float(match.group(1))
            
            return status_info
    except Exception as e:
        pass
    
    return {'id': ct_id, 'status': 'error', 'cpu': 0.0, 'ram': 0.0}

def list_all_containers():
    """Listar todos os containers"""
    containers = []
    
    try:
        result = subprocess.run(['pct', 'list'], capture_output=True, text=True, timeout=10)
        
        if result.returncode == 0:
            lines = result.stdout.strip().split('\n')
            
            # Pular cabeçalho
            for line in lines[1:]:
                parts = line.split()
                if len(parts) >= 3:
                    ct_id = int(parts[0])
                    
                    # Filtrar apenas CTs 100-112
                    if 100 <= ct_id <= 112:
                        status = parts[1]
                        name = parts[2] if len(parts) > 2 else f'CT{ct_id}'
                        
                        # Obter detalhes
                        details = get_container_status(ct_id)
                        details['name'] = name
                        
                        containers.append(details)
    except Exception as e:
        pass
    
    # Ordenar por ID
    containers.sort(key=lambda x: x['id'])
    return containers

def main():
    """Coletar e exibir status de todos os containers"""
    containers = list_all_containers()
    
    data = {
        'timestamp': datetime.now().isoformat(),
        'containers': containers,
        'total': len(containers),
        'running': sum(1 for c in containers if c['status'] == 'running'),
        'stopped': sum(1 for c in containers if c['status'] == 'stopped')
    }
    
    print(json.dumps(data, indent=2))
    return data

if __name__ == '__main__':
    main()
