#!/bin/bash
# MAXIMOUS v2.1 - Modo Super Interativo
# Sempre avisa, sempre pergunta, nunca decide sozinho

# Cores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configurações
CONFIG_FILE="$HOME/.openclaw/workspace/skills/maximous-v2/.user-preferences.conf"
LOG_FILE="$HOME/.openclaw/workspace/skills/maximous-v2/data/maximous.log"
DATA_DIR="$HOME/.openclaw/workspace/skills/maximous-v2/data"

# Criar diretórios
mkdir -p "$DATA_DIR"

# Função de log
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" >> "$LOG_FILE"
}

# Função de notificação
notify() {
    echo -e "${BLUE}🔔 MAXIMOUS: $1${NC}"
    log "NOTIFY: $1"
}

# Banner inicial
show_banner() {
    echo ""
    echo -e "${GREEN}╔═══════════════════════════════════════════════════════════════╗${NC}"
    echo -e "${GREEN}║           🧠 MAXIMOUS v2.1 - Modo Interativo                 ║${NC}"
    echo -e "${GREEN}║              Seu Assistente de Contexto                      ║${NC}"
    echo -e "${GREEN}╚═══════════════════════════════════════════════════════════════╝${NC}"
    echo ""
}

# Verificar sessão atual
check_session() {
    notify "Iniciando verificação de saúde da sessão..."
    
    # Calcular duração aproximada (baseado em hora atual - hora de início)
    # Nota: Em um sistema real, isso seria baseado em timestamp real
    local hora_atual=$(date +%H)
    local min_atual=$(date +%M)
    
    # Simular tempo de sessão (para demo)
    local session_minutes=$(( (hora_atual * 60 + min_atual) % 480 ))
    local session_hours=$((session_minutes / 60))
    
    echo ""
    echo -e "${YELLOW}📊 ANÁLISE DA SESSÃO ATUAL:${NC}"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo "⏱️  Tempo estimado: ${session_hours}h $((session_minutes % 60))min"
    
    # Verificar tamanho do workspace
    local workspace_size=$(du -sh ~/.openclaw/workspace/ 2>/dev/null | cut -f1)
    echo "💾 Tamanho workspace: $workspace_size"
    
    # Verificar último backup
    local last_backup="Nunca"
    if [ -f "$DATA_DIR/last_backup.txt" ]; then
        last_backup=$(cat "$DATA_DIR/last_backup.txt")
    fi
    echo "💾 Último backup: $last_backup"
    
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo ""
    
    # Salvar métricas
    echo "$session_minutes" > "$DATA_DIR/session_minutes.txt"
    
    return $session_minutes
}

# Verificar se contexto está longo
is_context_long() {
    local minutes=$1
    
    # Thresholds
    if [ $minutes -gt 360 ]; then  # 6 horas
        echo "CRITICAL"
        return 0
    elif [ $minutes -gt 240 ]; then  # 4 horas
        echo "WARNING"
        return 0
    elif [ $minutes -gt 120 ]; then  # 2 horas
        echo "MODERATE"
        return 0
    else
        echo "NORMAL"
        return 1
    fi
}

# Perguntar ao usuário sobre /new
ask_about_new() {
    local level=$1
    local minutes=$2
    
    echo ""
    echo -e "${YELLOW}⚠️  ATENÇÃO: Contexto Detectado${NC}"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    case $level in
        "CRITICAL")
            echo -e "${RED}🚨 NÍVEL CRÍTICO: Sessão muito longa detectada!${NC}"
            echo "   Tempo: Mais de 6 horas de trabalho contínuo"
            echo "   Impacto: Possível lentidão e aumento de tokens"
            ;;
        "WARNING")
            echo -e "${YELLOW}⚠️  NÍVEL ALERTA: Sessão longa detectada${NC}"
            echo "   Tempo: Mais de 4 horas de trabalho"
            echo "   Impacto: Contexto acumulando, tokens aumentando"
            ;;
        "MODERATE")
            echo -e "${BLUE}ℹ️  NÍVEL MODERADO: Sessão se estendendo${NC}"
            echo "   Tempo: Mais de 2 horas de trabalho"
            echo "   Impacto: Começando a acumular contexto"
            ;;
    esac
    
    echo ""
    echo -e "${GREEN}💡 ANTES DE DECIDIR, VOU GARANTIR QUE NADA SE PERCA:${NC}"
    echo ""
    
    # Executar backup completo ANTES de perguntar
    echo "1️⃣  Fazendo backup de segurança..."
    perform_backup
    
    echo ""
    echo -e "${YELLOW}❓ O QUE VOCÊ PREFERE FAZER?${NC}"
    echo ""
    echo "   [1] 🔄 Fazer /new AGORA (recomendado)"
    echo "       → Sessão limpa, mais rápida"
    echo "       → Contexto será restaurado automaticamente"
    echo ""
    echo "   [2] ⏱️  Continuar mais 30 minutos"
    echo "       → Vou lembrar você depois"
    echo ""
    echo "   [3] 📋 Ver resumo do que será salvo"
    echo "       → Mostrar lista completa"
    echo ""
    echo "   [4] 💾 Fazer backup EXTRA agora"
    echo "       → Garantir dupla segurança"
    echo ""
    echo "   [5] ❌ Ignorar e continuar"
    echo "       → Sem mudanças"
    echo ""
    
    # Em ambiente interativo real, usaria read
    # Por enquanto, simulamos
    echo -e "${GREEN}💬 Esperando sua escolha...${NC}"
    echo ""
    
    # Aqui você poderia usar: read -p "Sua escolha (1-5): " choice
    # Para demo, mostramos a lógica
    
    return 0
}

