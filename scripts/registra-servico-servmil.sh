#!/bin/bash
# =============================================================================
# REGISTRA SERVIÇO SERVMIL - Stark v2.0
# =============================================================================
# Registra serviços executados na SERVMIL para controle de faturamento
# Organizado por ANO/MÊS
# Salva em: /home/master/LAN/Stark_Output/SERVMIL/AAAA/MM/
# =============================================================================

set -e

# Configurações
DATA=$(date +%Y%m%d_%H%M%S)
DATA_BR=$(date +%d/%m/%Y)
HORA=$(date +%H:%M)
ANO=$(date +%Y)
MES=$(date +%m)
LOG_FILE="/var/log/stark-servmil-registro.log"
OUTPUT_DIR="/home/master/LAN/Stark_Output/SERVMIL"
MEMORY_DIR="/root/.openclaw/workspace/memory"

# Estrutura de pastas por ano/mês
STRUCT_DIR="$OUTPUT_DIR/$ANO/$MES"

# =============================================================================
# FUNÇÕES
# =============================================================================

log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Registrar serviço
registrar_servico() {
    local CLIENTE=$1
    local SOLICITANTE=$2
    local SERVICIO=$3
    local DESCRITIVO=$4
    local VALOR=$5
    local STATUS=$6
    local ANOTACOES=$7
    local DATA_RESOLUCAO=${8:-""}
    
    log "=== REGISTRANDO SERVIÇO SERVMIL ==="
    log "Cliente: $CLIENTE"
    log "Solicitante: $SOLICITANTE"
    log "Serviço: $SERVICIO"
    log "Descritivo: $DESCRITIVO"
    log "Valor: R$ $VALOR"
    log "Status: $STATUS"
    log "Anotações: $ANOTACOES"
    
    # Gerar número do chamado
    local CHAMADO="SERV-${ANO}${MES}-$(date +%d)-$(date +%H%M%S)"
    log "Chamado: $CHAMADO"
    
    # Criar diretórios (organizado por ano/mês)
    mkdir -p "$STRUCT_DIR"/{servicos,relatorios,emails}
    
    # Salvar em CSV
    local CSV_FILE="$STRUCT_DIR/servicos/servicos_${ANO}_${MES}.csv"
    
    # Criar cabeçalho se não existir
    if [ ! -f "$CSV_FILE" ]; then
        echo "DATA,HORA,CHAMADO,CLIENTE,SOLICITANTE,SERVICO,DESCRITIVO,VALOR,STATUS,ANOTACOES,DATA_RESOLUCAO" > "$CSV_FILE"
    fi
    
    # Adicionar registro
    echo "$DATA_BR,$HORA,$CHAMADO,$CLIENTE,$SOLICITANTE,\"$SERVICIO\",\"$DESCRITIVO\",$VALOR,$STATUS,\"$ANOTACOES\",\"$DATA_RESOLUCAO\"" >> "$CSV_FILE"
    
    # Salvar em Markdown (para leitura fácil)
    local MD_FILE="$STRUCT_DIR/servicos/servicos_${ANO}_${MES}.md"
    
    cat >> "$MD_FILE" << EOF

## 📋 Serviço Registrado - $DATA_BR $HORA

| Campo | Informação |
|-------|------------|
| **Chamado** | $CHAMADO |
| **Cliente** | $CLIENTE |
| **Solicitante** | $SOLICITANTE |
| **Serviço** | $SERVICIO |
| **Descritivo** | $DESCRITIVO |
| **Valor** | R$ $VALOR |
| **Status** | $STATUS |
| **Anotações** | $ANOTACOES |
| **Data Resolução** | ${DATA_RESOLUCAO:-Pendente} |

---
EOF
    
    # Salvar em memória
    cat >> "$MEMORY_DIR/servicos-servmil-${ANO}_${MES}.md" << EOF

### $DATA_BR - $HORA - Chamado: $CHAMADO
- **Cliente:** $CLIENTE
- **Solicitante:** $SOLICITANTE
- **Serviço:** $SERVICIO
- **Descritivo:** $DESCRITIVO
- **Valor:** R$ $VALOR
- **Status:** $STATUS
- **Anotações:** $ANOTACOES

EOF
    
    log "✅ Serviço registrado com sucesso!"
    
    # Retornar número do chamado
    echo "$CHAMADO"
}

# Mostrar ajuda
mostrar_ajuda() {
    echo "========================================="
    echo "  REGISTRO DE SERVIÇOS SERVMIL"
    echo "========================================="
    echo ""
    echo "Uso: $0 <cliente> <solicitante> <servico> <descritivo> <valor> <status> [anotacoes] [data_resolucao]"
    echo ""
    echo "Exemplo:"
    echo "  $0 \"Bryan\" \"Saulo\" \"Configuração VPN\" \"Instalação e configuração de VPN via TeamViewer\" \"80\" \"Solucionado\" \"Via TeamViewer\" \"22/04/2026\""
    echo ""
}

# =============================================================================
# EXECUÇÃO PRINCIPAL
# =============================================================================

# Se chamado com argumentos, registra serviço
if [ $# -ge 6 ]; then
    CHAMADO=$(registrar_servico "$1" "$2" "$3" "$4" "$5" "$6" "${7:-}" "${8:-}")
    
    echo ""
    echo "✅ SERVIÇO REGISTRADO COM SUCESSO!"
    echo ""
    echo "📋 Resumo:"
    echo "   Chamado: $CHAMADO"
    echo "   Cliente: $1"
    echo "   Solicitante: $2"
    echo "   Serviço: $3"
    echo "   Descritivo: $4"
    echo "   Valor: R$ $5"
    echo "   Status: $6"
    echo ""
    echo "📁 Arquivos:"
    echo "   CSV: $STRUCT_DIR/servicos/servicos_${ANO}_${MES}.csv"
    echo "   MD: $STRUCT_DIR/servicos/servicos_${ANO}_${MES}.md"
    echo ""
else
    mostrar_ajuda
    exit 1
fi
