# MEMORY.md - Long-Term Memory

## Identity
- **Name:** Stark 🤖
- **Restore date:** 2026-04-02
- **Backup source:** /mnt/meu-pendrive/Stark_Backup/

## User Info
- **User:** master (based on home directory)
- **Name:** Acib ABBADE
- **Telegram:** Acib_Abbade (ID: 1866226415)
- **Hardware:** AMD Ryzen 5 5600X, 30GB RAM, AMD RX 580 8GB, 223GB SSD
- **Pen Drive:** 57GB (Ventoy) mounted at /mnt/meu-pendrive
- **Timezone:** Horário Brasília (UTC-3)

## Infrastructure
- **Running on:** Proxmox CT 100 (pve1: 192.168.0.192)
- **SSH:** Configured and working on pve1
- **Ollama:** Running on port 11434
- **OpenClaw Gateway:** Running on port 18789

## Ollama Models
- **Default:** phi4-mini:latest
- **Available:** qwen2.5:3b, qwen2.5:7b, qwen3.5:0.8b, qwen3.5:latest, llama3:8b, mistral

## Important Protocols
- **Memory Organization:** Ask before creating new folders/categories
- **Log Format:** Date + Time + Request + Action + Result
- **Backup:** Keep redundancy on pendrive and local
- **Monitoramento 24/7:** Supervisor (CT 103) monitora todos os outros
- **Nada de ação destrutiva sem autorização do Acib**

## Key Learnings
- Telegram plugin must be enabled separately: `openclaw plugins enable telegram`
- Channel config ≠ Plugin enabled
- Pendrive backups in /mnt/meu-pendrive/Stark_Backup/

## ⚠️ PROTOCOLO DE BACKUP DE SESSÕES (2026-04-03)
- Sessões do OpenClaw NÃO persistem entre reinicializações
- Backup Local: `/root/.openclaw/backups/sessions/`
- Script: `/root/.openclaw/scripts/backup-sessions.sh`
- Cron: a cada 60 minutos, retenção 10 backups

## Equipe de Agentes - ATUALIZADO (2026-04-03)

| CT | Nome | RAM | Cores | Disk | Especialidade | Status |
|----|------|-----|-------|------|---------------|--------|
| 100 | **Stark** 🤖 | 4GB | 2 | 120GB | Coordenação/Geral | 🟢 |
| 101 | **Mails** 📧 | 4GB | 2 | 67GB | Emails | 🟢 |
| 102 | **DATASVR** 💾 | 5GB | 2 | 45GB | Armazenamento/Backup | 🟢 |
| 103 | **Supervisor** 👁️ | 4GB | 2 | 60GB | Monitoramento 24/7 | 🟢 |
| 104 | **Vorcaro** 🎯 | 2GB | 2 | 70GB | API Finance | 🟢 |
| 105 | **OfficeBoy** 📋 | 2GB | 2 | 70GB | Tarefas Admin | 🟢 |

**Rede:** Todos em DHCP bridge vmbr0 | **OS:** Ubuntu amd64

## Sistema Multi-Agente - Arquitetura de Equipe

### Regras de Monitoramento (OBRIGATÓRIO)
1. Supervisor (CT 103) monitora todos os outros 24/7
2. Se algum falhar → LOG → Notificar Stark → Notificar Acib → Pedir AUTORIZAÇÃO → Reparar
3. Nada de ação destrutiva sem aprovação

### Fluxo de Falha:
```
Agente falha → Supervisor detecta → Log registra → Stark verifica 
→ Stark notifica Acib → Acib autoriza → Stark repara
```

## Credenciais

| CT | IP | Senha Root |
|----|----|------------|
| DATASVR (102) | 192.168.0.72 | Rcmp@814k$1982 |
| Supervisor (103) | 192.168.0.42 | Rcmp814k@# |
| Vorcaro (104) | 192.168.0.? | Rcmp814k@# |
| OfficeBoy (105) | 192.168.0.? | Rcmp814k@# |

## 📂 DADOS COMPARTILHADOS
**Pasta:** `/mnt/data/` (DATASVR - 500GB)
- Estrutura LAN: `/mnt/data/LAN/`
- Todos agentes acessam esta pasta
- Acib acessa via Windows (Samba: `\\192.168.0.72`)

## 📊 Análises Financeiras - Nubank (2026-04-03)
- Relatório completo: `/root/DOCS/LAN/Relatorios/Financeiros/ANALISE_COMPLETA_MARCO_2026.md`
- Base JSON: `/root/DOCS/LAN/Documentos/Financeiros/Nubank/relatorio_marco2026.json`
- Conta PJ Principal (65): R$ -196,96 líquido em Março
- 128 transações analisadas
- **Documento:** `memory/PROJETO.md`
- **Fase 1:** ✅ Arquitetura base + Stark como orquestrador
- **Fase 2:** 🔜 Configurar Mails (CT 101) para email acibabbadecastro@gmail.com

## Skills Disponíveis no OpenClaw
- `clawflow` - workflow multi-tarefa
- `clawflow-inbox-triage` - triagem de inbox
- `healthcheck` - segurança/auditoria
- `node-connect` - diagnóstico de conexão
- `skill-creator` - criar/editar skills
- `weather` - clima

Verificar novas em: https://clawhub.ai
