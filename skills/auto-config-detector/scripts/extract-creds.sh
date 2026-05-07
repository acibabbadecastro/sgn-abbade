#!/bin/bash
# extract-creds.sh - Extrai e vaulta credenciais de forma segura

# Cores
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${BLUE}🔐 EXTRACT CREDS - Modo Seguro${NC}"
echo "==============================="
echo ""

# Criar vault se não existir
VAULT_DIR="$HOME/.openclaw/secure"
mkdir -p "$VAULT_DIR"
chmod 700 "$VAULT_DIR"

echo -e "${YELLOW}[1/5]${NC} Verificando estrutura de vault..."
echo "   Vault: $VAULT_DIR"
echo ""

# Função para vaultar senha
vault_password() {
    local name=$1
    local value=$2
    local file="$VAULT_DIR/${name}-vault.md"
    
    echo "# $name Credential" > "$file"
    echo "Created: $(date)" >> "$file"
    echo "" >> "$file"
    echo "```" >> "$file"
    echo "$value" >> "$file"
    echo "```" >> "$file"
    chmod 600 "$file"
    
    echo "[VAULT: ~/.openclaw/secure/${name}-vault.md]"
}

echo -e "${YELLOW}[2/5]${NC} Extraindo credenciais conhecidas..."

# Proxmox (de TOOLS.md / MEMORY.md)
if ! [ -f "$VAULT_DIR/pve-vault.md" ]; then
    echo "   🔐 Vaulting: Proxmox credentials..."
    # Não expõe a senha aqui, apenas cria estrutura
    echo "# Proxmox PVE1 Credential" > "$VAULT_DIR/pve-vault.md"
    echo "Created: $(date)" >> "$VAULT_DIR/pve-vault.md"
    echo "Source: MEMORY.md / ACESSO_PVE.md" >> "$VAULT_DIR/pve-vault.md"
    echo "" >> "$VAULT_DIR/pve-vault.md"
    echo "Host: 192.168.0.192" >> "$VAULT_DIR/pve-vault.md"
    echo "User: root" >> "$VAULT_DIR/pve-vault.md"
    echo "# Senha: Ver arquivo original ACESSO_PVE.md" >> "$VAULT_DIR/pve-vault.md"
    echo "Access: https://192.168.0.192:8006" >> "$VAULT_DIR/pve-vault.md"
    chmod 600 "$VAULT_DIR/pve-vault.md"
    echo "   ✅ PVE vaultado"
fi

# DATASVR
if ! [ -f "$VAULT_DIR/datasvr-vault.md" ]; then
    echo "   🔐 Vaulting: DATASVR credentials..."
    echo "# DATASVR (CT 102) Credential" > "$VAULT_DIR/datasvr-vault.md"
    echo "Created: $(date)" >> "$VAULT_DIR/datasvr-vault.md"
    echo "Source: MEMORY.md / TOOLS.md" >> "$VAULT_DIR/datasvr-vault.md"
    echo "" >> "$VAULT_DIR/datasvr-vault.md"
    echo "Host: 192.168.0.72" >> "$VAULT_DIR/datasvr-vault.md"
    echo "User: root" >> "$VAULT_DIR/datasvr-vault.md"
    echo "Samba: \\\\192.168.0.72\\LAN\\" >> "$VAULT_DIR/datasvr-vault.md"
    echo "# Senha: Ver TOOLS.md DATASVR section" >> "$VAULT_DIR/datasvr-vault.md"
    chmod 600 "$VAULT_DIR/datasvr-vault.md"
    echo "   ✅ DATASVR vaultado"
fi

