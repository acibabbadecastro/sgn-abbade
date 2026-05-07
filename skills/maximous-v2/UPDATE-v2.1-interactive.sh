#!/bin/bash
# UPDATE MAXIMOUS v2.0 → v2.1 (Modo Super Interativo)
# Instala todas as melhorias de notificação e interação

set -e

INSTALL_DIR="$HOME/.openclaw/workspace/skills/maximous-v2"
CRON_WRAPPER="$INSTALL_DIR/scripts/cron-wrapper.sh"
INTERACTIVE_SCRIPT="$INSTALL_DIR/scripts/maximous-interactive.sh"

echo ""
echo "╔═══════════════════════════════════════════════════════════════╗"
echo "║     🚀 ATUALIZAÇÃO MAXIMOUS v2.0 → v2.1                      ║"
echo "║        Modo Super Interativo                                ║"
echo "╚═══════════════════════════════════════════════════════════════╝"
echo ""
echo "✨ NOVIDADES DA v2.1:"
echo ""
echo "   ✅ SEMPRE avisa quando executa"
echo "   ✅ SEMPRE pergunta antes de /new"
echo "   ✅ Faz backup AUTOMÁTICO antes de qualquer ação"
echo "   ✅ NUNCA decide sozinho"
echo "   ✅ Mostra resumo do que será salvo"
echo "   ✅ Opções múltiplas para usuário escolher"
echo ""

# Verificar se scripts existem
if [ ! -f "$INTERACTIVE_SCRIPT" ]; then
    echo "❌ Script interativo não encontrado!"
    echo "   Execute primeiro: create-interactive.sh"
    exit 1
fi

# Tornar executáveis
chmod +x "$CRON_WRAPPER" "$INTERACTIVE_SCRIPT"

echo "🔧 Configurando permissões... ✅"

# Criar cron job que sempre notifica
echo ""
echo "⏰ Configurando notificações automáticas..."
echo "─────────────────────────────────────────────────────────────────"

# Verificar se já existe cron job
existing_cron=$(crontab -l 2>/dev/null | grep -c "maximous" || echo "0")

if [ "$existing_cron" -gt 0 ]; then
    echo "   ℹ️  Cron jobs do Maximous já existem"
    echo "   🔄 Atualizando para nova versão..."
    
    # Remover cron antigo
    crontab -l 2>/dev/null | grep -v maximous | crontab -
fi

# Adicionar novo cron que sempre notifica
echo "   ✅ Adicionando cron wrapper..."
(
    crontab -l 2>/dev/null
    echo "# MAXIMOUS v2.1 - Verificação Interativa"
    echo "*/30 * * * * export HOME=$HOME && bash $CRON_WRAPPER >> $INSTALL_DIR/data/cron-output.log 2>&1"
    echo ""
    echo "# MAXIMOUS - Alerta de sessão longa (a cada 2h)"
    echo "0 */2 * * * export HOME=$HOME && bash $INTERACTIVE_SCRIPT >> $INSTALL_DIR/data/interactive.log 2>&1"
) | crontab -

echo "   ✅ Cron configurado:"
echo "      • Verificação completa: A cada 30 minutos"
echo "      • Alerta de sessão longa: A cada 2 horas"

echo ""
echo "💾 Criando estrutura de dados..."
echo "─────────────────────────────────────────────────────────────────"

# Criar diretórios necessários
mkdir -p "$INSTALL_DIR/data/backups"
mkdir -p "$INSTALL_DIR/data/logs"
mkdir -p "$HOME/.openclaw/workspace/memory/maximous"

# Criar arquivo de versão
echo "2.1.0-interactive" > "$INSTALL_DIR/VERSION"

echo "   ✅ Diretórios criados"
echo "   ✅ Logs configurados"
echo "   ✅ Backups estruturados"

echo ""
echo "📋 Criando aliases úteis..."
echo "─────────────────────────────────────────────────────────────────"

# Adicionar alias ao .bashrc se não existir
if ! grep -q "maximous-interactive" ~/.bashrc 2>/dev/null; then
    echo "" >> ~/.bashrc
    echo "# MAXIMOUS v2.1 Aliases" >> ~/.bashrc
    echo "alias maximous='bash $INTERACTIVE_SCRIPT'" >> ~/.bashrc
    echo "alias maximous-summary='bash $INTERACTIVE_SCRIPT summary'" >> ~/.bashrc
    echo "alias maximous-backup='bash $INTERACTIVE_SCRIPT backup'" >> ~/.bashrc
    echo "✅ Aliases adicionados ao .bashrc"
else
    echo "   ℹ️  Aliases já existem"
fi

echo ""
echo "🧪 Testando instalação..."
echo "─────────────────────────────────────────────────────────────────"

# Teste rápido
if [ -f "$INTERACTIVE_SCRIPT" ] && [ -x "$INTERACTIVE_SCRIPT" ]; then
    echo "   ✅ Script interativo: OK"
else
    echo "   ❌ Erro no script interativo"
    exit 1
fi

if [ -f "$CRON_WRAPPER" ] && [ -x "$CRON_WRAPPER" ]; then
    echo "   ✅ Cron wrapper: OK"
else
    echo "   ❌ Erro no cron wrapper"
    exit 1
fi

echo ""
echo "╔═══════════════════════════════════════════════════════════════╗"
echo "║         ✅ ATUALIZAÇÃO CONCLUÍDA COM SUCESSO!                 ║"
echo "╚═══════════════════════════════════════════════════════════════╝"
echo ""
echo "📊 RESUMO DA v2.1:"
echo ""
echo "   Versão: 2.1.0-interactive"
echo "   Status: ✅ Super Interativo ativado"
echo ""
echo "🎯 COMO USAR AGORA:"
echo ""
echo "   # Executar verificação interativa manualmente"
echo "   bash $INTERACTIVE_SCRIPT"
echo ""
echo "   # Ou use o novo alias:"
echo "   maximous"
echo ""
echo "   # Ver resumo do que está salvo"
echo "   maximous-summary"
echo ""
echo "   # Forçar backup agora"
echo "   maximous-backup"
echo ""
echo "⏰ AUTOMÁTICO (Cron):"
echo "   • A cada 30 min: Verificação de saúde"
echo "   • A cada 2 horas: Alerta se sessão longa"
echo ""
echo "💡 CARACTERÍSTICAS DA v2.1:"
echo "   ✅ SEMPRE avisa quando executa"
echo "   ✅ SEMPRE pergunta antes de qualquer ação"
echo "   ✅ Faz backup AUTOMÁTICO antes de decisões"
echo "   ✅ Mostra opções múltiplas para escolher"
echo "   ✅ NUNCA perde dados"
echo ""
echo "🚀 PRÓXIMO PASSO:"
echo "   Execute 'maximous' para testar a nova versão!"
echo ""

# Executar teste
echo "🧪 Executando teste rápido..."
echo ""
bash "$INTERACTIVE_SCRIPT" 2>&1 | head -30

echo ""
echo "✅ Tudo pronto! Maximous v2.1 está no modo Super Interativo!"
echo ""
