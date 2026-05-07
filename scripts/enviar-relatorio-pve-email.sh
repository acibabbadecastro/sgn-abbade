#!/bin/bash
# Script para enviar relatório PVE por email

EMAIL_DESTINO="abbade@outlook.com"
ASSUNTO="Relatorio Varredura PVE - $(date +%d/%m/%Y)"
ARQUIVO="/root/.openclaw/workspace/RELATORIO-VARREDURA-PVE-2026-04-27.md"

# Verificar se arquivo existe
if [ ! -f "$ARQUIVO" ]; then
    echo "Erro: Arquivo $ARQUIVO nao encontrado"
    exit 1
fi

# Enviar via sendmail (se configurado) ou salvar para envio manual
echo "Para: $EMAIL_DESTINO"
echo "Assunto: $ASSUNTO"
echo "Content-Type: text/plain; charset=UTF-8"
echo ""
cat "$ARQUIVO"

echo ""
echo "Relatorio preparado para envio."
echo "Comando: cat $ARQUIVO | mail -s \"$ASSUNTO\" $EMAIL_DESTINO"
