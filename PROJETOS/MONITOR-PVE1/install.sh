#!/bin/bash
# Install Script - Monitor PVE1 Dashboard
# Executar como root

set -e

echo "🚀 Instalando Monitor PVE1 Dashboard..."
echo ""

# Verificar se é root
if [ "$EUID" -ne 0 ]; then 
    echo "❌ Executar como root (sudo ./install.sh)"
    exit 1
fi

# Atualizar pacotes
echo "📦 Atualizando pacotes..."
apt update -qq

# Instalar dependências
echo "📦 Instalando dependências..."
apt install -y -qq python3-flask speedtest-cli lm-sensors

# Instalar Flask via pip (caso não esteja disponível via apt)
if ! python3 -c "import flask" 2>/dev/null; then
    echo "📦 Instalando Flask via pip..."
    pip3 install flask
fi

# Configurar serviço systemd
echo "⚙️ Configurando serviço systemd..."
cp monitor-pve1.service /etc/systemd/system/
systemctl daemon-reload
systemctl enable monitor-pve1

echo ""
echo "✅ Instalação concluída!"
echo ""
echo "📊 Para iniciar o dashboard:"
echo "   systemctl start monitor-pve1"
echo ""
echo "📊 Para verificar status:"
echo "   systemctl status monitor-pve1"
echo ""
echo "🌐 Acessar em: http://$(hostname -I | awk '{print $1}'):5000"
echo ""
echo "🔧 Scripts disponíveis em ./scripts/"
echo ""
