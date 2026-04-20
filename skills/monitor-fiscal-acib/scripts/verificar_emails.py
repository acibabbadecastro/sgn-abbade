#!/usr/bin/env python3
"""
Monitor Fiscal - Verificador de Emails Bancários
Busca extratos Nubank no Gmail e processa automaticamente
"""

import os
import json
import base64
import csv
import io
from datetime import datetime, timedelta
from google.oauth2.credentials import Credentials
from google_auth_oauthlib.flow import InstalledAppFlow
from google.auth.transport.requests import Request
from googleapiclient.discovery import build
import pickle

# Configuração
SCOPES = ['https://www.googleapis.com/auth/gmail.readonly']
CONFIG_FILE = '/root/.openclaw/config/monitor_fiscal_config.json'
LOG_FILE = '/root/.openclaw/logs/monitor_fiscal.log'
EXTRACTS_DIR = '/root/.openclaw/media/inbound'

# Limites Fiscais 2026
LIMITES = {
    'mei': {
        'anual': 81000.00,
        'contas': ['PJ65', 'PJ20'],
        'alertas': {
            '70': 56700.00,
            '85': 68850.00,
            '95': 76950.00,
            '100': 81000.00
        }
    },
    'irpf': {
        'anual': 28559.70,
        'contas': ['PF'],
        'alertas': {
            '70': 19991.79,
            '85': 24275.75,
            '95': 27131.72,
            '100': 28559.70
        }
    }
}

CONTAS_CONFIG = {
    'PJ65': {
        'cnpj': '65.384.056/0001-32',
        'banco': 'Nubank',
        'tipo': 'MEI',
        'email_keywords': ['Nubank PJ', '65.384.056', 'extrato', 'Nu Empresas']
    },
    'PJ20': {
        'cnpj': '20.153.208/0001-58',
        'banco': 'Nubank',
        'tipo': 'MEI',
        'email_keywords': ['Nubank PJ', '20.153.208', 'extrato', 'Nu Empresas']
    },
    'PF': {
        'cpf': '307.572.858-64',
        'banco': 'Nubank',
        'tipo': 'PF',
        'email_keywords': ['Nubank', 'extrato', '16984256']
    },
    'ESPOSA': {
        'nome': 'Esposa',
        'tipo': 'RESERVA',
        'nota': 'Usar quando MEI próximo do limite'
    }
}

def log(msg):
    timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    print(f"[{timestamp}] {msg}")
    with open(LOG_FILE, 'a') as f:
        f.write(f"[{timestamp}] {msg}\n")

def get_gmail_service():
    """Autentica com Gmail API"""
    creds = None
    token_path = '/root/.openclaw/config/token.pickle'
    
    if os.path.exists(token_path):
        with open(token_path, 'rb') as token:
            creds = pickle.load(token)
    
    if not creds or not creds.valid:
        if creds and creds.expired and creds.refresh_token:
            creds.refresh(Request())
        else:
            # Requer autenticação manual
            log("⚠️ Autenticação Gmail necessária. Execute setup_gmail_auth.py")
            return None
    
    return build('gmail', 'v1', credentials=creds)

def buscar_emails_nubank(service, dias=7):
    """Busca emails do Nubank nos últimos N dias"""
    if not service:
        return []
    
    data_limite = (datetime.now() - timedelta(days=dias)).strftime('%Y/%m/%d')
    query = f'from:nubank after:{data_limite} (extrato OR "sua conta" OR "comprovante")'
    
    try:
        results = service.users().messages().list(
            userId='me',
            q=query,
            maxResults=50
        ).execute()
        
        return results.get('messages', [])
    except Exception as e:
        log(f"❌ Erro ao buscar emails: {e}")
        return []

def processar_anexo(service, msg_id):
    """Extrai anexos CSV/PDF de emails"""
    try:
        message = service.users().messages().get(
            userId='me',
            id=msg_id
        ).execute()
        
        parts = message.get('payload', {}).get('parts', [])
        anexos = []
        
        for part in parts:
            if part.get('filename') and ('csv' in part['filename'].lower() or 'pdf' in part['filename'].lower()):
                if 'data' in part['body']:
                    data = base64.urlsafe_b64decode(part['body']['data'])
                else:
                    att_id = part['body']['attachmentId']
                    att = service.users().messages().attachments().get(
                        userId='me',
                        messageId=msg_id,
                        id=att_id
                    ).execute()
                    data = base64.urlsafe_b64decode(att['data'])
                
                anexos.append({
                    'filename': part['filename'],
                    'data': data,
                    'tipo': 'csv' if 'csv' in part['filename'].lower() else 'pdf'
                })
        
        return anexos
    except Exception as e:
        log(f"❌ Erro ao processar anexo {msg_id}: {e}")
        return []

def identificar_conta(filename, headers):
    """Identifica qual conta (PJ65, PJ20, PF) baseado no filename e headers"""
    texto = f"{filename} {str(headers)}".upper()
    
    # Check PJ65
    if any(x in texto for x in ['65.384.056', '986080174', 'PJ65']):
        return 'PJ65'
    
    # Check PJ20
    if any(x in texto for x in ['20.153.208', '118844303', 'PJ20']):
        return 'PJ20'
    
    # Check PF
    if any(x in texto for x in ['16984256', 'PF', '307.572']):
        return 'PF'
    
    return 'DESCONHECIDO'

