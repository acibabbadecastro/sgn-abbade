# 🏗️ ARQUITETURA DO SISTEMA ABBADE

**Atualizado:** 2026-04-10 09:46  
**Status:** Vorcaro (CT 104) descontinuado

---

## 🤖 EQUIPE DE AGENTES ATUAL

| CT | Nome | IP | Especialidade | Status |
|----|------|-----|---------------|--------|
| **100** | Stark | 192.168.0.21 | 🧠 Orquestrador/Geral | ✅ ONLINE |
| **101** | MailBot | 192.168.0.240 | 📧 Emails/Comunicação | ⏳ A verificar |
| **102** | DATASVR | 192.168.0.72 | 💾 Armazenamento/Backup | ✅ ONLINE |
| **103** | Supervisor | 192.168.0.42 | 👁️ Monitoramento 24/7 | ⏳ A verificar |
| **105** | OfficeBoy | 192.168.0.117 | 📋 Tarefas Administrativas | ⏳ A verificar |
| **106** | Seguranca | 192.168.0.231 | 🛡️ Segurança de Rede | ⏳ A verificar |
| **107** | SAMU | 192.168.0.64 | 🚑 Socorro/Emergências | ⏳ A verificar |

---

## 🗑️ AGENTES DESCONTINUADOS

| CT | Nome | Motivo | Data |
|----|------|--------|------|
| **104** | Vorcaro | Não necessário mais | 2026-04-10 |

---

## 📊 NOVA ARQUITETURA

### Stark (CT 100) - Orquestrador
```
• Interface com Acib (humano)
• Coordenação de alto nível
• Memória e documentação
• Projetos especiais
• OpenClaw Gateway
```

### MailBot (CT 101) - Comunicação
```
• Gestão de emails (2 contas Gmail)
• Extração de dados de emails
• Comunicação externa
• Notificações Telegram
```

### DATASVR (CT 102) - Armazenamento
```
• Samba: \\192.168.0.72\LAN\
• Backup de memórias
• Compartilhamento de arquivos
• 500GB disponível
```

### Supervisor (CT 103) - Monitoramento
```
• Monitora todos os agentes 24/7
• Cron a cada 10 minutos
• Detecta falhas automaticamente
• Notifica Stark quando algo cai
```

### OfficeBoy (CT 105) - Administrativo
```
• Tarefas rotineiras
• Automação de processos
• Suporte geral
```

### Seguranca (CT 106) - Segurança
```
• Verificação de portas
• Segurança de rede
• Conformidade
```

### SAMU (CT 107) - Emergências
```
• Resposta a falhas críticas
• Recuperação de desastres
• Socorro do Stark
```

---

## 📁 ESTRUTURA DE DOCUMENTAÇÃO

**Local:** `/root/.openclaw/workspace/ARCA/Sistema_Abbade/`

| Pasta | Conteúdo |
|-------|----------|
| **00_Geral/** | Arquitetura, preferências, visão geral |
| **01_Banco_Dados/** | Schema PostgreSQL, tabelas, configs |
| **02_Web/** | SGN, site, loja virtual, domínios |
| **03_Infraestrutura/** | Containers, Proxmox, rede, IPs |
| **04_Modulos/** | Módulos do SGN (OS, financeiro, estoque) |
| **05_Documentacao/** | Manuais, procedimentos, fluxos |
| **06_Backups/** | Rotinas de backup, recovery |
| **07_Logs/** | Logs de operações, incidentes |
| **08_Projetos/** | Projetos ativos (IA, Site, etc) |
| **09_Manuales/** | Tutoriais, how-tos |
| **10_Valores_Telas/** | Preços de peças, distribuidores |

---

## 💾 ARMAZENAMENTO

**DATASVR (CT 102 - 192.168.0.72):**
```
/mnt/data/LAN/
├── Acib/
├── BACKUP_CRITICO/
├── Configs_Agentes/
├── Documentacao/
├── Emails/
├── Inventario/
├── LOGS/
├── MEMORIES/
├── Relatorios/
├── Stark_Output/
└── pve1/
```

---

## 🗄️ BANCO DE DADOS

**PostgreSQL (CT 103 - 192.168.0.109:5432):**
| Campo | Valor |
|-------|-------|
| Host | 192.168.0.109 |
| Porta | 5432 |
| Banco | sgn / financas |
| Usuário | acib |
| Senha | Rcmp814k@# |

**Schemas:**
- financeiro (contas, movimentações, categorias)
- clientes (clientes, fornecedores)
- os (ordens de serviço)
- estoque (produtos, fornecedores)
- fornecedores (produtos por fornecedor)
- garantia (controle de garantias)
- agenda (compromissos)

---

## 🔄 FLUXO DE MONITORAMENTO

```
Supervisor (CT 103) → Verifica a cada 10 min → Detecta falha → 
Log → Notifica Stark → Stark analisa → Se ação destrutiva → 
Pede autorização Acib → Se rotineiro → Repara automaticamente
```

---

## 📡 COMUNICAÇÃO COM ACIB

| Canal | Uso | Status |
|-------|-----|--------|
| **Telegram** | @acibclawd_bot | ✅ Funcionando |
| **Terminal** | Chat direto OpenClaw | ✅ Funcionando |
| **Heartbeat** | Lembretes automáticos | ✅ Configurado |

---

## 📝 HISTÓRICO DE MUDANÇAS

| Data | Mudança | Responsável |
|------|---------|-------------|
| 2026-04-10 09:46 | Vorcaro (CT 104) descontinuado | Acib |
| 2026-04-10 07:38 | SSD swap concluído (novo SSD mais confiável) | Acib |
| 2026-04-08 | Recriação de OfficeBoy, Seguranca, SAMU | Stark |

---

**Documento oficial da arquitetura do Sistema Abbade.**
