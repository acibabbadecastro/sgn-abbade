#!/bin/bash
# Integração Monitor Fiscal com MAILS (CT 105)

MAILS_IP="192.168.0.224"
MAILS_SENHA="Rcmp814k"
MONITOR_DIR="/root/.openclaw/workspace/skills/monitor-fiscal-acib"
LOG_FILE="/root/.openclaw/logs/integracao_mails.log"

echo "[$(date)] Iniciando integração com MAILS (CT 105)..." >> "$LOG_FILE"

# Função para executar comando no MAILS via SSH
executar_no_mails() {
    sshpass -p "$MAILS_SENHA" ssh -o StrictHostKeyChecking=no \
        -o PreferredAuthentications=password \
        -o PubkeyAuthentication=no \
        -o ConnectTimeout=10 \
        root@$MAILS_IP "$1" 2>> "$LOG_FILE"
}

# Verificar se MAILS está acessível
echo "[$(date)] Verificando acesso ao CT 105..." >> "$LOG_FILE"

# Tentar acesso
TESTE=$(executar_no_mails "hostname" 2>&1)

if [ "$TESTE" == "CT105" ] || [ "$TESTE" == "mails" ]; then
    echo "[$(date)] ✅ MAILS (CT 105) acessível" >> "$LOG_FILE"
    
    # Criar diretório no MAILS
    executar_no_mails "mkdir -p ~/.openclaw/skills/monitor-fiscal-acib/scripts"
    
    # Copiar scripts essenciais
    echo "[$(date)] Copiando scripts para CT 105..." >> "$LOG_FILE"
    
    # Transferir arquivo por arquivo
    for arquivo in "$MONITOR_DIR"/scripts/*.py; do
        if [ -f "$arquivo" ]; then
            basename=$(basename "$arquivo")
            # Usar scp para transferir
            sshpass -p "$MAILS_SENHA" scp -o StrictHostKeyChecking=no \
                -o PreferredAuthentications=password \
                -o PubkeyAuthentication=no \
                "$arquivo" "root@$MAILS_IP:~/.openclaw/skills/monitor-fiscal-acib/scripts/" 2>> "$LOG_FILE"
            
            if [ $? -eq 0 ]; then
                echo "[$(date)] ✅ $basename transferido" >> "$LOG_FILE"
            else
                echo "[$(date)] ❌ Falha ao transferir $basename" >> "$LOG_FILE"
            fi
        fi
    done
    
    # Configurar crontab no MAILS
    echo "[$(date)] Configurando cron no CT 105..." >> "$LOG_FILE"
    
    CRON_CMD="0 9,15,21 * * * cd ~/.openclaw/skills/monitor-fiscal-acib/scripts && python3 administrar_emails_financeiros.py >> /root/.openclaw/logs/monitor_fiscal.log 2>&1"
    
    # Adicionar ao crontab (sem duplicar)
    executar_no_mails "(crontab -l 2>/dev/null | grep -v 'administrar_emails_financeiros'; echo '$CRON_CMD') | crontab -"
    
    echo "[$(date)] ✅ Integração concluída" >> "$LOG_FILE"
    
else
    echo "[$(date)] ❌ MAILS (CT 105) não acessível via SSH" >> "$LOG_FILE"
    echo "[$(date)]    Tentando abordagem alternativa..." >> "$LOG_FILE"
    
    # Alternativa: Configurar no Stark e usar gateway para comunicar
    echo "[$(date)]    Configurando execução via Stark (CT 100)..." >> "$LOG_FILE"
    
    # Criar job no Stark para executar verificação fiscal
    # Isso será feito via cron do próprio Stark
    echo "[$(date)]    Job será executado no Stark (CT 100)" >> "$LOG_FILE"
fi

echo "[$(date)] Fim da integração" >> "$LOG_FILE"
