#!/bin/bash
# SGN - Script de Instalação Automática
# Execute no pve1 (Proxmox host) como root

echo "🚀 Iniciando instalação do SGN - Sistema de Gerenciamento de Negócios"
echo "📍 Destino: CT 104 (SGN - 192.168.0.99)"
echo ""

# Cores
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m'

# Verificar se está no pve1
if ! command -v pct &> /dev/null; then
    echo "❌ ERRO: Este script deve ser executado no Proxmox host (pve1)"
    exit 1
fi

# Verificar se CT 104 existe
echo "🔍 Verificando container 104..."
if ! pct status 104 &> /dev/null; then
    echo "❌ ERRO: Container 104 não encontrado"
    exit 1
fi

echo -e "${GREEN}✅ Container 104 encontrado${NC}"
echo ""

# Criar diretórios no CT 104
echo "📁 Criando estrutura de diretórios..."
pct exec 104 -- mkdir -p /var/www/html/includes
pct exec 104 -- mkdir -p /var/www/html/modulos/servicos
pct exec 104 -- mkdir -p /var/www/html/modulos/financeiro
pct exec 104 -- mkdir -p /var/www/html/modulos/clientes
pct exec 104 -- mkdir -p /var/www/html/modulos/config
pct exec 104 -- mkdir -p /var/www/html/scripts
pct exec 104 -- mkdir -p /var/www/html/alerts

echo -e "${GREEN}✅ Diretórios criados${NC}"

# Copiar arquivos
echo ""
echo "📄 Copiando arquivos do Stark (CT 100)..."

# Arquivos raiz
pct push 104 /root/.openclaw/workspace/sgn_final/index.php /var/www/html/index.php
pct push 104 /root/.openclaw/workspace/sgn_final/dashboard.php /var/www/html/dashboard.php
pct push 104 /root/.openclaw/workspace/sgn_final/logout.php /var/www/html/logout.php

echo -e "${BLUE}   ✓ index.php, dashboard.php, logout.php${NC}"

# Includes
pct push 104 /root/.openclaw/workspace/sgn_final/includes/config.php /var/www/html/includes/config.php
pct push 104 /root/.openclaw/workspace/sgn_final/includes/auth.php /var/www/html/includes/auth.php

echo -e "${BLUE}   ✓ includes/config.php, includes/auth.php${NC}"

# Módulos - Serviços
pct push 104 /root/.openclaw/workspace/sgn_final/modulos/servicos/agendados.php /var/www/html/modulos/servicos/agendados.php
pct push 104 /root/.openclaw/workspace/sgn_final/modulos/servicos/pendentes.php /var/www/html/modulos/servicos/pendentes.php
pct push 104 /root/.openclaw/workspace/sgn_final/modulos/servicos/execucao.php /var/www/html/modulos/servicos/execucao.php
pct push 104 /root/.openclaw/workspace/sgn_final/modulos/servicos/novo.php /var/www/html/modulos/servicos/novo.php

echo -e "${BLUE}   ✓ modulos/servicos/ (4 arquivos)${NC}"

# Módulos - Financeiro
pct push 104 /root/.openclaw/workspace/sgn_final/modulos/financeiro/index.php /var/www/html/modulos/financeiro/index.php
pct push 104 /root/.openclaw/workspace/sgn_final/modulos/financeiro/contas.php /var/www/html/modulos/financeiro/contas.php
pct push 104 /root/.openclaw/workspace/sgn_final/modulos/financeiro/extratos.php /var/www/html/modulos/financeiro/extratos.php
pct push 104 /root/.openclaw/workspace/sgn_final/modulos/financeiro/movimentacoes.php /var/www/html/modulos/financeiro/movimentacoes.php
pct push 104 /root/.openclaw/workspace/sgn_final/modulos/financeiro/monitor_mei.php /var/www/html/modulos/financeiro/monitor_mei.php

echo -e "${BLUE}   ✓ modulos/financeiro/ (5 arquivos)${NC}"

