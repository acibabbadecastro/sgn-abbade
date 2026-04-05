#!/usr/bin/env python3
import imaplib
import email
from email.header import decode_header
import os
import sys
from datetime import datetime

# Config
IMAP_HOST = "imap.gmail.com"
IMAP_PORT = 993
EMAIL = "acibabbadecastro@gmail.com"
PASSWORD = "juqqogjysxvpowtu"  # App password

BASE_DIR = "/mnt/data/LAN/Stark_Output/Emails"

def decode_str(s):
    if s is None:
        return ""
    parts = decode_header(s)
    result = ""
    for part, enc in parts:
        if isinstance(part, bytes):
            result += part.decode(enc or "utf-8", errors="replace")
        else:
            result += part
    return result

def get_charset(msg):
    return msg.get_content_charset() or "utf-8"

def save_attachment(part, email_date, sender_name, download_dir):
    filename = part.get_filename()
    if not filename:
        return None
    filename = decode_str(filename)
    
    # Get extension
    ext = os.path.splitext(filename)[1].lower()
    if ext not in ['.pdf', '.xml', '.jpg', '.jpeg', '.png', '.gif', '.zip', '.xlsx', '.xls', '.csv', '.doc', '.docx']:
        return None
    
    # Parse date
    if isinstance(email_date, str):
        try:
            email_date = email.utils.parsedate_to_datetime(email_date)
        except:
            email_date = datetime.now()
    
    year = email_date.year
    month = f"{email_date.month:02d}"
    day = f"{email_date.day:02d}"
    
    # Sanitize sender name
    sender_name = "".join(c for c in sender_name if c.isalnum() or c in ' _-').strip()
    if not sender_name:
        sender_name = "Unknown"
    
    # Save
    os.makedirs(download_dir, exist_ok=True)
    filepath = os.path.join(download_dir, filename)
    
    counter = 1
    base, ext2 = os.path.splitext(filepath)
    while os.path.exists(filepath):
        filepath = f"{base}_{counter}{ext2}"
        counter += 1
    
    data = part.get_payload(decode=True)
    if data is None:
        return None
    
    with open(filepath, "wb") as f:
        f.write(data)
    
    return filepath

def get_sender_name(msg):
    sender = msg.get("From", "")
    if '<' in sender:
        name = sender.split('<')[0].strip().strip('"').strip()
        if name:
            return name
    return sender.split('@')[0].strip() if '@' in sender else sender

def get_institution(sender):
    sender_lower = sender.lower()
    if 'nubank' in sender_lower or 'nubank.com.br' in sender_lower:
        return 'Nubank'
    if 'shopee' in sender_lower or 'shop.com.br' in sender_lower:
        return 'Shopee'
    if any(x in sender_lower for x in ['nf', 'nfe', 'nota', 'fiscal', 'sefa', 'receita']):
        return 'NFe'
    return 'Outros'

def determine_category(msg, subject, sender):
    subject_lower = subject.lower()
    sender_lower = sender.lower()
    
    if 'nubank' in sender_lower:
        return 'Financeiro'
    if 'shopee' in sender_lower:
        return 'Financeiro'
    if any(x in subject_lower for x in ['nf-e', 'nfe', 'nota fiscal', 'danfe']):
        return 'NFe'
    if any(x in sender_lower for x in ['nf', 'nfe', 'nota', 'fiscal', 'sefa']):
        return 'NFe'
    return 'Outros'

def main():
    print("Conectando ao Gmail IMAP...")
    try:
        mail = imaplib.IMAP4_SSL(IMAP_HOST, IMAP_PORT)
        mail.login(EMAIL, PASSWORD)
        print("✅ Conectado!")
    except Exception as e:
        print(f"❌ Erro de conexão: {e}")
        sys.exit(1)
    
    # List folders
    status, folders = mail.list()
    print(f"Pastas encontradas: {len(folders)}")
    
    # Select INBOX
    mail.select("INBOX")
    
    # Search for emails with attachments (ALL for now)
    status, messages = mail.search(None, 'ALL')
    if status != 'OK':
        print("Erro ao buscar mensagens")
        sys.exit(1)
    
    email_ids = messages[0].split()
    print(f"Total de emails na caixa: {len(email_ids)}")
    
    # Process last 50 emails to start
    email_ids = email_ids[-50:]
    
    downloaded = []
    errors = 0
    
    for eid in email_ids:
        try:
            status, msg_data = mail.fetch(eid, '(RFC822)')
            if status != 'OK':
                continue
            
            raw = msg_data[0][1]
            msg = email.message_from_bytes(raw)
            
            subject = decode_str(msg.get("Subject", ""))
            sender = decode_str(msg.get("From", ""))
            date_str = msg.get("Date", "")
            sender_name = get_sender_name(msg)
            
            try:
                email_date = email.utils.parsedate_to_datetime(date_str)
            except:
                email_date = datetime.now()
            
            category = determine_category(msg, subject, sender)
            institution = get_institution(sender)
            
            has_attachments = False
            for part in msg.walk():
                if part.get_content_type() == 'multipart/form-data' or part.get_content_disposition():
                    disp = str(part.get("Content-Disposition", ""))
                    if "attachment" in disp:
                        has_attachments = True
                        break
            
            if not has_attachments:
                continue
            
            year = email_date.year
            month = f"{email_date.month:02d}"
            day = f"{email_date.day:02d}"
            
            if category == 'Financeiro':
                download_dir = f"{BASE_DIR}/Financeiro/{institution}/{year}/{month}/{day}/Comprovantes"
            elif category == 'NFe':
                download_dir = f"{BASE_DIR}/NFe/Compra/{year}/{sender_name}/{month}"
            else:
                download_dir = f"{BASE_DIR}/Outros/{sender_name}"
            
            os.makedirs(download_dir, exist_ok=True)
            
            for part in msg.walk():
                disp = str(part.get("Content-Disposition", ""))
                if "attachment" in disp:
                    filepath = save_attachment(part, email_date, sender_name, download_dir)
                    if filepath:
                        filename = os.path.basename(filepath)
                        size = os.path.getsize(filepath)
                        downloaded.append({
                            'file': filename,
                            'path': filepath,
                            'size': size,
                            'sender': sender,
                            'subject': subject,
                            'date': email_date.strftime('%Y-%m-%d')
                        })
                        print(f"  📎 {filename} ({size} bytes) -> {filepath}")
        
        except Exception as e:
            errors += 1
            print(f"  ⚠️ Erro: {e}")
            continue
    
    mail.logout()
    
    # Create ANEXOS.txt
    anexos_path = f"{BASE_DIR}/ANEXOS.txt"
    with open(anexos_path, "w") as f:
        f.write(f"=== ANEXOS BAIXADOS - {datetime.now().strftime('%Y-%m-%d %H:%M:%S')} ===\n\n")
        f.write(f"Total: {len(downloaded)} anexos\n\n")
        for item in downloaded:
            f.write(f"[{item['date']}] {item['file']}\n")
            f.write(f"  De: {item['sender']}\n")
            f.write(f"  Assunto: {item['subject']}\n")
            f.write(f"  Tamanho: {item['size']} bytes\n")
            f.write(f"  Caminho: {item['path']}\n\n")
        f.write(f"\nErros: {errors}\n")
    
    print(f"\n✅ Concluído!")
    print(f"📎 Anexos baixados: {len(downloaded)}")
    print(f"⚠️ Erros: {errors}")
    print(f"📄 Lista salva em: {anexos_path}")

if __name__ == "__main__":
    main()
