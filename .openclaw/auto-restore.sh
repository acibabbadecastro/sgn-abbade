#!/bin/bash
# AUTO-RESTORE - Carregamento Automático Pós-/New
# Executado automaticamente pelo Maximous após cada /new

set -e

echo ""
echo "╔══════════════════════════════════════════════════════════════════╗"
echo "║            🧠 STARK - RESTAURAÇÃO DE CONTEXTO                   ║"
echo "║              Informações Críticas Carregadas                     ║"
echo "╚══════════════════════════════════════════════════════════════════╝"
echo ""

# Cores
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Carregar arquivo de recuperação se existir
RECOVERY_FILE="$HOME/.openclaw/workspace/.openclaw/POST_NEW_RECOVERY.md"

if [ -f "$RECOVERY_FILE" ]; then
    echo -e "${GREEN}✅ Arquivo de recuperação encontrado${NC}"
    echo ""
    
    # Extrair e mostrar informações críticas
    echo -e "${BLUE}🔐 CREDENCIAIS UNIVERSAIS:${NC}"
    echo "   Senha padrão: Rcmp814k@#"
    echo "   Usuário: root"
    echo ""
    
    echo -e "${BLUE}🖥️  INFRAESTRUTURA CRÍTICA:${NC}"
    echo "   PVE1: 192.168.0.192 (Rcmp814k@#)"
    echo "   DATASVR: 192.168.0.72 (ARCA)"
    echo "   Stark: 192.168.0.21 (CT 100)"
    echo ""
    
    echo -e "${BLUE}📂 LOCAIS IMPORTANTES:${NC}"
    echo "   Workspace: ~/.openclaw/workspace/"
    echo "   Secure: ~/.openclaw/workspace/.secure/"
    echo "   DATASVR: smb://192.168.0.72/LAN/"
    echo ""
    
    echo -e "${YELLOW}📋 Próximos passos:${NC}"
    echo "   1. Ler MEMORY.md para contexto completo"
    echo "   2. Verificar conectividade: ping 192.168.0.72"
    echo "   3. Listar CTs: pct list (se no PVE1)"
    echo ""
    
    # Criar aliases úteis
    echo -e "${BLUE}🎯 Aliases criados:${NC}"
    
    # Adicionar ao ambiente atual
    alias pve1='sshpass -p "Rcmp814k@#" ssh root@192.168.0.192'
    alias datasvr='sshpass -p "Rcmp814k@#" ssh root@192.168.0.72'
    alias cts='pct list 2>/dev/null || echo "Comando só funciona no PVE1"'
    
    echo "   pve1     → Acessar Proxmox PVE1"
    echo "   datasvr  → Acessar DATASVR"
    echo "   cts      → Listar containers"
    echo ""
    
    echo -e "${GREEN}✅ Sistema pronto para uso!${NC}"
    echo ""
    
    # Mostrar tarefas pendentes se houver
    if [ -f "$HOME/.openclaw/workspace/memory/2026-04-27.md" ]; then
        echo -e "${YELLOW}📝 Verifique tarefas em: memory/2026-04-27.md${NC}"
    fi
    
else
    echo -e "${YELLOW}⚠️  Arquivo de recuperação não encontrado${NC}"
    echo "   Criando informações básicas..."
    
    # Informações mínimas
    echo -e "${BLUE}🔐 CREDENCIAIS:${NC}"
    echo "   Senha: Rcmp814k@#"
    echo "   DATASVR: 192.168.0.72"
    echo ""
fi

echo ""
echo "💡 Dica: Execute 'cat ~/.openclaw/workspace/.openclaw/POST_NEW_RECOVERY.md' para ver todas as informações"
echo ""
