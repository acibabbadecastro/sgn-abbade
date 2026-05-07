#!/usr/bin/env python3
# =============================================================================
# VERIFICAR EMAILS NUBANK - Stark v1.0
# =============================================================================
# Acessa conta Gmail e busca emails do Nubank
# =============================================================================

import imaplib
import email
from email.header import decode_header
import os
from datetime import datetime

# Configurações
EMAIL = "acibabbade@gmail.com"
PASSWORD = "fnasjtjbyxvgpuew"  # Senha de app
IMAP_SERVER = "imap.gmail.com"
IMAP_PORT = 993

# Filtros do Nubank
FILTROS = [
    '(FROM "meuextrato@nubank.com.br")',
    '(FROM "fatura@nubank.com.br")',
    '(FROM "limite@nubank.com.br")',
    '(FROM "pix@nubank.com.br")',
    '(SUBJECT "Nubank")'
]

def conectar_gmail():
    """Conecta ao Gmail via IMAP"""
    print(f"📧 Conectando ao Gmail ({EMAIL})...")
    mail = imaplib.IMAP4_SSL(IMAP_SERVER, IMAP_PORT)
    mail.login(EMAIL, PASSWORD)
    print("✅ Conectado com sucesso!")
    return mail

def buscar_emails_nubank(mail):
    """Busca emails do Nubank"""
    print("\n🔍 Buscando emails do Nubank...")
    
    # Selecionar caixa de entrada
    mail.select("inbox")
    
    emails_encontrados = []
    
    for filtro in FILTROS:
        print(f"   Filtro: {filtro}")
        status, messages = mail.search(None, filtro)
        
        if status == "OK":
            email_ids = messages[0].split()
            print(f"   ✅ {len(email_ids)} emails encontrados")
            
            # Pegar últimos 5 emails de cada filtro
            for email_id in email_ids[-5:]:
                status, msg_data = mail.fetch(email_id, "(RFC822)")
                
                if status == "OK":
                    for response in msg_data:
                        if isinstance(response, tuple):
                            msg = email.message_from_bytes(response[1])
                            
                            # Extrair informações
                            subject = decode_header(msg["Subject"])[0][0]
                            if isinstance(subject, bytes):
                                subject = subject.decode()
                            
                            date = msg["Date"]
                            from_addr = msg["From"]
                            
                            emails_encontrados.append({
                                "id": email_id,
                                "subject": subject,
                                "date": date,
                                "from": from_addr,
                                "msg": msg
                            })
    
    return emails_encontrados

def mostrar_emails(emails):
    """Mostra emails encontrados"""
    print(f"\n📊 TOTAL DE EMAILS ENCONTRADOS: {len(emails)}")
    print("=" * 60)
    
    # Ordenar por data (mais recente primeiro)
    emails_sorted = sorted(emails, key=lambda x: x["date"], reverse=True)
    
    for i, email_info in enumerate(emails_sorted[:10], 1):
        print(f"\n{i}. {email_info['subject']}")
        print(f"   De: {email_info['from']}")
        print(f"   Data: {email_info['date']}")
        print(f"   ID: {email_info['id']}")
        
        # Verificar anexos
        if email_info['msg'].is_multipart():
            for part in email_info['msg'].walk():
                if part.get_content_disposition() == "attachment":
                    filename = part.get_filename()
                    if filename:
                        print(f"   📎 Anexo: {filename}")
        else:
            # Email simples (texto)
            payload = email_info['msg'].get_payload(decode=True)
            if payload:
                content = payload.decode()[:200]
                print(f"   📝 Conteúdo: {content}...")
        
        print("-" * 60)

def main():
    print("=" * 60)
    print("  VERIFICAR EMAILS NUBANK")
    print("  Conta: acibabbade@gmail.com")
    print("=" * 60)
    
    try:
        # Conectar
        mail = conectar_gmail()
        
        # Buscar emails
        emails = buscar_emails_nubank(mail)
        
        # Mostrar resultados
        mostrar_emails(emails)
        
        # Fechar conexão
        mail.close()
        mail.logout()
        
        print("\n✅ Verificação concluída!")
        
    except Exception as e:
        print(f"\n❌ ERRO: {str(e)}")
        print("\nPossíveis causas:")
        print("1. Senha de app incorreta")
        print("2. Conexão com internet")
        print("3. IMAP não habilitado no Gmail")

if __name__ == "__main__":
    main()
