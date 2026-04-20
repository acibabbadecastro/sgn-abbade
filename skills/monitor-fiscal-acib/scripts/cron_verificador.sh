#!/bin/bash
# Script de verificação periódica (executado via cron)

LOG_FILE="/root/.openclaw/logs/cron_verificador.log"
DATA_HORA=$(date '+%Y-%m-%d %H:%M:%S')

echo "[$DATA_HORA] Iniciando verificação de emails financeiros..." >> "$LOG_FILE"

# Executar verificador
cd /root/.openclaw/workspace/skills/monitor-fiscal-acib/scripts
python3 verificar_emails.py >> "$LOG_FILE" 2>&1

if [ $? -eq 0 ]; then
    echo "[$DATA_HORA] ✅ Verificação concluída com sucesso" >> "$LOG_FILE"
else
    echo "[$DATA_HORA] ❌ Erro na verificação" >> "$LOG_FILE"
fi

echo "" >> "$LOG_FILE"
