#!/bin/bash
# MAXIMOUS v2.1 - Script de Sincronização de Contexto
# Executa backup automático para DATASVR (ARCA)

LOG_FILE="$HOME/.openclaw/workspace/skills/maximous-v2/logs/sync.log"
mkdir -p "$(dirname "$LOG_FILE")"

log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" >> "$LOG_FILE"
}

# Modo silencioso ou verbose
SILENT=false
if [ "$1" == "--auto" ]; then
    SILENT=true
fi

# Verificar conectividade com DATASVR
ping -c 1 -W 2 192.168.0.72 >/dev/null 2>&1
DATASVR_ONLINE=$?

if [ $DATASVR_ONLINE -eq 0 ]; then
    # Sync para DATASVR
    rsync -az -e "ssh -i $HOME/.ssh/id_ed25519 -o StrictHostKeyChecking=no -o ConnectTimeout=5" \
        "$HOME/.openclaw/workspace/memory/" \
        root@192.168.0.72:/home/master/LAN/MEMORIES/ 2>/dev/null
    
    if [ $? -eq 0 ]; then
        log "SUCCESS: Sync DATASVR completed"
        if [ "$SILENT" = false ]; then
            echo "✅ $(date '+%H:%M') - Sync DATASVR concluído"
        fi
    else
        log "WARNING: DATASVR rsync failed, using local backup"
        # Backup local
        mkdir -p "$HOME/.openclaw/workspace/skills/maximous-v2/backups"
        cp -r "$HOME/.openclaw/workspace/memory/" "$HOME/.openclaw/workspace/skills/maximous-v2/backups/memory-$(date +%Y%m%d-%H%M)" 2>/dev/null
        if [ "$SILENT" = false ]; then
            echo "⚠️  $(date '+%H:%M') - DATASVR offline, backup local realizado"
        fi
    fi
else
    log "WARNING: DATASVR offline, using local backup"
    mkdir -p "$HOME/.openclaw/workspace/skills/maximous-v2/backups"
    cp -r "$HOME/.openclaw/workspace/memory/" "$HOME/.openclaw/workspace/skills/maximous-v2/backups/memory-$(date +%Y%m%d-%H%M)" 2>/dev/null
    if [ "$SILENT" = false ]; then
        echo "⚠️  $(date '+%H:%M') - DATASVR offline, backup local"
    fi
fi

exit 0
