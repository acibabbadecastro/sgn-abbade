#!/bin/bash
# TELEGRAM BRIDGE - Repassa comandos do Telegram para o Supervisor
# Roda no MailBot - verifica mensagens e envia para o Supervisor

export TZ=America/Sao_Paulo

TELEGRAM_TOKEN="8674882792:AAEIwzMDLWrMUdhYJ9qlk492gQ-X2KXAbTc"
SUPERVISOR_IP="192.168.0.42"
CHAT_ID="1866226415"
LAST_UPDATE_FILE="/root/.openclaw/last_update.txt"

LOG_FILE="/root/.openclaw/telegram_bridge.log"

log() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $1" | tee -a "$LOG_FILE"
}

send_reply() {
    local msg="$1"
    curl -s -X POST "https://api.telegram.org/bot$TELEGRAM_TOKEN/sendMessage" \
        -d "chat_id=$CHAT_ID" -d "text=$msg" -d "parse_mode=HTML" > /dev/null 2>&1
}

# Pega updates do Telegram
get_updates() {
    local offset="$1"
    curl -s "https://api.telegram.org/bot$TELEGRAM_TOKEN/getUpdates?offset=$offset&timeout=5" 2>/dev/null
}

# Processa mensagens
process_updates() {
    local last_update=$(cat "$LAST_UPDATE_FILE" 2>/dev/null || echo "0")
    
    local response=$(get_updates $((last_update + 1)))
    
    if [ -z "$response" ] || echo "$response" | grep -q '"ok":false'; then
        return 1
    fi
    
    # Verifica se há mensagens novas
    local update_ids=$(echo "$response" | grep -o '"update_id":[0-9]*' | cut -d':' -f2 | sort -n)
    
    if [ -z "$update_ids" ]; then
        return 1
    fi
    
    for update_id in $update_ids; do
        # Atualiza o último ID
        echo "$update_id" > "$LAST_UPDATE_FILE"
        
        # Extrai a mensagem
        local text=$(echo "$response" | jq -r ".result[] | select(.update_id == $update_id) | .message.text" 2>/dev/null)
        local chat_id_msg=$(echo "$response" | jq -r ".result[] | select(.update_id == $update_id) | .message.chat.id" 2>/dev/null)
        
        # Só processa se for do chat correto
        if [ "$chat_id_msg" != "$CHAT_ID" ]; then
            continue
        fi
        
        if [ -z "$text" ]; then
            continue
        fi
        
        log "Mensagem recebida: $text"
        
        # Envia para o Supervisor processar
        ssh -o StrictHostKeyChecking=no root@$SUPERVISOR_IP \
            "bash /root/supervisor/supervisor.sh cmd '$text'" 2>/dev/null
        
        # Responde que recebeu
        send_reply "📨 Mensagem enviada para o Supervisor..."
    done
}

# Menu principal
show_menu() {
    send_reply "📋 <b>MENU STARK</b>

<b>Supervisor Commands:</b>
/status - Ver equipe
/restart - Reiniciar Stark
/start [agente] - Iniciar agente
/logs - Ver logs
/samu - Status SAMU

<b>Stark Commands:</b>
/ajuda - Ajuda geral
"
}

# Loop principal
log "=== TELEGRAM BRIDGE INICIADO ==="

while true; do
    process_updates
    sleep 3
done
