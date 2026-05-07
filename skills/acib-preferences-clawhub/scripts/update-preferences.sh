#!/bin/bash
# update-preferences.sh - Script para atualizar preferências de Acib
# Uso: ./update-preferences.sh --categoria [tipo] --conteudo "preferência"

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
REFERENCES_DIR="$SCRIPT_DIR/../references"
DATASVR="192.168.0.72"
DATASVR_PASS="Rcmp@814k$1982"

# Cores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Função de ajuda
show_help() {
    echo "Uso: $0 [OPÇÕES]"
    echo ""
    echo "Opções:"
    echo "  --categoria [tipo]     Categoria da preferência (perfil, tecnicas, workflows, decisoes, projetos, comunicacao, automacoes)"
    echo "  --conteudo \"texto\"   Conteúdo da preferência a registrar"
    echo "  --listar [categoria]   Listar preferências de uma categoria"
    echo "  --buscar \"termo\"     Buscar preferência específica"
    echo "  --backup               Fazer backup na ARCA"
    echo "  --help                 Mostrar esta ajuda"
    echo ""
    echo "Exemplos:"
    echo "  $0 --categoria tecnicas --conteudo \"Prefere usar PostgreSQL para projetos grandes\""
    echo "  $0 --listar workflows"
    echo "  $0 --buscar \"backup\""
}

# Verificar dependências
if ! command -v sshpass &> /dev/null; then
    echo -e "${YELLOW}⚠️  sshpass não instalado. Instalando...${NC}"
    apt-get update && apt-get install -y sshpass
fi

# Parse argumentos
CATEGORIA=""
CONTEUDO=""
ACAO=""

while [[ $# -gt 0 ]]; do
    case $1 in
        --categoria)
            CATEGORIA="$2"
            shift 2
            ;;
        --conteudo)
            CONTEUDO="$2"
            shift 2
            ;;
        --listar)
            ACAO="listar"
            CATEGORIA="$2"
            shift 2
            ;;
        --buscar)
            ACAO="buscar"
            CONTEUDO="$2"
            shift 2
            ;;
        --backup)
            ACAO="backup"
            shift
            ;;
        --help)
            show_help
            exit 0
            ;;
        *)
            echo -e "${RED}❌ Opção desconhecida: $1${NC}"
            show_help
            exit 1
            ;;
    esac
done

# Categorias válidas
CATEGORIAS_VALIDAS=("perfil" "tecnicas" "workflows" "decisoes" "projetos" "comunicacao" "automacoes")

# Validar categoria
validar_categoria() {
    local cat="$1"
    for valida in "${CATEGORIAS_VALIDAS[@]}"; do
        if [[ "$cat" == "$valida" ]]; then
            return 0
        fi
    done
    echo -e "${RED}❌ Categoria inválida: $cat${NC}"
    echo "Categorias válidas: ${CATEGORIAS_VALIDAS[*]}"
    return 1
}

# Função: Adicionar preferência
adicionar_preferencia() {
    if [[ -z "$CATEGORIA" || -z "$CONTEUDO" ]]; then
        echo -e "${RED}❌ Categoria e conteúdo são obrigatórios${NC}"
        exit 1
    fi

    validar_categoria "$CATEGORIA" || exit 1

    local arquivo="$REFERENCES_DIR/$CATEGORIA.md"
    local data=$(date "+%d/%m/%Y")
    local hora=$(date "+%H:%M:%S")

    # Criar arquivo se não existir
    if [[ ! -f "$arquivo" ]]; then
        echo "# ${CATEGORIA^^} - Preferências Acib ABBADE" > "$arquivo"
        echo "" >> "$arquivo"
        echo "**Criado em:** $data" >> "$arquivo"
        echo "" >> "$arquivo"
        echo "---" >> "$arquivo"
        echo "" >> "$arquivo"
    fi

    # Adicionar entrada
    echo "" >> "$arquivo"
    echo "## [$data $hora]" >> "$arquivo"
    echo "" >> "$arquivo"
    echo "**Preferência:** $CONTEUDO" >> "$arquivo"
    echo "" >> "$arquivo"
    echo "**Contexto:** $(pwd)" >> "$arquivo"
    echo "" >> "$arquivo"
    echo "---" >> "$arquivo"

    echo -e "${GREEN}✅ Preferência adicionada em: $arquivo${NC}"
    
    # Fazer backup na ARCA
    fazer_backup_arca
}

