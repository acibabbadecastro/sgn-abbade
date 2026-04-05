#!/bin/bash
# SUPERVISOR v2 - Vice-Stark
# Assume controle quando Stark cai
# Desperta Stark e devolve controle quando acordar

export TZ=America/Sao_Paulo

# ============================================
# CONFIGURAÇÕES
# ============================================
STARK_IP="192.168.0.192"
STARK_CT_ID="100"
PVE_IP="192.168.0.192"
SAMU_IP="192.168.0.64"
SUPERVISOR_IP="192.168.0.42"

# Agentes
declare -A AGENTS=(
    ["MailBot"]="192.168.0.240:101"
    ["DATASVR"]="192.168.0.72:102"
    ["Vorcaro"]="192.168.0.172:104"
    ["OfficeBoy"]="192.168.0.117:105"
    ["Seguranca"]="192.168.0.231:106"
    ["SAMU"]="192.168.0.64:107"
)

TELEGRAM_TOKEN="8674882792:AAEIwzMDLWrMUdhYJ9qlk492gQ-X2KXAbTc"
CHAT_ID="1866226415"

LOG_FILE="/root/supervisor/team.log"
LAST_ACTION_FILE="/root/supervisor/last_actions.txt"
LOCK_FILE="/root/supervisor/vice.lock"

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
}

# ============================================
# VERIFICA STARK
# ============================================

check_stark() {
    # Tenta SSH + gateway
    if ssh -o ConnectTimeout=10 -o StrictHostKeyChecking=no root@$STARK_IP "openclaw gateway status" 2>/dev/null | grep -q "running"; then
        echo "ONLINE"
    else
        echo "OFFLINE"
    fi
}

# ============================================
# COLETA INFORMAÇÕES DE CADA AGENTE
# ============================================

get_agent_info() {
    local nome="$1"
    local ip="$2"
    local ct_id="$3"
    
    local info=""
    
    # Status SSH
    if ssh -o ConnectTimeout=5 root@$ip "exit 0" 2>/dev/null; then
        info="✅ SSH OK"
    else
        info="❌ SSH FAIL"
        return
    fi
    
    # Status Gateway
    if ssh -o StrictHostKeyChecking=no root@$ip "openclaw gateway status" 2>/dev/null | grep -q "running"; then
        info="$info | ✅ Gateway"
    else
        info="$info | ⚠️ Gateway OFF"
    fi
    
    # Última ação (history + logs)
    local last_cmd=$(ssh -o StrictHostKeyChecking=no root@$ip "tail -20 ~/.bash_history 2>/dev/null | tail -1" 2>/dev/null)
    [ -n "$last_cmd" ] && info="$info | Last CMD: $last_cmd"
    
    # Interações (verificar se conversou com outros)
    local interact=$(ssh -o StrictHostKeyChecking=no root@ip "grep -c 'interaction' /root/.openclaw/*.log 2>/dev/null" || echo "0")
    info="$info | Interações: $interact"
    
    echo "$info"
}

# ============================================
# RELATÓRIO COMPLETO DE TODOS OS AGENTES
# ============================================

full_report() {
    log "=== GERANDO RELATÓRIO COMPLETO ==="
    
    local report="📊 <b>RELATÓRIO COMPLETO DA EQUIPE</b>
🕐 $(date '+%H:%M:%S')

━━━━━━━━━━━━━━━
🟢 <b>STARK:</b> $(check_stark)
━━━━━━━━━━━━━━━"
    
    for nome in "${!AGENTS[@]}"; do
        IFS=':' read -r ip ct_id <<< "${AGENTS[$nome]}"
        
        report="$report

━━━━━━━━━━━━━━━
🤖 <b>$nome</b> (CT $ct_id)
"
        
        # Status
        if ssh -o ConnectTimeout=5 root@$ip "exit 0" 2>/dev/null; then
            report="$report ✅ SSH |"
            
            if ssh -o StrictHostKeyChecking=no root@$ip "openclaw gateway status" 2>/dev/null | grep -q "running"; then
                report="$report ✅ Gateway"
            else
                report="$report ⚠️ Gateway OFF"
            fi
            
            # Última tarefa
            local last_task=$(ssh -o StrictHostKeyChecking=no root@$ip "cat /root/.openclaw/agent_last_task.txt 2>/dev/null || echo 'N/A'" 2>/dev/null)
            report="$report

📋 Última tarefa: $last_task"
            
            # Logs recentes
            local recent_log=$(ssh -o StrictHostKeyChecking=no root@$ip "tail -5 /tmp/openclaw/*.log 2>/dev/null | tail -1" 2>/dev/null)
            [ -n "$recent_log" ] && report="$report

📜 Log: $(echo "$recent_log" | head -c100)"
            
        else
            report="$report ❌ COMPLETAMENTE OFFLINE"
        fi
        
        report="$report
"
    done
    
    report="$report
━━━━━━━━━━━━━━━"
    
    send_telegram "$report"
}

# ============================================
# TENTAR DESPERTAR STARK
# ============================================

