# 🔐 CREDENCIAIS DE ACESSO AOS CONTAINERS (CTs)
## ⚠️ DOCUMENTO CRÍTICO - NUNCA PERDER APÓS /new

**Criado:** 27/04/2026 14:41  
**Motivo:** Perda de informações após /new  
**Prioridade:** MÁXIMA  
**Sistema:** Maximous v2.0 + STORMS

---

## 🎯 COMANDO RÁPIDO DE ACESSO

```bash
# Template para acessar qualquer CT
sshpass -p 'SENHA' ssh -o StrictHostKeyChecking=no root@IP_DO_CT

# Ou com SSH key (quando configurado)
ssh -i ~/.ssh/id_ed25519 -o StrictHostKeyChecking=no root@IP_DO_CT
```

---

## 📋 TABELA COMPLETA DE CTs

| CT | Nome | IP | Senha | Função | Status |
|----|------|-----|-------|--------|--------|
| 100 | Stark | 192.168.0.21 | Rcmp814k@# | Orquestrador Principal | ✅ Running |
| 101 | STARK | 192.168.0.240 | Rcmp814k@# | MailBot | ✅ Running |
| 102 | DATASVR | 192.168.0.72 | Rcmp814k@# | Armazenamento/Samba | ✅ Running |
| 103 | Marcos | 192.168.0.109 | Rcmp814k@# | Banco de Dados (PostgreSQL) | ✅ Running |
| 104 | SGN | 192.168.0.99 | Rcmp814k@# | Sistema Web | ✅ Running |
| 105 | MAILS | 192.168.0.224 | Rcmp814k@# | Processamento Emails | ✅ Running |
| 106 | gerente-fin | DHCP | Rcmp814k@# | Financeiro | ✅ Running |
| 107 | 4pets | 192.168.0.200 | Rcmp814k@# | Site Amigos de 4 Patas | ✅ Running |
| 109 | ADM-SERVMIL | DHCP | Rcmp814k@# | Administração SERVMIL | ✅ Running |
| 110 | bd-servmil | DHCP | Rcmp814k@# | Banco SERVMIL | ⏹️ Stopped |
| 111 | Fe-Servmil | DHCP | Rcmp814k@# | Frontend SERVMIL | ⏹️ Stopped |
| 112 | Analista-Servmil | DHCP | Rcmp814k@# | Análise Dados SERVMIL | ⏹️ Stopped |
| 113 | Hermes1 | DHCP | Rcmp814k@# | Outro | ⏹️ Stopped |

---

## 🚀 COMANDOS PRONTOS (COPY & PASTE)

### CT 100 - Stark (Orquestrador)
```bash
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.21
```

### CT 101 - STARK (MailBot)
```bash
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.240
```

### CT 102 - DATASVR (Armazenamento)
```bash
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.72
# Ou com SSH key:
ssh -i ~/.ssh/id_ed25519 -o StrictHostKeyChecking=no root@192.168.0.72
```

### CT 103 - Marcos (Banco PostgreSQL)
```bash
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.109
```

### CT 104 - SGN (Sistema Web)
```bash
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.99
```

### CT 105 - MAILS (Email)
```bash
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.224
```

### CT 107 - 4pets (Site - PRIORIDADE)
```bash
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.200
```

### CT 109 - ADM-SERVMIL
```bash
# Verificar IP DHCP primeiro
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.X
```

---

## 🔧 ACESSO VIA PROXMOX (PVE)

### Quando SSH não funcionar:
```bash
# Acessar PVE primeiro
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.192

# Depois acessar CT
pct exec NUMERO_DO_CT -- /bin/bash

# Exemplo CT 107
pct exec 107 -- /bin/bash
```

---

## 📁 CAMINHOS IMPORTANTES

### DATASVR (CT 102)
- **Samba:** `\\192.168.0.72\LAN\`
- **Path:** `/home/master/LAN/`
- **Pasta Acib:** `\\192.168.0.72\LAN\Acib\`

### Site 4Pets (CT 107)
- **URL:** https://amigos4patas.com.br
- **Path:** `/var/www/html/amigos4patas/`
- **IP Local:** http://192.168.0.200

### Banco SGN (CT 103)
- **IP:** 192.168.0.109
- **Porta:** 5432
- **Banco:** sgn
- **Usuário:** acib

---

## ⚠️ CHECKLIST PÓS-/new

Após cada `/new`, executar:

```bash
# 1. Ler este arquivo
cat ~/.openclaw/workspace/CREDENCIAIS-CTS-CRITICO.md

# 2. Verificar se Maximous está ativo
bash ~/.openclaw/workspace/skills/maximous-v2/scripts/dashboard-status.sh

# 3. Verificar Storms
bash ~/.openclaw/workspace/skills/storms/scripts/dashboard.sh 2>/dev/null

# 4. Confirmar acesso aos CTs
# Testar pelo menos um CT
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.72 "hostname"
```

---

## 🧠 INTEGRAÇÃO COM MAXIMOUS

Este documento DEVE ser:
1. ✅ Lido automaticamente pelo Maximous após /new
2. ✅ Sincronizado com DATASVR (backup)
3. ✅ Referenciado em toda sessão nova
4. ✅ Atualizado quando houver mudanças

### Comando Maximous para recuperar:
```bash
# Maximous irá buscar em:
# /root/.openclaw/workspace/CREDENCIAIS-CTS-CRITICO.md
# Ou
# /home/master/LAN/MEMORIES/CREDENCIAIS-CTS-CRITICO.md
```

---

## 🚨 LEMBRETE PERMANENTE

> **NUNCA DELETAR ESTE ARQUIVO**
> **NUNCA ESQUECER SENHA: Rcmp814k@#**
> **NUNCA ESQUECER PVE: 192.168.0.192**

---

**Última atualização:** 27/04/2026 14:41  
**Responsável:** Stark  
**Validação:** Acib ABBADE