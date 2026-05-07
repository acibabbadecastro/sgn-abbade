#!/bin/bash
# Script para iniciar o bot da Viviane

echo "🤖 Iniciando Stark Família (Bot da Viviane)..."

# Configurar variáveis de ambiente
export OPENCLAW_TELEGRAM_BOT_TOKEN="8558193763:AAExVtcUT8OHZUm4HZs5xU8eRkqjf2gME5w"
export OPENCLAW_TELEGRAM_ALLOW_FROM="5512988013359"

# Iniciar gateway OpenClaw com configuração do bot
openclaw gateway start --port 18790

echo "✅ Bot iniciado na porta 18790!"
echo "📱 Bot: @stark_familia_bot"
echo "👤 Usuária: Viviane"
