#!/bin/bash
# Script para enviar PRD técnico por email

EMAIL_DESTINO="abbade@outlook.com"
ASSUNTO="PRD Técnico - OpenClaw Implementações (27/04/2026)"
ARQUIVO="$HOME/.openclaw/workspace/PRD-OPENCLAW-IMPLEMENTACOES-2026-04-27.md"

# Verificar se arquivo existe
if [ ! -f "$ARQUIVO" ]; then
    echo "❌ Erro: Arquivo $ARQUIVO não encontrado"
    exit 1
fi

# Preparar conteúdo do email
cat > /tmp/email-prd.txt << 'EOF'
Olá Acib,

Segue em anexo o PRD Técnico completo das implementações OpenClaw realizadas em 27/04/2026.

RESUMO DO DOCUMENTO:
• MAXIMOUS v2.0 - Sistema de preservação de contexto (7 melhorias)
• STORMS v1.0 - Sistema de otimização (4 sistemas)
• Infraestrutura - 13 CTs Proxmox documentados
• 11 Cron jobs ativos
• Métricas de performance (64% economia tokens)
• Regras comportamentais implementadas

O documento contém especificações técnicas completas para replicação
ou treinamento de novas IAs baseadas neste modelo.

Arquivos também disponíveis em:
• Local: ~/.openclaw/workspace/
• DATASVR: /home/master/LAN/MEMORIES/

Atenciosamente,
Stark (Assistente IA)

---
Sistema Stark/Maestro
Proxmox VE - 13 Containers
Data: $(date)
EOF

# Tentar enviar via sendmail se disponível
if command -v sendmail > /dev/null 2>&1; then
    (
        echo "To: $EMAIL_DESTINO"
        echo "Subject: $ASSUNTO"
        echo "Content-Type: text/plain; charset=UTF-8"
        echo ""
        cat /tmp/email-prd.txt
        echo ""
        echo "---"
        echo "CONTEÚDO DO PRD:"
        echo "---"
        cat "$ARQUIVO"
    ) | sendmail "$EMAIL_DESTINO"
    
    if [ $? -eq 0 ]; then
        echo "✅ Email enviado com sucesso para $EMAIL_DESTINO"
    else
        echo "⚠️  Falha no envio via sendmail"
    fi
else
    echo "⚠️  sendmail não disponível"
    echo ""
    echo "📧 CONTEÚDO DO EMAIL PREPARADO:"
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    cat /tmp/email-prd.txt
    echo ""
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
    echo ""
    echo "💡 Para enviar manualmente:"
    echo "   1. Copie o conteúdo acima"
    echo "   2. Cole no seu cliente de email"
    echo "   3. Anexe o arquivo: $ARQUIVO"
    echo "   4. Envie para: $EMAIL_DESTINO"
fi

# Informações adicionais
echo ""
echo "📊 ESTATÍSTICAS DO PRD:"
echo "   Tamanho: $(du -h $ARQUIVO | awk '{print $1}')"
echo "   Linhas: $(wc -l $ARQUIVO | awk '{print $1}')"
echo "   Palavras: $(wc -w $ARQUIVO | awk '{print $1}')"
echo ""
echo "📁 Arquivo disponível em:"
echo "   $ARQUIVO"
