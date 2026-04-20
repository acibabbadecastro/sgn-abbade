#!/usr/bin/env python3
"""
Setup da autenticação Gmail API
Executar uma vez para obter token de acesso
"""

import os
import pickle
from google.oauth2.credentials import Credentials
from google_auth_oauthlib.flow import InstalledAppFlow
from google.auth.transport.requests import Request
from googleapiclient.discovery import build

SCOPES = ['https://www.googleapis.com/auth/gmail.readonly']

def main():
    print("="*60)
    print("SETUP GMAIL API - Administrador Financeiro")
    print("="*60)
    print()
    
    # Verificar se já existe token
    token_path = '/root/.openclaw/config/token.pickle'
    
    if os.path.exists(token_path):
        print(f"✅ Token já existe em: {token_path}")
        
        with open(token_path, 'rb') as token:
            creds = pickle.load(token)
        
        if creds.valid:
            print("✅ Token válido!")
            service = build('gmail', 'v1', credentials=creds)
            profile = service.users().getProfile(userId='me').execute()
            print(f"✅ Conectado como: {profile['emailAddress']}")
            return True
        else:
            print("⚠️ Token expirado. Renovar...")
    
    # Verificar se existe credentials.json
    creds_path = '/root/.openclaw/config/credentials.json'
    
    if not os.path.exists(creds_path):
        print("❌ Arquivo credentials.json não encontrado!")
        print()
        print("INSTRUÇÕES:")
        print("1. Acesse: https://console.cloud.google.com/")
        print("2. Crie um projeto ou use um existente")
        print("3. Ative a Gmail API")
        print("4. Crie credenciais OAuth 2.0 (Desktop app)")
        print("5. Baixe o arquivo JSON e salve em:")
        print(f"   {creds_path}")
        print()
        print("6. Execute este script novamente")
        return False
    
    print("✅ credentials.json encontrado")
    print()
    print("Iniciando fluxo de autenticação...")
    print("(Uma URL será exibida - abra no navegador e autorize)")
    print()
    
    flow = InstalledAppFlow.from_client_secrets_file(
        creds_path, SCOPES)
    
    creds = flow.run_local_server(port=0)
    
    # Salvar token
    os.makedirs(os.path.dirname(token_path), exist_ok=True)
    with open(token_path, 'wb') as token:
        pickle.dump(creds, token)
    
    print(f"✅ Token salvo em: {token_path}")
    
    # Testar conexão
    service = build('gmail', 'v1', credentials=creds)
    profile = service.users().getProfile(userId='me').execute()
    print(f"✅ Conectado com sucesso como: {profile['emailAddress']}")
    
    return True

if __name__ == '__main__':
    main()
