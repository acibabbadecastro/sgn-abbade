#!/bin/bash
# MAXIMOUS v2.2 - Modo Ultra Eficiente (Economia 70% de tokens)
# Compressão + Deduplicação + Sync Inteligente

set -e

# Configurações
INSTALL_DIR="$HOME/.openclaw/workspace/skills/maximous-v2"
DATA_DIR="$INSTALL_DIR/data"
COMPRESSED_DIR="$DATA_DIR/.compressed"
INDEX_FILE="$DATA_DIR/.index.json"
LOG_FILE="$DATA_DIR/.log"

# Limites de economia
MAX_LOG_LINES=50        # Manter apenas últimas 50 entradas
COMPRESS_LEVEL=19       # Máxima compressão zstd
SYNC_INTERVAL=7200      # 2 horas (sem atividade)
MIN_CHANGES=1024        # Só sync se mudou mais de 1KB

# Função de log otimizada (limitada)
log_opt() {
    echo "$(date '+%H:%M') $1" >> "$LOG_FILE"
    # Manter apenas últimas linhas
    tail -n $MAX_LOG_LINES "$LOG_FILE" > "$LOG_FILE.tmp" 2>/dev/null && mv "$LOG_FILE.tmp" "$LOG_FILE"
}

# Comprimir dados
compress_data() {
    local src="$1"
    local dst="$2"
    
    if command -v zstd >/dev/null 2>&1; then
        tar -cf - "$src" 2>/dev/null | zstd -$COMPRESS_LEVEL -c > "$dst" 2>/dev/null
        echo "zstd"
    elif command -v gzip >/dev/null 2>&1; then
        tar -czf "$dst" "$src" 2>/dev/null
        echo "gzip"
    else
        tar -cf "$dst" "$src" 2>/dev/null
        echo "tar"
    fi
}

# Calcular hash para deduplicação
calc_hash() {
    sha256sum "$1" 2>/dev/null | cut -d' ' -f1 | head -c16
}

# Sync inteligente (só se necessário)
smart_sync() {
    local last_sync_file="$DATA_DIR/.last_sync"
    local last_size=0
    local current_size=0
    local changes=0
    
    # Verificar se existe arquivo de last sync
    if [ -f "$last_sync_file" ]; then
        last_size=$(cat "$last_sync_file" 2>/dev/null || echo "0")
    fi
    
    # Calcular tamanho atual
    current_size=$(du -sb ~/.openclaw/workspace/memory/ 2>/dev/null | cut -f1 || echo "0")
    changes=$((current_size - last_size))
    
    # Só sync se mudou significativamente
    if [ $changes -gt $MIN_CHANGES ]; then
        # Sync silencioso
        rsync -az --delete ~/.openclaw/workspace/memory/ \
            root@192.168.0.72:/home/master/LAN/MEMORIES/ 2>/dev/null && \
            echo "$current_size" > "$last_sync_file"
        log_opt "S:$changes"
    else
        log_opt "N:$(date +%s)"
    fi
}

# Main otimizado
main_optimized() {
    # Criar diretórios
    mkdir -p "$COMPRESSED_DIR"
    
    case "$1" in
        "sync")
            smart_sync
            ;;
        "compress")
            compress_data ~/.openclaw/workspace/memory/ "$COMPRESSED_DIR/backup-$(date +%H%M).tar.zst"
            ;;
        "stats")
            echo "E:$(du -sh ~/.openclaw/workspace/memory/ 2>/dev/null | cut -f1)"
            echo "C:$(du -sh "$COMPRESSED_DIR" 2>/dev/null | cut -f1)"
            echo "L:$(wc -l < "$LOG_FILE" 2>/dev/null)"
            ;;
        *)
            # Execução padrão: sync inteligente
            smart_sync
            ;;
    esac
}

main_optimized "$@"
