# 📊 VARREDURA COMPLETA DE MEMÓRIAS - 30/04/2026 09:15

**Realizada por:** Stark  
**Data:** Quinta-feira, 30 de Abril de 2026 - 09:15  
**Total de arquivos:** 162 arquivos .md em /root/.openclaw/workspace/memory/

---

## 🔴 PRIORIDADE MÁXIMA ATUAL

### 1️⃣ PROJETO MYROBOT (Bioimpedância)
- **Status:** Aguardando briefing completo de Acib
- **Local:** `~/workspace/PROJETOS/MYROBOT/`
- **ARCA:** `\\192.168.0.72\LAN\Acib\PROJETOS\MYROBOT\`
- **Documentação:** `PROJECT-MYROBOT-PRIORIDADE-MAXIMA.md`
- **Origem:** Bioimpedância pessoal de Acib (imagem)

### 2️⃣ FACULDADE UNOPAR - Portfólios (Entrega: 02/05/2026)
- **Projeto:** Amigos de 4 Patas - Extensão II (10.000 pts)
- **Status:** ✅ Relatório completo pronto
- **Falta:** Depoimento assinado do grupo WhatsApp
- **Prazo:** 3 DIAS (02/05 - sábado)
- **Site:** https://amigos4patas.com.br (online)

---

## 🎓 FORMAÇÃO ACADÊMICA - UNOPAR

**Curso:** Análise e Desenvolvimento de Sistemas  
**Semestre:** 5º Semestre  
**Previsão Formatura:** 2026  
**Portal:** meunovoportal.unopar.com.br  
**Login:** 30757385864

### 6 Matérias do 5º Semestre:

| # | Disciplina | Professor | Status | Próxima Avaliação |
|---|------------|-----------|--------|-------------------|
| 1 | Extensão II | Dorival Magro Jr | 🟢 Relatório pronto | **02/05/2026** |
| 2 | Programação Web I | [verificar] | 🟡 Em andamento | [verificar] |
| 3 | Banco de Dados | [verificar] | 🟡 Em andamento | [verificar] |
| 4 | Engenharia de Software | [verificar] | 🟡 Em andamento | [verificar] |
| 5 | Ética e Legislação | [verificar] | 🟡 Em andamento | [verificar] |
| 6 | Redes de Computadores | [verificar] | 🟡 Em andamento | [verificar] |

**⚠️ AÇÃO NECESSÁRIA:** Acessar portal para verificar provas das 5 matérias restantes

---

## 💼 TRABALHO - CLIENTES E SERVIÇOS

### Cliente Principal: SERVMIL
**Contatos:** Saulo, Anderson, Murilo  
**CNPJ:** 04.XXX.XXX/0001-XX  
**Serviços Recentes:**
- Verificação câmeras CFTV (29/04 - pendente)
- Instalação câmera almoxarifado (pendente)
- Sistema FTP para impressões de saneamento (pendente)
- Orçamento roteador R$ 2.750,00 (pendente)

### Outros Clientes Ativos:
- **Sr. Luiz:** Orçamento impressora (29/04 - pendente)
- **Edmilson:** Garantia Moto E22 - tela com mancha (29/04)
- **Mozart:** Troca telas Poco C75, A50
- **Willian:** Troca tela Moto E20
- **Sr João:** Troca telas G15, G05, E15
- **Marcel:** Cabo de energia (pendente)
- **Pamela:** 2 monitores 17"+ (pendente)
- **Adalberto Zinho:** Tela iPhone 11 (29/04)
- **Mariane:** Entregar celular (pendente)
- **Simone:** Comprar peças impressora (pendente)

### Fornecedores:
- **ATUAL PEÇAS:** Silvana Barbosa, Rogerio Espedito
- **ALL PRO IMPORTS**

---

## 🏗️ INFRAESTRUTURA - PROXMOX PVE1

**Host:** pve1 (192.168.0.192)  
**CPU:** AMD Ryzen 5 5600X  
**RAM:** 30GB total  
**Containers:** 13 LXC (CT 100-112)

### Containers Ativos:

| CT | Nome | IP | Porta | Função |
|----|------|-----|-------|--------|
| 100 | Stark | 192.168.0.21 | 18789 | Orquestrador |
| 101 | STARK | 192.168.0.240 | 18789 | MailBot |
| 102 | DATASVR | 192.168.0.72 | 18789 | Armazenamento/Samba |
| 103 | BD | 192.168.0.109 | 18789 | PostgreSQL |
| 104 | SGN | 192.168.0.99 | 18789 | Sistema Web |
| 105 | MAILS | 192.168.0.224 | 18789 | Processamento Emails |
| 106 | Vorcaro | DHCP | 18789 | Financeiro |
| 107 | SAMU | 192.168.0.64 | 18789 | Socorro/Emergência |
| 108 | Scraper | DHCP | 18789 | Coleta de dados |
| 109 | ADM-SERVMIL | DHCP | 18789 | Administração SERVMIL |
| 110 | bd-servmil | DHCP | 18789 | Banco SERVMIL |
| 111 | Fe-Servmil | DHCP | 18789 | Frontend SERVMIL |
| 112 | Analista-Servmil | DHCP | 18789 | Análise de dados SERVMIL |

**Thin Pool:** ~38.5% usado (normal)  
**SSH:** Senha padrão `Rcmp814k@#` (exceto DATASVR: `Rcmp@814k$1982`)

