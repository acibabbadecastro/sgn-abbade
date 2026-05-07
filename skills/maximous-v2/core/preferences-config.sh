#!/bin/bash
# MAXIMOUS v2.0 - Configurador de Preferências de Armazenamento
# Pergunta ao usuário como quer organizar seus dados

MAXIMOUS_DIR="$HOME/.openclaw/workspace/skills/maximous-v2"
CONFIG_FILE="$MAXIMOUS_DIR/.user-preferences.conf"

clear
echo ""
echo "╔═══════════════════════════════════════════════════════════════╗"
echo "║   🧠 MAXIMOUS - CONFIGURAÇÃO DE PREFERÊNCIAS                 ║"
echo "║       Como você quer organizar suas memórias?                 ║"
echo "╚═══════════════════════════════════════════════════════════════╝"
echo ""
echo "👤 Usuário: Acib ABBADE"
echo "📅 Data: $(date '+%d/%m/%Y %H:%M')"
echo ""

# Função para salvar preferências
salvar_preferencia() {
    local chave="$1"
    local valor="$2"
    
    # Criar arquivo se não existir
    [ -f "$CONFIG_FILE" ] || touch "$CONFIG_FILE"
    
    # Remover chave existente
    grep -v "^$chave=" "$CONFIG_FILE" > "$CONFIG_FILE.tmp" 2>/dev/null || true
    mv "$CONFIG_FILE.tmp" "$CONFIG_FILE" 2>/dev/null || true
    
    # Adicionar nova preferência
    echo "$chave=$valor" >> "$CONFIG_FILE"
}

# Pergunta 1: Tipo de organização
echo "📂 1. ORGANIZAÇÃO DE ARQUIVOS"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "Como você prefere que organize seus dados?"
echo ""
echo "   [1] 📅 Automático por DATA (ano/mês/dia)"
echo "   [2] 🏷️  Automático por CATEGORIA (faculdade/trabalho/pessoal)"
echo "   [3] 🏢 Automático por PROJETO (cada projeto uma pasta)"
echo "   [4] ⚡ Inteligente (MIX: categoria + data + valor)"
echo ""
read -p "   Escolha (1-4): " org_tipo

case $org_tipo in
    1) salvar_preferencia "ORGANIZACAO" "data" ;;
    2) salvar_preferencia "ORGANIZACAO" "categoria" ;;
    3) salvar_preferencia "ORGANIZACAO" "projeto" ;;
    4) salvar_preferencia "ORGANIZACAO" "inteligente" ;;
    *) salvar_preferencia "ORGANIZACAO" "inteligente" ;;
esac

echo ""
echo "✅ Preferência salva!"
echo ""

# Pergunta 2: Locais de backup
echo "💾 2. LOCAIS DE BACKUP"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "Onde você quer que salve seus dados?"
echo ""
echo "   [1] 💻 Só local (rápido, mas sem backup)"
echo "   [2] 🏠 DATASVR (backup em casa)"
echo "   [3] ☁️  Multi-cloud (GitHub + Google + Dropbox)"
echo "   [4] 🔒 Todos (local + DATASVR + cloud)"
echo ""
read -p "   Escolha (1-4): " backup_local

case $backup_local in
    1) salvar_preferencia "BACKUP" "local" ;;
    2) salvar_preferencia "BACKUP" "datasvr" ;;
    3) salvar_preferencia "BACKUP" "cloud" ;;
    4) salvar_preferencia "BACKUP" "todos" ;;
    *) salvar_preferencia "BACKUP" "datasvr" ;;
esac

echo ""
echo "✅ Preferência salva!"
echo ""

# Pergunta 3: Frequência de sync
echo "🔄 3. FREQUÊNCIA DE SINCRONIZAÇÃO"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "Com que frequência sincronizar dados?"
echo ""
echo "   [1] ⚡ Tempo real (a cada alteração)"
echo "   [2] 🕐 A cada 5 minutos (padrão)"
echo "   [3] 🕕 A cada 30 minutos (econômico)"
echo "   [4] 📅 Diário (manual quando quiser)"
echo ""
read -p "   Escolha (1-4): " sync_freq

