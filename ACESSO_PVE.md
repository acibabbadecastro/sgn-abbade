## 🔐 ACESSO PROXMOX (PVE)

**Atualizado:** 2026-04-23
**Ultima verificacao:** 2026-04-23

### Host Principal
| Campo | Valor |
|-------|-------|
| **Hostname** | pve1 |
| **IP** | 192.168.0.192 |
| **Interface Web** | https://192.168.0.192:8006 |
| **Usuario** | root |
| **Senha** | Rcmp814k@# |

### Acesso SSH
ssh root@192.168.0.192
Senha: Rcmp814k@#

### Containers (CTs)
| CT | Nome | IP | Funcao |
|----|------|-----|--------|
| 100 | Stark | 192.168.0.21 | OpenClaw Principal |
| 101 | MailBot | 192.168.0.240 | Emails |
| 102 | DATASVR | 192.168.0.72 | Storage/Dados |
| 103 | Supervisor | 192.168.0.42 | Monitoramento |
| 104 | Vorcaro | 192.168.0.172 | Financeiro |
| 105 | OfficeBoy | 192.168.0.117 | Tarefas Admin |
| 106 | Seguranca | 192.168.0.231 | Seguranca |
| 107 | SAMU | 192.168.0.64 | Emergencias |

### Comandos Uteis

# Entrar em um container
pct exec 100 -- /bin/bash

# Ver status de todos os CTs
pct list

# Iniciar/Parar container
pct start 100
pct stop 100
pct restart 100

# Ver recursos
pct status 100

### IMPORTANTE
- Nunca compartilhar estas credenciais
- Fazer backup regular do /etc/pve/
- Manter Proxmox atualizado
