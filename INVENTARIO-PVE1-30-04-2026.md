# 📊 INVENTÁRIO COMPLETO PVE1 - 30/04/2026 13:45

**Data:** 30/04/2026 13:45  
**Host:** PVE1 (192.168.0.192)  
**Total Containers:** 14 (CT 100-113)

---

## 📋 TABELA GERAL:

| CT | Nome | Hostname | Status | RAM | CPU | IP | Função |
|----|------|----------|--------|-----|-----|-----|--------|
| 100 | Stark | Stark | ✅ RUNNING | 6GB | 4 | DHCP | OpenClaw (Orquestrador) |
| 101 | STARK2 | STARK | ⏳ STOPPED | 6GB | 2 | DHCP | Stark Backup (OpenClaw secundário) |
| 102 | DATASVR | DATASVR | ✅ RUNNING | 4.8GB | 2 | DHCP | Samba/Backup/Storage |
| 103 | Marcos | Marcos | ⏳ STOPPED | 3GB | 2 | DHCP | BD (PostgreSQL) |
| 104 | SGN | SGN | ✅ RUNNING | 2.3GB | 2 | DHCP | Sistema Web SGN |
| 105 | MAILS | MAILS | ⏳ STOPPED | 4GB | 2 | DHCP | Processamento Emails |
| 106 | gerente-fin | gerente-fin | ✅ RUNNING | 2GB | 2 | 192.168.0.231 | Financeiro |
| 107 | 4pets | 4pets | ✅ RUNNING | 4GB | 2 | 192.168.0.200 | Site Amigos 4 Patas |
| 108 | myrobot | myrobot | ⏳ STOPPED | 2.2GB | 2 | DHCP | Projeto Bioimpedância |
| 109 | ADM-SERVMIL | ADM-SERVMIL | ⏳ STOPPED | 3GB | 2 | DHCP | Admin SERVMIL |
| 110 | bd-servmil | bd-servmil | ⏳ STOPPED | 4GB | 2 | DHCP | Banco SERVMIL |
| 111 | Fe-Servmil | Fe-Servmil | ⏳ STOPPED | 2.7GB | 2 | DHCP | Frontend SERVMIL |
| 112 | Analista-Servmil | Analista-Servmil | ⏳ STOPPED | 3.3GB | 2 | DHCP | Análise SERVMIL |
| 113 | Hermes1 | Hermes1 | ⏳ STOPPED | 4GB | 3 | DHCP | Hermes/Telegram |

---

## 📊 RESUMO DE STATUS:

| Status | Quantidade | RAM Total |
|--------|------------|-----------|
| **RUNNING** | 5 containers | 18.3 GB |
| **STOPPED** | 9 containers | 28.5 GB |
| **TOTAL** | 14 containers | 46.8 GB |

---

## 🎯 CONTAINERS RUNNING (5):

### CT 100 - Stark (OpenClaw)
- **RAM:** 6GB
- **CPU:** 4 cores
- **IP:** DHCP
- **Função:** Orquestrador principal, IA, automação

### CT 102 - DATASVR
- **RAM:** 4.8GB
- **CPU:** 2 cores
- **IP:** DHCP
- **Função:** Samba, backup, storage central

### CT 104 - SGN
- **RAM:** 2.3GB
- **CPU:** 2 cores
- **IP:** DHCP
- **Função:** Sistema web SGN (estoque, clientes, OS)

### CT 106 - gerente-fin
- **RAM:** 2GB
- **CPU:** 2 cores
- **IP:** 192.168.0.231 (estático)
- **Função:** Financeiro

### CT 107 - 4pets
- **RAM:** 4GB
- **CPU:** 2 cores
- **IP:** 192.168.0.200 (estático)
- **Função:** Site Amigos 4 Patas (nginx)

---

## 📦 CONTAINERS STOPPED (9):

### Projetos em Desenvolvimento:
- **CT 101** - STARK (MailBot backup)
- **CT 103** - Marcos (BD PostgreSQL)
- **CT 105** - MAILS (Processamento emails)
- **CT 108** - myrobot (Bioimpedância)

### Projeto SERVMIL (6 containers):
- **CT 109** - ADM-SERVMIL (Administração)
- **CT 110** - bd-servmil (Banco de dados)
- **CT 111** - Fe-Servmil (Frontend)
- **CT 112** - Analista-Servmil (Análise dados)
- **CT 113** - Hermes1 (Telegram bot)

---

## 🔧 REDE:

**Bridge:** vmbr0  
**Gateway:** 192.168.0.1  
**Subnet:** 192.168.0.0/24

**IPs Estáticos:**
- 192.168.0.231 - CT 106 (gerente-fin)
- 192.168.0.200 - CT 107 (4pets)

**DHCP:** Demais containers

---

## 💾 STORAGE:

**Host:** PVE1  
**Thin Pool:** ~38.5% usado (normal)

---

## 📝 REGRAS GRAVADAS:

### 1. **Regra de Documentação** (NOVA - 30/04/2026):
> "Para toda atualização de documentação, voce deve primeiro revisar a documentação ja existente, ler, absorver e entende-la, e so depois atualiza-la"

### 2. **Regra de Economia de Tokens** (NOVA - 30/04/2026):
> "Grave as informações que voce obter, tudo o que for possivel a fim de economizar tokens"

### 3. **Regra de Red Lines** (EXISTENTE):
> Nunca fazer ações destrutivas sem autorização explícita do Acib

### 4. **Regra de Heartbeat** (EXISTENTE):
> Atualizar memórias compartilhadas a cada 4 horas
> Notificar APENAS falhas críticas

### 5. **Regra de Independência dos Agentes** (EXISTENTE):
> Cada agente mantém autonomia em sua especialidade
> Decisões técnicas são tomadas localmente sem consulta

---

## 📊 ARQUIVOS DE DOCUMENTAÇÃO:

| Arquivo | Caminho | Finalidade |
|---------|---------|------------|
| **HEARTBEAT.md** | `/root/.openclaw/workspace/HEARTBEAT.md` | Status containers, IPs, check de saúde |
| **CONTAINER-4PETS.md** | `/root/.openclaw/workspace/CONTAINER-4PETS.md` | Documentação completa do 4pets |
| **INVENTARIO-PVE1-30-04-2026.md** | `/root/.openclaw/workspace/INVENTARIO-PVE1-30-04-2026.md` | Este arquivo - inventário completo |
| **DEPLOY-30-04-2026.md** | `/var/www/amigos4patas/` | Log do deploy no 4pets |

---

## 🚀 PRÓXIMAS AÇÕES:

- [ ] Iniciar containers SERVMIL (109-113)
- [ ] Testar site 4pets após deploy
- [ ] Backup automático diário dos containers
- [ ] Monitoramento de saúde (CPU, RAM, disco)

---

**Última atualização:** 30/04/2026 13:45  
**Próxima revisão:** 07/05/2026
