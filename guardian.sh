#!/bin/bash
# STARK GUARDIAN - Sistema de Proteção com Palavra Mágica
# Ativa SAMU e Supervisor apenas em emergência

export TZ=America/Sao_Paulo

TELEGRAM_TOKEN="8674882792:AAEIwzMDLWrMUdhYJ9qlk492gQ-X2KXAbTc"
CHAT_ID="1866226415"

MAGIC_WORD="LIBERAR"
LOG_FILE="/root/.openclaw/guardian.log"

log() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $1" | tee -a "$LOG_FILE"
}

send_telegram() {
    local msg="$1"
    curl -s -X POST "https://api.telegram.org/bot$TELEGRAM_TOKEN/sendMessage" \
        -d "chat_id=$CHAT_ID" -d "text=$msg" -d "parse_mode=HTML" > /dev/null 2>&1
}

# ============================================
# SALVAR ESTADO ATUAL
# ============================================

save_state() {
    log "=== SALVANDO ESTADO ATUAL ==="
    
    mkdir -p /root/.openclaw/guardian
    
    # Salvar IPs e configs
    cat > /root/.openclaw/guardian/ips.conf << 'EOF'
STARK_IP=192.168.0.21
PVE_IP=192.168.0.192
MAILBOT_IP=192.168.0.240
DATASVR_IP=192.168.0.72
SUPERVISOR_IP=192.168.0.42
SAMU_IP=192.168.0.64
VORCARO_IP=192.168.0.172
OFFICEBOY_IP=192.168.0.117
SEGURANCA_IP=192.168.0.231
EOF
    
    # Status atual
    echo "STATE_SAVED=$(date '+%Y-%m-%d %H:%M:%S')" >> /root/.openclaw/guardian/ips.conf
    
    log "Estado salvo em /root/.openclaw/guardian/"
    send_telegram "💾 <b>ESTADO SALVO</b>

📁 Local: /root/.openclaw/guardian/
🕐 $(date '+%H:%M:%S')"
}

# ============================================
# ATIVAR EMERGÊNCIA
# ============================================

activate_emergency() {
    log "=== ATIVANDO MODO EMERGÊNCIA ==="
    
    send_telegram "🚨 <b>MODO EMERGÊNCIA ATIVADO!</b>

🔓 Palavra mágica recebida
⏰ $(date '+%H:%M:%S')

⚡ Ativando SAMU e Supervisor..."
    
    # Ativar SAMU - verificar a cada 60s
    ssh -o StrictHostKeyChecking=no root@192.168.0.64 "
        echo '* * * * * /root/samu/monitor.sh >> /root/samu/cron_emerg.log 2>&1' | crontab -
        echo 'SAMU ATIVADO!'
    " 2>/dev/null
    
    # Ativar Supervisor - verificar a cada 30s
    ssh -o StrictHostKeyChecking=no root@192.168.0.42 "
        echo '* * * * * /root/supervisor/vice_stark.sh monitor >> /root/supervisor/vice_cron.log 2>&1' | crontab -
        echo 'SUPERVISOR ATIVADO!'
    " 2>/dev/null
    
    send_telegram "✅ <b>EMERGÊNCIA ATIVA</b>

👁️ SAMU: Verificando a cada 60s
👁️ Supervisor: Verificando a cada 30s
🔄 Monitorando Stark..."
}

# ============================================
# DESATIVAR EMERGÊNCIA
# ============================================

deactivate_emergency() {
    log "=== DESATIVANDO MODO EMERGÊNCIA ==="
    
    send_telegram "🔒 <b>MODO EMERGÊNCIA DESATIVADO</b>

⏰ $(date '+%H:%M:%S')
✅ Voltando ao modo normal"
    
    # Desativar SAMU
    ssh -o StrictHostKeyChecking=no root@192.168.0.64 "crontab -r" 2>/dev/null
    
    # Desativar Supervisor
    ssh -o StrictHostKeyChecking=no root@192.168.0.42 "crontab -r" 2>/dev/null
}

# ============================================
# VERIFICAR ESTADO
# ============================================

check_status() {
    log "=== VERIFICANDO ESTADO ==="
    
    local samu_active=$(ssh -o ConnectTimeout=5 root@192.168.0.64 "crontab -l 2>/dev/null | grep -c monitor" 2>/dev/null || echo "0")
    local sup_active=$(ssh -o ConnectTimeout=5 root@192.168.0.42 "crontab -l 2>/dev/null | grep -c vice_stark" 2>/dev/null || echo "0")
    
    local status="📊 <b>ESTADO ATUAL</b>

🕐 $(date '+%H:%M:%S')

👁️ <b>SAMU:</b> "
    [ "$samu_active" -gt 0 ] && status="$status ⚠️ ATIVO" || status="$status ✅ DORMANT"
    
    status="$status

👁️ <b>SUPERVISOR:</b> "
    [ "$sup_active" -gt 0 ] && status="$status ⚠️ ATIVO" || status="$status ✅ DORMANT"
    
    status="$status

━━━━━━━━━━━━━━━
💡 Comandos:
<code>/guard save</code> - Salvar estado
<code>/guard emergencia</code> - Ativar emergência
<code>/guard normal</code> - Desativar"
    
    send_telegram "$status"
}

# ============================================
# RESTAURAR ESTADO SALVO
# ============================================

restore_state() {
    log "=== RESTAURANDO ESTADO ==="
    
    if [ -f /root/.openclaw/guardian/ips.conf ]; then
        source /root/.openclaw/guardian/ips.conf
        
        send_telegram "♻️ <b>RESTAURANDO ESTADO SALVO</b>

📁 De: /root/.openclaw/guardian/
🕐 $(cat /root/.openclaw/guardian/ips.conf | grep STATE_SAVED | cut -d= -f2)"
        
        # Desativar tudo primeiro
        deactivate_emergency
        
        sleep 2
        
        # Restaurar configurações se necessário
        log "Estado restaurado!"
        send_telegram "✅ <b>ESTADO RESTAURADO</b>

🔄 Configurações de rede
🔄 IPs dos agentes
🔄 Pronto para operação normal"
    else
        send_telegram "❌ <b>ERRO</b>

📁 Nenhum estado salvo encontrado"
    fi
}

# ============================================
# MAIN
# ============================================

main() {
    local cmd="$1"
    
    log "Comando: $cmd"
    
    case "$cmd" in
        "save"|"/guard save")
            save_state
            ;;
        "emergencia"|"/guard emergencia"|"LIBERAR")
            activate_emergency
            ;;
        "normal"|"/guard normal")
            deactivate_emergency
            ;;
        "status"|"/guard status")
            check_status
            ;;
        "restore"|"/guard restore")
            restore_state
            ;;
        *)
            echo "Uso: $0 [save|emergencia|normal|status|restore]"
            ;;
    esac
}

main "$@"
