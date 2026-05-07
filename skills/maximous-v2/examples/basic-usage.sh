#!/bin/bash
# MAXIMOUS - Exemplo de Uso
# Demonstra como usar o sistema em um fluxo de trabalho real

echo "═══════════════════════════════════════════════════════════"
echo "  🧠 MAXIMOUS v2.0 - EXEMPLO DE USO"
echo "═══════════════════════════════════════════════════════════"
echo ""

# Passo 1: Verificar status
echo "📊 Passo 1: Verificando status do sistema"
echo "─────────────────────────────────────────────────────────────"
bash ~/.openclaw/workspace/skills/maximous-v2/scripts/dashboard-status.sh
echo ""

# Passo 2: Organizar memórias
echo "📂 Passo 2: Organizando memórias pendentes"
echo "─────────────────────────────────────────────────────────────"
bash ~/.openclaw/workspace/skills/maximous-v2/scripts/memory-organizer.sh process
echo ""

# Passo 3: Ver economia
echo "💰 Passo 3: Analisando economia de tokens"
echo "─────────────────────────────────────────────────────────────"
bash ~/.openclaw/workspace/skills/maximous-v2/scripts/memory-organizer.sh economy
echo ""

# Passo 4: Sincronizar
echo "☁️  Passo 4: Sincronizando com nuvem"
echo "─────────────────────────────────────────────────────────────"
bash ~/.openclaw/workspace/skills/maximous-v2/scripts/multi-cloud-sync.sh datasvr
echo ""

echo "═══════════════════════════════════════════════════════════"
echo "  ✅ Exemplo concluído!"
echo "═══════════════════════════════════════════════════════════"
echo ""
echo "Comandos úteis:"
echo ""
echo "  # Dashboard em tempo real"
echo "  bash ~/.openclaw/workspace/skills/maximous-v2/scripts/dashboard-status.sh"
echo ""
echo "  # Forçar /new inteligente"
echo "  bash ~/.openclaw/workspace/skills/maximous-v2/../storms/scripts/force-new.sh"
echo ""
echo "  # Gerar relatório de economia"
echo "  bash ~/.openclaw/workspace/skills/maximous-v2/scripts/savings-report.sh"
echo ""