# Função: Listar preferências
listar_preferencias() {
    if [[ -z "$CATEGORIA" ]]; then
        echo -e "${YELLOW}📋 Categorias disponíveis:${NC}"
        for cat in "${CATEGORIAS_VALIDAS[@]}"; do
            local arquivo="$REFERENCES_DIR/$cat.md"
            if [[ -f "$arquivo" ]]; then
                local linhas=$(wc -l < "$arquivo")
                echo "  ✅ $cat (${linhas} linhas)"
            else
                echo "  ⚪ $cat (vazio)"
            fi
        done
        return 0
    fi

    validar_categoria "$CATEGORIA" || exit 1

    local arquivo="$REFERENCES_DIR/$CATEGORIA.md"
    if [[ -f "$arquivo" ]]; then
        echo -e "${GREEN}📄 Conteúdo de $CATEGORIA.md:${NC}"
        echo ""
        cat "$arquivo"
    else
        echo -e "${YELLOW}⚠️  Arquivo $CATEGORIA.md não existe ainda${NC}"
    fi
}

# Função: Buscar preferência
buscar_preferencia() {
    if [[ -z "$CONTEUDO" ]]; then
        echo -e "${RED}❌ Termo de busca é obrigatório${NC}"
        exit 1
    fi

    echo -e "${YELLOW}🔍 Buscando por: '$CONTEUDO'${NC}"
    echo ""

    local encontrou=false
    for cat in "${CATEGORIAS_VALIDAS[@]}"; do
        local arquivo="$REFERENCES_DIR/$cat.md"
        if [[ -f "$arquivo" ]]; then
            local resultado=$(grep -n -i "$CONTEUDO" "$arquivo" 2>/dev/null)
            if [[ ! -z "$resultado" ]]; then
                echo -e "${GREEN}📁 Encontrado em $cat.md:${NC}"
                echo "$resultado" | head -10
                echo ""
                encontrou=true
            fi
        fi
    done

    if [[ "$encontrou" == false ]]; then
        echo -e "${YELLOW}⚠️  Nenhum resultado encontrado${NC}"
    fi
}

# Função: Backup na ARCA
fazer_backup_arca() {
    echo -e "${YELLOW}📤 Fazendo backup na ARCA...${NC}"
    
    # Verificar conexão
    if ! ping -c 1 -W 2 "$DATASVR" &> /dev/null; then
        echo -e "${RED}❌ DATASVR ($DATASVR) inacessível${NC}"
        return 1
    fi

    # Criar diretório na ARCA
    sshpass -p "$DATASVR_PASS" ssh -o StrictHostKeyChecking=no root@$DATASVR "mkdir -p /home/master/LAN/Acib/skills/acib-preferences/references" 2>/dev/null

    # Copiar arquivos
    for arquivo in "$REFERENCES_DIR"/*.md; do
        if [[ -f "$arquivo" ]]; then
            local nome=$(basename "$arquivo")
            sshpass -p "$DATASVR_PASS" scp -o StrictHostKeyChecking=no "$arquivo" root@$DATASVR:/home/master/LAN/Acib/skills/acib-preferences/references/ 2>/dev/null
            if [[ $? -eq 0 ]]; then
                echo -e "  ✅ $nome"
            else
                echo -e "  ❌ $nome (falha)"
            fi
        fi
    done

    echo -e "${GREEN}✅ Backup na ARCA concluído${NC}"
}

# Main
main() {
    case "$ACAO" in
        listar)
            listar_preferencias
            ;;
        buscar)
            buscar_preferencia
            ;;
        backup)
            fazer_backup_arca
            ;;
        *)
            if [[ ! -z "$CATEGORIA" || ! -z "$CONTEUDO" ]]; then
                adicionar_preferencia
            else
                show_help
            fi
            ;;
    esac
}

main
