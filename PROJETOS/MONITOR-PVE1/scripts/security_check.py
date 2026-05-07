#!/usr/bin/env python3
"""
Security Check
Verifica falhas SSH, IPs bloqueados, firewall e alertas
"""

import subprocess
import json
import re
import os
from datetime import datetime

def get_ssh_failures(limit=20):
    """Obter falhas de login SSH recentes"""
    failures = []
    auth_logs = ['/var/log/auth.log', '/var/log/secure']
    
    for log_file in auth_logs:
        if os.path.exists(log_file):
            try:
                result = subprocess.run(
                    ['grep', '-i', 'failed password', log_file],
                    capture_output=True, text=True, timeout=5
                )
                
                if result.returncode == 0:
                    lines = result.stdout.strip().split('\n')[-limit:]
                    
                    for line in lines:
                        # Extrair IP
                        ip_match = re.search(r'from\s+(\d+\.\d+\.\d+\.\d+)', line)
                        if ip_match:
                            failures.append({
                                'ip': ip_match.group(1),
                                'timestamp': line[:15] if len(line) > 15 else line,
                                'user': extract_username(line)
                            })
            except Exception as e:
                pass
    
    return failures

def extract_username(line):
    """Extrair nome de usuário da linha de log"""
    match = re.search(r'for\s+(\w+)\s+from', line)
    if match:
        return match.group(1)
    return 'unknown'

def get_blocked_ips():
    """Obter IPs bloqueados pelo fail2ban"""
    blocked = []
    
    try:
        # Status do fail2ban
        result = subprocess.run(
            ['fail2ban-client', 'status'],
            capture_output=True, text=True, timeout=5
        )
        
        if result.returncode == 0:
            # Extrair jails ativos
            jails_match = re.search(r'Jail list:\s+(.+)', result.stdout)
            if jails_match:
                jails = [j.strip() for j in jails_match.group(1).split(',')]
                
                for jail in jails:
                    try:
                        jail_status = subprocess.run(
                            ['fail2ban-client', 'status', jail],
                            capture_output=True, text=True, timeout=5
                        )
                        
                        if jail_status.returncode == 0:
                            banned_match = re.search(r'Currently banned:\s+(\d+)', jail_status.stdout)
                            if banned_match:
                                blocked.append({
                                    'source': f'fail2ban-{jail}',
                                    'count': int(banned_match.group(1))
                                })
                    except:
                        pass
    except Exception as e:
        pass
    
    return blocked

def get_firewall_status():
    """Obter status do firewall"""
    firewall = {
        'active': False,
        'rules_count': 0,
        'type': 'unknown'
    }
    
    # Tentar iptables
    try:
        result = subprocess.run(['iptables', '-L', '-n'], capture_output=True, text=True, timeout=5)
        if result.returncode == 0:
            firewall['active'] = True
            firewall['type'] = 'iptables'
            firewall['rules_count'] = len(result.stdout.strip().split('\n')) - 3
    except:
        pass
    
    # Tentar nftables
    if not firewall['active']:
        try:
            result = subprocess.run(['nft', 'list', 'ruleset'], capture_output=True, text=True, timeout=5)
            if result.returncode == 0:
                firewall['active'] = True
                firewall['type'] = 'nftables'
                firewall['rules_count'] = len(result.stdout.strip().split('\n'))
        except:
            pass
    
    # Tentar ufw
    if not firewall['active']:
        try:
            result = subprocess.run(['ufw', 'status'], capture_output=True, text=True, timeout=5)
            if result.returncode == 0 and 'active' in result.stdout.lower():
                firewall['active'] = True
                firewall['type'] = 'ufw'
        except:
            pass
    
    return firewall

def get_system_alerts(limit=10):
    """Obter alertas recentes do sistema"""
    alerts = []
    
    try:
        result = subprocess.run(
            ['dmesg', '-l', 'err,crit,alert,warn'],
            capture_output=True, text=True, timeout=5
        )
        
        if result.returncode == 0:
            lines = result.stdout.strip().split('\n')[-limit:]
            alerts = lines
    except Exception as e:
        pass
    
    return alerts

def get_failed_logins_summary():
    """Resumo de tentativas de login falhas por IP"""
    failures = get_ssh_failures(limit=100)
    
    ip_counts = {}
    for failure in failures:
        ip = failure['ip']
        ip_counts[ip] = ip_counts.get(ip, 0) + 1
    
    # Ordenar por contagem
    summary = [
        {'ip': ip, 'count': count}
        for ip, count in sorted(ip_counts.items(), key=lambda x: x[1], reverse=True)
    ]
    
    return summary[:10]  # Top 10 IPs

def main():
    """Coletar e exibir informações de segurança"""
    data = {
        'timestamp': datetime.now().isoformat(),
        'ssh_failures': get_ssh_failures(),
        'failed_logins_summary': get_failed_logins_summary(),
        'blocked_ips': get_blocked_ips(),
        'firewall': get_firewall_status(),
        'alerts': get_system_alerts()
    }
    
    print(json.dumps(data, indent=2))
    return data

if __name__ == '__main__':
    main()
