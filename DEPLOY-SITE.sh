#!/bin/bash
# Script de Deploy - Amigos de 4 Patas
# Data: 30/04/2026

echo "🚀 Deploy - Amigos de 4 Patas"
echo "=============================="
echo ""

# Arquivos para deploy
FILES=(
    "amigos4patas-index-novo.html"
    "novo-sobre.html"
    "castracao.html"
    "utilidade-publica.html"
    "doacoes.html"
    "diy.html"
    "servicos.html"
)

echo "📋 Arquivos para deploy:"
for file in "${FILES[@]}"; do
    if [ -f "/root/.openclaw/workspace/$file" ]; then
        echo "  ✅ $file"
    else
        echo "  ❌ $file (não encontrado)"
    fi
done

echo ""
echo "📍 Destino do deploy:"
echo "  Opção 1: /var/www/amigos4patas/"
echo "  Opção 2: FTP/SFTP (hospedagem externa)"
echo "  Opção 3: Git push"
echo ""

# Verificar se é hospedagem local
if [ -d "/var/www/amigos4patas" ]; then
    echo "✅ Pasta local encontrada!"
    echo ""
    echo "Copiando arquivos..."
    
    for file in "${FILES[@]}"; do
        src="/root/.openclaw/workspace/$file"
        dst="/var/www/amigos4patas/$file"
        
        if [ -f "$src" ]; then
            cp "$src" "$dst"
            echo "  ✅ $file copiado"
        fi
    done
    
    # Renomear index
    echo ""
    echo "Atualizando index.html..."
    cp /root/.openclaw/workspace/amigos4patas-index-novo.html /var/www/amigos4patas/index.html
    echo "  ✅ index.html atualizado"
    
    echo ""
    echo "✅ Deploy concluído!"
else
    echo "⚠️  Pasta /var/www/amigos4patas não encontrada"
    echo ""
    echo "Instruções:"
    echo "1. Se o site for em hospedagem externa:"
    echo "   - Use FTP/SFTP para upload dos arquivos"
    echo "   - Ou faça git push se usar repositório"
    echo ""
    echo "2. Se o site for local:"
    echo "   - Crie a pasta: mkdir -p /var/www/amigos4patas"
    echo "   - Rode este script novamente"
    echo ""
fi

echo ""
echo "📊 Resumo das alterações:"
echo "  ✅ Slogan: 'Comunidade Unida, Cidade Sustentável, Vida Protegida'"
echo "  ✅ ODS 11, 15, 17 destacados"
echo "  ✅ Seção Impacto na Saúde Pública"
echo "  ✅ 4 páginas de Utilidade Pública"
echo ""
