#!/bin/bash
# SETUP DE SISTEMA SEGURO DE CREDENCIAIS - ACIB ABBADE
# Executar UMA VEZ para configurar o sistema completo

echo "🔐 CONFIGURANDO SISTEMA SEGURO DE CREDENCIAIS..."
echo "=================================================="

# Criar diretório seguro
SECURE_DIR="$HOME/.openclaw/workspace/.secure"
mkdir -p "$SECURE_DIR"/{keys/{ssh,pgp,api},passwords/{databases,services,personal},backup/{local,datasvr,offline},logs}

# Definir permissões ultra-restritivas
chmod 700 "$SECURE_DIR"
chmod 700 "$SECURE_DIR/keys"
chmod 700 "$SECURE_DIR/passwords"
chmod 700 "$SECURE_DIR/backup"
touch "$SECURE_DIR/logs/access.log"
chmod 600 "$SECURE_DIR/logs/access.log"

# Copiar script gerenciador
cp "$HOME/.openclaw/workspace/.secure/secure-manager.sh" "$SECURE_DIR/" 2>/dev/null || true
chmod 700 "$SECURE_DIR/secure-manager.sh"

# Mover chaves SSH existentes para local seguro
if [ -f "$HOME/.ssh/id_ed25519" ]; then
    cp "$HOME/.ssh/id_ed25519" "$SECURE_DIR/keys/ssh/"
    cp "$HOME/.ssh/id_ed25519.pub" "$SECURE_DIR/keys/ssh/"
    chmod 600 "$SECURE_DIR/keys/ssh/"*
    echo "✅ Chaves SSH copiadas para local seguro"
fi

# Criar arquivo de configuração
cat > "$SECURE_DIR/.config" << 'EOF'
# CONFIGURAÇÃO DO SISTEMA DE CREDENCIAIS
# NÃO EDITE MANUALMENTE

NIVEL_CRITICO="90"
NIVEL_ALTO="180"
NIVEL_MEDIO="365"
ALERTA_ACESSO="true"
BACKUP_AUTO="true"
CRIPTOGRAFIA="AES-256-GCM"
EOF

chmod 600 "$SECURE_DIR/.config"

# Criar .gitignore para nunca commitar
cat > "$SECURE_DIR/.gitignore" << 'EOF'
# NUNCA COMMITAR ESTE DIRETÓRIO
*
!.gitignore
EOF

echo ""
echo "✅ SISTEMA CONFIGURADO COM SUCESSO!"
echo ""
echo "📁 Estrutura criada em: $SECURE_DIR"
echo ""
echo "🔒 Permissões:"
echo "   Diretórios: 700 (rwx------)"
echo "   Arquivos:   600 (rw-------)"
echo ""
echo "🎯 PRÓXIMOS PASSOS:"
echo "   1. Execute: bash $SECURE_DIR/secure-manager.sh init"
echo "   2. Defina uma senha mestra FORTE"
echo "   3. Adicione suas credenciais:"
echo "      bash $SECURE_DIR/secure-manager.sh add ssh ct100 'senha' 5"
echo ""
echo "⚠️  IMPORTANTE:"
echo "   • Nunca commit este diretório no Git"
echo "   • Faça backups regulares"
echo "   • Mantenha a senha mestra em local seguro"
echo ""