def calcular_totais_csv(csv_data, conta_tipo):
    """Calcula totais de entradas e saídas de CSV"""
    try:
        csv_str = csv_data.decode('utf-8-sig')
        reader = csv.DictReader(io.StringIO(csv_str), delimiter=';' if conta_tipo != 'PF' else ',')
        
        entradas = 0
        saidas = 0
        
        for row in reader:
            try:
                valor_str = row.get('Valor', '0').replace(',', '.')
                valor = float(valor_str)
                
                if valor > 0:
                    entradas += valor
                else:
                    saidas += abs(valor)
            except:
                pass
        
        return entradas, saidas
    except Exception as e:
        log(f"❌ Erro ao processar CSV: {e}")
        return 0, 0

def verificar_limites(conta, acumulado):
    """Verifica proximidade dos limites fiscais"""
    tipo = CONTAS_CONFIG[conta]['tipo']
    
    if tipo == 'MEI':
        limite = LIMITES['mei']['anual']
        alertas = LIMITES['mei']['alertas']
    elif tipo == 'PF':
        limite = LIMITES['irpf']['anual']
        alertas = LIMITES['irpf']['alertas']
    else:
        return None
    
    percentual = (acumulado / limite) * 100
    
    # Determinar nível de alerta
    if percentual >= 95:
        nivel = '🔴 EMERGÊNCIA'
        acao = 'MIGRAR PARA ESPOSA OU PF IMEDIATAMENTE'
    elif percentual >= 85:
        nivel = '🟠 CRÍTICO'
        acao = 'COMEÇAR A MIGRAR VENDAS PARA PF'
    elif percentual >= 70:
        nivel = '🟡 ATENÇÃO'
        acao = 'PLANEJAR MIGRAÇÃO PARA PRÓXIMOS MESES'
    else:
        nivel = '🟢 NORMAL'
        acao = 'CONTINUAR NORMAL'
    
    return {
        'conta': conta,
        'acumulado': acumulado,
        'limite': limite,
        'percentual': percentual,
        'nivel': nivel,
        'acao': acao,
        'restante': limite - acumulado
    }

def main():
    log("="*60)
    log("MONITOR FISCAL - Verificação de Emails")
    log("="*60)
    
    service = get_gmail_service()
    if not service:
        log("❌ Serviço Gmail não disponível")
        return
    
    # Buscar emails
    emails = buscar_emails_nubank(service, dias=3)
    log(f"📧 {len(emails)} emails do Nubank encontrados (últimos 3 dias)")
    
    novos_extratos = []
    
    for email in emails:
        msg_id = email['id']
        anexos = processar_anexo(service, msg_id)
        
        for anexo in anexos:
            if anexo['tipo'] == 'csv':
                conta = identificar_conta(anexo['filename'], {})
                
                if conta in ['PJ65', 'PJ20', 'PF']:
                    entradas, saidas = calcular_totais_csv(anexo['data'], conta)
                    
                    log(f"✅ Extrato {conta}: Entradas R${entradas:,.2f}, Saídas R${saidas:,.2f}")
                    
                    # Salvar arquivo
                    timestamp = datetime.now().strftime('%Y%m%d_%H%M%S')
                    filename = f"{conta}_{timestamp}_{anexo['filename']}"
                    filepath = os.path.join(EXTRACTS_DIR, filename)
                    
                    with open(filepath, 'wb') as f:
                        f.write(anexo['data'])
                    
                    novos_extratos.append({
                        'conta': conta,
                        'entradas': entradas,
                        'saidas': saidas,
                        'arquivo': filepath
                    })
    
    # Verificar limites
    log("\n" + "="*60)
    log("VERIFICAÇÃO DE LIMITES")
    log("="*60)
    
    # Agrupar por conta
    totais = {'PJ65': 0, 'PJ20': 0, 'PF': 0}
    for extrato in novos_extratos:
        totais[extrato['conta']] += extrato['entradas']
    
    alertas_gerados = []
    
    for conta, total in totais.items():
        if total > 0:
            alerta = verificar_limites(conta, total)
            if alerta:
                log(f"\n{alerta['nivel']}")
                log(f"Conta: {conta}")
                log(f"Acumulado: R${alerta['acumulado']:,.2f}")
                log(f"Limite: R${alerta['limite']:,.2f}")
                log(f"Percentual: {alerta['percentual']:.1f}%")
                log(f"Restante: R${alerta['restante']:,.2f}")
                log(f"AÇÃO: {alerta['acao']}")
                
                if alerta['percentual'] >= 70:
                    alertas_gerados.append(alerta)
    
    # Resumo MEI
    total_mei = totais['PJ65'] + totais['PJ20']
    if total_mei > 0:
        alerta_mei = verificar_limites('MEI_TOTAL', total_mei)
        if alerta_mei['percentual'] >= 70:
            log(f"\n🚨 ALERTA MEI GERAL:")
            log(f"Total MEI: R${total_mei:,.2f} ({alerta_mei['percentual']:.1f}% do limite)")
            log(f"AÇÃO: {alerta_mei['acao']}")
            alertas_gerados.append({
                'tipo': 'MEI_TOTAL',
                'percentual': alerta_mei['percentual'],
                'acao': alerta_mei['acao']
            })
    
    # Gerar relatório JSON
    relatorio = {
        'timestamp': datetime.now().isoformat(),
        'emails_verificados': len(emails),
        'novos_extratos': len(novos_extratos),
        'totais_por_conta': totais,
        'alertas': alertas_gerados
    }
    
    report_path = '/root/.openclaw/logs/monitor_fiscal_report.json'
    with open(report_path, 'w') as f:
        json.dump(relatorio, f, indent=2, default=str)
    
    log(f"\n✅ Relatório salvo em: {report_path}")
    log(f"📊 Total de alertas: {len(alertas_gerados)}")
    
    return relatorio

if __name__ == '__main__':
    main()
