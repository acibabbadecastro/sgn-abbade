#!/bin/bash
# Backup automático do perfil de Acib para DATASVR
# Executado a cada mudança significativa no perfil

DATASVR_IP="192.168.0.72"
DATASVR_USER="root"
DATASVR_PASS="Rcmp@814k$1982"
LOCAL_PROFILE="/root/.openclaw/workspace/memory/PERFIL_ACIB.md"
DATASVR_PATH="/home/master/LAN/MEMORIES/STARK-KNOWLEDGE/"
TIMESTAMP=$(date +%Y-%m-%d_%H-%M)

# Verifica se o perfil local existe
if [ ! -f "$LOCAL_PROFILE" ]; then
    echo "[ERRO] Perfil local não encontrado: $LOCAL_PROFILE"
    exit 1
fi

# Cria diretório de backup no DATASVR se não existir
sshpass -p "$DATASVR_PASS" ssh -o StrictHostKeyChecking=no "$DATASVR_USER@$DATASVR_IP" "mkdir -p $DATASVR_PATH/BACKUP-DAILY"

# Copia perfil principal
sshpass -p "$DATASVR_PASS" scp -o StrictHostKeyChecking=no "$LOCAL_PROFILE" "$DATASVR_USER@$DATASVR_IP:$DATASVR_PATH/PERFIL_ACIB.md"

# Copia com timestamp para histórico
sshpass -p "$DATASVR_PASS" scp -o StrictHostKeyChecking=no "$LOCAL_PROFILE" "$DATASVR_USER@$DATASVR_IP:$DATASVR_PATH/BACKUP-DAILY/PERFIL_ACIB_$TIMESTAMP.md"

# Verifica se copiou com sucesso
if [ $? -eq 0 ]; then
    echo "[OK] Perfil de Acib backupado em DATASVR em $TIMESTAMP"
    # Loga o backup
    echo "$TIMESTAMP - Backup realizado com sucesso" >> /root/.openclaw/workspace/logs/acib-profile-backups.log
else
    echo "[ERRO] Falha ao fazer backup para DATASVR"
    exit 1
fi
