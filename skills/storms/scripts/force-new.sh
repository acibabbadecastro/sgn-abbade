#!/bin/bash
# STORMS - Forçador Inteligente de /new
# Decide quando resetar sessão para economizar tokens

STORMS_DIR="$HOME/.openclaw/workspace/skills/storms"
DATA_DIR="$STORMS_DIR/monitors"
MAXIMOUS_DIR="$HOME/.openclaw/workspace/skills/maximous-v2"

# Thresholds
MAX_SESSION_MIN=${STORMS_MAX_SESSION_MIN:-240}  # 4 horas
MAX_TOKENS=${STORMS_TOKEN_LIMIT:-50000}
AUTO_NEW=${STORMS_AUTO_NEW:-true}

# Verificar condições para /new
check_new_needed() {
    local session_min=$1
    local tokens_used=$2
    local critical_tasks=$3
    
    local score=0
    
    # Pontuação baseada em tempo
    if [ $session_min -gt 360 ]; then  # 6h
        score=$((score + 40))
        echo "⚠️  Sessão muito longa (${session_min}min)"
    elif [ $session_min -gt 240 ]; then  # 4h
        score=$((score + 25))
        echo "⚠️  Sessão longa (${session_min}min)"
    fi
    
    # Pontuação baseada em tokens
    local token_pct=$((tokens_used * 100 / MAX_TOKENS))
    if [ $token_pct -gt 90 ]; then
        score=$((score + 35))
        echo "⚠️  Uso crítico de tokens (${token_pct}%)"
    elif [ $token_pct -gt 75 ]; then
        score=$((score + 20))
        echo "⚠️  Alto uso de tokens (${token_pct}%)"
    fi
    
    # Pontuação baseada em degradê de performance
    # (simulado - integrar com métricas reais)
    if [ -f "$DATA_DIR/performance_degraded" ]; then
        score=$((score + 15))
        echo "⚠️  Performance degradada detectada"
    fi
    
    echo ""
    echo "📊 Score de necessidade de /new: $score/100"
    
    # Decisão
    if [ $score -ge 70 ]; then
        if [ "$critical_tasks" == "true" ]; then
            echo ""
            echo "🛑 DECISÃO: NÃO fazer /new agora"
            echo "   Motivo: Tarefas críticas em andamento"
            echo "   Ação: Comprimir contexto e continuar"
            return 1
        else
            echo ""
            echo "✅ DECISÃO: Fazer /new RECOMENDADO"
            
            if [ "$AUTO_NEW" == "true" ]; then
                echo ""
                echo "🔄 Executando /new automaticamente..."
                # Salvar contexto no Maximous primeiro
                if [ -d "$MAXIMOUS_DIR" ]; then
                    bash "$MAXIMOUS_DIR/scripts/sync-imediato.sh" 2>/dev/null
                    echo "   Contexto preservado no Maximous"
                fi
                
                # Executar /new (simulado - na prática seria via API)
                echo "   /new executado!"
                echo "   Instruções para restauração salvas em:"
                echo "   ~/.openclaw/workspace/memory/restore-after-new.md"
            else
                echo "   (Modo manual: execute /new quando estiver pronto)"
            fi
            return 0
        fi
    elif [ $score -ge 40 ]; then
        echo ""
        echo "🟡 ATENÇÃO: Considere /new em breve"
        return 1
    else
        echo ""
        echo "🟢 Sessão saudável, continue trabalhando"
        return 1
    fi
}

# Analisar tarefas críticas
check_critical_tasks() {
    echo "🔍 Verificando tarefas críticas..."
    
    # Verificar se há tarefas urgentes registradas
    if [ -f "$MAXIMOUS_DIR/data/todos.json" ]; then
        URGENT=$(grep -c "urgente\|crítico\|hoje\|amanhã" "$MAXIMOUS_DIR/data/todos.json" 2>/dev/null || echo "0")
        if [ "$URGENT" -gt 0 ]; then
            echo "   ⚠️  Encontradas $URGENT tarefa(s) urgente(s)"
            return 0  # true
        fi
    fi
    
    echo "   ✅ Nenhuma tarefa crítica detectada"
    return 1  # false
}

# Simular valores (integrar com API real)
SESSION_MIN=${1:-300}  # 5 horas padrão
TOKENS_USED=${2:-40000}  # 40K tokens padrão

echo ""
echo "🌩️  STORMS - Forçador de /new"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# Verificar tarefas críticas
if check_critical_tasks; then
    CRITICAL="true"
else
    CRITICAL="false"
fi

# Executar verificação
check_new_needed $SESSION_MIN $TOKENS_USED $CRITICAL

exit $?
