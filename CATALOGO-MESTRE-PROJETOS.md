# 🗂️ CATÁLOGO MESTRE DE PROJETOS
## Acib ABBADE - Inventário Completo de Sites e Sistemas

**Data atualização:** 29/04/2026  
**Responsável:** Stark  
**Localização:** /home/master/LAN/Acib/projetos/

---

## 📊 RESUMO EXECUTIVO

| Total Projetos | Sites Online | Sites em Desenvolvimento | Containers | Domínios Próprios |
|----------------|--------------|--------------------------|------------|-------------------|
| 2+ | 1 | 1+ | 2+ | 1 |

---

## 🌐 PROJETOS WEB

### 1. 🐾 AMIGOS DE 4 PATAS

| Campo | Detalhes |
|-------|----------|
| **Nome** | Amigos de 4 Patas - Parque Meia Lua |
| **Tipo** | Site institucional / Projeto social |
| **URL Pública** | https://amigos4patas.com.br |
| **Status** | ✅ **ONLINE E FUNCIONANDO** |
| **Propósito** | Projeto de Extensão II UNOPAR - Centralização de informações sobre bem-estar animal |
| **Público-alvo** | Moradores do bairro Parque Meia Lua, protetores de animais, potenciais adotantes |

**INFRAESTRUTURA:**
| Componente | Especificação |
|------------|---------------|
| **Container Proxmox** | CT 107 (4pets) |
| **IP Local** | 192.168.0.200 |
| **Sistema Operacional** | Ubuntu 25.04 LTS |
| **Servidor Web** | Nginx 1.26.3 |
| **Banco de Dados** | PostgreSQL 17.7 |
| **Backend** | PHP + API REST |
| **Frontend** | HTML5, CSS3, JavaScript |
| **SSL/HTTPS** | Certbot + Cloudflare Tunnel |
| **Domínio** | amigos4patas.com.br (registrado) |

**ESTRUTURA DE ARQUIVOS:**
```
Container CT 107 (/var/www/amigos4patas/):
├── 📄 index.html              # Página inicial
├── 📄 perdidos.html           # Animais perdidos
├── 📄 avistados.html          # Avistamentos
├── 📄 adocao.html             # Adoção
├── 📄 sobre.html              # Sobre o projeto
├── 📄 apoiadores.html         # Parceiros
├── 📄 admin.php               # Painel administrativo
├── 📄 notificacoes.html       # Alertas automáticos
├── 📄 relatorio-admin.php     # Dashboard (❌ QUEBRADO - 404)
├── 📁 backend/                # APIs PHP
│   ├── salvar-cadastro.php
│   ├── salvar-inscricao.php
│   └── get-notifications.php
└── 📁 assets/                 # CSS, JS, imagens
    ├── analytics.js
    ├── estatisticas.js
    ├── newsletter.js
    └── compartilhar.js
```

**LOCAL NA ARCA (DATASVR):**
```
\\192.168.0.72\LAN\Acib\projetos\4pets\
├── 📁 argumentacao/           # Argumentos para aceitação faculdade
├── 📁 comunicacao/            # Emails, mensagens
├── 📁 documentacao/           # Relatórios, textos
├── 📁 backup/                 # Cópia memory/4pets/
├── 📁 site/                   # (preparado para arquivos)
├── 📁 codigo-fonte/           # (preparado para código)
├── 📁 versoes/                # Histórico de versões
├── 📁 imagens/                # Assets
└── 📄 README.md               # Índice do projeto
```

**WORKSPACE LOCAL:**
- `/root/.openclaw/workspace/memory/4pets/`

**DOCUMENTAÇÃO:**
- Relatório Extensão II: ✅ Completo
- Argumentação aceitação: ✅ Atualizada (29/04)
- Texto "Sobre" novo: ✅ Criado (aguardando deploy)
- Ações de campo: ✅ Documentadas

**FUNCIONALIDADES:**
- ✅ Cadastro de animais perdidos
- ✅ Registro de avistamentos
- ✅ Adoção de animais
- ✅ Canal de resgate
- ✅ Denúncia de maus-tratos
- ✅ Newsletter
- ✅ Compartilhamento social
- ✅ QR Code para WhatsApp
- ✅ Analytics e dashboard

**PROBLEMAS CONHECIDOS:**
- ❌ Página `relatorio-admin.php` dá 404 (dashboard quebrado)
- ❌ Página "Sobre" precisa ser atualizada com texto de sensibilização
- ❌ Contadores mostram "0" (dados não atualizados)

**ODS TRABALHADAS:**
- ODS 11: Cidades e comunidades sustentáveis
- ODS 3: Saúde e bem-estar
- ODS 15: Vida terrestre

**CONTEXTO ACADÊMICO:**
- Disciplina: Projeto de Extensão II
- Curso: Análise e Desenvolvimento de Sistemas - UNOPAR
- Semestre: 5º
- Pontuação: 10.000 pts
- Prazo entrega: 02/05/2026
- Professor: Dorival Magro Junior

