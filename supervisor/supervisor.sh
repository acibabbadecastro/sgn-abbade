#!/bin/bash
# SUPERVISOR - Monitor de Equipe + Comandos
# Verifica a cada 60 seg + responde comandos do Stark

export TZ=America/Sao_Paulo

# ============================================
# CONFIGURAÇÕES
# ============================================
STARK_IP="192.168.0.192"
PVE_IP="192.168.0.192"
SAMU_IP="192.168.0.64"
MAILBOT_IP="192.168.0.240"

# CTs
STARK_CT_ID="100"
MAILBOT_CT_ID="101"
DATASVR_CT_ID="102"
VORCARO_CT_ID="104"
OFFICE_CT_ID="105"
SEGURANCA_CT_ID="106"

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
CMD_FILE="/root/supervisor/commands.txt"
LOCK_FILE="/root/supervisor/monitor.lock"

# ============================================
# FUNÇÕES DE LOG
# ============================================

log() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $1" | tee -a "$LOG_FILE"
}

# ============================================
# FUNÇÕES DE REDE
# ============================================

send_telegram() {
    local msg="$1"
    curl -s -X POST "https://api.telegram.org/bot$TELEGRAM_TOKEN/sendMessage" \
        -d "chat_id=$CHAT_ID" -d "text=$msg" -d "parse_mode=HTML" > /dev/null 2>&1
}

