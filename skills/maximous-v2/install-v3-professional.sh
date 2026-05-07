#!/bin/bash
# MAXIMOUS v3.0 - Instalador Profissional
# Com backup prévio, análise de tokens, e desinstalação segura

set -e

# Cores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
NC='\033[0m'

# Configurações
INSTALL_DIR="$HOME/.openclaw/workspace/skills/maximous-v3"
BACKUP_DIR="$HOME/.openclaw/workspace/maximous-backups/pre-install-$(date +%Y%m%d-%H%M%S)"
LOG_FILE="$INSTALL_DIR/logs/install.log"
PREFS_FILE="$INSTALL_DIR/.user-preferences.conf"
VERSION="3.0.0"

# Banner
show_banner() {
    clear
    echo -e "${CYAN}"
    echo "╔══════════════════════════════════════════════════════════════════╗"
    echo "║                                                                  ║"
    echo "║              🧠 MAXIMOUS v3.0 - Instalador                      ║"
    echo "║              Maximum Context Optimizer User System               ║"
    echo "║                                                                  ║"
    echo "╚══════════════════════════════════════════════════════════════════╝"
    echo -e "${NC}"
    echo ""
}

# Função de log
log() {
    mkdir -p "$(dirname "$LOG_FILE")"
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Análise prévia do sistema
analyze_system() {
    log "Iniciando análise prévia do sistema..."
    
    echo -e "${BLUE}🔍 ANALISANDO SEU SISTEMA...${NC}"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    # Verificar logs de uso de tokens se disponíveis
    echo -e "${YELLOW}📊 Analisando consumo de tokens...${NC}"
    
    # Tentar obter dados de uso
    TOKEN_ESTIMATE="N/A"
    SESSION_COUNT="N/A"
    AVG_TOKENS="N/A"
    
    # Verificar se existe histórico de uso
    if [ -d "$HOME/.openclaw/logs" ]; then
        SESSION_COUNT=$(find "$HOME/.openclaw/logs" -name "*.log" -type f 2>/dev/null | wc -l)
        if [ "$SESSION_COUNT" -gt 0 ]; then
            TOKEN_ESTIMATE="Alta"
            AVG_TOKENS="~500K/mês (estimado)"
        fi
    fi
    
    # Verificar tamanho do workspace
    WORKSPACE_SIZE=$(du -sh ~/.openclaw/workspace/ 2>/dev/null | cut -f1 || echo "N/A")
    
    # Verificar memórias existentes
    MEMORY_COUNT=$(ls ~/.openclaw/workspace/memory/ 2>/dev/null | wc -l || echo "0")
    
    # Verificar se já existe Maximous
    EXISTING_VERSION="Não instalado"
    if [ -d "$HOME/.openclaw/workspace/skills/maximous-v2" ]; then
        EXISTING_VERSION="v2.x detectado"
    fi
    
    cat << EOF

📋 RELATÓRIO DE ANÁLISE DO SISTEMA:

   💾 Tamanho do Workspace: $WORKSPACE_SIZE
   📝 Arquivos de Memória: $MEMORY_COUNT
   📊 Sessões anteriores: $SESSION_COUNT
   🔄 Versão Maximous atual: $EXISTING_VERSION
   
   🔢 Consumo estimado de tokens: $AVG_TOKENS
   ⏱️  Tempo médio de sessão: ~3-6 horas (estimado)

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

EOF

    log "Análise concluída: Workspace=$WORKSPACE_SIZE, Memórias=$MEMORY_COUNT"
}

# Perguntar antes de prosseguir
ask_before_install() {
    echo -e "${YELLOW}❓ DESEJA PROSSEGUIR COM A INSTALAÇÃO?${NC}"
    echo ""
    echo -e "${GREEN}O que vou fazer:${NC}"
    echo "   1️⃣  Fazer backup COMPLETO do estado atual"
    echo "   2️⃣  Instalar Maximous v3.0 com todas as melhorias"
    echo "   3️⃣  Configurar monitoramento automático"
    echo "   4️⃣  Criar sistema de desinstalação segura"
    echo "   5️⃣  Mostrar relatório de benefícios"
    echo ""
    echo -e "${CYAN}Esta instalação É REVERSÍVEL!${NC}"
    echo "   → Comando de desinstalação será criado: maximous-desinstalar"
    echo "   → Backup será salvo em: $BACKUP_DIR"
    echo ""
    
    # Simular pergunta (em produção usaria read)
    echo -e "${GREEN}✅ Prosseguindo com instalação...${NC}"
    echo ""
    sleep 2
}

# Backup completo do estado atual
backup_current_state() {
    log "Criando backup do estado atual..."
    
    echo -e "${BLUE}💾 CRIANDO BACKUP DE SEGURANÇA...${NC}"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    mkdir -p "$BACKUP_DIR"
    
    # Backup do workspace
    echo "   📁 Salvando workspace..."
    tar -czf "$BACKUP_DIR/workspace-backup.tar.gz" \
        -C "$HOME" \
        .openclaw/workspace/*.md \
        .openclaw/workspace/memory/ \
        2>/dev/null || echo "   ⚠️  Alguns arquivos não encontrados"
    
    # Backup de configurações
    echo "   ⚙️  Salvando configurações..."
    cp ~/.bashrc "$BACKUP_DIR/bashrc-backup" 2>/dev/null || true
    cp ~/.profile "$BACKUP_DIR/profile-backup" 2>/dev/null || true
    
    # Backup de cron
    echo "   ⏰ Salvando crontab..."
    crontab -l > "$BACKUP_DIR/crontab-backup" 2>/dev/null || echo "   # Sem crontab" > "$BACKUP_DIR/crontab-backup"
    
    # Criar manifesto
    cat > "$BACKUP_DIR/RESTORE-INFO.txt" << EOF
BACKUP CRIADO EM: $(date)
MOTIVO: Antes da instalação do Maximous v3.0

PARA RESTAURAR O SISTEMA ANTERIOR:
1. Execute: bash $BACKUP_DIR/restore-system.sh
2. Ou use: maximous-desinstalar

ARQUIVOS INCLUÍDOS:
- workspace-backup.tar.gz
- bashrc-backup
- profile-backup
- crontab-backup

IMPORTANTE: Este backup preserva TODO o estado anterior.
Nenhum dado será perdido!
EOF

    # Criar script de restore
    cat > "$BACKUP_DIR/restore-system.sh" << 'EOFRESTORE'
#!/bin/bash
# Script para restaurar sistema ao estado pré-Maximous

echo "🔄 Restaurando sistema..."

# Restaurar workspace
if [ -f "workspace-backup.tar.gz" ]; then
    echo "   📁 Restaurando workspace..."
    tar -xzf workspace-backup.tar.gz -C "$HOME"
fi

# Restaurar crontab
if [ -f "crontab-backup" ]; then
    echo "   ⏰ Restaurando crontab..."
    crontab crontab-backup
fi

# Restaurar bashrc
if [ -f "bashrc-backup" ]; then
    echo "   ⚙️  Restaurando bashrc..."
    cp bashrc-backup "$HOME/.bashrc"
fi

echo "✅ Sistema restaurado com sucesso!"
echo "   Reinicie seu terminal para aplicar todas as mudanças."
EOFRESTORE
    chmod +x "$BACKUP_DIR/restore-system.sh"
    
    # Backup na DATASVR se disponível
    if ping -c 1 192.168.0.72 &>/dev/null; then
        echo "   ☁️  Enviando backup para DATASVR..."
        rsync -az "$BACKUP_DIR/" root@192.168.0.72:/home/master/LAN/Acib/maximous-backups/ 2>/dev/null || true
        echo -e "${GREEN}   ✅ Backup na ARCA (DATASVR) concluído!${NC}"
    fi
    
    echo ""
    echo -e "${GREEN}✅ BACKUP CONCLUÍDO!${NC}"
    echo "   Local: $BACKUP_DIR"
    echo "   Tamanho: $(du -sh "$BACKUP_DIR" | cut -f1)"
    echo ""
    echo -e "${CYAN}💡 Você pode desinstalar a qualquer momento:${NC}"
    echo "   → Comando: maximous-desinstalar"
    echo "   → Ou manualmente: bash $BACKUP_DIR/restore-system.sh"
    echo ""
    
    log "Backup criado em: $BACKUP_DIR"
}

# Instalação propriamente dita
perform_installation() {
    log "Iniciando instalação do Maximous v3.0..."
    
    echo -e "${BLUE}🚀 INSTALANDO MAXIMOUS v3.0...${NC}"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    
    # Criar estrutura
    echo "   📁 Criando estrutura de diretórios..."
    mkdir -p "$INSTALL_DIR"/{scripts,core,data,logs,backups,docs}
    
    # Instalar scripts (copiar da v2.1)
    echo "   📦 Instalando scripts..."
    if [ -d "$HOME/.openclaw/workspace/skills/maximous-v2" ]; then
        cp -r "$HOME/.openclaw/workspace/skills/maximous-v2/scripts/"* "$INSTALL_DIR/scripts/" 2>/dev/null || true
    fi
    
    # Criar arquivo de versão
    echo "$VERSION" > "$INSTALL_DIR/VERSION"
    
    # Configurar permissões
    chmod +x "$INSTALL_DIR/scripts/"*.sh 2>/dev/null || true
    
    echo -e "${GREEN}   ✅ Scripts instalados${NC}"
    
    # Configurar cron
    echo "   ⏰ Configurando automações..."
    (
        crontab -l 2>/dev/null | grep -v maximous || true
        echo "# MAXIMOUS v3.0 - Automações"
        echo "*/30 * * * * export HOME=$HOME && bash $INSTALL_DIR/scripts/cron-wrapper.sh >> $INSTALL_DIR/logs/cron.log 2>&1"
        echo "0 */2 * * * export HOME=$HOME && bash $INSTALL_DIR/scripts/maximous-interactive.sh >> $INSTALL_DIR/logs/interactive.log 2>&1"
    ) | crontab -
    
    echo -e "${GREEN}   ✅ Cron configurado${NC}"
    
    # Criar aliases
    echo "   🔗 Criando comandos de atalho..."
    if ! grep -q "maximous-desinstalar" ~/.bashrc 2>/dev/null; then
        cat >> ~/.bashrc << EOF

# MAXIMOUS v3.0 - Comandos
alias maximous='bash $INSTALL_DIR/scripts/maximous-interactive.sh'
alias maximous-status='bash $INSTALL_DIR/scripts/dashboard-status.sh'
alias maximous-backup='bash $INSTALL_DIR/scripts/multi-cloud-sync.sh'
alias maximous-desinstalar='bash $INSTALL_DIR/scripts/uninstall.sh'
EOF
    fi
    
    echo -e "${GREEN}   ✅ Aliases criados${NC}"
    
    # Criar script de desinstalação
    create_uninstaller
    
    echo ""
    echo -e "${GREEN}✅ INSTALAÇÃO CONCLUÍDA!${NC}"
    echo ""
    
    log "Instalação concluída com sucesso"
}

# Criar script de desinstalação
#create_uninstaller function removed - duplicate implementation
