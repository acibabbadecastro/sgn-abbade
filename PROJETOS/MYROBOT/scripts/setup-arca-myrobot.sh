#!/bin/bash
# Script para criar estrutura de pastas MYROBOT na ARCA
# Executar quando DATASVR (192.168.0.72) estiver online

# Configurações
ARCA_IP="192.168.0.72"
ARCA_USER="master"
ARCA_BASE="/home/master/LAN/Acib/MYROBOT"
LOCAL_BACKUP="~/.openclaw/workspace/PROJETOS/MYROBOT"

# Cores para output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${YELLOW}Iniciando estruturação MYROBOT na ARCA...${NC}"

# Verificar conectividade
if ! ping -c 1 $ARCA_IP &> /dev/null; then
    echo -e "${RED}❌ DATASVR ($ARCA_IP) não está acessível${NC}"
    echo "⏳ Salve este script e execute quando DATASVR voltar"
    exit 1
fi

echo -e "${GREEN}✅ DATASVR acessível!${NC}"

# Criar estrutura de pastas via SSH
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no $ARCA_USER@$ARCA_IP << 'EOF'
    # Criar diretório base
    mkdir -p $ARCA_BASE
    cd $ARCA_BASE
    
    # Estrutura completa
    mkdir -p 00-DOCUMENTACAO_GERAL
    mkdir -p 01-PRODUTOS_SERVICOS/BIOIMPEDANCIA/{docs,src,hardware,assets}
    mkdir -p 01-PRODUTOS_SERVICOS/ESTOQUE_GESTAO
    mkdir -p 01-PRODUTOS_SERVICOS/ATENDIMENTO
    mkdir -p 01-PRODUTOS_SERVICOS/ANALISE_DADOS
    mkdir -p 01-PRODUTOS_SERVICOS/AUTOMACAO
    mkdir -p 02-CLIENTES/{leads,ativos,cases}
    mkdir -p 03-MARKETING_VENDAS/website/{design,conteudo,assets}
    mkdir -p 03-MARKETING_VENDAS/materiais
    mkdir -p 03-MARKETING_VENDAS/propostas
    mkdir -p 04-INFRAESTRUTURA/containers/{CT113-MYROBOT-WEB,CT114-MYROBOT-SEC,CT115-MYROBOT-DATA}
    mkdir -p 04-INFRAESTRUTURA/configuracoes
    mkdir -p 04-INFRAESTRUTURA/backups
    mkdir -p 05-RESEARCH/{tecnologias,concorrentes,mercado}
    mkdir -p 06-FINANCEIRO/{precificacao,orcamentos,contratos}
    mkdir -p 99-ARQUIVO/versoes_antigas
    
    echo "Estrutura criada com sucesso!"
    
    # Listar estrutura
    find . -type d | sort
EOF

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Estrutura MYROBOT criada na ARCA!${NC}"
    echo ""
    echo "📁 Próximo passo: Sincronizar arquivos locais para ARCA"
    echo "Comando: rsync -avz $LOCAL_BACKUP/ $ARCA_USER@$ARCA_IP:$ARCA_BASE/00-DOCUMENTACAO_GERAL/"
else
    echo -e "${RED}❌ Erro ao criar estrutura${NC}"
    exit 1
fi
