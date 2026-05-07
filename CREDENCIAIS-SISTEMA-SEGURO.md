# 🔐 SISTEMA DE GERENCIAMENTO DE CREDENCIAIS - ACIB ABBADE

## 📋 POLÍTICA DE SEGURANÇA

**Data:** 27/04/2026  
**Nível:** CRÍTICO - Acesso Restrito  
**Criptografia:** AES-256-GCM + Chave Mestra

---

## 🎯 PRINCÍPIOS FUNDAMENTAIS

1. **CONFIDENCIALIDADE** - Ninguém além do Acib acessa
2. **INTEGRIDADE** - Hash SHA-512 para verificação
3. **DISPONIBILIDADE** - 3 backups em locais diferentes
4. **AUDITORIA** - Log de todos os acessos
5. **MÍNIMO PRIVILÉGIO** - Acesso apenas quando necessário

---

## 🗂️ HIERARQUIA DE SEGURANÇA

```
NÍVEL 5 (ULTRA-CRÍTICO)
├── Chaves SSH (ed25519)
├── Tokens de API (GitHub, OpenAI)
├── Senhas de root/admin
└── 2FA/Seeds

NÍVEL 4 (CRÍTICO)
├── Senhas de banco de dados
├── Chaves de API de serviços
├── Tokens de sessão
└── Certificados SSL

NÍVEL 3 (ALTO)
├── Senhas de email
├── Credenciais de serviços
├── API keys secundárias
└── Senhas de aplicações

NÍVEL 2 (MÉDIO)
├── Configurações de rede
├── IPs e portas
└── Usuários de sistemas

NÍVEL 1 (BAIXO)
├── Documentação pública
├── Configurações gerais
└── Informações não sensíveis
```

---

## 🔒 ARMAZENAMENTO SEGURO

### Localização Oficial:
```
~/.openclaw/workspace/.secure/
├── .gitignore (nunca commitar)
├── .env.vault (criptografado)
├── keys/
│   ├── ssh/
│   ├── pgp/
│   └── api/
├── passwords/
│   ├── databases/
│   ├── services/
│   └── personal/
├── backup/
│   ├── local/
│   ├── datasvr/
│   └── offline/
└── logs/
    └── access.log (auditoria)
```

---

## 🛡️ CRIPTOGRAFIA

### Método: AES-256-GCM
```bash
# Criptografar
openssl enc -aes-256-cbc -pbkdf2 -iter 100000 -salt \
    -in segredo.txt -out segredo.txt.enc

# Descriptografar
openssl enc -aes-256-cbc -pbkdf2 -iter 100000 -d \
    -in segredo.txt.enc -out segredo.txt
```

### Permissões de Arquivos:
```
Chaves SSH:        600 (rw-------)
Arquivos de senha: 600 (rw-------)
Diretórios:        700 (rwx------)
Logs:              644 (rw-r--r--)
```

---

## 📊 INVENTÁRIO DE CREDENCIAIS

### 🔑 Chaves SSH

| ID | Tipo | Local | Hash (SHA-256) | Uso | Nível |
|----|------|-------|----------------|-----|-------|
| ssh-001 | ed25519 | ~/.ssh/id_ed25519 | [HASH] | Acesso CTs | 5 |
| ssh-002 | rsa | ~/.ssh/id_rsa | [HASH] | Backup DATASVR | 5 |
| ssh-003 | ed25519 | CT102:/root/.ssh/ | [HASH] | DATASVR interno | 4 |

### 🎫 Tokens de API

| Serviço | Token | Scopes | Expiração | Nível |
|---------|-------|--------|-----------|-------|
| GitHub | ghp_**** | repo, user | 90 dias | 5 |
| Telegram | 867488**** | bot | permanente | 4 |
| OpenClaw | - | admin | permanente | 5 |

### 🔐 Senhas Críticas

