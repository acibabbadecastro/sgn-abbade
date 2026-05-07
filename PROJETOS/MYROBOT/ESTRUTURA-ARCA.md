# 📂 ESTRUTURA DE PASTAS MYROBOT - NA ARCA

**Quando executar:** Quando DATASVR (192.168.0.72) estiver online  
**Script:** `setup-arca-myrobot.sh`  
**Local na ARCA:** `\\192.168.0.72\LAN\Acib\MYROBOT\`

---

## 🗂️ Estrutura Completa

```
MYROBOT/
├── 📁 00-DOCUMENTACAO_GERAL/
│   ├── PROJECT-MYROBOT-VISAO-GERAL.md
│   ├── PROJECT-MYROBOT-EVOLUCAO.md
│   ├── BRAND-MYROBOT.md
│   └── BUSINESS-PLAN.md
│
├── 📁 01-PRODUTOS_SERVICOS/
│   ├── 📁 BIOIMPEDANCIA/
│   │   ├── docs/
│   │   ├── src/
│   │   ├── hardware/
│   │   └── assets/
│   │
│   ├── 📁 ESTOQUE_GESTAO/
│   ├── 📁 ATENDIMENTO/
│   ├── 📁 ANALISE_DADOS/
│   └── 📁 AUTOMACAO/
│
├── 📁 02-CLIENTES/
│   ├── leads/
│   ├── ativos/
│   └── cases/
│
├── 📁 03-MARKETING_VENDAS/
│   ├── 📁 website/
│   │   ├── design/
│   │   ├── conteudo/
│   │   └── assets/
│   ├── materiais/
│   └── propostas/
│
├── 📁 04-INFRAESTRUTURA/
│   ├── 📁 containers/
│   │   ├── CT113-MYROBOT-WEB/
│   │   ├── CT114-MYROBOT-SEC/
│   │   └── CT115-MYROBOT-DATA/
│   ├── configuracoes/
│   └── backups/
│
├── 📁 05-RESEARCH/
│   ├── tecnologias/
│   ├── concorrentes/
│   └── mercado/
│
├── 📁 06-FINANCEIRO/
│   ├── precificacao/
│   ├── orcamentos/
│   └── contratos/
│
└── 📁 99-ARQUIVO/
    └── versoes_antigas/
```

---

## 📝 Descrição das Pastas

### 00-DOCUMENTACAO_GERAL
Documentação mestre do projeto, visão geral, planejamento estratégico

### 01-PRODUTOS_SERVICOS
Cada produto/serviço tem sua própria pasta com estrutura completa

### 02-CLIENTES
Gestão de clientes: leads, clientes ativos, cases de sucesso

### 03-MARKETING_VENDAS
Website, materiais de marketing, propostas comerciais

### 04-INFRAESTRUTURA
Configurações dos containers, backups, infraestrutura técnica

### 05-RESEARCH
Pesquisas: tecnologias, análise de concorrentes, estudo de mercado

### 06-FINANCEIRO
Precificação, orçamentos, contratos, documentação fiscal

### 99-ARQUIVO
Versões antigas, documentos obsoletos (histórico)

---

## 🚀 Como Criar

### Opção 1: Executar Script (Quando DATASVR online)
```bash
chmod +x setup-arca-myrobot.sh
./setup-arca-myrobot.sh
```

### Opção 2: Criar Manualmente
Acessar `\\192.168.0.72\LAN\Acib\` e criar pasta MYROBOT com subpastas

---

## 🔄 Sincronização

Após criar estrutura na ARCA, sincronizar arquivos locais:

```bash
rsync -avz ~/.openclaw/workspace/PROJETOS/MYROBOT/ \
  master@192.168.0.72:/home/master/LAN/Acib/MYROBOT/00-DOCUMENTACAO_GERAL/
```

---

*Estrutura definida em: 28/04/2026 10:51*  
*Status: ⏳ Aguardando DATASVR para criação*
