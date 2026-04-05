#!/bin/bash
# SAMU Alert Script - Envio direto de alertas
# Não depende do MailBot - usa curl direto

TELEGRAM_TOKEN="8674882792:AAEIwzMDLWrMUdhYJ9qlk492gQ-X2KXAbTc"
CHAT_ID="1866226415"

send_telegram() {
    local mensagem="$1"
    curl -s -X POST "https://api.telegram.org/bot$TELEGRAM_TOKEN/sendMessage" \
        -d "chat_id=$CHAT_ID" \
        -d "text=$mensagem" \
        -d "parse_mode=HTML" 2>/dev/null
    echo "Telegram enviado: $mensagem"
}

# Teste
send_telegram "🔔 SAMU - Teste de Telegram direto!"
