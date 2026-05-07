#!/bin/bash
# MAXIMOUS v3.0 - Sistema de Recuperação Automática Completa
# Garante que NUNCA esqueça nada após /new

set -e

RECOVERY_DIR="$HOME/.openclaw/workspace/.openclaw"
MEMORY_DIR="$HOME/.openclaw/workspace/memory"

# Criar diretório de recuperação se não existir
mkdir -p "$RECOVERY_DIR"

echo "🧠 MAXIMOUS: Preparando sistema de recuperação automática..."

# Configurar para executar automaticamente após /new
# Adicionar ao .bashrc se ainda não estiver
if ! grep -q "post-new-hook" "$HOME/.bashrc" 2>/dev/null; then
    echo "" >> "$HOME/.bashrc"
    echo "# MAXIMOUS - Auto-restore após /new" >> "$HOME/.bashrc"
    echo "if [ -f ~/.openclaw/workspace/skills/maximous-v2/scripts/post-new-hook.sh ]; then" >> "$HOME/.bashrc"
    echo "    bash ~/.openclaw/workspace/skills/maximous-v2/scripts/post-new-hook.sh 2>/dev/null" >> "$HOME/.bashrc"
    echo "fi" >> "$HOME/.bashrc"
    echo "✅ Auto-restore configurado no .bashrc"
fi

# Criar arquivo de credenciais de emergência
cat > "$RECOVERY_DIR/EMERGENCY-CREDENTIALS.txt" << 'EOF'
╔══════════════════════════════════════════════════════════════════╗
║                    🆘 EMERGÊNCIA - CREDENCIAIS                ║
╚══════════════════════════════════════════════════════════════════╝

SE VOCÊ ESQUECEU TUDO, USE ISTO:

🔐 SENHA UNIVERSAL: Rcmp814k@#

🖥️ SERVIDORES:
   PVE1:     192.168.0.192 (root/Rcmp814k@#)
   DATASVR:  192.168.0.72  (ARCA - root/Rcmp814k@#)
   Stark:    192.168.0.21  (CT 100)

📂 DATASVR (Samba):
   \\192.168.0.72\LAN\
   /home/master/LAN/

🎯 COMANDOS RÁPIDOS:
   sshpass -p 'Rcmp814k@#' ssh root@192.168.0.72
   sshpass -p 'Rcmp814k@#' ssh root@192.168.0.192

📁 WORKSPACE:
   ~/.openclaw/workspace/
   ~/.openclaw/workspace/.secure/ (credenciais)

⚠️ NUNCA compartilhe esta senha!
⚠️ Sempre use o sistema .secure/ para armazenar!
EOF

chmod 600 "$RECOVERY_DIR/EMERGENCY-CREDENTIALS.txt"

echo "✅ Arquivo de emergência criado: EMERGENCY-CREDENTIALS.txt"
echo "✅ Sistema de recuperação configurado!"
echo ""
echo "🎯 Após cada /new, o Maximous irá:"
echo "   1. Carregar credenciais automaticamente"
echo "   2. Verificar conectividade com infraestrutura"
echo "   3. Restaurar aliases úteis"
echo "   4. Mostrar resumo do contexto"
echo ""
echo "⏱️ Tempo de recuperação: ~5 segundos"
