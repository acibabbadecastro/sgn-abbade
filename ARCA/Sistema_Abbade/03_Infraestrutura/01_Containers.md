# 📦 CONTAINERS - INFRAESTRUTURA

**Documento:** 01_Containers.md  
**Data:** 09/04/2026 13:36  
**Autor:** Stark (CT 100)  
**Versão:** 1.0  
**Status:** ✅ 8/8 ONLINE

---

## 📋 VISÃO GERAL

| Total | Online | Offline | % Online |
|-------|--------|---------|----------|
| **8** | **8** | **0** | **100%** |

**Última Verificação:** 09/04/2026 13:36  
**Host:** Proxmox pve1 (192.168.0.192)

---

## 🗂️ TABELA DE CONTAINERS

| CT | Nome | IP | Porta | Função | Status |
|----|------|-----|-------|--------|--------|
| **100** | Stark (Telegram) | 192.168.0.192 | 18789 | Interface humana, coordenação | ✅ ONLINE |
| **101** | STARK (TUI) | 192.168.0.240 | 18789 | Backup, terminal | ✅ ONLINE |
| **102** | DATASVR | 192.168.0.72 | 18789 | Armazenamento, Samba | ✅ ONLINE |
| **103** | Supervisor | 192.168.0.42 | 18789 | PostgreSQL (banco de dados) | ✅ ONLINE |
| **104** | Vorcaro | 192.168.0.172 | 18789 | Web Server (Sistema Abbade) | ✅ ONLINE |
| **105** | OfficeBoy | 192.168.0.117 | 18789 | Tarefas administrativas | ✅ ONLINE |
| **106** | SAMU | 192.168.0.64 | 18789 | Emergências, recuperação | ✅ ONLINE |
| **107** | Scraper | 192.168.0.?? | 18789 | Web scraping | ✅ ONLINE |

---

## 🔍 DETALHES POR CONTAINER

### **CT 100 - Stark (Telegram)**

| Campo | Informação |
|-------|------------|
| **Nome** | Stark (Telegram) |
| **IP** | 192.168.0.192 |
| **Porta OpenClaw** | 18789 |
| **Função** | Interface humana via Telegram, coordenação geral |
| **Bot** | @acibclawd_bot |
| **Chat ID Acib** | 1866226415 |
| **Workspace** | `/root/.openclaw/workspace/` |
| **Memórias** | `/root/.openclaw/workspace/memory/` |
| **Status** | ✅ ONLINE (esta sessão) |

**Serviços:**
- OpenClaw Gateway (18789)
- Telegram Bot (@acibclawd_bot)
- Gestão de compromissos
- Interface com Acib

**Acesso SSH:**
```bash
ssh root@192.168.0.192
# Senha: Rcmp814k@#
```

---

### **CT 101 - STARK (TUI)**

| Campo | Informação |
|-------|------------|
| **Nome** | STARK (TUI) |
| **IP** | 192.168.0.240 |
| **Porta OpenClaw** | 18789 |
| **Função** | Interface terminal (TUI), backup do Stark |
| **Backup** | `/mnt/data/ARCA/BOT_TUI/STARK/` |
| **Status** | ✅ ONLINE |

**Serviços:**
- OpenClaw Gateway (18789)
- Interface TUI (terminal)
- Backup de memórias

**Acesso SSH:**
```bash
ssh root@192.168.0.240
# Senha: Rcmp814k@#
```

---

### **CT 102 - DATASVR**

| Campo | Informação |
|-------|------------|
| **Nome** | DATASVR |
| **IP** | 192.168.0.72 |
| **Porta OpenClaw** | 18789 |
| **Função** | Armazenamento central, Samba, backups |
| **Storage** | 500GB (/mnt/data/) |
| **Samba** | `\\192.168.0.72\LAN\` |
| **Status** | ✅ ONLINE |

**Pastas Principais:**
```
/mnt/data/
├── LAN/                    # Compartilhado via Samba
│   ├── Acib/
│   ├── BACKUP_CRITICO/
│   ├── Configs_Agentes/
│   ├── Documentacao/
│   ├── Emails/
│   ├── LOGS/
│   ├── MEMORIES/           # Memórias compartilhadas
│   ├── Relatorios/
│   └── Stark_Output/
└── ARCA/
    ├── BACKUP_CRITICO/
    ├── CT101_STARK/
    ├── CT102_DATASVR/
    ├── CT108_Scraper/
    ├── PVE_Backups/
    └── Sistema_Abbade/     # NOVA (documentação)
