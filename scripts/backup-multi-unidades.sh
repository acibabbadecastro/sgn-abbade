#!/bin/bash
# Backup Multi-Unidades - Stark v1.0
# Backup em 3 unidades diferentes: DATASVR, Pendrive, LAN

set -e

WORKSPACE="/root/.openclaw/workspace"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
LOG_FILE="/var/log/stark-backup-multi.log"

log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Destinos de backup
DESTINOS=(
    "192.168.0.72:/mnt/data/BACKUPS_WORKSPACE/"  # DATASVR
    "/mnt/meu-pendrive/Stark_Backup/workspace/"  # Pendrive
    "/home/master/LAN/BACKUP_CRITICO/workspace/" # LAN (Samba)
)

log "=== INICIANDO BACKUP MULTI-UNIDADES ==="
log "Workspace: $WORKSPACE"
log "Timestamp: $TIMESTAMP"

# Criar arquivo tarball
TARBALL="/tmp/workspace_backup_${TIMESTAMP}.tar.gz"
log "Criando tarball: $TARBALL"
tar -czf "$TARBALL" -C "$(dirname $WORKSPACE)" "$(basename $WORKSPACE)" --exclude='node_modules' --exclude='.git' 2>/dev/null

log "Tarball criado: $(du -h $TARBALL | cut -f1)"

# Backup em cada destino
for DESTINO in "${DESTINOS[@]}"; do
    log "Enviando para: $DESTINO"
    
    # Extrair host e path
    if [[ "$DESTINO" == *":"* ]]; then
        # SSH (DATASVR)
        HOST=$(echo $DESTINO | cut -d: -f1)
        PATH_REMOTE=$(echo $DESTINO | cut -d: -f2)
        
        # Criar diretório remoto
        sshpass -p 'Rcmp814k' ssh -o StrictHostKeyChecking=no root@$HOST "mkdir -p $PATH_REMOTE" 2>/dev/null || true
        
        # Copiar arquivo
        sshpass -p 'Rcmp814k' scp -o StrictHostKeyChecking=no "$TARBALL" root@$HOST:"$PATH_REMOTE/" 2>/dev/null && \
            log "✅ $DESTINO - SUCESSO" || \
            log "❌ $DESTINO - FALHOU"
    else
        # Local (Pendrive/LAN)
        mkdir -p "$DESTINO" 2>/dev/null || true
        cp "$TARBALL" "$DESTINO/" 2>/dev/null && \
            log "✅ $DESTINO - SUCESSO" || \
            log "❌ $DESTINO - FALHOU (não montado?)"
    fi
done

# Limpar tarball local
rm -f "$TARBALL"
log "Tarball local removido"

# Manter apenas últimos 5 backups em cada destino
log "Limpando backups antigos (mantendo últimos 5)..."
for DESTINO in "${DESTINOS[@]}"; do
    if [[ "$DESTINO" == *":"* ]]; then
        HOST=$(echo $DESTINO | cut -d: -f1)
        PATH_REMOTE=$(echo $DESTINO | cut -d: -f2)
        sshpass -p 'Rcmp814k' ssh -o StrictHostKeyChecking=no root@$HOST "cd $PATH_REMOTE && ls -t workspace_backup_*.tar.gz | tail -n +6 | xargs rm -f" 2>/dev/null || true
    else
        cd "$DESTINO" 2>/dev/null && ls -t workspace_backup_*.tar.gz 2>/dev/null | tail -n +6 | xargs rm -f 2>/dev/null || true
    fi
done

log "=== BACKUP MULTI-UNIDADES CONCLUÍDO ==="
log ""
