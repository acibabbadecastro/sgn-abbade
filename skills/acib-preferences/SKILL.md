---
name: acib-preferences
description: Learn and apply Acib ABBADE's personal preferences, patterns, and workflows. Use when interacting with Acib (Telegram ID 1866226415) to maintain continuity, apply learned patterns, and provide personalized assistance. Triggers on any task where context about Acib's preferences, history, or workflows would improve the response.
---

# Acib Preferences - Personal Profile & Workflows

## Identity
- **Name:** Acib ABBADE
- **Telegram:** @Acib_Abbade (ID: 1866226415)
- **Timezone:** America/Sao_Paulo (UTC-3)
- **Role:** System administrator, entrepreneur, multi-agent system architect

## Core Preferences

### Communication Style
- **Language:** Portuguese (Brazil)
- **Tone:** Direct, professional, technical when needed
- **Response style:** Values concise, actionable information over verbose explanations
- **Decision making:** Prefers I take technical decisions but ALWAYS asks authorization for destructive actions

### Critical Rules (NEVER BREAK)
1. **Data Destruction:** Any DELETE/REMOVE/DESTROY requires EXPLICIT authorization
2. **External Actions:** Ask before sending emails, tweets, public posts
3. **Privacy:** NEVER exfiltrate private data
4. **Authorization Pattern:** Present clear description + reason, wait for /Aprovar or /Negar

### Business Context
- **Primary Business:** Technology services, electronics sales (All Pro Imports)
- **Key Client:** SERVMIL (Saulo/Saulinho) - "Melhor cliente"
- **Infrastructure:** Proxmox VE with 13+ containers
- **Data Storage:** DATASVR (192.168.0.72) via Samba \\192.168.0.72\LAN\

## Workflows & Patterns

### Financial Monitoring
- **Accounts:**
  - PJ65 (65.384.056/0001-32) - MEI limit R$ 81.000/year
  - PJ20 (20.153.208/0001-58) - MEI limit R$ 81.000/year
  - PF (307.572.858-64) - IRPF isenção limit R$ 28.559,70/year
- **Alert Thresholds:** 70%, 85%, 95% of limits
- **Frequency:** Monitor monthly, alert on proximity to limits
- **Data Integrity:** CRITICAL - prevent duplicates, ensure accuracy

### System Administration
- **Proxmox Access:** pve1 (192.168.0.192), senha Rcmp814k@#
- **Container SSH:** sshpass -p 'Rcmp814k' with StrictHostKeyChecking=no
- **DATASVR SSH:** Different password Rcmp@814k$1982
- **Preferred Pattern:** sshpass for automation

### Memory Management
- **Frequency:** 4 HOURS (NOVA REGRA CRÍTICA 16/04/2026)
- **Location:** /home/master/LAN/MEMORIES/
- **Logs:** /home/master/LAN/LOGS/Stark/
- **Local Backup:** /root/.openclaw/backups/sessions/

### Email Processing
- **Gmail:** acibabbadecastro@gmail.com
- **App Password:** juqqogjysxvpowtu
- **Key Identifiers:**
  - "Saulo" = SERVMIL owner
  - "SERVMIL" = priority client
  - Nubank extratos = process immediately

## Technical Stack

### Database (CT 103 - 192.168.0.109:5432)
- **Database:** sgn
- **User:** acib
- **Password:** Rcmp814k@#
- **Schemas:** estoque, clientes, os, financeiro, fornecedores, garantia, agenda

### Web Applications
- **SGN:** http://192.168.0.99 (separate server, not container)
- **Admin:** http://192.168.0.99/admin_bd.php

### Multi-Agent System
| CT | Name | IP | Function |
|----|------|-----|----------|
| 100 | Stark | 192.168.0.21 | Orquestrador |
| 101 | STARK | 192.168.0.240 | MailBot |
| 102 | DATASVR | 192.168.0.72 | Storage/Samba |
| 103 | BD | 192.168.0.109 | PostgreSQL |
| 105 | MAILS | 192.168.0.224 | Email processing |
| ... | ... | ... | ... |

## Common Tasks & Patterns

### Financial Analysis
1. Always verify for duplicates before processing
2. Use ONLY one file per account (latest extract)
3. Generate IDs: e0001, e0002... for entries; s0001, s0002... for exits
4. Monthly breakdown with subtotals

### Data Processing
1. **PJ65/PJ20:** Semicolon delimiter (;) CSVs from Nubank
2. **PF:** Comma delimiter (,) CSVs
3. **Duplication Check:** Compare file hashes or timestamps

### Cron Job Management
- **Config file:** /root/.openclaw/cron/jobs.json
- **Frequency changes:** Require authorization
- **Current critical jobs:**
  - Backup: every 60 min
  - Memory update: every 4 hours
  - MailBot: every hour

## Alerts & Monitoring

### Thresholds
- **Thin Pool:** Alert if >80%
- **Container Status:** Check RUNNING state
- **MEI Limits:** Alert at 70%, 85%, 95%
- **IRPF Limit:** Alert at 70%, 85%, 95%

### Notification Policy
- **CRITICAL:** Immediate notification (system failures, data loss risk)
- **IMPORTANT:** Daily summary if pending
- **ROUTINE:** Silent operation, log only

## Learning Tracker

### Preferences Learned
- [x] 4-hour memory update frequency (16/04/2026)
- [x] No duplicate data in financial reports
- [x] Silent backup notifications (only failures)
- [x] PJ65/PJ20 format differences (semicolon vs comma)
- [x] Authorization required for destructive actions

### Patterns to Learn
- [ ] Email classification priorities
- [ ] Client communication preferences
- [ ] Report formatting preferences
- [ ] Automation scheduling preferences

## Reference Files
- See [references/financial-limits.md](references/financial-limits.md) for detailed monitoring thresholds
- See [references/container-map.md](references/container-map.md) for infrastructure details
- See [references/authorization-matrix.md](references/authorization-matrix.md) for decision authority

## Quick Commands
```bash
# Check all containers
for ct in 100 101 102 103 104 105 106 107 108 109 110 111 112; do
  sshpass -p 'Rcmp814k' ssh -o StrictHostKeyChecking=no root@192.168.0.XX "hostname" 2>/dev/null
done

# Access DATASVR
sshpass -p 'Rcmp@814k$1982' ssh -o StrictHostKeyChecking=no root@192.168.0.72

# Update memories (manual trigger)
# Copy from memory/ to /home/master/LAN/MEMORIES/
```