| Sistema | Usuário | Senha | Última troca | Nível |
|---------|---------|-------|--------------|-------|
| Proxmox PVE | root | [HASH] | 23/04/2026 | 5 |
| DATASVR | root | [HASH] | - | 5 |
| GitHub | acibabbadecastro | [HASH] | - | 5 |

---

## 🔄 BACKUP E RECUPERAÇÃO

### Estratégia 3-2-1:
- **3** cópias de cada credencial
- **2** tipos diferentes de mídia
- **1** cópia offsite/offline

### Locais de Backup:

1. **LOCAL** (Criptografado)
   - `~/.openclaw/workspace/.secure/`
   - Chave GPG local

2. **DATASVR** (Criptografado)
   - `192.168.0.72:/home/master/LAN/SECRETS/`
   - Acesso via SSH key

3. **OFFLINE** (Pendrive)
   - `/mnt/meu-pendrive/SECRETS/`
   - Desconectado quando não em uso

---

## 📜 PROCEDIMENTOS DE ACESSO

### Para Acessar Credenciais:

1. **Identificar** necessidade
2. **Autenticar** com Acib (se possível)
3. **Descriptografar** no momento do uso
4. **Usar** imediatamente
5. **Limpar** variáveis de ambiente
6. **Logar** acesso

### Comando Seguro de Acesso:

```bash
# Script: secure-access.sh
# Uso: bash secure-access.sh [ID_DA_CREDENCIAL]

#!/bin/bash
ID=$1
LOG="~/.openclaw/workspace/.secure/logs/access.log"

# Log do acesso
echo "$(date) - Acesso a $ID - PID: $$" >> $LOG

# Descriptografar temporariamente
openssl enc -aes-256-cbc -d -in ~/.secure/.env.vault -out /tmp/.env.tmp

# Carregar e usar
source /tmp/.env.tmp
grep "^$ID=" /tmp/.env.tmp | cut -d'=' -f2

# Limpar após 30 segundos
(sleep 30 && shred -u /tmp/.env.tmp) &
```

---

## ⚠️ ALERTAS DE SEGURANÇA

### Monitoramento:
- Acessos fora do horário → Alerta
- Múltiplas tentativas falhas → Bloqueio
- Backup não realizado → Alerta
- Permissões alteradas → Alerta

### Rotação de Credenciais:
- **Nível 5:** A cada 90 dias
- **Nível 4:** A cada 180 dias
- **Nível 3:** Anualmente

---

## 🔍 AUDITORIA

### Logs Mantidos:
```
~/.openclaw/workspace/.secure/logs/
├── access.log        (quem acessou o quê e quando)
├── changes.log       (alterações nas credenciais)
├── backup.log        (status dos backups)
└── alerts.log        (alertas de segurança)
```

### Retenção:
- Logs de acesso: 1 ano
- Logs de alteração: 2 anos
- Logs de backup: 6 meses

---

## 🆘 RECUPERAÇÃO DE DESASTRES

### Plano de Contingência:

1. **Perda de chave SSH:**
   - Restaurar do backup DATASVR
   - Ou regenerar e atualizar em todos os CTs

2. **Comprometimento de token:**
   - Revogar imediatamente no serviço
   - Gerar novo
   - Atualizar em todos os locais

3. **Corrupção do vault:**
   - Restaurar de backup offline
   - Verificar integridade com hash

4. **Acesso não autorizado:**
   - Trocar todas as credenciais nível 5
   - Auditar logs
   - Revisar permissões

---

## ✅ CHECKLIST DE SEGURANÇA

- [ ] Todas as credenciais criptografadas
- [ ] Backups automáticos configurados
- [ ] Logs de auditoria ativados
- [ ] Permissões 600/700 aplicadas
- [ ] Rotação de senhas agendada
- [ ] Acesso offsite testado
- [ ] Plano de recuperação documentado

---

**Documento de Segurança - Nível: CONFIDENCIAL**  
*Acesso restrito ao proprietário das credenciais*