case $sync_freq in
    1) salvar_preferencia "SYNC_FREQ" "tempo-real" ;;
    2) salvar_preferencia "SYNC_FREQ" "5min" ;;
    3) salvar_preferencia "SYNC_FREQ" "30min" ;;
    4) salvar_preferencia "SYNC_FREQ" "diario" ;;
    *) salvar_preferencia "SYNC_FREQ" "5min" ;;
esac

echo ""
echo "✅ Preferência salva!"
echo ""

# Pergunta 4: Alertas
echo "🔔 4. NOTIFICAÇÕES E ALERTAS"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "Como você quer ser notificado?"
echo ""
echo "   [1] 📱 Somente erros críticos"
echo "   [2] 📊 Resumo diário (1x por dia)"
echo "   [3] 🔔 Tudo em tempo real (chat)"
echo "   [4] 🤐 Silencioso (consultar quando quiser)"
echo ""
read -p "   Escolha (1-4): " notificacao

case $notificacao in
    1) salvar_preferencia "NOTIFICACAO" "erros" ;;
    2) salvar_preferencia "NOTIFICACAO" "resumo" ;;
    3) salvar_preferencia "NOTIFICACAO" "tempo-real" ;;
    4) salvar_preferencia "NOTIFICACAO" "silencioso" ;;
    *) salvar_preferencia "NOTIFICACAO" "resumo" ;;
esac

echo ""
echo "✅ Preferência salva!"
echo ""

# Pergunta 5: Economia de tokens
echo "💰 5. ECONOMIA DE TOKENS"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "Qual nível de economia você prefere?"
echo ""
echo "   [1] 🐌 Conservador (economia ~30%, máxima qualidade)"
echo "   [2] ⚖️  Balanceado (economia ~50%, boa qualidade)"
echo "   [3] 🚀 Agresivo (economia ~70%, qualidade mantida)"
echo "   [4] 🏎️  Ultra (economia ~80%, pode perder nuances)"
echo ""
read -p "   Escolha (1-4): " economia

case $economia in
    1) salvar_preferencia "ECONOMIA_NIVEL" "conservador" ;;
    2) salvar_preferencia "ECONOMIA_NIVEL" "balanceado" ;;
    3) salvar_preferencia "ECONOMIA_NIVEL" "agressivo" ;;
    4) salvar_preferencia "ECONOMIA_NIVEL" "ultra" ;;
    *) salvar_preferencia "ECONOMIA_NIVEL" "balanceado" ;;
esac

echo ""
echo "✅ Preferência salva!"
echo ""

# Salvar usuário
salvar_preferencia "USUARIO" "Acib ABBADE"
salvar_preferencia "DATA_CONFIG" "$(date -Iseconds)"

# Resumo final
echo ""
echo "╔═══════════════════════════════════════════════════════════════╗"
echo "║          ✅ CONFIGURAÇÃO SALVA COM SUCESSO!                   ║"
echo "╚═══════════════════════════════════════════════════════════════╝"
echo ""
echo "📋 RESUMO DAS PREFERÊNCIAS:"
echo ""
echo "   Organização: $(grep ORGANIZACAO $CONFIG_FILE | cut -d= -f2)"
echo "   Backup: $(grep BACKUP $CONFIG_FILE | cut -d= -f2)"
echo "   Sincronização: $(grep SYNC_FREQ $CONFIG_FILE | cut -d= -f2)"
echo "   Notificações: $(grep NOTIFICACAO $CONFIG_FILE | cut -d= -f2)"
echo "   Economia: $(grep ECONOMIA_NIVEL $CONFIG_FILE | cut -d= -f2)"
echo ""
echo "💾 Configuração salva em: $CONFIG_FILE"
echo ""
echo "🚀 Maximous está pronto para organizar suas memórias!"
echo ""
echo "💡 Para alterar depois, execute:"
echo "   bash $MAXIMOUS_DIR/core/preferences-config.sh"
echo ""

# Backup das preferências
if ping -c 1 -W 2 "192.168.0.72" >/dev/null 2>&1; then
    scp -i "$HOME/.ssh/id_ed25519" -o StrictHostKeyChecking=no \
        "$CONFIG_FILE" "root@192.168.0.72:/home/master/LAN/MEMORIES/maximous-v2/" 2>/dev/null
    echo "☁️  Configuração também salva na ARCA (DATASVR)"
fi

echo ""
echo "╚═══════════════════════════════════════════════════════════════╝"
echo ""