wake_stark() {
    log "=== TENTANDO DESPERTAR STARK ==="
    
    send_telegram "🔴 <b>STARK OFFLINE - DESPERTANDO...</b>"
    
    # 1. Verificar se CT está rodando
    local ct_status=$(ssh -o StrictHostKeyChecking=no root@$PVE_IP "pct status $STARK_CT_ID" 2>/dev/null)
    log "CT Status: $ct_status"
    
    if ! echo "$ct_status" | grep -q "running"; then
        log "Iniciando CT..."
        ssh -o StrictHostKeyChecking=no root@$PVE_IP "pct start $STARK_CT_ID" 2>/dev/null
        sleep 30
    fi
    
    # 2. Verificar gateway
    if ! ssh -o ConnectTimeout=10 root@$STARK_IP "openclaw gateway status" 2>/dev/null | grep -q "running"; then
        log "Iniciando gateway..."
        ssh -o StrictHostKeyChecking=no root@$STARK_IP "systemctl --user start openclaw-gateway" 2>/dev/null
        sleep 10
    fi
    
    # 3. Verificar se responde
    if check_stark | grep -q "ONLINE"; then
        log "Stark acordado!"
        send_telegram "🟢 <b>STARK DESPERTADO!</b>

✅ Gateway online
🔄 Devolvendo controle..."
        return 0
    fi
    
    # 4. Tentar ollama launch
    log "Tentando ollama launch..."
    ssh -o StrictHostKeyChecking=no root@$STARK_IP "pkill -f 'openclaw' 2>/dev/null; sleep 2; ollama launch openclaw --model ollama/minimax-m2.7:cloud > /tmp/stark_wake.log 2>&1 &" 2>/dev/null
    sleep 20
    
    if check_stark | grep -q "ONLINE"; then
        log "Stark acordado via ollama!"
        send_telegram "🟢 <b>STARK DESPERTADO!</b>

🔧 Método: ollama launch"
        return 0
    fi
    
    log "FALHA ao despertar Stark"
    send_telegram "❌ <b>FALHA ao despertar Stark</b>

⚠️ Ação manual pode ser necessária"
    return 1
}

# ============================================
# VERIFICAR SE STARK VOLTOU
# ============================================

check_stark_return() {
    # Se Stark está online e tínhamos assumido, devolver controle
    if check_stark | grep -q "ONLINE"; then
        log "Stark voltou! Devolvendo controle..."
        send_telegram "🟢 <b>STARK DE VOLTA!</b>

✅ Retomou operação normal
👁️ Supervisor voltando a monitorar"
        return 0
    fi
    return 1
}

# ============================================
# MONITORAMENTO PRINCIPAL
# ============================================

monitor_loop() {
    # Verificar Stark
    local stark_status=$(check_stark)
    
    if echo "$stark_status" | grep -q "OFFLINE"; then
        log "ALERTA: STARK OFFLINE!"
        
        # Tentar acordar
        wake_stark
        
        # Se ainda offline, assumir controle
        if check_stark | grep -q "OFFLINE"; then
            log "STARK CONTINUA OFFLINE - ASSUMINDO CONTROLE"
            assume_control
        fi
    else
        check_stark_return
    fi
    
    # Verificar outros agentes
    for nome in "${!AGENTS[@]}"; do
        IFS=':' read -r ip ct_id <<< "${AGENTS[$nome]}"
        
        if ! ssh -o ConnectTimeout=5 root@$ip "exit 0" 2>/dev/null; then
            log "ALERTA: $nome OFFLINE!"
            send_telegram "⚠️ <b>$nome OFFLINE!</b>

🔧 Iniciando CT $ct_id..."
            
            # Tentar startar
            ssh -o StrictHostKeyChecking=no root@$PVE_IP "pct start $ct_id" 2>/dev/null
        fi
    done
}

# ============================================
# ASSUMIR CONTROLE
# ============================================

assume_control() {
    log "=== SUPERVISOR ASSUMINDO CONTROLE ==="
    
    send_telegram "🚨 <b>SUPERVISOR ASSUMIU CONTROLE</b>

⚠️ Stark continua offline
👁️ Eu estou assumindo operações
📊 Monitorando equipe
🔄 Tentando acordar Stark"
    
    # Gerar relatório da situação
    full_report
    
    # Loop de verificação a cada 30s enquanto aguarda Stark
    local count=0
    while check_stark | grep -q "OFFLINE"; do
        sleep 30
        count=$((count + 1))
        
        # A cada 2 min, relatório
        if [ $((count % 4)) -eq 0 ]; then
            send_telegram "⏱️ <b>Aguardando Stark...</b>

👁️ Supervisor no comando há ${count}0 segundos
📊 Verificações contínuas"
            
            # Tentar acordar novamente
            wake_stark
        fi
    done
    
    # Stark voltou!
    check_stark_return
}

# ============================================
# COMANDOS INTERATIVOS
# ============================================

cmd_status() {
    full_report
}

cmd_menu() {
    send_telegram "📋 <b>MENU SUPERVISOR</b>

<code>/status</code> - Relatório completo
<code>/wake</code> - Despertar Stark
<code>/agents</code> - Status dos agentes
<code>/logs</code> - Ver logs
<code>/help</code> - Ajuda"
}

cmd_help() {
    send_telegram "ℹ️ <b>SUPERVISOR v2 - Vice-Stark</b>

<b>Funções:</b>
• Monitorar todos os agentes
• Assumir se Stark cair
• Despertar Stark
• Relatório de tarefas

<b>Automático:</b>
• Verifica a cada 60s
• Se Stark offline → acorda
• Se não conseguir → assume
• Quando Stark volta → devolve"
}

# ============================================
# MAIN
# ============================================

main() {
    local mode="${1:-monitor}"
    
    case "$mode" in
        "monitor")
            log "=== MONITORAMENTO SUPERVISOR v2 ==="
            monitor_loop
            ;;
        "status")
            cmd_status
            ;;
        "menu")
            cmd_menu
            ;;
        "help")
            cmd_help
            ;;
        *)
            echo "Uso: $0 [monitor|status|menu|help]"
            ;;
    esac
}

main "$@"