# Módulos - Clientes
pct push 104 /root/.openclaw/workspace/sgn_final/modulos/clientes/index.php /var/www/html/modulos/clientes/index.php
pct push 104 /root/.openclaw/workspace/sgn_final/modulos/clientes/cadastro.php /var/www/html/modulos/clientes/cadastro.php
pct push 104 /root/.openclaw/workspace/sgn_final/modulos/clientes/importar.php /var/www/html/modulos/clientes/importar.php

echo -e "${BLUE}   ✓ modulos/clientes/ (3 arquivos)${NC}"

# Módulos - Config
pct push 104 /root/.openclaw/workspace/sgn_final/modulos/config/alertas_email.php /var/www/html/modulos/config/alertas_email.php

echo -e "${BLUE}   ✓ modulos/config/alertas_email.php${NC}"

# Scripts
pct push 104 /root/.openclaw/workspace/sgn_final/scripts/monitor_email.py /var/www/html/scripts/monitor_email.py

echo -e "${BLUE}   ✓ scripts/monitor_email.py${NC}"

echo ""
echo -e "${GREEN}✅ Todos os arquivos copiados com sucesso!${NC}"

# Ajustar permissões
echo ""
echo "🔧 Ajustando permissões..."
pct exec 104 -- chown -R www-data:www-data /var/www/html/
pct exec 104 -- chmod +x /var/www/html/scripts/monitor_email.py
pct exec 104 -- chmod 755 /var/www/html/includes

echo -e "${GREEN}✅ Permissões configuradas${NC}"

# Instalar dependências Python
echo ""
echo "📦 Instalando dependências Python..."
pct exec 104 -- apt update
pct exec 104 -- apt install -y python3-pip
pct exec 104 -- pip3 install imaplib2 email-validator

echo -e "${GREEN}✅ Python configurado${NC}"

# Configurar cron para bot de email
echo ""
echo "⏰ Configurando cron (verificação a cada 5 minutos)..."
pct exec 104 -- bash -c "crontab -l 2>/dev/null | grep -v monitor_email || true" > /tmp/cron_old
pct exec 104 -- bash -c "echo '*/5 * * * * /usr/bin/python3 /var/www/html/scripts/monitor_email.py >> /var/log/sgn_email_monitor.log 2>&1' | crontab -"

echo -e "${GREEN}✅ Cron configurado${NC}"

# Criar diretório de logs
echo ""
echo "📝 Criando diretório de logs..."
pct exec 104 -- mkdir -p /var/log
pct exec 104 -- touch /var/log/sgn_email_monitor.log
pct exec 104 -- chown www-data:www-data /var/log/sgn_email_monitor.log

echo -e "${GREEN}✅ Logs configurados${NC}"

# Restart Apache
echo ""
echo "🔄 Reiniciando Apache..."
pct exec 104 -- systemctl restart apache2

echo -e "${GREEN}✅ Apache reiniciado${NC}"

echo ""
echo "=========================================="
echo -e "${GREEN}🎉 INSTALAÇÃO CONCLUÍDA COM SUCESSO!${NC}"
echo "=========================================="
echo ""
echo "📍 Acesse: http://192.168.0.99/"
echo "👤 Login: admin"
echo "🔒 Senha: Rcmp814k@#"
echo ""
echo "📊 Funcionalidades disponíveis:"
echo "   • Dashboard com menu lateral"
echo "   • Serviços (Agendados, Pendentes, Em Execução)"
echo "   • Financeiro (4 contas, Extratos, Movimentações)"
echo "   • Monitor MEI (limite R$ 6.750/mês)"
echo "   • Clientes e Fornecedores"
echo "   • Importação de extratos"
echo "   • Bot de email (verifica a cada 5 min)"
echo ""
echo "📁 Total de arquivos instalados: 20"
echo ""
echo "💡 Próximos passos:"
echo "   1. Acesse http://192.168.0.99/ no navegador"
echo "   2. Faça login com admin / Rcmp814k@#"
echo "   3. Cadastre suas 4 contas bancárias"
echo "   4. Comece a usar!"
echo ""
echo "🆘 Suporte: Verifique logs em /var/log/sgn_email_monitor.log"
echo "=========================================="