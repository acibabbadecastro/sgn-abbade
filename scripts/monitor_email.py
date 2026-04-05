#!/usr/bin/env python3
"""
SGN - Bot de Monitoramento de Emails
Verifica emails de remetentes importantes (ex: Prefeitura)

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

# ⚠️ CONFIGURAÇÃO: Preencha com seus dados
CONFIG = {
    'imap_server': 'imap.gmail.com',
    'imap_port': 993,
    'email': 'SEU_EMAIL@gmail.com',           # PREENCHER
    'password': 'SENHA_APP_GMAIL',            # PREENCHER - App Password do Gmail
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
        _, messages = mail.search(None, 'UNSEEN')
        
        if not messages[0]:
            log("📭 Nenhum email novo")
            return
        
        email_ids = messages[0].split()
        log(f"📧 {len(email_ids)} emails não lidos encontrados")
        
        # Processamento...
        
        mail.close()
        mail.logout()
        
    except Exception as e:
        log(f"❌ Erro ao processar emails: {e}")

if __name__ == '__main__':
    log("🚀 Iniciando monitoramento de emails...")
    processar_emails()
    log("✅ Monitoramento concluído")