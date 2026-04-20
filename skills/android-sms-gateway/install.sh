#!/bin/bash
# Script de instalação do serviço de SMS
# Autor: Acib ABBADE
# Projeto: Dr_Finance - Bootcamp DIO

set -e

echo "============================================================"
echo "📱 Instalando API Local de SMS - Dr_Finance"
echo "============================================================"

# 1. Criar diretório
echo ""
echo "[1/5] Criando diretório /opt/dr-finance..."
mkdir -p /opt/dr-finance
mkdir -p /var/log/sms-api

# 2. Copiar arquivos
echo ""
echo "[2/5] Copiando arquivos..."
cp /root/.openclaw/workspace/skills/android-sms-gateway/api-local.py /opt/dr-finance/
cp /root/.openclaw/workspace/skills/android-sms-gateway/enviar-sms.sh /opt/dr-finance/
chmod +x /opt/dr-finance/enviar-sms.sh

# 3. Instalar service systemd
echo ""
echo "[3/5] Instalando serviço systemd..."
cp /root/.openclaw/workspace/skills/android-sms-gateway/sms-api.service /etc/systemd/system/

# 4. Configurar IP do Android (pedir ao usuário)
echo ""
echo "[4/5] Configuração do Android Gateway"
echo "------------------------------------------------------------"
echo "Digite o IP do seu celular na rede Wi-Fi:"
echo "Exemplo: 192.168.0.100"
echo "------------------------------------------------------------"
read -p "IP do Android: " IP_ANDROID

echo ""
echo "Digite o API Token (copiado do app no celular):"
echo "------------------------------------------------------------"
read -p "Token: " API_TOKEN

# Atualizar service com valores corretos
sed -i "s|http://192.168.0.100:8080|http://${IP_ANDROID}:8080|g" /etc/systemd/system/sms-api.service
sed -i "s|seu-token-aqui|${API_TOKEN}|g" /etc/systemd/system/sms-api.service

echo ""
echo "[5/5] Habilitando e iniciando serviço..."
systemctl daemon-reload
systemctl enable sms-api
systemctl start sms-api

# Aguardar e verificar status
sleep 2

echo ""
echo "============================================================"
echo "✅ INSTALAÇÃO CONCLUÍDA!"
echo "============================================================"
echo ""
echo "Status do serviço:"
systemctl status sms-api --no-pager | head -10

echo ""
echo "============================================================"
echo "📊 COMANDOS ÚTEIS:"
echo "============================================================"
echo ""
echo "Ver status:"
echo "  systemctl status sms-api"
echo ""
echo "Ver logs:"
echo "  journalctl -u sms-api -f"
echo ""
echo "Reiniciar:"
echo "  systemctl restart sms-api"
echo ""
echo "Parar:"
echo "  systemctl stop sms-api"
echo ""
echo "Testar envio:"
echo "  /opt/dr-finance/enviar-sms.sh '+5511999999999' 'Olá do Dr_Finance!'"
echo ""
echo "============================================================"
echo ""
echo "🎉 API de SMS está rodando em http://localhost:5000"
echo ""
