#!/usr/bin/env python3
"""
SGN - Bot de Monitoramento de Emails
Verifica emails de remetentes importantes (ex: Prefeitura)
Envia alertas quando detectar palavras-chave como "pedido de compras"

Execução: python3 monitor_email.py
Cron: */5 * * * * /usr/bin/python3 /var/www/html/scripts/monitor_email.py
"""

import imaplib
import email
from email.header import decode_header
import re
import json
import os
from datetime import datetime

# Configuração
CONFIG = {
    'imap_server': 'imap.gmail.com',
    'imap_port': 993,
    'email': 'acibabbadecastro@gmail.com',
    'password': 'juqqogjysxvpowtu',  # App Password
    'palavras_chave': [
        'pedido de compra',
        'pregão',
        'licitação', 
        'convite',
        'proposta',
        'orçamento',
        'compra direta',
        'dispensa',
        'tomada de preço',
        'concorrência'
    ],
    'remetentes_importantes': [
        'prefeitura',
        'prefeitura@',
        '.gov.br',
        'compras@',
        'licitacao@',
        'secretaria',
        'fazenda'
    ],
    'log_file': '/var/log/sgn_email_monitor.log',
    'alert_file': '/var/www/html/alerts/email_alerts.json'
}

def log(mensagem):
    """Registra log com timestamp"""
    timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    log_msg = f"[{timestamp}] {mensagem}"
    print(log_msg)
    
    # Salvar em arquivo
    os.makedirs(os.path.dirname(CONFIG['log_file']), exist_ok=True)
    with open(CONFIG['log_file'], 'a') as f:
        f.write(log_msg + '\n')

def verificar_remetente(remetente):
    """Verifica se o remetente é importante"""
    remetente_lower = remetente.lower()
    for importante in CONFIG['remetentes_importantes']:
        if importante in remetente_lower:
            return True
    return False

def verificar_conteudo(assunto, corpo):
    """Verifica se o conteúdo contém palavras-chave"""
    texto_completo = f"{assunto} {corpo}".lower()
    
    palavras_encontradas = []
    for palavra in CONFIG['palavras_chave']:
        if palavra in texto_completo:
            palavras_encontradas.append(palavra)
    
    return palavras_encontradas

def enviar_alerta(email_data):
    """Envia alerta para o sistema SGN"""
    os.makedirs(os.path.dirname(CONFIG['alert_file']), exist_ok=True)
    
    # Carregar alertas existentes
    alertas = []
    if os.path.exists(CONFIG['alert_file']):
        with open(CONFIG['alert_file'], 'r') as f:
            try:
                alertas = json.load(f)
            except:
                alertas = []
    
    # Adicionar novo alerta
    alertas.append({
        'id': len(alertas) + 1,
        'data': datetime.now().isoformat(),
        'remetente': email_data['remetente'],
        'assunto': email_data['assunto'],
        'palavras_chave': email_data['palavras_encontradas'],
        'status': 'novo',
        'prioridade': 'alta' if 'prefeitura' in email_data['remetente'].lower() else 'media'
    })
    
    # Salvar
    with open(CONFIG['alert_file'], 'w') as f:
        json.dump(alertas, f, indent=2)
    
    log(f"🚨 ALERTA GERADO: {email_data['assunto'][:50]}...")

def conectar_email():
    """Conecta ao servidor IMAP"""
    try:
        mail = imaplib.IMAP4_SSL(CONFIG['imap_server'], CONFIG['imap_port'])
        mail.login(CONFIG['email'], CONFIG['password'])
        log("✅ Conectado ao servidor de email")
        return mail
    except Exception as e:
        log(f"❌ Erro ao conectar: {e}")
        return None

def processar_emails():
    """Processa emails não lidos"""
    mail = conectar_email()
    if not mail:
        return
    
    try:
        mail.select('inbox')
        
        # Buscar emails não lidos
        _, messages = mail.search(None, 'UNSEEN')
        
        if not messages[0]:
            log("📭 Nenhum email novo")
            return
        
        email_ids = messages[0].split()
        log(f"📧 {len(email_ids)} emails não lidos encontrados")
        
        for email_id in email_ids:
            _, msg_data = mail.fetch(email_id, '(RFC822)')
            
            for response_part in msg_data:
                if isinstance(response_part, tuple):
                    msg = email.message_from_bytes(response_part[1])
                    
                    # Decodificar assunto
                    assunto, encoding = decode_header(msg['Subject'])[0]
                    if isinstance(assunto, bytes):
                        assunto = assunto.decode(encoding or 'utf-8')
                    
                    # Decodificar remetente
                    remetente = msg.get('From', '')
                    
                    # Extrair corpo
                    corpo = ""
                    if msg.is_multipart():
                        for part in msg.walk():
                            content_type = part.get_content_type()
                            if content_type == 'text/plain':
                                corpo = part.get_payload(decode=True).decode('utf-8', errors='ignore')
                                break
                    else:
                        corpo = msg.get_payload(decode=True).decode('utf-8', errors='ignore')
                    
                    # Verificar se é importante
                    if verificar_remetente(remetente):
                        log(f"📨 Email de remetente importante: {remetente}")
                        
                        # Verificar palavras-chave
                        palavras = verificar_conteudo(assunto, corpo)
                        
                        if palavras:
                            email_data = {
                                'remetente': remetente,
                                'assunto': assunto,
                                'corpo': corpo[:500],  # Primeiros 500 chars
                                'palavras_encontradas': palavras
                            }
                            enviar_alerta(email_data)
                            log(f"🔍 Palavras-chave encontradas: {', '.join(palavras)}")
        
        mail.close()
        mail.logout()
        
    except Exception as e:
        log(f"❌ Erro ao processar emails: {e}")

if __name__ == '__main__':
    log("🚀 Iniciando monitoramento de emails...")
    processar_emails()
    log("✅ Monitoramento concluído")