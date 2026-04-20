#!/bin/bash
# Script para enviar SMS via API Local
# Uso: ./enviar-sms.sh "+5511999999999" "Mensagem aqui"

API_URL="${SMS_API_URL:-http://localhost:5000}"

if [ $# -lt 2 ]; then
    echo "❌ Uso: $0 <telefone> <mensagem>"
    echo "Exemplo: $0 '+5511999999999' 'Olá do OpenClaw!'"
    exit 1
fi

TELEFONE="$1"
MENSAGEM="$2"

echo "📱 Enviando SMS para: $TELEFONE"
echo "📝 Mensagem: $MENSAGEM"
echo ""

RESPONSE=$(curl -s -X POST "$API_URL/send" \
    -H "Content-Type: application/json" \
    -d "{\"to\": \"$TELEFONE\", \"message\": \"$MENSAGEM\"}")

echo "Resposta:"
echo "$RESPONSE" | python3 -m json.tool 2>/dev/null || echo "$RESPONSE"

# Verificar se foi sucesso
if echo "$RESPONSE" | grep -q '"sucesso": true'; then
    echo ""
    echo "✅ SMS enviado com sucesso!"
    exit 0
else
    echo ""
    echo "❌ Erro ao enviar SMS"
    exit 1
fi