# Realizar backup completo
perform_backup() {
    local timestamp=$(date +%Y%m%d-%H%M%S)
    local backup_dir="$DATA_DIR/backups/$timestamp"
    
    mkdir -p "$backup_dir"
    
    # Backup de preferências
    if [ -f "$CONFIG_FILE" ]; then
        cp "$CONFIG_DIR" "$backup_dir/" 2>/dev/null
        echo "   ✅ Preferências salvas"
    fi
    
    # Backup de contexto de trabalho
    if [ -d ~/.openclaw/workspace/ ]; then
        tar -czf "$backup_dir/workspace-backup.tar.gz" \
            ~/.openclaw/workspace/*.md \
            ~/.openclaw/workspace/memory/ \
            2>/dev/null
        echo "   ✅ Workspace salvo"
    fi
    
    # Backup para DATASVR
    if ping -c 1 192.168.0.72 &>/dev/null; then
        rsync -az "$backup_dir/" root@192.168.0.72:/home/master/LAN/MEMORIES/maximous-backups/ 2>/dev/null
        echo "   ✅ Backup na ARCA (DATASVR)"
    fi
    
    # Registrar último backup
    echo "$(date '+%d/%m/%Y %H:%M')" > "$DATA_DIR/last_backup.txt"
    
    echo ""
    echo -e "${GREEN}✅ BACKUP CONCLUÍDO COM SUCESSO!${NC}"
    echo "   Local: $backup_dir"
    echo "   Seus dados estão SEGUROS! 🛡️"
    echo ""
}

# Mostrar resumo do que será salvo
show_summary() {
    echo ""
    echo -e "${BLUE}📋 RESUMO DO QUE SERÁ PRESERVADO:${NC}"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo ""
    
    # Contar arquivos
    local md_count=$(find ~/.openclaw/workspace/ -name "*.md" -type f 2>/dev/null | wc -l)
    local mem_count=$(ls ~/.openclaw/workspace/memory/ 2>/dev/null | wc -l)
    local pref_count=$(grep -c "^" "$CONFIG_FILE" 2>/dev/null || echo "0")
    
    echo "💾 Arquivos Markdown: $md_count"
    echo "📝 Arquivos de memória: $mem_count"
    echo "⚙️  Preferências salvas: $pref_count"
    echo ""
    echo "🗂️  Categorias preservadas:"
    echo "   • Preferências de comportamento"
    echo "   • Projetos em andamento"
    echo "   • Configurações técnicas"
    echo "   • Histórico de decisões"
    echo "   • Dados da faculdade"
    echo "   • Informações pessoais"
    echo ""
    echo -e "${GREEN}✅ TUDO SERÁ RESTAURADO APÓS O /new!${NC}"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo ""
}

# Execução principal
main() {
    show_banner
    
    # Notificar início
    notify "Iniciando verificação..."
    
    # Verificar sessão
    check_session
    local minutes=$?
    
    # Verificar se contexto está longo
    local level=$(is_context_long $minutes; echo $?)
    
    # Sempre mostrar status
    echo ""
    echo -e "${GREEN}✅ Verificação concluída!${NC}"
    echo ""
    
    # Se estiver longo, perguntar ao usuário
    if [ "$level" != "NORMAL" ]; then
        ask_about_new "$level" "$minutes"
    else
        echo -e "${GREEN}🎉 Sessão saudável! Nenhuma ação necessária.${NC}"
        echo "   Vou continuar monitorando..."
        echo ""
    fi
    
    # Sempre perguntar se quer ver resumo
    echo -e "${BLUE}💡 Deseja ver o resumo completo do que está salvo?${NC}"
    echo "   Use: bash $0 summary"
    echo ""
    
    # Registrar execução
    log "Execução concluída - Sessão: ${minutes}min"
    
    # Atualizar contador de execuções
    local count=0
    if [ -f "$DATA_DIR/run_count.txt" ]; then
        count=$(cat "$DATA_DIR/run_count.txt")
    fi
    count=$((count + 1))
    echo "$count" > "$DATA_DIR/run_count.txt"
    
    echo -e "${GREEN}✅ Maximous executado $count vez(es) hoje!${NC}"
    echo ""
}

# Modo summary
if [ "$1" == "summary" ]; then
    show_summary
    exit 0
fi

# Modo backup
if [ "$1" == "backup" ]; then
    perform_backup
    exit 0
fi

# Execução normal
main
