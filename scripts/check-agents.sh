#!/bin/bash
# ============================================
# STARK AGENT MONITOR - Script de Monitoramento
# ============================================
# Verifica status de todos os agentes da equipe
# Se algum falhar, notifica e registra LOG
# ============================================

LOG_DIR="/root/.openclaw/workspace/logs"
DASHBOARD="/root/.openclaw/workspace/dashboard.md"
TEAM_FILE="/root/.openclaw/workspace/TEAM.md"

# Cores para output
VERDE='\033[0;32m'
AMARELO='\033[1;33m'
VERMELHO='\033[0;31m'
SEM_COR='\033[0m'

echo "🤖 Verificando agentes..."

# Verificar Stark (CT 100) - sempre online
if systemctl is-active --quiet openclaw 2>/dev/null; then
    echo -e "${VERDE}✅${SEM_COR} Stark (CT 100) - ONLINE"
    STARK_STATUS="✅ ONLINE"
else
    echo -e "${VERMELHO}❌${SEM_COR} Stark (CT 100) - FALHOU"
    STARK_STATUS="❌ FALHOU"
fi

# Verificar containers registrados na TEAM.md
if [ -f "$TEAM_FILE" ]; then
    echo ""
    echo "📋 Verificando equipe..."
    # Extrai CT IDs do TEAM.md
    AGENTS=$(grep -E "^\|.*CT [0-9]+" "$TEAM_FILE" | grep -oP 'CT \d+' | grep -oP '\d+' | sort -u)
    
    for CT_ID in $AGENTS; do
        echo ""
        echo "🔍 Verificando CT $CT_ID..."
        
        # Verificar se CT existe
        if pct status $CT_ID >/dev/null 2>&1; then
            # CT existe, verificar se está rodando
            if pct status $CT_ID | grep -q "running"; then
                # Verificar gateway do OpenClaw
                GATEWAY_STATUS=$(pct exec $CT_ID -- curl -s -o /dev/null -w "%{http_code}" http://127.0.0.1:18789 2>/dev/null || echo "000")
                
                if [ "$GATEWAY_STATUS" = "200" ]; then
                    echo -e "${VERDE}✅${SEM_COR} CT $CT_ID - ONLINE (Gateway OK)"
                else
                    echo -e "${AMARELO}⚠️${SEM_COR} CT $CT_ID - LENTO (Gateway: $GATEWAY_STATUS)"
                fi
            else
                echo -e "${VERMELHO}❌${SEM_COR} CT $CT_ID - PARADO"
                
                # Registrar falha
                FAIL_LOG="$LOG_DIR/falha-$(date +%Y-%m-%d_%H:%M).log"
                echo "FALHA DETECTADA: CT $CT_ID - $(date)" > "$FAIL_LOG"
                echo "Status: CT não está rodando" >> "$FAIL_LOG"
                pct status $CT_ID >> "$FAIL_LOG" 2>&1
                
                # Notificar (implementar depois via Telegram)
                echo "⚠️ ALERTA: CT $CT_ID falhou! Verificar logs em $FAIL_LOG"
            fi
        else
            echo -e "${VERMELHO}❌${SEM_COR} CT $CT_ID - NÃO EXISTE"
        fi
    done
else
    echo ""
    echo "📋 TEAM.md não encontrado. Nenhum agente para verificar."
fi

echo ""
echo "✅ Verificação concluída: $(date)"
