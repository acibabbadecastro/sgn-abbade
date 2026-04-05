#!/bin/bash
# SAMU - Stark Automated Monitoring Unit
# UNICO OBJETIVO: Manter o STARK online
# Quando ativado pelo Supervisor, coleta logs e reinicia

export TZ=America/Sao_Paulo

# ============================================
# CONFIGURAÇÕES
# ============================================
STARK_IP="192.168.0.192"
PVE_IP="192.168.0.192"
STARK_CT_ID="100"
EMAIL_DEST="acib@outlook.com"

# Telegram direto
TELEGRAM_TOKEN="8674882792:AAEIwzMDLWrMUdhYJ9qlk492gQ-X2KXAbTc"
CHAT_ID="1866226415"

LOG_FILE="/root/samu/monitor.log"
LOCK_FILE="/root/samu/monitor.lock"
SAMU_MODEL="ollama/minimax-m2.7:cloud"

# ============================================
# FUNÇÕES
# ============================================

log() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $1" | tee -a "$LOG_FILE"
}

send_telegram() {
    local msg="$1"
    curl -s -X POST "https://api.telegram.org/bot$TELEGRAM_TOKEN/sendMessage" \
        -d "chat_id=$CHAT_ID" -d "text=$msg" -d "parse_mode=HTML" > /dev/null 2>&1
    log "Telegram: $msg"
}

send_email() {
    local assunto="$1"
    local corpo="$2"
    ssh -o StrictHostKeyChecking=no root@192.168.0.240 \
        "echo '$corpo' | mail -s '$assunto' $EMAIL_DEST" 2>/dev/null
    log "Email enviado: $assunto"
}

# ============================================
# COLETA DE INFORMAÇÕES DO STARK
# ============================================

collect_stark_logs() {
    log "=== COLETANDO LOGS DO STARK ==="
    
    LOGS=""
    
    # Logs do gateway
    LOGS="$LOGS\n\n=== GATEWAY LOGS (ultimas 30 linhas) ==="
    LOGS="$LOGS\n$(ssh -o StrictHostKeyChecking=no root@$STARK_IP \
        "tail -30 /tmp/openclaw/openclaw-*.log 2>/dev/null | tail -30" 2>/dev/null || echo 'Logs não disponíveis')"
    
    # Journal do serviço
    LOGS="$LOGS\n\n=== JOURNAL (ultimas 30 entradas) ==="
    LOGS="$LOGS\n$(ssh -o StrictHostKeyChecking=no root@$STARK_IP \
        "journalctl --user -u openclaw-gateway.service -n 30 --no-pager 2>/dev/null | tail -20" 2>/dev/null || echo 'Journal não disponível')"
    
    # Status do sistema
    LOGS="$LOGS\n\n=== STATUS DO SISTEMA ==="
    LOGS="$LOGS\nUptime: $(ssh -o StrictHostKeyChecking=no root@$STARK_IP "uptime" 2>/dev/null || echo 'N/A')"
    LOGS="$LOGS\nMemoria: $(ssh -o StrictHostKeyChecking=no root@$STARK_IP "free -h" 2>/dev/null | head -3 || echo 'N/A')"
    LOGS="$LOGS\nDisco: $(ssh -o StrictHostKeyChecking=no root@$STARK_IP "df -h / /mnt/data 2>/dev/null" || echo 'N/A')"
    
    # Processos do OpenClaw
    LOGS="$LOGS\n\n=== PROCESSOS OPEBCLAW ==="
    LOGS="$LOGS\n$(ssh -o StrictHostKeyChecking=no root@$STARK_IP \
        "ps aux | grep -i openclaw | grep -v grep" 2>/dev/null || echo 'Nenhum processo')"
    
    echo -e "$LOGS"
}

get_last_action() {
    # Tenta identificar última ação registrada
    LAST_ACTION="Não foi possível identificar última ação específica"
    
    # Verifica últimos comandos no bash history
    LAST_CMD=$(ssh -o StrictHostKeyChecking=no root@$STARK_IP \
        "tail -10 ~/.bash_history 2>/dev/null | tail -1" 2>/dev/null)
    
    if [ -n "$LAST_CMD" ]; then
        LAST_ACTION="Último comando no history: $LAST_CMD"
    fi
    
    echo "$LAST_ACTION"
}

# ============================================
# TENTATIVAS DE RESTAURAÇÃO
# ============================================

check_stark() {
    ssh -o ConnectTimeout=10 -o StrictHostKeyChecking=no root@$STARK_IP \
        "openclaw gateway status" > /dev/null 2>&1
    return $?
}

start_ct() {
    log "Tentando startar CT $STARK_CT_ID..."
    
    if ssh -o StrictHostKeyChecking=no root@$PVE_IP "pct status $STARK_CT_ID" 2>/dev/null | grep -q "stopped"; then
        ssh -o StrictHostKeyChecking=no root@$PVE_IP "pct start $STARK_CT_ID" 2>/dev/null
        log "CT $STARK_CT_ID iniciado!"
        sleep 30
        return 0
    else
        log "CT não está parado"
        return 1
    fi
}

try_restart_gateway() {
    log "Tentativa 1: Restart gateway..."
    ssh -o StrictHostKeyChecking=no root@$STARK_IP \
        "systemctl --user restart openclaw-gateway" 2>/dev/null
    sleep 10
    check_stark && return 0 || return 1
}

try_stop_start() {
    log "Tentativa 2: Stop + Start..."
    ssh -o StrictHostKeyChecking=no root@$STARK_IP \
        "systemctl --user stop openclaw-gateway; sleep 3; systemctl --user start openclaw-gateway" 2>/dev/null
    sleep 15
    check_stark && return 0 || return 1
}

