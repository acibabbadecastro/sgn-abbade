#!/bin/bash
# Monitor de Espaço em Disco - Stark v1.0
# Verifica uso de disco e alerta quando próximo do limite

# Configurações
ALERT_THRESHOLD=85      # Alerta em 85%
CRITICAL_THRESHOLD=95   # Crítico em 95%
WORKSPACE="/root/.openclaw/workspace"
LOG_FILE="/var/log/stark-disco-monitor.log"

# Cores
RED='\033[0;31m'
YELLOW='\033[1;33m'
GREEN='\033[0;32m'
NC='\033[0m' # No Color

log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Verifica workspace
check_workspace() {
    local usage=$(df "$WORKSPACE" | tail -1 | awk '{print $5}' | sed 's/%//')
    local avail=$(df -h "$WORKSPACE" | tail -1 | awk '{print $4}')
    
    if [ "$usage" -ge "$CRITICAL_THRESHOLD" ]; then
        echo -e "${RED}🔴 CRÍTICO: Workspace em ${usage}% (Disponível: ${avail})${NC}"
        return 2
    elif [ "$usage" -ge "$ALERT_THRESHOLD" ]; then
        echo -e "${YELLOW}🟠 ALERTA: Workspace em ${usage}% (Disponível: ${avail})${NC}"
        return 1
    else
        echo -e "${GREEN}✅ Workspace: ${usage}% (Disponível: ${avail})${NC}"
        return 0
    fi
}

# Verifica /var/log
check_logs() {
    local log_size=$(du -sh /var/log 2>/dev/null | cut -f1)
    local journal_size=$(du -sh /var/log/journal 2>/dev/null | cut -f1)
    
    echo "📊 /var/log: ${log_size:-N/A}"
    echo "   └─ Journal: ${journal_size:-N/A}"
}

# Verifica DATASVR (se acessível)
check_datasvr() {
    if sshpass -p 'Rcmp814k' ssh -o StrictHostKeyChecking=no -o PreferredAuthentications=password -o PubkeyAuthentication=no root@192.168.0.72 "df -h /mnt/data 2>/dev/null" 2>/dev/null; then
        return 0
    else
        echo "⚠️ DATASVR não acessível"
        return 1
    fi
}

# Ações automáticas de limpeza
auto_clean() {
    local threshold=$1
    
    if [ "$threshold" -ge "$CRITICAL_THRESHOLD" ]; then
        log "🧹 Limpando journal automaticamente..."
        journalctl --vacuum-size=200M 2>/dev/null
        log "✅ Journal vacuum concluído"
    fi
}

# Relatório principal
echo "════════════════════════════════════════"
echo "  📊 MONITOR DE DISCO - STARK"
echo "════════════════════════════════════════"
echo ""

check_workspace
STATUS=$?

echo ""
check_logs

echo ""
echo "────────────────────────────────────────"
check_datasvr

echo ""
echo "════════════════════════════════════════"

# Se crítico, executa limpeza automática
if [ $STATUS -eq 2 ]; then
    auto_clean $STATUS
    echo ""
    echo "🔄 Re-verificando após limpeza..."
    check_workspace
fi

exit $STATUS