send_telegram_multi() {
    # Envia mensagem longa dividindo em partes
    local msg="$1"
    local max_len=4000
    
    while [ ${#msg} -gt 0 ]; do
        local part="${msg:0:$max_len}"
        msg="${msg:$max_len}"
        send_telegram "$part"
        [ -n "$msg" ] && sleep 0.5
    done
}

# ============================================
# COMANDOS DO SUPERVISOR
# ============================================

check_stark_status() {
    log "Verificando status do Stark..."
    
    if ssh -o ConnectTimeout=10 -o StrictHostKeyChecking=no root@$STARK_IP "openclaw gateway status" 2>/dev/null | grep -q "running"; then
        echo "ONLINE"
    else
        echo "OFFLINE"
    fi
}

get_ct_status() {
    local nome="$1"
    local ip="$2"
    local ct_id="$3"
    
    local ssh_status="❌"
    local gateway_status="❌"
    local ct_status="❌"
    
    # Testa SSH
    if ssh -o ConnectTimeout=5 -o StrictHostKeyChecking=no root@$ip "exit 0" 2>/dev/null; then
        ssh_status="✅"
        
        # Testa Gateway
        if ssh -o StrictHostKeyChecking=no root@$ip "openclaw gateway status" 2>/dev/null | grep -q "running"; then
            gateway_status="✅"
        else
            gateway_status="⚠️"
        fi
    fi
    
    # Status do CT no pve
    local ct_raw=$(ssh -o StrictHostKeyChecking=no root@$PVE_IP "pct status $ct_id" 2>/dev/null)
    if echo "$ct_raw" | grep -q "running"; then
        ct_status="🟢"
    elif echo "$ct_raw" | grep -q "stopped"; then
        ct_status="🔴"
    else
        ct_status="❓"
    fi
    
    echo "$ct_status $nome: SSH=$ssh_status Gateway=$gateway_status"
}

start_ct() {
    local nome="$1"
    local ct_id="$2"
    
    log "Iniciando $nome (CT $ct_id)..."
    
    local result=$(ssh -o StrictHostKeyChecking=no root@$PVE_IP "pct start $ct_id" 2>&1)
    
    if [ $? -eq 0 ]; then
        sleep 5
        send_telegram "✅ $nome iniciado! (CT $ct_id)"
        return 0
    else
        send_telegram "❌ Falha ao iniciar $nome: $result"
        return 1
    fi
}

restart_stark() {
    log "=== REINICIANDO STARK (via Supervisor) ==="
    
    local method="$1"
    local start_time=$(date '+%Y-%m-%d %H:%M:%S')
    
    send_telegram "🔄 <b>Reiniciando Stark...</b>
⏰ Início: $start_time
🔧 Método: $method"
    
    # Para todos os métodos exceto reboot
    if [ "$method" != "reboot" ]; then
        # Tenta restart gateway
        ssh -o StrictHostKeyChecking=no root@$STARK_IP "systemctl --user restart openclaw-gateway" 2>/dev/null
        sleep 15
        
        if check_stark_status | grep -q "ONLINE"; then
            send_telegram "✅ <b>STARK REINICIADO!</b>
🔧 Método: $method
⏰ Tempo: $(date '+%H:%M:%S')"
            return 0
        fi
        
        # Força stop + start
        ssh -o StrictHostKeyChecking=no root@$STARK_IP "systemctl --user stop openclaw-gateway; sleep 3; systemctl --user start openclaw-gateway" 2>/dev/null
        sleep 15
        
        if check_stark_status | grep -q "ONLINE"; then
            send_telegram "✅ <b>STARK REINICIADO!</b>
🔧 Método: $method
⏰ Tempo: $(date '+%H:%M:%S')"
            return 0
        fi
    fi
    
    # Reboot do CT
    log "Tentando reboot do CT..."
    ssh -o StrictHostKeyChecking=no root@$PVE_IP "pct reboot $STARK_CT_ID" 2>/dev/null
    sleep 60
    
    if check_stark_status | grep -q "ONLINE"; then
        send_telegram "✅ <b>STARK REINICIADO!</b>
🔧 Método: reboot CT
⏰ Tempo: $(date '+%H:%M:%S')"
        return 0
    fi
    
    send_telegram "❌ <b>FALHA AO REINICIAR STARK!</b>
Tente reiniciar manualmente."
    return 1
}

# ============================================
# MENU DE COMANDOS
# ============================================

show_menu() {
    send_telegram "📋 <b>MENU STARK - SUPERVISOR</b>

<code>1.</code> 📊 Status da Equipe
<code>2.</code> 🔄 Reiniciar Stark
<code>3.</code> 🚀 Startar Agente
<code>4.</code> 📜 Ver Logs Recentes
<code>5.</code> 🏥 SAMU - Status
<code>6.</code> ℹ️ Ajuda"
}

cmd_status() {
    log "Comando: Status da Equipe"
    
    local msg="📊 <b>STATUS DA EQUIPE</b>
🕐 $(date '+%H:%M:%S')

━━━━━━━━━━━━━━━
🟢 <b>STARK:</b> $(check_stark_status)
━━━━━━━━━━━━━━━"
    
    for nome in "${!AGENTS[@]}"; do
        IFS=':' read -r ip ct_id <<< "${AGENTS[$nome]}"
        msg="$msg
$(get_ct_status "$nome" "$ip" "$ct_id")"
    done
    
    msg="$msg
━━━━━━━━━━━━━━━"
    
    send_telegram_multi "$msg"
}

cmd_restart_stark() {
    log "Comando: Reiniciar Stark"
    
    if check_stark_status | grep -q "ONLINE"; then
        restart_stark "restart gateway"
    else
        send_telegram "⚠️ <b>STARK JÁ ESTÁ OFFLINE!</b>
Iniciando procedimento de emergência..."
        start_ct "Stark" "$STARK_CT_ID"
    fi
}

cmd_start_agent() {
    local agent="$1"
    
    case "$agent" in
        "1"|"MailBot"|"mailbot")
            start_ct "MailBot" "$MAILBOT_CT_ID"
            ;;
        "2"|"DATASVR"|"datasvr")
            start_ct "DATASVR" "$DATASVR_CT_ID"
            ;;
        "3"|"Vorcaro"|"vorcaro")
            start_ct "Vorcaro" "$VORCARO_CT_ID"
            ;;
        "4"|"OfficeBoy"|"officeboy")
            start_ct "OfficeBoy" "$OFFICE_CT_ID"
            ;;
        "5"|"Seguranca"|"seguranca")
            start_ct "Seguranca" "$SEGURANCA_CT_ID"
            ;;
        *)
            send_telegram "📋 <b>AGENTES DISPONÍVEIS:</b>

<code>1.</code> MailBot (CT 101)
<code>2.</code> DATASVR (CT 102)
<code>3.</code> Vorcaro (CT 104)
<code>4.</code> OfficeBoy (CT 105)
<code>5.</code> Seguranca (CT 106)

Use: /start [número ou nome]"
            ;;
    esac
}

