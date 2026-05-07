#!/bin/bash
# MAXIMOUS Cron Wrapper - Executa com notificação
# Sempre avisa antes de executar qualquer coisa

LOG_FILE="$HOME/.openclaw/workspace/skills/maximous-v2/data/cron.log"
mkdir -p "$(dirname "$LOG_FILE")"

echo "[$(date '+%Y-%m-%d %H:%M:%S')] Cron Maximous iniciado" >> "$LOG_FILE"

# Enviar notificação de início
# No Telegram, isso seria enviado automaticamente
cat << EOF

╔═══════════════════════════════════════════════════════════════╗
║           🧠 MAXIMOUS - Verificação Automática               ║
╚═══════════════════════════════════════════════════════════════╝

⏰ Horário: $(date '+%H:%M:%S')
📅 Data: $(date '+%d/%m/%Y')

🔔 Estou executando minha verificação programada!

Em 5 segundos vou analisar sua sessão...

💡 Você pode:
   • Deixar eu rodar (automático)
   • Responder para interagir
   • Ignorar (vou salvar os dados mesmo assim)

EOF

# Aguardar 5 segundos para usuário ver
sleep 5

# Executar o script interativo
bash "$HOME/.openclaw/workspace/skills/maximous-v2/scripts/maximous-interactive.sh" 2>&1 | tee -a "$LOG_FILE"

# Notificar conclusão
echo ""
echo "✅ Verificação automática concluída às $(date '+%H:%M:%S')"
echo "   Próxima verificação: Em breve"
echo ""