try_openclaw_launch() {
    log "Tentativa 3: openclaw launch..."
    
    # Verifica se CT está rodando
    start_ct
    
    if ! ssh -o ConnectTimeout=10 root@$STARK_IP "exit 0" 2>/dev/null; then
        log "Não consigo conectar via SSH!"
        return 1
    fi
    
    # Verifica se gateway já está rodando
    if ssh -o StrictHostKeyChecking=no root@$STARK_IP "openclaw gateway status" 2>/dev/null | grep -q "running"; then
        log "Gateway já está rodando!"
        return 0
    fi
    
    # Mata processos antigos e inicia
    ssh -o StrictHostKeyChecking=no root@$STARK_IP \
        "pkill -9 -f openclaw 2>/dev/null; sleep 2; openclaw launch --model $SAMU_MODEL > /tmp/stark.log 2>&1 &" 2>/dev/null
    
    sleep 20
    check_stark && return 0 || return 1
}

try_reboot_ct() {
    log "Tentativa 4: Reboot CT..."
    ssh -o StrictHostKeyChecking=no root@$PVE_IP "pct reboot $STARK_CT_ID" 2>/dev/null
    sleep 60
    check_stark && return 0 || return 1
}

# ============================================
# ALERTAS
# ============================================

alert_offline() {
    local offline_time="$1"
    local logs="$2"
    local last_action="$3"
    
    log "=== ENVIANDO ALERTA: STARK OFFLINE ==="
    
    local msg="⚠️ <b>STARK ESTÁ FORA!</b>

🕐 Desde: $offline_time
🔍 <b>Investigando...</b>

📋 Última ação conhecida:
$last_action

🔄 SAMU tentando restaurar..."
    
    send_telegram "$msg"
}

alert_resolved() {
    local offline_time="$1"
    local restart_time="$2"
    local method="$3"
    local logs="$4"
    local last_action="$5"
    
    local offline_sec=$(($(date -d "$restart_time" +%s) - $(date -d "$offline_time" +%s)))
    local offline_min=$((offline_sec / 60))
    
    local msg="✅ <b>STARK RETORNOU!</b>

⏰ Ficou offline: $offline_time
✅ Retornou: $restart_time
⏱️ Tempo: ~${offline_min} minutos
🔧 Método: $method

📋 <b>RELATÓRIO SAMU:</b>

🔍 Última ação antes de cair:
$last_action

📊 Logs coletados:
$(echo "$logs" | head -30 | sed 's/^/   /')
"
    
    send_telegram "$msg"
    send_email "✅ Stark Retornou ao Normal" "Stark ficou offline por ${offline_min} minutos. Metodo: $method. Ultima ação: $last_action"
}

alert_critical() {
    local offline_time="$1"
    local logs="$2"
    local last_action="$3"
    
    local msg="🚨 <b>ALERTA CRÍTICO - STARK OFFLINE</b>

⏰ Horário: $offline_time
❌ <b>TODAS AS TENTATIVAS FALHARAM!</b>

🔍 <b>Última ação conhecida:</b>
$last_action

📊 <b>Logs coletados:</b>
$(echo "$logs" | head -20 | sed 's/^/   /')

⚠️ <b>AÇÃO MANUAL REQUERIDA!</b>
1. Acesse: ssh root@$STARK_IP
2. Verifique: journalctl --user -u openclaw-gateway.service
3. Execute manualmente: openclaw launch --model $SAMU_MODEL
"
    
    send_telegram "$msg"
    send_email "🚨 ALERTA CRITICO - Stark Offline" "Todas as tentativas de restauracao falharam. Ultima acao: $last_action"
}

# ============================================
# PRINCIPAL
# ============================================

main() {
    log "=============================================="
    log "SAMU ATIVADO - MANUTENÇÃO DO STARK"
    log "Hora: $(date '+%Y-%m-%d %H:%M:%S')"
    log "=============================================="
    
    if [ -f "$LOCK_FILE" ]; then
        PID=$(cat "$LOCK_FILE" 2>/dev/null)
        if [ -n "$PID" ] && kill -0 $PID 2>/dev/null; then
            log "Já está rodando (PID $PID)"
            return 1
        fi
    fi
    
    echo $$ > "$LOCK_FILE"
    
    OFFLINE_TIME=$(date '+%Y-%m-%d %H:%M:%S')
    
    # Coleta informações ANTES de tentar restartar
    log "Coletando informações do Stark..."
    LOGS=$(collect_stark_logs)
    LAST_ACTION=$(get_last_action)
    
    log "=== INFORMAÇÕES COLETADAS ==="
    log "Última ação: $LAST_ACTION"
    
    alert_offline "$OFFLINE_TIME" "$LOGS" "$LAST_ACTION"
    
    RESTART_TIME=$(date '+%Y-%m-%d %H:%M:%S')
    METHOD=""
    
    # Tentativas de restauração
    try_restart_gateway && METHOD="restart gateway" || \
    try_stop_start && METHOD="stop + start" || \
    try_openclaw_launch && METHOD="openclaw launch" || \
    try_reboot_ct && METHOD="reboot CT"
    
    # Resultado
    if [ -n "$METHOD" ]; then
        alert_resolved "$OFFLINE_TIME" "$RESTART_TIME" "$METHOD" "$LOGS" "$LAST_ACTION"
    else
        alert_critical "$OFFLINE_TIME" "$LOGS" "$LAST_ACTION"
    fi
    
    rm -f "$LOCK_FILE"
    log "=== FIM DO CICLO SAMU ==="
}

main
