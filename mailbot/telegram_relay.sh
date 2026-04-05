#!/bin/bash
# TELEGRAM RELAY - Roda no MailBot
# Encaminha mensagens do Telegram pro Stark e retorna resposta

export TZ=America/Sao_Paulo

TELEGRAM_TOKEN="8674882792:AAEIwzMDLWrMUdhYJ9qlk492gQ-X2KXAbTc"
STARK_IP="192.168.0.192"
CHAT_ID="1866226415"

LOG_FILE="/root/.openclaw/telegram_relay.log"
LAST_UPDATE_FILE="/root/.openclaw/last_update.txt"

log() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $1" | tee -a "$LOG_FILE"
}

send_tg() {
    local msg="$1"
    curl -s -X POST "https://api.telegram.org/bot$TELEGRAM_TOKEN/sendMessage" \
        -d "chat_id=$CHAT_ID" -d "text=$msg" -d "parse_mode=HTML" > /dev/null 2>&1
}

# Resposta padrão do menu
show_menu() {
    send_tg "📋 <b>MENU STARK</b>

<b>Equipe:</b>
/status - Ver status da equipe
/restart - Reiniciar Stark
/start [agente] - Startar agente
/logs - Ver logs
/samu - Status SAMU
/ajuda - Este menu

<b>Quer falar comigo?</b>
Use este chat para comandos ou 
abra um chat direto comigo!"
}

get_updates() {
    local offset="$1"
    curl -s "https://api.telegram.org/bot$TELEGRAM_TOKEN/getUpdates?offset=$offset&timeout=3" 2>/dev/null
}

process_message() {
    local text="$1"
    text=$(echo "$text" | xargs)  # trim
    
    log "Comando: $text"
    
    # Comandos do Supervisor
    case "$text" in
        "/status"|"status"|"/1")
            ssh -o StrictHostKeyChecking=no root@192.168.0.42 "bash /root/supervisor/supervisor.sh cmd /status" 2>/dev/null
            ;;
        "/restart"|"restart"|"/2")
            ssh -o StrictHostKeyChecking=no root@192.168.0.42 "bash /root/supervisor/supervisor.sh cmd /restart" 2>/dev/null
            ;;
        "/start"|"start")
            send_tg "📋 <b>AGENTES:</b>

/start mailbot
/start datasvr
/start vorcaro
/start officeboy
/start seguranca"
            ;;
        "/start mailbot"|"/start 1")
            ssh -o StrictHostKeyChecking=no root@192.168.0.42 "bash /root/supervisor/supervisor.sh cmd /start mailbot" 2>/dev/null
            ;;
        "/start datasvr"|"/start 2")
            ssh -o StrictHostKeyChecking=no root@192.168.0.42 "bash /root/supervisor/supervisor.sh cmd /start datasvr" 2>/dev/null
            ;;
        "/start vorcaro"|"/start 3")
            ssh -o StrictHostKeyChecking=no root@192.168.0.42 "bash /root/supervisor/supervisor.sh cmd /start vorcaro" 2>/dev/null
            ;;
        "/start officeboy"|"/start 4")
            ssh -o StrictHostKeyChecking=no root@192.168.0.42 "bash /root/supervisor/supervisor.sh cmd /start officeboy" 2>/dev/null
            ;;
        "/start seguranca"|"/start 5")
            ssh -o StrictHostKeyChecking=no root@192.168.0.42 "bash /root/supervisor/supervisor.sh cmd /start seguranca" 2>/dev/null
            ;;
        "/logs"|"logs"|"/4")
            ssh -o StrictHostKeyChecking=no root@192.168.0.42 "bash /root/supervisor/supervisor.sh cmd /logs" 2>/dev/null
            ;;
        "/samu"|"samu"|"/5")
            ssh -o StrictHostKeyChecking=no root@192.168.0.42 "bash /root/supervisor/supervisor.sh cmd /samu" 2>/dev/null
            ;;
        "/menu"|"menu")
            show_menu
            ;;
        "/ajuda"|"ajuda"|"ajuda"|"help"|"/help")
            send_tg "📚 <b>COMANDOS:</b>

/menu - Este menu
/status - Status da equipe
/restart - Reiniciar Stark
/start [agente] - Startar agente
/logs - Logs do supervisor
/samu - Ver status SAMU"
            ;;
        *)
            # Qualquer outra mensagem vai pro Stark
            log "Mensagem para Stark: $text"
            send_tg "🤖 <b>Mensagem recebida!</b>

Você disse: $text

⚠️ Função de chat com Stark em desenvolvimento."
            ;;
    esac
}

# Script de polling
poll_telegram() {
    log "=== INICIANDO POLLING ==="
    
    # Reseta offset pra pegar mensagens desde o início
    echo "0" > "$LAST_UPDATE_FILE"
    
    while true; do
        local last_update=$(cat "$LAST_UPDATE_FILE" 2>/dev/null || echo "0")
        local response=$(get_updates $((last_update + 1)))
        
        if [ -z "$response" ] || echo "$response" | grep -q '"ok":false'; then
            sleep 3
            continue
        fi
        
        # Extrai update_ids
        local update_ids=$(echo "$response" | jq -r '.result[]?.update_id // empty' 2>/dev/null | sort -n)
        
        for update_id in $update_ids; do
            echo "$update_id" > "$LAST_UPDATE_FILE"
            
            local text=$(echo "$response" | jq -r ".result[] | select(.update_id == $update_id) | .message.text" 2>/dev/null)
            local chat_id_msg=$(echo "$response" | jq -r ".result[] | select(.update_id == $update_id) | .message.chat.id" 2>/dev/null)
            
            [ "$chat_id_msg" != "$CHAT_ID" ] && continue
            [ -z "$text" ] && continue
            
            process_message "$text"
        done
        
        sleep 1
    done
}

# Menu inicial
show_menu

# Inicia polling
poll_telegram
