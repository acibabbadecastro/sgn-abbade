#!/bin/bash
# SUPERVISOR - Monitor de Equipe
# Verifica a cada 60 seg se todos os agentes estão funcionando
# Tenta startar CTs offline e notifica sobre Stark

export TZ=America/Sao_Paulo

# ============================================
# CONFIGURAÇÕES
# ============================================
STARK_IP="192.168.0.192"
STARK_CT_ID="100"
PVE_IP="192.168.0.192"
SAMU_IP="192.168.0.64"
MAILBOT_IP="192.168.0.240"
EMAIL_DEST="acib@outlook.com"

# Lista de agentes
AGENTS=(
    "MailBot:192.168.0.240:101"
    "DATASVR:192.168.0.72:102"
    "Vorcaro:192.168.0.172:104"
    "OfficeBoy:192.168.0.117:105"
    "Seguranca:192.168.0.231:106"
    "SAMU:192.168.0.64:107"
)

TELEGRAM_TOKEN="8674882792:AAEIwzMDLWrMUdhYJ9qlk492gQ-X2KXAbTc"
CHAT_ID="1866226415"

LOG_FILE="/root/supervisor/team.log"
LOCK_FILE="/root/supervisor/monitor.lock"

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

notify_stark() {
    local agent="$1"
    local status="$2"
    local detalhes="$3"
    
    local msg="📊 <b>SUPERVISOR AVISA:</b>

🤖 Agente: <b>$agent</b>
📌 Status: $status
🕐 Horário: $(date '+%H:%M:%S')
$detalhes"
    
    # Notifica Stark via SSH
    ssh -o StrictHostKeyChecking=no -o ConnectTimeout=10 root@$STARK_IP \
        "echo '$msg' | mail -s '[SUPERVISOR] $agent - $status' $EMAIL_DEST" 2>/dev/null
    
    log "Notificado Stark sobre: $agent - $status"
}

notify_samu_about_stark() {
    log "ALERTA: STARK OFFLINE! Notificando SAMU..."
    
    local msg="🚨 <b>SUPERVISOR → SAMU:</b>

⚠️ <b>STARK ESTÁ OFFLINE!</b>
🕐 Horário: $(date '+%Y-%m-%d %H:%M:%S')

<b>TAREFA:</b>
1. Coleta logs do Stark
2. Identifica última ação antes de cair
3. Inicia o Stark
4. Reporta em @Acib_Abbade

IPs:
- Stark: $STARK_IP
- SAMU: $SAMU_IP"
    
    # Notifica SAMU via Telegram
    send_telegram "$msg"
    
    # SAMU também recebe por SSH
    ssh -o StrictHostKeyChecking=no root@$SAMU_IP \
        "echo '$msg' | mail -s '[SUPERVISOR] STARK OFFLINE' $EMAIL_DEST" 2>/dev/null
    
    log "SAMU notificado sobre Stark offline"
}

check_agent() {
    local nome="$1"
    local ip="$2"
    
    if ssh -o ConnectTimeout=10 -o StrictHostKeyChecking=no root@$ip \
        "hostname && openclaw gateway status" > /dev/null 2>&1; then
        echo "ONLINE"
    else
        if ssh -o ConnectTimeout=5 -o StrictHostKeyChecking=no root@$ip "exit 0" > /dev/null 2>&1; then
            echo "GATEWAY_OFFLINE"
        else
            echo "OFFLINE"
        fi
    fi
}

start_ct() {
    local ct_id="$1"
    local nome="$2"
    
    log "Tentando startar $nome (CT $ct_id)..."
    
    if ssh -o StrictHostKeyChecking=no root@$PVE_IP "pct status $ct_id" 2>/dev/null | grep -q "stopped"; then
        ssh -o StrictHostKeyChecking=no root@$PVE_IP "pct start $ct_id" 2>/dev/null
        sleep 5
        log "$nome: CT iniciado"
        return 0
    else
        log "$nome: CT não está parado (pode estar rodando ou inacessível)"
        return 1
    fi
}

# ============================================
# PRINCIPAL
# ============================================

main() {
    log "=============================================="
    log "SUPERVISOR - Verificacao da Equipe (60s)"
    log "Hora: $(date '+%Y-%m-%d %H:%M:%S')"
    log "=============================================="
    
    # Evita duplicidade
    if [ -f "$LOCK_FILE" ]; then
        PID=$(cat "$LOCK_FILE" 2>/dev/null)
        if [ -n "$PID" ] && kill -0 $PID 2>/dev/null; then
            log "Ja esta rodando (PID $PID)"
            return 1
        fi
    fi
    
    echo $$ > "$LOCK_FILE"
    
    STARK_OFFLINE=0
    OTHER_OFFLINE=""
    
    # Verifica STARK primeiro
    log "Verificando: STARK ($STARK_IP)..."
    if ssh -o ConnectTimeout=10 -o StrictHostKeyChecking=no root@$STARK_IP "openclaw gateway status" > /dev/null 2>&1; then
        log "  ✓ STARK - ONLINE"
    else
        log "  ✗ STARK - OFFLINE!"
        STARK_OFFLINE=1
        notify_samu_about_stark
    fi
    
    # Verifica outros agentes
    for agent in "${AGENTS[@]}"; do
        nome="${agent%%:*}"
        ip="${agent%%:*}"
        ip="${ip##*:}"
        # já temos ip acima, agora ct_id
        ct_id="${agent##*:}"
        
        log "Verificando: $nome ($ip)..."
        status=$(check_agent "$nome" "$ip")
        
        if [ "$status" == "ONLINE" ]; then
            log "  ✓ $nome - ONLINE"
        elif [ "$status" == "GATEWAY_OFFLINE" ]; then
            log "  ⚠ $nome - Gateway Offline (SSH OK)"
            notify_stark "$nome" "GATEWAY_OFFLINE" "Gateway não responde mas SSH funciona"
        else
            log "  ✗ $nome - OFFLINE"
            OTHER_OFFLINE="$OTHER_OFFLINE $nome"
            
            # Tenta startar o CT
            start_ct "$ct_id" "$nome"
            
            notify_stark "$nome" "OFFLINE" "Agente inacessível. Tentativa de start iniciada."
        fi
    done
    
    # Resumo
    log "=============================================="
    log "RESUMO:"
    [ $STARK_OFFLINE -eq 0 ] && [ -z "$OTHER_OFFLINE" ] && log "  Todos os agentes ONLINE!" || {
        [ $STARK_OFFLINE -eq 1 ] && log "  ⚠️ STARK OFFLINE (SAMU notificado)"
        [ -n "$OTHER_OFFLINE" ] && log "  OFFLINE:$OTHER_OFFLINE"
    }
    log "=============================================="
    
    rm -f "$LOCK_FILE"
}

main