---

## 🗄️ BANCO DE DADOS SGN

**Host:** 192.168.0.109:5432  
**Banco:** sgn  
**Usuário:** acib  
**Schemas:** estoque, clientes, os, financeiro, fornecedores, garantia, agenda

**Empresa Proprietária:**
- CNPJ: 65.384.056/0001-32
- Nome: ACIB ABBADE DE CASTRO

---

## 🌐 SISTEMA SGN WEB

**Servidor:** 192.168.0.99  
**URLs:**
- Principal: http://192.168.0.99
- Admin BD: http://192.168.0.99/admin_bd.php
- Dashboard: http://192.168.0.99/

---

## 🐾 PROJETO AMIGOS DE 4 PATAS

**Status:** ✅ ONLINE  
**URL:** https://amigos4patas.com.br  
**Hospedagem:** Proxmox CT 107 (própria infra)  
**Domínio:** Cloudflare Tunnel configurado

**Páginas:**
- Início (index.html)
- Perdidos (perdidos.html)
- Avistados (avistados.html)
- Adoção (adocao.html)
- Castração (castracao.html) - ✅ NOVA (30/04)
- Sobre (sobre.html)

**Funcionalidades:**
- Newsletter funcionando
- Compartilhamento redes sociais
- Design responsivo
- Analytics configurado
- QR Code para WhatsApp

**Pendências Faculdade:**
- [ ] Enviar texto no grupo WhatsApp pedindo depoimento
- [ ] Receber depoimento assinado
- [ ] Entregar até 02/05/2026

---

## 💰 FINANÇAS - MEI

**Limites Fiscais 2026:**
- **MEI (Anual):** R$ 81.000,00
- **IRPF (Isento):** Até R$ 2.824,00/mês

**Contas Nubank Monitoradas:**
- PJ65 (Conta Principal)
- PJ20 (Conta Secundária)
- PF (Pessoa Física)

**Monitoramento:** Automático via extratos CSV  
**Alertas:** 70%, 85%, 95%, 100% dos limites

---

## 📁 ARQUIVOS DE MEMÓRIA PRINCIPAIS

### Perfil e Formação:
- `MEMORY.md` - Memória permanente (longo prazo)
- `FACULDADE-FORMACAO-COMPLETA.md` - Formação acadêmica completa ⭐
- `CURRICULO-ACIB-COMPLETO.md` - Currículo profissional
- `PITCH-ACIB.md` - Pitch profissional
- `GITHUB-PROFILE.md` - Perfil GitHub

