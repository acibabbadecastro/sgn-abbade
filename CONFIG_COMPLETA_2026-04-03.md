# CONFIGURAÇÃO COMPLETA DOS AGENTES - STARK
# Data: 2026-04-03 21:19 (Brasília)
# IMPORTANTE: Este arquivo contém todo o estado funcional da equipe

## ARQUITETURA DA EQUIPE

| CT | Nome | IP | Porta | Função |
|----|------|-----|-------|--------|
| 100 | Stark | 192.168.0.21 | 18789 | Orquestrador principal |
| 101 | MailBot | 192.168.0.240 | 18789 | Email/Notificações |
| 102 | DATASVR | 192.168.0.72 | 18789 | Armazenamento (HD 500GB) |
| 103 | Supervisor | 192.168.0.42 | 18789 | Vice-Stark (dormant) |
| 104 | Vorcaro | 192.168.0.172 | 18789 | Financeiro |
| 105 | OfficeBoy | 192.168.0.117 | 18789 | Tarefas Admin |
| 106 | Seguranca | 192.168.0.231 | 18789 | Segurança (OFFLINE) |
| 107 | SAMU | 192.168.0.64 | 18789 | Resgate Stark (dormant) |

## SERVIDORES

| Serviço | IP | Porta |
|---------|-----|-------|
| pve1 (Proxmox) | 192.168.0.192 | - |
| Stark (CT 100) | 192.168.0.21 | 18789 |

## STARK (CT 100) - CONFIGURAÇÃO COMPLETA

### Gateway
- Mode: lan
- Port: 18789
- Token: 84c98cf437f99f67f42553f4ec2639b49bf7991ee616d6ae
- Model: ollama/minimax-m2.7:cloud

### Services
- openclaw-gateway: enabled, running
- CT onboot: enabled (inicia automático)
- Auto-start: systemctl --user enable openclaw-gateway

### Comandos para Recovery
```bash
# Verificar status
ssh root@192.168.0.192 "pct status 100"
ssh root@192.168.0.192 "pct exec 100 -- systemctl --user status openclaw-gateway"

# Reiniciar CT
ssh root@192.168.0.192 "pct reboot 100"

# Reiniciar gateway
ssh root@192.168.0.192 "pct exec 100 -- systemctl --user restart openclaw-gateway"

# Acordar Stark (dentro do CT)
ollama launch openclaw --model ollama/minimax-m2.7:cloud
```

## SAMU (CT 107) - CONFIGURAÇÃO

### Função
- Monitora Stark a cada 60 segundos (MODO DORMANT)
- Se ativo: tenta acordar Stark automaticamente
- Envia alertas via Telegram

### IP Correto
- STARK_IP: 192.168.0.21 (CRÍTICO - não usar 192.168.0.192!)

### Scripts
- `/root/samu/monitor.sh` - Script principal
- `/root/samu/send_alert.sh` - Envio Telegram direto

### Cron (MODO DORMANT - removido)
```bash
# Para ativar manualmente:
ssh root@192.168.0.64 "echo '*/1 * * * * /root/samu/monitor.sh' | crontab -"
```

### Telegram
- Token: 8674882792:AAEIwzMDLWrMUdhYJ9qlk492gQ-X2KXAbTc
- Chat ID: 1866226415

## SUPERVISOR (CT 103) - CONFIGURAÇÃO

### Função
- Vice-Stark: assume se Stark cair (MODO DORMANT)
- Monitora todos os agentes
- Gera relatórios de status

### IP Correto
- STARK_IP: 192.168.0.21 (CRÍTICO)

### Scripts
- `/root/supervisor/vice_stark.sh` - Script Vice-Stark
- `/root/supervisor/team_monitor.sh` - Monitor de equipe

### Cron (MODO DORMANT - removido)
```bash
# Para ativar manualmente:
ssh root@192.168.0.42 "echo '* * * * * /root/supervisor/vice_stark.sh monitor' | crontab -"
```

## GUARDIAN - SISTEMA DE EMERGÊNCIA

### Local
- Arquivo: `/root/guardian/guardian.sh`
- Logs: `/root/.openclaw/guardian/`
- IPs: `/root/.openclaw/guardian/ips.conf`

### Comandos
```bash
/guard save       # Salvar estado atual
/guard emergencia # Ativar SAMU + Supervisor
/guard normal     # Desativar (modo dormant)
/guard status     # Ver estado atual
```

### Palavra Mágica
- "LIBERAR" - ativa emergência automaticamente