**ACESSO:**
- Público: https://amigos4patas.com.br
- Admin: https://amigos4patas.com.br/admin.php
- Local: http://192.168.0.200

**ATUALIZAÇÕES:**
- **26-27/04/2026:** Site criado e publicado
- **29/04/2026:** Argumentação reforçada com ações de campo

---

### 2. 🤖 MYROBOT (ou MYROBOT UM)

| Campo | Detalhes |
|-------|----------|
| **Nome** | MYROBOT / MYROBOT UM |
| **Tipo** | Site/E-commerce (em desenvolvimento) |
| **URL Pública** | http://192.168.0.112 (IP local) |
| **Status** | 🟡 **EM DESENVOLVIMENTO** |
| **Propósito** | Loja virtual (tema: Bioimpedância) |
| **Público-alvo** | A definir com Acib |

**INFRAESTRUTURA:**
| Componente | Especificação |
|------------|---------------|
| **Container Proxmox** | CT 108 (Scraper/MYROBOT) |
| **IP Local** | 192.168.0.112 |
| **Sistema Operacional** | Ubuntu |
| **Servidor Web** | Nginx |
| **Stack** | Python Flask + PostgreSQL |
| **Domínio** | ❌ Não registrado |

**ESTRUTURA DE ARQUIVOS:**
```
Container CT 108:
├── 📁 Site com placeholders
│   ├── Imagens placeholder
│   └── Estrutura de e-commerce
└── 📁 (em desenvolvimento)
```

**LOCAL NA ARCA:**
```
\\192.168.0.72\LAN\Acib\PROJETOS\MYROBOT\
├── 📁 Workspace local
└── 📁 Documentação
```

**WORKSPACE LOCAL:**
- `~/workspace/PROJETOS/MYROBOT/`

**DOCUMENTAÇÃO:**
- `PROJECT-MYROBOT-PRIORIDADE-MAXIMA.md`

**STATUS ATUAL:**
- 🟡 Aguardando briefing completo do Acib
- 🔴 Placeholders precisam ser substituídos por fotos reais
- 🔴 Escopo ainda não definido completamente

**PRIORIDADE:** 🔴 MÁXIMA (junto com portfólios UNOPAR)

**ACESSO:**
- Local: http://192.168.0.112
- Público: ❌ Não disponível (sem domínio)

**ATUALIZAÇÕES:**
- **28/04/2026:** Projeto iniciado, estrutura criada

---

### 3. 💼 DR_FINANCE (Dr. Finance)

| Campo | Detalhes |
|-------|----------|
| **Nome** | Dr. Finance / Dr_Finance |
| **Tipo** | Agente financeiro inteligente |
| **URL Pública** | ❌ Sistema interno (sem site público) |
| **Status** | 🟡 **EM DESENVOLVIMENTO** |
| **Propósito** | Automação financeira com IA |
| **GitHub** | https://github.com/acibabbadecastro/dr-finance |

**INFRAESTRUTURA:**
| Componente | Especificação |
|------------|---------------|
| **Container Proxmox** | CT 106 (Vorcaro/Financeiro) |
| **IP Local** | DHCP (atribuído dinamicamente) |
| **Stack** | Proxmox, OpenClaw, Ollama, Python, Flask |
| **Tecnologias** | Python, Flask, Mermaid |

**ESTRUTURA:**
```
Container CT 106:
├── Agente financeiro inteligente
├── Processamento de dados financeiros
└── Relatórios automáticos
```