### Projetos:
- `memory/4pets/README.md` - Projeto Amigos de 4 Patas
- `memory/4pets/projeto/PROJETO-EXTENSAO-AMIGOS-4-PATAS.md` - Relatório faculdade
- `memory/2026-04-28-NOVO-PROJETO-MYROBOT.md` - Projeto MYROBOT

### Compromissos:
- `memory/2026-04-29-compromissos-entrada.md` - Serviços de entrada
- `memory/2026-04-29-TRAJETO-SAIDA.md` - Trajeto de saída
- `memory/TAREFAS-MASTER-26-04-2026.md` - Lista master de tarefas

### Infraestrutura:
- `HEARTBEAT.md` - Status containers e monitoramento
- `TOOLS.md` - Configurações técnicas locais
- `ACCESSO_PVE.md` - Credenciais Proxmox

### Financeiro:
- `memory/DEBITOS-NEGOCIACOES-EM-ABERTO.md` - Negociações pendentes
- `memory/CRONOGRAMA-FACULDADE-5SEM-2026-04-24.md` - Cronograma acadêmico

---

## 📋 COMPROMISSOS PENDENTES (Resumo)

### Urgentes (Hoje/Amanhã):
1. ⏳ Orçamento impressora - Sr. Luiz
2. ⏳ Verificação câmeras CFTV - Murilo (SERVMIL)
3. ⏳ Garantia Moto E22 - Edmilson (aguardando aparelho)
4. ⏳ Site banda - Adalberto
5. ⏳ Ligar computador OS
6. ⏳ Entregar celular - Mariane
7. ⏳ Comprar peças impressora - Simone

### Faculdade (Prazo: 02/05):
- [ ] Enviar texto WhatsApp pedindo depoimento
- [ ] Receber depoimento assinado
- [ ] Consolidar entrega Extensão II

### MYROBOT:
- [ ] Aguardar briefing completo de Acib
- [ ] Definir escopo e cronograma

---

## 🔐 CREDENCIAIS IMPORTANTES

**Proxmox PVE1:**
- Host: 192.168.0.192
- Usuário: root
- Senha: `Rcmp814k@#`
- Web: https://192.168.0.192:8006

**DATASVR (CT 102):**
- IP: 192.168.0.72
- Samba: `\\192.168.0.72\LAN\`
- Senha: `Rcmp@814k$1982`

**UNOPAR:**
- Portal: meunovoportal.unopar.com.br
- Login: 30757385864
- Senha: Arquivo separado `CREDENCIAIS-UNOPAR.md`

---

## 📊 ESTATÍSTICAS DA VARREDURA

- **Total arquivos memory/:** 162 arquivos .md
- **Período coberto:** Março 2026 - Abril 2026
- **Projetos ativos:** 3 principais (MYROBOT, 4Pets, SGN)
- **Containers monitorados:** 13
- **Clientes cadastrados:** 15+
- **Compromissos pendentes:** 7+ urgentes

---

## ✅ AÇÕES RECOMENDADAS IMEDIATAS

1. **Faculdade UNOPAR** - Acessar portal e verificar provas das 5 matérias
2. **MYROBOT** - Aguardar briefing de Acib para iniciar
3. **Amigos 4 Patas** - Enviar texto no grupo WhatsApp pedindo depoimento
4. **SERVMIL** - Verificar câmeras CFTV (compromisso 29/04)
5. **Clientes** - Executar 7 compromissos pendentes de entrada

---

**Varredura concluída em:** 30/04/2026 09:15  
**Próxima verificação automática:** Heartbeat (4 horas)  
**Status:** ✅ Todas as memórias sincronizadas e atualizadas

*Documento gerado automaticamente por Stark - Assistente de Acib ABBADE*