## AGENTES - STATUS E CONFIG

### MailBot (CT 101)
- IP: 192.168.0.240
- Gateway: ✅ Running
- Token: 507de523881f4ba3b8647da3aa4f80408c34013b6f478ec0
- Modelo: ollama/minimax-m2.7:cloud
- Telegram: ✅ Configurado

### DATASVR (CT 102)
- IP: 192.168.0.72
- Gateway: ✅ Running
- Token: 84c98cf437f99f67f42553f4ec2639b49bf7991ee616d6ae
- HD: 500GB mounted at /mnt/data
- Modelo: ollama/minimax-m2.7:cloud

### Vorcaro (CT 104)
- IP: 192.168.0.172
- Gateway: ✅ Running
- Token: (mesmo do Stark - unificado)
- Modelo: ollama/minimax-m2.7:cloud
- Função: Agente financeiro

### OfficeBoy (CT 105)
- IP: 192.168.0.117
- Gateway: ⚠️ OFFLINE (precisa reinstall)
- Modelo: ollama/minimax-m2.7:cloud
- Função: Tarefas administrativas

### Seguranca (CT 106)
- IP: 192.168.0.231
- Status: ❌ COMPLETAMENTE OFFLINE
- Precisa: atenção manual

## HD 500GB (DATASVR)

### Montagem
- Device: /dev/sdb3
- Mount: /mnt/sdb (no pve1)
- Bind mount: /mnt/data (dentro do CT 102)
- Tamanho: 465GB

### Pasta LAN
- Local: /mnt/data/LAN/
- Subpastas:
  - /mnt/data/LAN/Configs_Agentes/ (ESTE ARQUIVO)
  - /mnt/data/LAN/Backups/
  - /mnt/data/LAN/Documentacao/

## TEMPORIZADORES (TIMEZONE)

Todos os agentes em America/Sao_Paulo (-03:00):
```bash
timedatectl set-timezone America/Sao_Paulo
```

## CRON JOBS

### Stark (CT 100)
- Backup sessions: a cada 60 min (ID: 4a72e14b-f00a-4fdd-962d-da1e43d49e08)
- Location: /root/.openclaw/cron/jobs.json

### Sistema
- Backup full: 0 * * * * (/root/.openclaw/scripts/backup-full.sh)
- Recovery kit: 0 */6 * * * (/root/.openclaw/RecoveryKit/scripts/emergency-backup.sh)

## COMO RESTAURAR TODO O SISTEMA

### 1. Carregar este arquivo
```bash
cat /mnt/data/LAN/Configs_Agentes/CONFIG_COMPLETA_2026-04-03.md
```

### 2. Verificar IPs
```bash
# Do pve1:
pct exec 100 -- hostname -I  # Stark
pct exec 107 -- hostname -I  # SAMU
# etc.
```

### 3. Verificar serviços
```bash
# Em cada CT:
systemctl --user status openclaw-gateway
openclaw gateway status
```

### 4. Restaurar cron se necessário
```bash
# SAMU:
ssh root@192.168.0.64 "echo '*/1 * * * * /root/samu/monitor.sh' | crontab -"

# Supervisor:
ssh root@192.168.0.42 "echo '* * * * * /root/supervisor/vice_stark.sh monitor' | crontab -"
```

### 5. Corrigir tokens se necessário
```bash
# Token unificado:
TOKEN="84c98cf437f99f67f42553f4ec2639b49bf7991ee616d6ae"

# Aplicar em todos:
sed -i "s/\"token\": \"[^\"]*\"/\"token\": \"$TOKEN\"/" /root/.openclaw/openclaw.json
```

## ARQUIVOS IMPORTANTES

| Arquivo | Descrição |
|---------|-----------|
| /mnt/data/LAN/Configs_Agentes/CONFIG_COMPLETA_2026-04-03.md | ESTE ARQUIVO |
| /root/.openclaw/workspace/COMANDOS_RECUPERACAO.md | Comandos de recovery |
| /root/.openclaw/workspace/guardian.sh | Sistema emergência |
| /root/.openclaw/workspace/memory/2026-04-03.md | Registro do dia |

---

## ÚLTIMA ATUALIZAÇÃO
- Data: 2026-04-03 21:19 (Brasília, -03:00)
- Por: Stark (auto-gravado)
- Local secundário: /mnt/data/LAN/Configs_Agentes/CONFIG_COMPLETA_2026-04-03.md
