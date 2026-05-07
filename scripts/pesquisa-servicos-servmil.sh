#!/bin/bash
# =============================================================================
# PESQUISA SERVIÇOS SERVMIL - Stark v1.0
# =============================================================================
# Pesquisa serviços por: solicitante, data, chamado, status, etc.
# =============================================================================

set -e

OUTPUT_DIR="/home/master/LAN/Stark_Output/SERVMIL"

# =============================================================================
# FUNÇÕES DE PESQUISA
# =============================================================================

# Pesquisar por solicitante
pesquisar_solicitante() {
    local SOLICITANTE=$1
    
    echo "=== PESQUISANDO POR SOLICITANTE: $SOLICITANTE ==="
    echo ""
    
    # Buscar em todos os CSVs
    local RESULTADOS=$(grep -i "$SOLICITANTE" "$OUTPUT_DIR"/servicos/*.csv 2>/dev/null || echo "")
    
    if [ -z "$RESULTADOS" ]; then
        echo "❌ Nenhum serviço encontrado para: $SOLICITANTE"
        return 1
    fi
    
    echo "✅ Serviços encontrados:"
    echo ""
    echo "$RESULTADOS" | column -t -s','
}

# Pesquisar por período
pesquisar_periodo() {
    local DATA_INICIO=$1
    local DATA_FIM=$2
    
    echo "=== PESQUISANDO PERÍODO: $DATA_INICIO a $DATA_FIM ==="
    echo ""
    
    # Buscar CSVs do período
    local ANO_INICIO=$(echo $DATA_INICIO | cut -d'/' -f3)
    local MES_INICIO=$(echo $DATA_INICIO | cut -d'/' -f2)
    local ANO_FIM=$(echo $DATA_FIM | cut -d'/' -f3)
    local MES_FIM=$(echo $DATA_FIM | cut -d'/' -f2)
    
    # Listar CSVs no período
    for csv in "$OUTPUT_DIR"/servicos/servicos_*.csv; do
        if [ -f "$csv" ]; then
            echo "📄 Arquivo: $(basename $csv)"
            tail -n +2 "$csv" | head -5
            echo ""
        fi
    done
}

# Pesquisar por número do chamado
pesquisar_chamado() {
    local CHAMADO=$1
    
    echo "=== PESQUISANDO CHAMADO: $CHAMADO ==="
    echo ""
    
    local RESULTADO=$(grep "$CHAMADO" "$OUTPUT_DIR"/servicos/*.csv 2>/dev/null || echo "")
    
    if [ -z "$RESULTADO" ]; then
        echo "❌ Chamado não encontrado: $CHAMADO"
        return 1
    fi
    
    echo "✅ Chamado encontrado:"
    echo ""
    echo "$RESULTADO" | column -t -s','
}

# Listar serviços pendentes
listar_pendentes() {
    echo "=== SERVIÇOS PENDENTES DE RESOLUÇÃO ==="
    echo ""
    
    local PENDENTES=$(grep "Pendente\|Aguardando" "$OUTPUT_DIR"/servicos/*.csv 2>/dev/null || echo "")
    
    if [ -z "$PENDENTES" ]; then
        echo "✅ Nenhum serviço pendente!"
        return 0
    fi
    
    echo "⚠️ Serviços pendentes:"
    echo ""
    echo "$PENDENTES" | column -t -s','
}

# Listar serviços por status
listar_por_status() {
    local STATUS=$1
    
    echo "=== SERVIÇOS COM STATUS: $STATUS ==="
    echo ""
    
    local RESULTADOS=$(grep "$STATUS" "$OUTPUT_DIR"/servicos/*.csv 2>/dev/null || echo "")
    
    if [ -z "$RESULTADOS" ]; then
        echo "❌ Nenhum serviço com status: $STATUS"
        return 1
    fi
    
    echo "✅ Serviços encontrados:"
    echo ""
    echo "$RESULTADOS" | column -t -s','
}

# Gerar relatório por solicitante
relatorio_solicitante() {
    local SOLICITANTE=$1
    local RELATORIO_FILE="$OUTPUT_DIR/relatorios/relatorio_solicitante_$(echo $SOLICITANTE | tr ' ' '_').md"
    
    echo "=== GERANDO RELATÓRIO: $SOLICITANTE ==="
    
    # Cabeçalho
    cat > "$RELATORIO_FILE" << EOF
# 📊 RELATÓRIO POR SOLICITANTE

**Solicitante:** $SOLICITANTE  
**Gerado em:** $(date +%d/%m/%Y %H:%M)

---

## 📋 SERVIÇOS ENCONTRADOS

EOF
    
    # Buscar serviços
    grep -i "$SOLICITANTE" "$OUTPUT_DIR"/servicos/*.csv 2>/dev/null | while read linha; do
        echo "- $linha" >> "$RELATORIO_FILE"
    done
    
    # Calcular total
    local TOTAL=$(grep -i "$SOLICITANTE" "$OUTPUT_DIR"/servicos/*.csv 2>/dev/null | wc -l)
    local VALOR_TOTAL=$(grep -i "$SOLICITANTE" "$OUTPUT_DIR"/servicos/*.csv 2>/dev/null | cut -d',' -f6 | paste -sd+ | bc 2>/dev/null || echo "0")
    
    # Adicionar resumo
    cat >> "$RELATORIO_FILE" << EOF

---

## 💰 RESUMO

| Métrica | Valor |
|---------|-------|
| **Total de Serviços** | $TOTAL |
| **Valor Total** | R$ $VALOR_TOTAL |

---
*Gerado automaticamente por Stark*
EOF
    
    echo "✅ Relatório gerado: $RELATORIO_FILE"
}

# Mostrar ajuda
mostrar_ajuda() {
    echo "========================================="
    echo "  PESQUISA DE SERVIÇOS SERVMIL"
    echo "========================================="
    echo ""
    echo "Uso: $0 <comando> [parâmetros]"
    echo ""
    echo "Comandos disponíveis:"
    echo "  solicitante <nome>     - Pesquisar por solicitante"
    echo "  periodo <ini> <fim>    - Pesquisar por período (DD/MM/AAAA)"
    echo "  chamado <numero>       - Pesquisar por número do chamado"
    echo "  pendentes              - Listar serviços pendentes"
    echo "  status <status>        - Listar por status (Solucionado, Pendente, etc.)"
    echo "  relatorio <solicitante> - Gerar relatório por solicitante"
    echo "  help                   - Mostrar esta ajuda"
    echo ""
    echo "Exemplos:"
    echo "  $0 solicitante Bryan"
    echo "  $0 periodo 01/04/2026 30/04/2026"
    echo "  $0 chamado SERV-20260422-101530"
    echo "  $0 pendentes"
    echo "  $0 status Solucionado"
    echo "  $0 relatorio Bryan"
    echo ""
}

# =============================================================================
# EXECUÇÃO PRINCIPAL
# =============================================================================

case "$1" in
    solicitante)
        if [ -z "$2" ]; then
            echo "❌ Informe o nome do solicitante"
            exit 1
        fi
        pesquisar_solicitante "$2"
        ;;
    periodo)
        if [ -z "$2" ] || [ -z "$3" ]; then
            echo "❌ Informe data de início e fim (DD/MM/AAAA)"
            exit 1
        fi
        pesquisar_periodo "$2" "$3"
        ;;
    chamado)
        if [ -z "$2" ]; then
            echo "❌ Informe o número do chamado"
            exit 1
        fi
        pesquisar_chamado "$2"
        ;;
    pendentes)
        listar_pendentes
        ;;
    status)
        if [ -z "$2" ]; then
            echo "❌ Informe o status"
            exit 1
        fi
        listar_por_status "$2"
        ;;
    relatorio)
        if [ -z "$2" ]; then
            echo "❌ Informe o solicitante"
            exit 1
        fi
        relatorio_solicitante "$2"
        ;;
    help|"")
        mostrar_ajuda
        ;;
    *)
        echo "❌ Comando desconhecido: $1"
        mostrar_ajuda
        exit 1
        ;;
esac
