#!/bin/bash
# Setup CT 105 - MAILBOT
# Executar no PVE host: pct exec 105 -- bash /tmp/setup-mailbot.sh

set -e

echo "🔧 Configurando CT 105 como MAILBOT..."

# 1. Instalar Node.js e npm (se não existir)
if ! command -v npm &> /dev/null; then
    echo "📦 Instalando Node.js e npm..."
    apt-get update
    apt-get install -y nodejs npm
fi

# 2. Instalar OpenClaw
echo "🤖 Instalando OpenClaw..."
npm install -g openclaw

# 3. Criar diretórios
echo "📁 Criando diretórios..."
mkdir -p ~/.openclaw
mkdir -p ~/.openclaw/workspace
mkdir -p /root/emails_financeiros/{Contas_Pagar,Contas_Receber,Faturas,NF-e,Outros}

# 4. Copiar credenciais
echo "🔐 Configurando credenciais..."
cat > /root/.msmtprc << 'EOF'
defaults
tls on
tls_starttls on

account gmail
host smtp.gmail.com
port 587
from acibabbadecastro@gmail.com
auth on
user acibabbadecastro@gmail.com
password juqqogjysxvpowtu

account default : gmail
EOF
chmod 600 /root/.msmtprc

# 5. Criar config OpenClaw
echo "⚙️ Criando configuração OpenClaw..."
cat > ~/.openclaw/openclaw.json << 'EOF'
{
  "agents": {
    "defaults": {
      "workspace": "~/.openclaw/workspace",
      "model": {
        "primary": "ollama/qwen3.5:cloud"
      }
    }
  },
  "channels": {
    "telegram": {
      "enabled": false
    }
  },
  "messages": {
    "tts": {
      "edge": {
        "enabled": false
      }
    }
  }
}
EOF

# 6. Testar envio de email
echo "📧 Testando envio de email..."
echo "CT 105 MAILBOT configurado com sucesso!" | msmtp -a gmail acibabbadecastro@gmail.com

# 7. Criar script de processamento de emails
echo "📝 Criando script de processamento..."
cat > /root/process-emails.sh << 'SCRIPT'
#!/bin/bash
# Processar emails financeiros

cd /root
python3 /root/mails_processor.py

# Sincronizar com DATASVR
echo "📦 Sincronizando com DATASVR..."
rsync -avz /root/emails_financeiros/ root@192.168.0.72:/home/master/LAN/Emails/

echo "✅ Processamento concluído!"
SCRIPT
chmod +x /root/process-emails.sh

echo ""
echo "✅ CT 105 MAILBOT configurado com sucesso!"
echo ""
echo "📋 COMANDOS ÚTEIS:"
echo "  - Processar emails: /root/process-emails.sh"
echo "  - Ver emails hoje: ls /root/emails_financeiros/Contas_Pagar/$(date +%Y-%m-%d)/"
echo "  - Testar email: echo 'teste' | msmtp -a gmail acibabbadecastro@gmail.com"
echo "  - OpenClaw: openclaw --help"
echo ""