**LOCAL NA ARCA:**
- `\\192.168.0.72\LAN\Acib\financeiro\` (parcial)

**WORKSPACE:**
- GitHub: acibabbadecastro/dr-finance
- Local: CT 106

**DOCUMENTAÇÃO:**
- GitHub README
- Prazo original: 20/04/2026 00:01 (entregue no prazo)

**STATUS ATUAL:**
- 🟡 Em desenvolvimento contínuo
- Funcionalidades básicas operacionais

---

### 4. 🏢 KIT HUB

| Campo | Detalhes |
|-------|----------|
| **Nome** | Kit Hub |
| **Tipo** | Documentação técnica / Repositório de conhecimento |
| **URL Pública** | ❌ Documentação interna |
| **Status** | ✅ **ATIVO** |
| **Propósito** | Documentação Proxmox completa |
| **GitHub** | https://github.com/acibabbadecastro/kit-hub |

**CONTEÚDO:**
- 11 arquivos de documentação Proxmox
- Scripts de automação
- Guias de configuração

**LOCAL:**
- GitHub: acibabbadecastro/kit-hub
- Possivelmente espelhado na ARCA

---

## 🗄️ INFRAESTRUTURA DE DADOS (ARCA)

### Servidor DATASVR (CT 102)

| Campo | Valor |
|-------|-------|
| **Nome** | ARCA / DATASVR |
| **Container** | CT 102 |
| **IP** | 192.168.0.72 |
| **Serviço** | Samba + Armazenamento |
| **Path** | `/home/master/LAN/` |
| **Acesso rede** | `\\192.168.0.72\LAN\` |
| **Senha** | Rcmp@814k$1982 |

**ESTRUTURA DE PASTAS:**
```
\\192.168.0.72\LAN\
├── 📁 Acib/                    # Pasta pessoal
│   ├── 📁 projetos/            # PROJETOS
│   │   ├── 📁 4pets/          # Amigos de 4 Patas
│   │   └── 📁 MYROBOT/        # MYROBOT
│   ├── 📁 Documentos/
│   ├── 📁 SGN/
│   ├── 📁 documentacao/
│   ├── 📁 faculdade/
│   └── 📁 financeiro/
├── 📁 MEMORIES/                # Memórias compartilhadas
├── 📁 Stark_Output/
├── 📁 Documentacao/
├── 📁 MD/
├── 📁 BACKUP_CRITICO/
└── [outras pastas...]
```

---

## 🖥️ CONTAINERS PROXMOX

| CT | Nome | IP | Função | Projetos |
|----|------|-----|--------|----------|
| 100 | Stark | 192.168.0.21 | Orquestrador principal | - |
| 101 | STARK (ex-Mails) | 192.168.0.240 | MailBot | - |
| 102 | **DATASVR** | **192.168.0.72** | **ARCA - Servidor de dados** | **Todos** |
| 103 | BD | 192.168.0.109 | PostgreSQL | SGN, outros |
| 104 | SGN | 192.168.0.99 | Sistema de Gestão | SGN Web |
| 105 | MAILS | 192.168.0.224 | Processamento emails | - |
| 106 | Vorcaro | DHCP | Financeiro | Dr_Finance |
| 107 | **4PETS** | **192.168.0.200** | **Site Amigos de 4 Patas** | **Amigos4Patas** |
| 108 | Scraper/MYROBOT | 192.168.0.112 | Desenvolvimento | **MYROBOT** |
| 109+ | [Outros CTs...] | DHCP | Vários | - |

---

## 🔄 FLUXO DE BACKUP E VERSÕES

### Protocolo de Backup na ARCA

**Regra:** Sempre que atualizar documentação → Copiar imediatamente para DATASVR

**Comando:**
```bash
sshpass -p 'Rcmp@814k$1982' scp -r [arquivos] root@192.168.0.72:/home/master/LAN/Acib/projetos/[projeto]/
```

### Estrutura de Versionamento

```
[projeto]/
├── 📁 versoes/
│   ├── v1.0-[data].md
│   ├── v1.1-[data].md
│   └── v2.0-[data].md
├── 📁 documentacao/
│   └── [arquivo-atual].md
└── 📄 README.md
```

---

## 📋 CHECKLIST DE MANUTENÇÃO

### Mensal:
- [ ] Verificar se sites estão online
- [ ] Atualizar contadores e estatísticas
- [ ] Revisar backups na ARCA
- [ ] Verificar renovação de domínios/certificados SSL

### A cada atualização:
- [ ] Salvar localmente
- [ ] Copiar para ARCA
- [ ] Confirmar cópia bem-sucedida
- [ ] Atualizar este catálogo se necessário

---

## 🚨 PENDÊNCIAS CRÍTICAS

| Prioridade | Projeto | Tarefa | Prazo |
|------------|---------|--------|-------|
| 🔴 Máxima | Amigos4Patas | Atualizar página "Sobre" com texto de sensibilização | 02/05/2026 |
| 🔴 Máxima | Amigos4Patas | Obter depoimento assinado do grupo | 02/05/2026 |
| 🔴 Máxima | Amigos4Patas | Corrigir página relatorio-admin.php (404) | 02/05/2026 |
| 🟡 Alta | MYROBOT | Definir escopo completo com Acib | A definir |
| 🟡 Alta | MYROBOT | Substituir placeholders por fotos reais | A definir |
| 🟢 Média | Dr_Finance | Continuar desenvolvimento de features | Contínuo |

---

## 📞 CONTATOS E ACESSOS

| Recurso | Informação |
|---------|------------|
| **GitHub** | https://github.com/acibabbadecastro |
| **Proxmox** | https://192.168.0.192:8006 |
| **ARCA (DATASVR)** | `\\192.168.0.72\LAN\` |
| **Email Acib** | abbade@outlook.com |

---

## 📝 HISTÓRICO DE ATUALIZAÇÕES DESTE CATÁLOGO

| Data | Versão | Alterações |
|------|--------|------------|
| 29/04/2026 | v1.0 | Criação do catálogo mestre |

---

*Catálogo mantido por: Stark 🤖*  
*Assistente de Acib ABBADE*  
*Última atualização: 29/04/2026 12:22*
