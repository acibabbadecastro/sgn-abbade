# 🆘 KIT DE SOBREVIVÊNCIA - PÓS /NEW
## Informações Críticas para Recuperação Imediata

**⚠️ Este arquivo deve ser carregado AUTOMATICAMENTE após cada /new**

---

## 🔐 CREDENCIAIS UNIVERSAIS

### Senha Padrão de Todos os CTs
```
Senha: Rcmp814k@#
Usuário: root
```

### SSH Pass
```
Comando: sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@[IP]
```

---

## 🖥️ INFRAESTRUTURA COMPLETA (13 CTs)

| CT | Nome | IP | Função | Acesso Rápido |
|----|------|-----|--------|---------------|
| **100** | Stark | 192.168.0.21 | Orquestrador Principal | `pct exec 100 -- /bin/bash` |
| **101** | STARK | 192.168.0.240 | MailBot | `pct exec 101 -- /bin/bash` |
| **102** | DATASVR | 192.168.0.72 | **ARCA** - Armazenamento/Samba | `ssh root@192.168.0.72` |
| **103** | Marcos | 192.168.0.109 | PostgreSQL | `pct exec 103 -- /bin/bash` |
| **104** | SGN | 192.168.0.99 | Sistema Web | `pct exec 104 -- /bin/bash` |
| **105** | MAILS | 192.168.0.224 | Processamento Emails | `pct exec 105 -- /bin/bash` |
| **106** | gerente-fin | DHCP | Financeiro | `pct exec 106 -- /bin/bash` |
| **107** | 4pets | 192.168.0.200 | Site Amigos 4 Patas | `pct exec 107 -- /bin/bash` |
| **109** | ADM-SERVMIL | DHCP | Administração SERVMIL | `pct exec 109 -- /bin/bash` |
| **110** | bd-servmil | DHCP | Banco SERVMIL | `pct exec 110 -- /bin/bash` |
| **111** | Fe-Servmil | DHCP | Frontend SERVMIL | `pct exec 111 -- /bin/bash` |
| **112** | Analista-Servmil | DHCP | Análise SERVMIL | `pct exec 112 -- /bin/bash` |
| **113** | Hermes1 | DHCP | Outro | `pct exec 113 -- /bin/bash` |

---

## 🎯 COMANDOS ESSENCIAIS

### Acesso via PVE1 (192.168.0.192)
```bash
# SSH no PVE1
sshpass -p 'Rcmp814k@#' ssh root@192.168.0.192

# Acessar qualquer CT
pct exec [NUMERO_CT] -- /bin/bash

# Ver status de todos os CTs
pct list

# Ver recursos
pveperf
```

### Acesso Direto via SSH (para CTs com IP fixo)
```bash
# DATASVR (CT 102)
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.72

# 4pets (CT 107)
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.200

# SGN Web (CT 104)
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.99
```

---

## 📂 CAMINHOS CRÍTICOS

### DATASVR (ARCA) - 192.168.0.72
```
Samba: \\192.168.0.72\LAN\
Path: /home/master/LAN/
Pastas: Acib/, MEMORIES/, Stark_Output/, Configs_Agentes/

Acesso SSH: root@192.168.0.72
Senha: Rcmp814k@#
```

### Workspace Local
```
Base: ~/.openclaw/workspace/
Skills: ~/.openclaw/workspace/skills/
Memórias: ~/.openclaw/workspace/memory/
Scripts: ~/.openclaw/workspace/scripts/
Seguro: ~/.openclaw/workspace/.secure/
```

### SSH Keys
```
Local: ~/.ssh/id_ed25519
DATASVR: ~/.ssh/id_ed25519 (copiar para CTs)
Fingerprint: AAAAC3NzaC1lZDI1NTE5AAAAIGMI7JK2K4u48w/Bh+ZJqia/ZY9C54V4nQftGP1u0fpk
```

---

## 👤 INFORMAÇÕES DO USUÁRIO

| Campo | Valor |
|-------|-------|
| **Nome** | Acib ABBADE |
| **Email** | abbade@outlook.com |
| **Telegram** | @Acib_Abbade |
| **RA UNOPAR** | 30757385864 |
| **Portal UNOPAR** | https://meunovoportal.unopar.com.br |

---

## 🔄 FLUXO DE TRABALHO PÓS-/NEW

### PASSO 1: Carregar Contexto (automático)
```
1. Ler ~/.openclaw/workspace/MEMORY.md
2. Ler ~/.openclaw/workspace/SOUL.md
3. Ler ~/.openclaw/workspace/USER.md
4. Ler ~/.openclaw/workspace/AGENTS.md
5. Ler ~/.openclaw/workspace/.openclaw/POST_NEW_RECOVERY.md (este arquivo)
```

### PASSO 2: Verificar Infraestrutura
```bash
# Testar acesso ao PVE1
ping -c 1 192.168.0.192

# Testar DATASVR
ping -c 1 192.168.0.72

# Listar CTs ativos
pct list | grep running
```

### PASSO 3: Restaurar Conexões
```bash
# Verificar SSH keys
ls -la ~/.ssh/

# Testar acesso DATASVR
ssh -o StrictHostKeyChecking=no -o ConnectTimeout=5 root@192.168.0.72 "echo 'OK'"
```

---

## 🚨 EMERGÊNCIA - ESQUECI TUDO

Se por algum motivo não conseguir acessar:

### Opção 1: Acesso Físico/Console
```
Acesse PVE1 diretamente: https://192.168.0.192:8006
Usuário: root
Senha: Rcmp814k@#
```

### Opção 2: Recuperação via DATASVR
```bash
# DATASVR nunca deve estar offline
# Acesse de outra máquina na rede
ssh root@192.168.0.72

# Ou monte o Samba
smbclient //192.168.0.72/LAN -U root
```

### Opção 3: Pendrive de Recuperação
```
Local: /mnt/meu-pendrive/
Backup crítico: /mnt/meu-pendrive/Stark_Backup/
```

---

## 📊 STATUS DOS SISTEMAS

### ✅ SEMPRE ONLINE (Críticos)
- PVE1 (192.168.0.192)
- Stark (CT 100, 192.168.0.21)
- DATASVR (CT 102, 192.168.0.72)

### ⚠️ VERIFICAR STATUS
- Site 4Pets: https://amigos4patas.com.br
- SGN Web: http://192.168.0.99

---

## 📝 NOTAS IMPORTANTES

1. **NUNCA** salve senhas em texto plano em commits do Git
2. **SEMPRE** use o sistema `.secure/` para credenciais
3. **VERIFIQUE** conectividade com DATASVR após /new
4. **TESTE** acesso a pelo menos 1 CT antes de começar tarefas

---

## 🔄 ATUALIZAÇÃO

**Última atualização:** 27/04/2026 17:30
**Próxima revisão:** Após mudanças na infraestrutura
**Responsável:** Stark (Automático)

---

**LEMBRETE:** Este arquivo deve ser carregado automaticamente pelo Maximous após cada /new!
