#!/usr/bin/env python3
"""
API Local de SMS - Usa seu plano da operadora via Android
Desenvolvido por Acib ABBADE para o ecossistema Dr_Finance

Instalação:
    pip install flask requests

Uso:
    python3 api-local.py

Endpoints:
    POST /send  - Enviar SMS
    GET  /status - Status do gateway
    GET  /messages - Mensagens recebidas
"""

from flask import Flask, request, jsonify
import requests
import json
import os
from datetime import datetime

app = Flask(__name__)

# Configurações (carregar de variáveis de ambiente ou arquivo)
SMS_GATEWAY_URL = os.getenv('SMS_GATEWAY_URL', 'http://192.168.0.100:8080')
SMS_GATEWAY_TOKEN = os.getenv('SMS_GATEWAY_TOKEN', 'sua-api-token-aqui')

# Logs de envio
LOG_FILE = '/root/.openclaw/workspace/skills/android-sms-gateway/sms-log.json'

def carregar_logs():
    """Carrega histórico de SMS enviados"""
    if os.path.exists(LOG_FILE):
        with open(LOG_FILE, 'r', encoding='utf-8') as f:
            return json.load(f)
    return []

def salvar_log(mensagem):
    """Salva log de SMS enviado"""
    logs = carregar_logs()
    logs.append(mensagem)
    # Manter apenas últimos 1000 registros
    logs = logs[-1000:]
    with open(LOG_FILE, 'w', encoding='utf-8') as f:
        json.dump(logs, f, indent=2, ensure_ascii=False)

@app.route('/send', methods=['POST'])
def enviar_sms():
    """
    Enviar SMS via Android Gateway
    
    Payload:
    {
        "to": "+5511999999999",
        "message": "Texto do SMS",
        "sim": 1  # Opcional: qual chip usar (1 ou 2)
    }
    """
    try:
        dados = request.get_json()
        
        if not dados:
            return jsonify({"erro": "JSON necessário"}), 400
        
        telefone = dados.get('to', dados.get('telefone', dados.get('numero')))
        mensagem = dados.get('message', dados.get('mensagem', dados.get('texto')))
        sim = dados.get('sim', 1)
        
        if not telefone or not mensagem:
            return jsonify({"erro": "Telefone e mensagem são obrigatórios"}), 400
        
        # Chamar API do Android
        url = f"{SMS_GATEWAY_URL}/api/v1/send"
        headers = {
            'Authorization': f'Bearer {SMS_GATEWAY_TOKEN}',
            'Content-Type': 'application/json'
        }
        payload = {
            'phoneNumber': telefone,
            'message': mensagem,
            'simSlot': sim
        }
        
        resposta = requests.post(url, json=payload, headers=headers, timeout=30)
        
        if resposta.status_code == 200:
            resultado = resposta.json()
            
            # Salvar log
            log_entry = {
                "timestamp": datetime.now().isoformat(),
                "telefone": telefone,
                "mensagem": mensagem,
                "status": "enviado",
                "detalhes": resultado
            }
            salvar_log(log_entry)
            
            return jsonify({
                "sucesso": True,
                "mensagem": "SMS enviado com sucesso",
                "dados": resultado
            })
        else:
            return jsonify({
                "sucesso": False,
                "erro": f"Erro na API: {resposta.status_code}",
                "detalhes": resposta.text
            }), 500
            
    except requests.exceptions.ConnectionError:
        return jsonify({
            "sucesso": False,
            "erro": "Não foi possível conectar ao Android Gateway",
            "dica": "Verifique se o app está rodando e o IP está correto"
        }), 503
    except Exception as e:
        return jsonify({
            "sucesso": False,
            "erro": str(e)
        }), 500

@app.route('/status', methods=['GET'])
def status():
    """Verifica status do gateway Android"""
    try:
        url = f"{SMS_GATEWAY_URL}/api/v1/status"
        headers = {'Authorization': f'Bearer {SMS_GATEWAY_TOKEN}'}
        resposta = requests.get(url, headers=headers, timeout=10)
        
        if resposta.status_code == 200:
            return jsonify({
                "gateway": "online",
                "url": SMS_GATEWAY_URL,
                "dados": resposta.json()
            })
        else:
            return jsonify({
                "gateway": "offline",
                "erro": f"Status: {resposta.status_code}"
            }), 503
    except Exception as e:
        return jsonify({
            "gateway": "offline",
            "erro": str(e)
        }), 503

@app.route('/messages', methods=['GET'])
def receber_mensagens():
    """Lista mensagens recebidas"""
    try:
        limite = request.args.get('limit', 10, type=int)
        url = f"{SMS_GATEWAY_URL}/api/v1/messages/received"
        headers = {'Authorization': f'Bearer {SMS_GATEWAY_TOKEN}'}
        params = {'limit': limite}
        
        resposta = requests.get(url, headers=headers, params=params, timeout=10)
        
        if resposta.status_code == 200:
            return jsonify({
                "sucesso": True,
                "mensagens": resposta.json()
            })
        else:
            return jsonify({
                "sucesso": False,
                "erro": f"Erro: {resposta.status_code}"
            }), 500
    except Exception as e:
        return jsonify({
            "sucesso": False,
            "erro": str(e)
        }), 503

@app.route('/logs', methods=['GET'])
def listar_logs():
    """Lista histórico de SMS enviados"""
    logs = carregar_logs()
    limite = request.args.get('limit', 50, type=int)
    return jsonify({
        "total": len(logs),
        "logs": logs[-limite:]
    })

@app.route('/', methods=['GET'])
def index():
    """Página inicial com documentação"""
    return jsonify({
        "nome": "API Local de SMS",
        "descricao": "Use seu plano de operadora via Android Gateway",
        "autor": "Acib ABBADE",
        "endpoints": {
            "POST /send": "Enviar SMS",
            "GET /status": "Status do gateway",
            "GET /messages": "Mensagens recebidas",
            "GET /logs": "Histórico de envios"
        },
        "exemplo_envio": {
            "curl": 'curl -X POST http://localhost:5000/send -H "Content-Type: application/json" -d \'{"to": "+5511999999999", "message": "Olá"}\''
        }
    })

if __name__ == '__main__':
    print("=" * 60)
    print("📱 API Local de SMS - Acib ABBADE")
    print("=" * 60)
    print(f"Gateway Android: {SMS_GATEWAY_URL}")
    print(f"Logs: {LOG_FILE}")
    print("=" * 60)
    print("Endpoints:")
    print("  POST /send     - Enviar SMS")
    print("  GET  /status   - Status do gateway")
    print("  GET  /messages - Mensagens recebidas")
    print("  GET  /logs     - Histórico de envios")
    print("=" * 60)
    print("Servindo em http://0.0.0.0:5000")
    print("=" * 60)
    
    app.run(host='0.0.0.0', port=5000, debug=False)
