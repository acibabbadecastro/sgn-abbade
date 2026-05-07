#!/bin/bash
# Script de verificação - Acib pode executar quando quiser

echo "=========================================="
echo "  📚 VERIFICAÇÃO FACULDADE - ACIB"
echo "=========================================="
echo ""
echo "📅 Data: $(date '+%d/%m/%Y %H:%M')"
echo ""

# Verificar arquivo principal
if [ -f /root/.openclaw/workspace/FACULDADE-FORMACAO-COMPLETA.md ]; then
    echo "✅ Arquivo principal: EXISTE"
    echo "   Tamanho: $(stat -c%s /root/.openclaw/workspace/FACULDADE-FORMACAO-COMPLETA.md) bytes"
    echo "   Modificado: $(stat -c%y /root/.openclaw/workspace/FACULDADE-FORMACAO-COMPLETA.md | cut -d' ' -f1)"
else
    echo "❌ Arquivo principal: NÃO ENCONTRADO"
fi

# Verificar backup DATASVR
if [ -f /home/master/LAN/Acib/faculdade/FACULDADE-FORMACAO-COMPLETA.md ]; then
    echo "✅ Backup DATASVR: EXISTE"
else
    echo "❌ Backup DATASVR: NÃO ENCONTRADO"
fi

# Verificar cron jobs
echo ""
echo "🔔 Lembretes configurados:"
curl -s http://localhost:8080/v1/cron/list | grep -E "(faculdade|Portfólio|prova)" | wc -l | xargs echo "   Total:"

echo ""
echo "=========================================="
echo "Execute este script a qualquer momento"
echo "para verificar se está tudo salvo."
echo "=========================================="