```

**Acesso SSH:**
```bash
ssh root@192.168.0.72
# Senha: Rcmp@814k$1982
```

**Acesso Samba (Windows):**
```
\\192.168.0.72\LAN\
```

---

### **CT 103 - Supervisor**

| Campo | Informação |
|-------|------------|
| **Nome** | Supervisor |
| **IP** | 192.168.0.42 |
| **Porta OpenClaw** | 18789 |
| **Função** | PostgreSQL (banco de dados), monitoramento |
| **Banco** | PostgreSQL (192.168.0.109:5432) |
| **Monitoramento** | Script a cada 10 minutos |
| **Status** | ✅ ONLINE |

**Serviços:**
- PostgreSQL (192.168.0.109:5432)
- Script de monitoramento (`/root/supervisor/team_monitor.sh`)
- Log: `/root/supervisor/team.log`

**Acesso SSH:**
```bash
ssh root@192.168.0.42
# Senha: Rcmp814k@#
```

**Acesso PostgreSQL:**
```bash
psql -h 192.168.0.109 -p 5432 -U acib -d financas
# Senha: Rcmp814k@#
```

---

### **CT 104 - Vorcaro**

| Campo | Informação |
|-------|------------|
| **Nome** | Vorcaro |
| **IP** | 192.168.0.172 |
| **Porta OpenClaw** | 18789 |
| **Função** | Web Server (Sistema Abbade) |
| **Web** | http://192.168.0.99 |
| **Tecnologia** | Apache + PHP + PostgreSQL |
| **Status** | ✅ ONLINE |

**Serviços:**
- Apache (porta 80)
- PHP
- Sistema Abbade (3 páginas)

**Páginas:**
1. Home: http://192.168.0.99
2. Admin BD: http://192.168.0.99/admin_bd.php
3. Dashboard: http://192.168.0.99/dashboard.php

**Acesso SSH:**
```bash
ssh root@192.168.0.172
# Senha: Rcmp814k@#
```

---

### **CT 105 - OfficeBoy**

| Campo | Informação |
|-------|------------|
| **Nome** | OfficeBoy |
| **IP** | 192.168.0.117 |
| **Porta OpenClaw** | 18789 |
| **Função** | Tarefas administrativas, automação |
| **Status** | ✅ ONLINE (recriado 08/04/2026) |

**Serviços:**
- OpenClaw Gateway (18789)
- Automação de rotinas
- Tarefas administrativas

**Acesso SSH:**
```bash
ssh root@192.168.0.117
# Senha: Rcmp814k@#
```

---

### **CT 106 - SAMU**

| Campo | Informação |
|-------|------------|
| **Nome** | SAMU |
| **IP** | 192.168.0.64 |
| **Porta OpenClaw** | 18789 |
| **Função** | Emergências, recuperação de falhas |
| **Status** | ✅ ONLINE (recriado 08/04/2026) |

**Serviços:**
- OpenClaw Gateway (18789)
- Monitoramento de saúde
- Recuperação automática

**Acesso SSH:**
```bash
ssh root@192.168.0.64
# Senha: Rcmp814k@#
```

---

### **CT 107 - Scraper**

| Campo | Informação |
|-------|------------|
| **Nome** | Scraper |
| **IP** | 192.168.0.?? (dinâmico) |
| **Porta OpenClaw** | 18789 |
| **Função** | Web scraping, coleta de preços |
| **Status** | ✅ ONLINE (recriado 08/04/2026) |

**Serviços:**
- OpenClaw Gateway (18789)
- Scraper Bazar Mix
- Coleta de preços de mercado

**Acesso SSH:**
```bash
# IP dinâmico - verificar no Proxmox
ssh root@<IP>
# Senha: Rcmp814k@#
```

---

## 🔧 COMANDOS ÚTEIS

### **VERIFICAR STATUS DE TODOS:**

```bash
# No Proxmox (pve1)
for ct in 100 101 102 103 104 105 106 107; do
    echo "=== CT $ct ==="
    pct status $ct
done
```

### **INICIAR TODOS:**

```bash
for ct in 100 101 102 103 104 105 106 107; do
    pct start $ct
done
```

### **PARAR TODOS:**

```bash
for ct in 100 101 102 103 104 105 106 107; do
    pct stop $ct
done
```

### **REINICIAR TODOS:**

```bash
for ct in 100 101 102 103 104 105 106 107; do
    pct reboot $ct
done
```

---

## 📊 RECURSOS POR CONTAINER

| CT | RAM | CPU | Disco |
|----|-----|-----|-------|
| 100 | 4GB | 2 vCPU | 32GB |
| 101 | 4GB | 2 vCPU | 32GB |
| 102 | 4GB | 2 vCPU | 500GB |
| 103 | 4GB | 2 vCPU | 32GB |
| 104 | 4GB | 2 vCPU | 32GB |
| 105 | 2GB | 1 vCPU | 16GB |
| 106 | 2GB | 1 vCPU | 16GB |
| 107 | 2GB | 1 vCPU | 16GB |

**Total:** 24GB RAM, 13 vCPU, ~664GB Disco

---

## 🛡️ SEGURANÇA

### **SENHAS ROOT:**

| CT | Senha |
|----|-------|
| 100 | Rcmp814k@# |
| 101 | Rcmp814k@# |
| 102 | Rcmp@814k$1982 |
| 103 | Rcmp814k@# |
| 104 | Rcmp814k@# |
| 105 | Rcmp814k@# |
| 106 | Rcmp814k@# |
| 107 | Rcmp814k@# |

### **RECOMENDAÇÕES:**

1. ✅ Senhas fortes (todas com 10+ caracteres)
2. ✅ Acesso SSH com senha (chave pública pendente)
3. ✅ Rede isolada (192.168.0.x)
4. ⏳ Implementar fail2ban (pendente)
5. ⏳ Chaves SSH (pendente)

---

## 📞 SUPORTE

| Problema | Solução |
|----------|---------|
| Container OFFLINE | `pct start <CT>` no Proxmox |
| SSH não conecta | Verificar rede e senha |
| OpenClaw não responde | `systemctl restart openclaw` |
| IP não responde | Verificar no Proxmox (`pct status <CT>`) |

---

## 📝 HISTÓRICO DE REVISÕES

| Versão | Data | Autor | Alterações |
|--------|------|-------|------------|
| 1.0 | 09/04/2026 | Stark | Criação inicial |

---

**Última atualização:** 09/04/2026 13:36  
**Próxima revisão:** 16/04/2026 (7 dias)  
**Responsável:** Stark (CT 100)
