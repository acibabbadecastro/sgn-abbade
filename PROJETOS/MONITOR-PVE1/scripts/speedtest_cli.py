#!/usr/bin/env python3
"""
Speedtest CLI
Executa teste de velocidade da internet e salva resultado
"""

import subprocess
import json
import os
from datetime import datetime

SPEEDTEST_FILE = os.path.join(os.path.dirname(__file__), 'speedtest.json')

def run_speedtest():
    """Executar speedtest e retornar resultado"""
    try:
        # Tentar speedtest-cli (Ookla)
        result = subprocess.run(
            ['speedtest', '--json'],
            capture_output=True, text=True, timeout=60
        )
        
        if result.returncode == 0:
            data = json.loads(result.stdout)
            
            return {
                'success': True,
                'timestamp': datetime.now().isoformat(),
                'download_mbps': round(data.get('download', 0) / 1_000_000, 2),
                'upload_mbps': round(data.get('upload', 0) / 1_000_000, 2),
                'ping_ms': data.get('ping', 0),
                'server': data.get('server', {}).get('name', 'Unknown'),
                'isp': data.get('client', {}).get('isp', 'Unknown')
            }
    except FileNotFoundError:
        pass
    except Exception as e:
        pass
    
    # Alternativa: usar curl com API do speedtest.net
    try:
        # Download test (usando arquivo de teste)
        download_result = subprocess.run(
            ['curl', '-o', '/dev/null', '-w', '%{speed_download}', 
             'http://speedtest.tele2.net/10MB.zip', '--max-time', '15'],
            capture_output=True, text=True, timeout=20
        )
        
        # Upload test (simulado - na verdade não temos como testar upload facilmente via CLI)
        upload_mbps = 0.0
        
        if download_result.returncode == 0:
            download_bytes = float(download_result.stdout.strip())
            download_mbps = round((download_bytes * 8) / 1_000_000, 2)
            
            return {
                'success': True,
                'timestamp': datetime.now().isoformat(),
                'download_mbps': download_mbps,
                'upload_mbps': upload_mbps,
                'ping_ms': 0,
                'server': 'Tele2 (fallback)',
                'isp': 'Unknown',
                'note': 'Fallback method - may be less accurate'
            }
    except Exception as e:
        pass
    
    return {
        'success': False,
        'error': 'Speedtest not available or failed',
        'timestamp': datetime.now().isoformat()
    }

def load_last_result():
    """Carregar último resultado salvo"""
    if os.path.exists(SPEEDTEST_FILE):
        try:
            with open(SPEEDTEST_FILE, 'r') as f:
                return json.load(f)
        except:
            pass
    return None

def save_result(result):
    """Salvar resultado em arquivo"""
    with open(SPEEDTEST_FILE, 'w') as f:
        json.dump(result, f, indent=2)

def main():
    """Executar speedtest e exibir resultado"""
    import sys
    
    if len(sys.argv) > 1 and sys.argv[1] == '--last':
        # Apenas mostrar último resultado
        last = load_last_result()
        if last:
            print(json.dumps(last, indent=2))
        else:
            print(json.dumps({'error': 'No previous result found'}))
    else:
        # Executar novo teste
        result = run_speedtest()
        
        if result['success']:
            save_result(result)
        
        print(json.dumps(result, indent=2))
    
    return result

if __name__ == '__main__':
    main()
