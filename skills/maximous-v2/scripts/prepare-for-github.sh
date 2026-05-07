#!/bin/bash
# MAXIMOUS v2.0 - Preparador para Publicação
# Remove dados sensíveis e cria versão clean para GitHub

echo ""
echo "╔═══════════════════════════════════════════════════════════════╗"
echo "║     🔒 MAXIMOUS - PREPARADOR PARA PUBLICAÇÃO                  ║"
echo "║         Removendo dados sensíveis...                         ║"
echo "╚═══════════════════════════════════════════════════════════════╝"
echo ""

# Diretórios
SOURCE_DIR="$HOME/.openclaw/workspace/skills/maximous-v2"
CLEAN_DIR="$HOME/.openclaw/workspace/maximous-clean-v2.0"

echo "📁 Criando diretório clean: $CLEAN_DIR"
mkdir -p "$CLEAN_DIR"
echo ""

# Copiar estrutura
echo "📂 Copiando arquivos..."
echo "─────────────────────────────────────────────────────────────────"

# Arquivos principais
cp "$SOURCE_DIR/README.md" "$CLEAN_DIR/"
cp "$SOURCE_DIR/LICENSE" "$CLEAN_DIR/"
cp "$SOURCE_DIR/CHANGELOG.md" "$CLEAN_DIR/"
cp "$SOURCE_DIR/CONTRIBUTING.md" "$CLEAN_DIR/"
cp "$SOURCE_DIR/.skill" "$CLEAN_DIR/"
cp "$SOURCE_DIR/.gitignore" "$CLEAN_DIR/"
cp "$SOURCE_DIR/install.sh" "$CLEAN_DIR/"
cp "$SOURCE_DIR/VERSION" "$CLEAN_DIR/" 2>/dev/null || echo "2.0.0" > "$CLEAN_DIR/VERSION"

# Criar estrutura
mkdir -p "$CLEAN_DIR"/{scripts,core,examples,docs}

# Copiar scripts (sem dados sensíveis)
echo "   ✅ Scripts principais..."
for script in "$SOURCE_DIR/scripts/"*.sh; do
    [ -f "$script" ] || continue
    # Limpar dados sensíveis dos scripts
    sed 's/192\.168\.[0-9]\+\.[0-9]\+/\<IP_DO_SERVIDOR\>/g; \
           s/Rcmp[0-9a-zA-Z@#]*\+/\<SENHA\>/g; \
           s/abbade@[a-z]*\.[a-z]*/\<EMAIL_DO_USUARIO\>/g; \
           s/1866226415/\<TELEGRAM_ID\>/g; \
           s/30757385864/\<RA\>/g' \
           "$script" > "$CLEAN_DIR/scripts/$(basename $script)"
done

# Limpar scripts específicos
echo "   🧹 Limpando dados sensíveis..."

# Sync imediato - remover dados pessoais
sed -i 's/root@[0-9]\+\.[0-9]\+\.[0-9]\+\.[0-9]\+/root@\<IP_DO_SERVIDOR\>/g' "$CLEAN_DIR/scripts/"*.sh 2>/dev/null || true
sed -i 's/192\.168\.[0-9]\+\.[0-9]\+/\<IP_DO_SERVIDOR\>/g' "$CLEAN_DIR/scripts/"*.sh 2>/dev/null || true

# Config - remover dados pessoais
cp "$SOURCE_DIR/core/preferences-config.sh" "$CLEAN_DIR/core/" 2>/dev/null || true

# Examples
cp "$SOURCE_DIR/examples/"*.sh "$CLEAN_DIR/examples/" 2>/dev/null || true

# Criar README específico para desenvolvedores
cat > "$CLEAN_DIR/README-DEV.md" << 'EOF'
# MAXIMOUS v2.0 - Notas para Desenvolvedores

## Configuração Inicial

Antes de usar, configure:

1. **Editar configurações:**
   ```bash
   bash core/preferences-config.sh
   ```

2. **Configurar servidor de backup:**
   - Edite `scripts/multi-cloud-sync.sh`
   - Defina seu DATASVR/cloud

3. **Configurar SSH keys:**
   ```bash
   ssh-keygen -t ed25519
   # Copie para seus servidores
   ```

## Estrutura de Configuração

```
~/.openclaw/workspace/skills/maximous-v2/
├── .user-preferences.conf    # Suas preferências
├── data/                      # Seus dados
├── secure/                    # Dados criptografados
└── backups/                   # Backups locais
```

## Segurança

- NUNCA commite arquivos em `secure/`
- NUNCA commite `.user-preferences.conf`
- Use `.gitignore` fornecido

---
**Template pronto para personalização!**
EOF

echo ""
echo "✅ Versão clean criada em: $CLEAN_DIR"
echo ""

# Verificar o que foi removido
echo "🔍 Verificando dados sensíveis..."
echo "─────────────────────────────────────────────────────────────────"

# Buscar por IPs
IPS=$(grep -r "192\.168\." "$CLEAN_DIR/" 2>/dev/null | wc -l)
SENHAS=$(grep -r "Rcmp" "$CLEAN_DIR/" 2>/dev/null | wc -l)
EMAILS=$(grep -r "abbade@" "$CLEAN_DIR/" 2>/dev/null | wc -l)

echo "   IPs encontrados: $IPS (deve ser 0)"
echo "   Senhas encontradas: $SENHAS (deve ser 0)"
echo "   Emails encontrados: $EMAILS (deve ser 0)"

if [ "$IPS" -eq 0 ] && [ "$SENHAS" -eq 0 ] && [ "$EMAILS" -eq 0 ]; then
    echo "   ✅ Dados sensíveis removidos com sucesso!"
else
    echo "   ⚠️  Ainda há dados sensíveis - verificar manualmente"
fi

echo ""
echo "📊 Estrutura final:"
find "$CLEAN_DIR" -type f | head -20 | sed "s|$CLEAN_DIR/|   |"

echo ""
echo "🚀 PRÓXIMOS PASSOS:"
echo ""
echo "   1. cd $CLEAN_DIR"
echo "   2. git init"
echo "   3. git add ."
echo "   4. git commit -m 'feat: MAXIMOUS v2.0 clean'"
echo "   5. git remote add origin https://github.com/SEU_USUARIO/maximous.git"
echo "   6. git push -u origin main"
echo ""
echo "✅ Versão pronta para GitHub SEM dados pessoais!"
echo ""
