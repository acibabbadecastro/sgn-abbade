#!/bin/bash
# MAXIMOUS v2.0 - Auto-recuperação após /new
# Script executado automaticamente quando sessão nova detecta perda de contexto

echo "🧠 MAXIMOUS: Verificando dados pós-/new..."
echo ""

ARQUIVOS_CRITICOS=(
    "$HOME/.openclaw/workspace/CREDENCIAIS-CTS-CRITICO.md"
    "$HOME/.openclaw/workspace/PRIMEIRO-A-LER.md"
)

# Verificar se arquivos críticos existem
recuperar_dados() {
    local recuperados=0
    
    # Tentar recuperar da ARCA
    if ping -c 1 -W 2 "192.168.0.72" >/dev/null 2>&1; then
        echo "☁️ Conectado à ARCA (DATASVR), recuperando dados..."
        
        scp -i "$HOME/.ssh/id_ed25519" -o StrictHostKeyChecking=no \
            "root@192.168.0.72:/home/master/LAN/MEMORIES/CREDENCIAIS-CTS-CRITICO.md" \
            "$HOME/.openclaw/workspace/" 2>/dev/null && recuperados=$((recuperados + 1))
    fi
    
    # Verificar se recuperou
    for arquivo in "${ARQUIVOS_CRITICOS[@]}"; do
        if [ -f "$arquivo" ]; then
            echo "✅ Encontrado: $(basename $arquivo)"
        else
            echo "❌ Perdido: $(basename $arquivo)"
        fi
    done
    
    return $recuperados
}

# Mostrar resumo
mostrar_resumo() {
    echo ""
    echo "╔════════════════════════════════════════════════════════════╗"
    echo "║  🧠 MAXIMOUS - RECUPERAÇÃO AUTOMÁTICA PÓS-/new              ║"
    echo "╚════════════════════════════════════════════════════════════╝"
    echo ""
    echo "📂 ARQUIVOS CRÍTICOS RECUPERADOS:"
    echo ""
    
    # Credenciais
    if [ -f "$HOME/.openclaw/workspace/CREDENCIAIS-CTS-CRITICO.md" ]; then
        echo "✅ CREDENCIAIS: Disponíveis"
        echo "   Local: ~/.openclaw/workspace/CREDENCIAIS-CTS-CRITICO.md"
        echo "   → Acesse: cat ~/.openclaw/workspace/CREDENCIAIS-CTS-CRITICO.md"
    else
        echo "❌ CREDENCIAIS: Não recuperado"
    fi
    
    echo ""
    echo "🎯 PRÓXIMOS PASSOS:"
    echo "   1. Leia o arquivo de credenciais"
    echo "   2. Verifique acesso aos CTs"
    echo "   3. Continue seu trabalho normal"
    echo ""
    echo "🌩️  STORMS: Monitoramento ativo"
    echo "   Economia de tokens: ON"
    echo ""
}

# Executar recuperação
recuperar_dados
mostrar_resumo

echo "✅ Sistema restaurado. Pronto para trabalhar!"
