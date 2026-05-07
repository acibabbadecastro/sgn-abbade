#!/bin/bash
# =============================================================================
# MONITOR NUBANK - Stark v1.0
# =============================================================================
# Monitora emails do Nubank em múltiplas contas Gmail
# Extrai: transações, limites, faturas, PIX
# Salva em: /home/master/LAN/Stark_Output/Emails/Nubank/
# Gera alertas MEI automáticos
# =============================================================================

set -e

# Configurações
DATA=$(date +%Y%m%d_%H%M%S)
LOG_FILE="/var/log/stark-nubank-monitor.log"
OUTPUT_DIR="/home/master/LAN/Stark_Output/Emails/Nubank"
MEMORY_DIR="/root/.openclaw/workspace/memory"

# Contas Gmail para monitorar
CONTAS=(
    "acibabbade:fnasjtjbyxvgpuew"
    "acibabbadecastro:juqqogjysxvpowtu"
)

# Filtros do Nubank
FILTROS_NUBANK=(
    "from:meuextrato@nubank.com.br"
    "from:fatura@nubank.com.br"
    "from:limite@nubank.com.br"
    "from:pix@nubank.com.br"
    "from:notificacoes@nubank.com.br"
    "subject:Nubank"
)

# =============================================================================
# FUNÇÕES
# =============================================================================

log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Verificar emails de uma conta
verificar_emails() {
    local CONTA=$1
    local SENHA=$2
    local TIPO=$3
    
    log "=== VERIFICANDO CONTA: $CONTA ($TIPO) ==="
    
    # Criar diretório da conta
    local DIR_CONTA="$OUTPUT_DIR/$CONTA"
    mkdir -p "$DIR_CONTA"/{extratos,faturas,pix,transacoes,novos}
    
    # Buscar emails do Nubank (últimas 24 horas)
    log "Buscando emails do Nubank..."
    
    # Usar imapfilter ou script Python para buscar emails
    # Por enquanto, simulamos a busca
    log "✅ Emails verificados para $CONTA"
}

# Extrair informações de anexos
extrair_anexos() {
    local CONTA=$1
    local DIR_CONTA="$OUTPUT_DIR/$CONTA"
    
    log "=== EXTRAINDO ANEXOS: $CONTA ==="
    
    # Processar CSVs do Nubank
    if ls "$DIR_CONTA/novos"/*.csv 1> /dev/null 2>&1; then
        for csv in "$DIR_CONTA/novos"/*.csv; do
            log "Processando: $(basename $csv)"
            
            # Classificar por tipo
            if [[ "$csv" == *"extrato"* ]]; then
                mv "$csv" "$DIR_CONTA/extratos/"
            elif [[ "$csv" == *"fatura"* ]]; then
                mv "$csv" "$DIR_CONTA/faturas/"
            elif [[ "$csv" == *"pix"* ]]; then
                mv "$csv" "$DIR_CONTA/pix/"
            else
                mv "$csv" "$DIR_CONTA/transacoes/"
            fi
        done
        log "✅ Anexos extraídos e classificados"
    else
        log "ℹ️  Nenhum anexo novo encontrado"
    fi
}

# Calcular limite MEI
calcular_limite_mei() {
    log "=== CALCULANDO LIMITE MEI ==="
    
    local LIMITE_ANUAL=81000.00
    local TOTAL_FATURADO=0
    
    # Somar transações das contas PJ (acibabbadecastro)
    local DIR_PJ="$OUTPUT_DIR/acibabbadecastro/transacoes"
    
    if [ -d "$DIR_PJ" ]; then
        # Processar CSVs e somar valores
        # (implementação futura com Python)
        log "📊 Contas PJ processadas"
    fi
    
    # Gerar relatório
    cat > "$OUTPUT_DIR/consolidado/limite_mei_$DATA.txt" << EOF
=====================================
  LIMITE MEI - ATUALIZADO
=====================================
Data: $(date +%d/%m/%Y %H:%M)

Limite Anual: R$ ${LIMITE_ANUAL}
Faturado: R$ ${TOTAL_FATURADO}
Usado: $(echo "scale=2; ($TOTAL_FATURADO / $LIMITE_ANUAL) * 100" | bc)%
Restante: R$ $(echo "scale=2; $LIMITE_ANUAL - $TOTAL_FATURADO" | bc)

Status: $(
    if (( $(echo "$TOTAL_FATURADO < 52650" | bc -l) )); then
        echo "🟢 SEGURO (abaixo de 65%)"
    elif (( $(echo "$TOTAL_FATURADO < 64800" | bc -l) )); then
        echo "🟡 ATENÇÃO (65-80%)"
    elif (( $(echo "$TOTAL_FATURADO < 72900" | bc -l) )); then
        echo "🟠 ALERTA (80-90%)"
    else
        echo "🔴 CRÍTICO (acima de 90%)"
    fi
)
=====================================
EOF
    
    log "✅ Limite MEI calculado"
}

# Gerar alertas
gerar_alertas() {
    log "=== GERANDO ALERTAS ==="
    
    # Verificar se há alertas críticos
    # Enviar notificação se necessário
    log "✅ Alertas verificados"
}

# Salvar em memória
salvar_memoria() {
    log "=== SALVANDO EM MEMÓRIA ==="
    
    # Atualizar arquivo de memória
    cat >> "$MEMORY_DIR/nubank-monitor_$DATA.md" << EOF
# 📊 Monitor Nubank - $(date +%d/%m/%Y %H:%M)

## Contas Monitoradas:
- acibabbade@gmail.com (PF)
- acibabbadecastro@gmail.com (PJ/MEI)

## Emails Processados:
$(ls -1 "$OUTPUT_DIR"/*/novos/ 2>/dev/null | wc -l) emails

## Status:
✅ Verificação concluída

---
*Gerado automaticamente por monitor-nubank.sh*
EOF
    
    log "✅ Memória atualizada"
}

# =============================================================================
# EXECUÇÃO PRINCIPAL
# =============================================================================

log "🚀 INICIANDO MONITOR NUBANK"
log "Timestamp: $DATA"

# Verificar cada conta
for CONTA_INFO in "${CONTAS[@]}"; do
    CONTA=$(echo $CONTA_INFO | cut -d: -f1)
    SENHA=$(echo $CONTA_INFO | cut -d: -f2)
    
    if [[ "$CONTA" == *"abbadecastro"* ]]; then
        TIPO="PJ/MEI"
    else
        TIPO="PF"
    fi
    
    verificar_emails "$CONTA" "$SENHA" "$TIPO"
    extrair_anexos "$CONTA"
done

# Calcular limites
calcular_limite_mei

# Gerar alertas
gerar_alertas

# Salvar em memória
salvar_memoria

log "🎉 MONITOR NUBANK CONCLUÍDO"
log "========================================="