cmd_logs() {
    log "Comando: Ver Logs"
    send_telegram "📜 <b>ÚLTIMOS LOGS DO SUPERVISOR</b>

<code>(tail -20 /root/supervisor/team.log)</code>

$(tail -20 $LOG_FILE 2>/dev/null | sed 's/^/    /')"
}

cmd_samu_status() {
    log "Comando: Status SAMU"
    
    if ssh -o ConnectTimeout=5 root@$SAMU_IP "exit 0" 2>/dev/null; then
        local last_run=$(ssh -o StrictHostKeyChecking=no root@$SAMU_IP "tail -5 /root/samu/monitor.log 2>/dev/null | head -1")
        send_telegram "🏥 <b>SAMU STATUS:</b>

✅ SAMU está online
🕐 Última verificação: $last_run"
    else
        send_telegram "🏥 <b>SAMU STATUS:</b>

❌ SAMU está offline!"
    fi
}

cmd_help() {
    send_telegram "ℹ️ <b>COMANDOS DISPONÍVEIS:</b>

<code>/menu</code> - Mostra este menu
<code>/status</code> - Status da equipe
<code>/restart</code> - Reinicia Stark
<code>/start [agente]</code> - Inicia agente específico
<code>/logs</code> - Ver logs recentes
<code>/samu</code> - Status do SAMU

<b>Agentes:</b> mailbot, datasvr, vorcaro, officeboy, seguranca"
}

# ============================================
# MONITORAMENTO AUTOMÁTICO
# ============================================

monitor_loop() {
    log "=== INICIANDO MONITORAMENTO (60s) ==="
    
    # Verifica Stark
    if ! check_stark_status | grep -q "ONLINE"; then
        log "ALERTA: STARK OFFLINE!"
        send_telegram "🚨 <b>ALERTA: STARK ESTÁ OFFLINE!</b>

🕐 $(date '+%H:%M:%S')
🔧 Tentando iniciar automaticamente..."
        
        # Tenta startar
        start_ct "Stark" "$STARK_CT_ID"
        
        # Notifica SAMU
        ssh -o StrictHostKeyChecking=no root@$SAMU_IP \
            "echo 'Supervisor detectou Stark offline em $(date)' >> /root/samu/samu_activations.log" 2>/dev/null
    fi
    
    # Verifica outros agentes
    for nome in "${!AGENTS[@]}"; do
        IFS=':' read -r ip ct_id <<< "${AGENTS[$nome]}"
        
        if ! ssh -o ConnectTimeout=5 root@$ip "exit 0" 2>/dev/null; then
            log "ALERTA: $nome OFFLINE!"
            send_telegram "⚠️ <b>$nome ESTÁ OFFLINE!</b>

🕐 $(date '+%H:%M:%S')
🔧 Iniciando automaticamente..."
            start_ct "$nome" "$ct_id"
        fi
    done
    
    log "=== MONITORAMENTO FINALIZADO ==="
}

# ============================================
# PROCESSAMENTO DE COMANDOS
# ============================================

process_command() {
    local cmd="$1"
    cmd=$(echo "$cmd" | tr '[:upper:]' '[:lower:]' | sed 's/^//')
    
    log "Processando comando: $cmd"
    
    case "$cmd" in
        "/menu"|"menu")
            show_menu
            ;;
        "/status"|"status"|"1")
            cmd_status
            ;;
        "/restart"|"restart"|"2")
            cmd_restart_stark
            ;;
        "/start"*|"start"*)
            local agent=$(echo "$cmd" | sed 's|/start ||' | sed 's/start //')
            cmd_start_agent "$agent"
            ;;
        "/logs"|"logs"|"4")
            cmd_logs
            ;;
        "/samu"|"samu"|"5")
            cmd_samu_status
            ;;
        "/help"|"help"|"6"|"info")
            cmd_help
            ;;
        *)
            send_telegram "❓ <b>Comando não reconhecido:</b> $cmd

Digite /menu para ver os comandos disponíveis."
            ;;
    esac
}

# ============================================
# MAIN
# ============================================

main() {
    local mode="$1"
    
    case "$mode" in
        "monitor")
            # Modo monitoramento automático
            monitor_loop
            ;;
        "cmd"|*)
            # Modo comando interativo
            if [ -n "$2" ]; then
                process_command "$2"
            else
                show_menu
            fi
            ;;
    esac
}

main "$@"