# GitHub
if ! [ -f "$VAULT_DIR/github-vault.md" ]; then
    echo "   🔐 Vaulting: GitHub SSH..."
    echo "# GitHub Access" > "$VAULT_DIR/github-vault.md"
    echo "Created: $(date)" >> "$VAULT_DIR/github-vault.md"
    echo "" >> "$VAULT_DIR/github-vault.md"
    echo "User: acibabbadecastro" >> "$VAULT_DIR/github-vault.md"
    echo "SSH Key: ~/.ssh/github_key" >> "$VAULT_DIR/github-vault.md"
    echo "Email: abbade@outlook.com" >> "$VAULT_DIR/github-vault.md"
    echo "" >> "$VAULT_DIR/github-vault.md"
    echo "# Para push: git@github.com:acibabbadecastro/REPO.git" >> "$VAULT_DIR/github-vault.md"
    chmod 600 "$VAULT_DIR/github-vault.md"
    echo "   ✅ GitHub vaultado"
fi

# Admin 4Pets
if ! [ -f "$VAULT_DIR/4pets-admin-vault.md" ]; then
    echo "   🔐 Vaulting: 4Pets admin..."
    echo "# Amigos de 4 Patas Admin" > "$VAULT_DIR/4pets-admin-vault.md"
    echo "Created: $(date)" >> "$VAULT_DIR/4pets-admin-vault.md"
    echo "" >> "$VAULT_DIR/4pets-admin-vault.md"
    echo "URL: https://amigos4patas.com.br/admin.php" >> "$VAULT_DIR/4pets-admin-vault.md"
    echo "Hash: e90beb78da7f345282d5b95184652691be4accc9dfe7e7d5b50a07acaa516171" >> "$VAULT_DIR/4pets-admin-vault.md"
    echo "# Senha: Ver RELATORIO-COMPLETO-SITE-4PETS.md" >> "$VAULT_DIR/4pets-admin-vault.md"
    chmod 600 "$VAULT_DIR/4pets-admin-vault.md"
    echo "   ✅ 4Pets vaultado"
fi

echo ""
echo -e "${YELLOW}[3/5]${NC} Criando índice mestre..."

# Criar master index
MASTER_INDEX="$VAULT_DIR/master-vault.md"
echo "# 🔐 MASTER VAULT INDEX" > "$MASTER_INDEX"
echo "Created: $(date)" >> "$MASTER_INDEX"
echo "" >> "$MASTER_INDEX"
echo "## Credenciais Vaultadas" >> "$MASTER_INDEX"
echo "" >> "$MASTER_INDEX"

for vault in "$VAULT_DIR"/*-vault.md; do
    if [ -f "$vault" ] && [ "$(basename "$vault")" != "master-vault.md" ]; then
        name=$(basename "$vault" -vault.md)
        echo "- [$name]($(basename "$vault"))" >> "$MASTER_INDEX"
    fi
done

echo "" >> "$MASTER_INDEX"
echo "## Segurança" >> "$MASTER_INDEX"
echo "" >> "$MASTER_INDEX"
echo "- Permissões: chmod 600 em todos os arquivos" >> "$MASTER_INDEX"
echo "- Local: ~/.openclaw/secure/" >> "$MASTER_INDEX"
echo "- Backup: DATASVR (automático)" >> "$MASTER_INDEX"

chmod 600 "$MASTER_INDEX"

echo ""
echo -e "${YELLOW}[4/5]${NC} Verificando permissões..."
chmod -R 600 "$VAULT_DIR"/*.md 2>/dev/null
chmod 700 "$VAULT_DIR"
echo "   ✅ Permissões 600/700 aplicadas"

echo ""
echo -e "${YELLOW}[5/5]${NC} Resumo do vault..."
echo ""
echo -e "${GREEN}✅ CREDENCIAIS VAULTADAS:${NC}"
ls -la "$VAULT_DIR/"*.md 2>/dev/null | while read line; do
    echo "   $line"
done

echo ""
echo -e "${BLUE}📁 Localização:${NC} ~/.openclaw/secure/"
echo -e "${BLUE}📋 Índice:${NC} ~/.openclaw/secure/master-vault.md"
echo ""
echo "Próximo passo: ./generate-report.sh"
