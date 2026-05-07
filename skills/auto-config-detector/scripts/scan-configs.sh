#!/bin/bash
# scan-configs.sh - Varre o sistema por configurações

# Cores
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${BLUE}🔍 AUTO CONFIG DETECTOR - Scan Phase${NC}"
echo "======================================"
echo ""

# Diretório de trabalho
WORK_DIR="/root/.openclaw/workspace/skills/auto-config-detector"
SCAN_RESULTS="$WORK_DIR/scan-results.tmp"
mkdir -p "$WORK_DIR/references" "$HOME/.openclaw/secure"

# Limpar resultados anteriores
> "$SCAN_RESULTS"

echo -e "${YELLOW}[Phase 1/4]${NC} Scanning SSH Keys..."
# SSH Keys
echo "## SSH KEYS" >> "$SCAN_RESULTS"
ls -la ~/.ssh/ 2>/dev/null | grep -E "(id_|github|authorized)" >> "$SCAN_RESULTS" 2>/dev/null
echo "Found: $(ls ~/.ssh/ 2>/dev/null | grep -cE "(id_|github)" 2>/dev/null) keys"
echo ""

echo -e "${YELLOW}[Phase 2/4]${NC} Scanning Git Configs..."
# Git Config
echo -e "\n## GIT CONFIG" >> "$SCAN_RESULTS"
if [ -f ~/.gitconfig ]; then
    grep -E "(name|email)" ~/.gitconfig | head -5 >> "$SCAN_RESULTS"
    echo "Git user: $(git config --global user.name 2>/dev/null || echo 'N/A')"
    echo "Git email: $(git config --global user.email 2>/dev/null || echo 'N/A')"
fi
echo ""

echo -e "${YELLOW}[Phase 3/4]${NC} Scanning Environment Files..."
# Dotenv files
echo -e "\n## DOTENV FILES" >> "$SCAN_RESULTS"
find /root/.openclaw -name ".env*" -type f 2>/dev/null | head -10 >> "$SCAN_RESULTS"
echo "Found: $(find /root/.openclaw -name ".env*" -type f 2>/dev/null | wc -l) .env files"
echo ""

echo -e "${YELLOW}[Phase 4/4]${NC} Scanning Application Configs..."
# Config files
echo -e "\n## APPLICATION CONFIGS" >> "$SCAN_RESULTS"

# Himalaya
if [ -f ~/.config/himalaya/config.toml ]; then
    echo "✅ Himalaya: ~/.config/himalaya/config.toml" >> "$SCAN_RESULTS"
    echo "  Email: $(grep -oP 'email = "\K[^"]+' ~/.config/himalaya/config.toml 2>/dev/null || echo 'detected')"
fi

# Known hosts
echo -e "\n## KNOWN HOSTS" >> "$SCAN_RESULTS"
grep -E "^Host " ~/.ssh/config 2>/dev/null | head -10 >> "$SCAN_RESULTS"
HOST_COUNT=$(grep -cE "^Host " ~/.ssh/config 2>/dev/null || echo 0)
echo "SSH hosts configured: $HOST_COUNT"

# OpenClaw
if [ -d ~/.openclaw/workspace/skills ]; then
    echo -e "\n## OPENCLAW SKILLS" >> "$SCAN_RESULTS"
    ls ~/.openclaw/workspace/skills/ 2>/dev/null >> "$SCAN_RESULTS"
    echo "Skills installed: $(ls ~/.openclaw/workspace/skills/ 2>/dev/null | wc -l)"
fi

echo ""
echo -e "${GREEN}✅ Scan completo!${NC}"
echo "Resultados: $SCAN_RESULTS"
echo ""
echo "Próximo passo: ./extract-creds.sh --safe-mode"
