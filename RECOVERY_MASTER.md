# 🆘 RECOVERY MASTER - KIT DE SOBREVIVÊNCIA DO SISTEMA
**Criado:** 2026-04-05 11:40  
**Versão:** 1.0 - À PROVA DE FALHA  
**Proprietário:** Acib ABBADE  

---

## ⚠️ INSTRUÇÕES CRÍTICAS

Este arquivo contém TUDO necessário para reconstruir o sistema do ZERO.
Guarde em múltiplos locais. Sem este arquivo, a recuperação será extremamente difícil.

**Locais onde este arquivo DEVE estar:**
1. ✅ /home/master/LAN/BACKUP_CRITICO/RECOVERY_MASTER.md (DATASVR)
2. ✅ /root/.openclaw/workspace/RECOVERY_MASTER.md (Stark CT100)
3. ✅ /mnt/meu-pendrive/Stark_Backup/RECOVERY_MASTER.md (Pendrive Físico)
4. ✅ Impresso em papel (opcional mas recomendado)

---

## 👤 IDENTIFICAÇÃO DO PROPRIETÁRIO

| Campo | Valor |
|-------|-------|
| **Nome Completo** | Acib ABBADE DE CASTRO |
| **CPF** | 307.572.858-64 |
| **Email Principal** | acibabbadecastro@gmail.com |
| **Email Secundário** | infoacib@gmail.com |
| **Email Alertas** | acib@outlook.com |
| **Telegram** | @Acib_Abbade (ID: 1866226415) |

---

## 🏦 CONTAS BANCÁRIAS (NUBANK)

### CONTA 1: PJ-65 (Principal)
```
CNPJ: 65.384.056/0001-32
Razão Social: ABBADE Informatica
Conta: 986080174-7
Agência: 0001
Banco: Nubank (260)
Tipo: Conta Corrente Empresarial
```

### CONTA 2: PJ-20
```
CNPJ: 20.153.208/0001-58
Conta: 118844303
Banco: Nubank (260)
```

### CONTA 3: PF
```
CPF: 307.572.858-64
Titular: ACIB ABBADE DE CASTRO
Conta: 169842561
Banco: Nubank (260)
```

---

## 🔐 CREDENCIAIS CRÍTICAS

### GMAIL APP PASSWORDS
```
Email 1: acibabbadecastro@gmail.com
Password: juqqogjysxvpowtu

Email 2: acibabbade@gmail.com
Password: obtx vtvr znrw bxlv
```

### TELEGRAM BOT
```
Bot Token: 8674882792:AAEIwzMDLWrMUdhYJ9qlk492gQ-X2KXAbTc
Bot Username: @acibclawd_bot
Seu User ID: 1866226415
```

### OPENCLAW GATEWAY
```
Port: 18789
Token: 84c98cf437f99f67f42553f4ec2639b49bf7991ee616d6ae
```

### PROXMOX HOST
```
Host: pve1
IP: 192.168.0.192
Acesso: SSH via terminal ou interface web https://192.168.0.192:8006
```

---

## 🖥️ INFRAESTRUTURA - CONTAINERS (8 AGENTES)

| CT | Nome | IP | Função | Senha Root | Status |
|----|------|-----|--------|------------|--------|
| 100 | **Stark** | 192.168.0.21 | Maestro/Orquestrador | SSH Key | ⭐ PRINCIPAL |
| 101 | MailBot | 192.168.0.240 | Emails | Rcmp814k@# | 🟢 ONLINE |
| 102 | DATASVR | 192.168.0.72 | Dados/Storage | Rcmp@814k$1982 | 🟢 ONLINE |
| 103 | Supervisor | 192.168.0.42 | Monitoramento | Rcmp814k@# | 🟢 ONLINE |
| 104 | Vorcaro | 192.168.0.172 | Financeiro | Rcmp814k@# | 🟢 ONLINE |
| 105 | OfficeBoy | 192.168.0.117 | Tarefas Admin | Rcmp814k@# | 🟢 ONLINE |
| 106 | Seguranca | 192.168.0.231 | Segurança | Rcmp814k | 🟢 ONLINE |
| 107 | SAMU | 192.168.0.64 | Emergências | Rcmp814k@# | 🟢 ONLINE |

**Modelo AI (todos):** `ollama/minimax-m2.7:cloud`

---

## 📂 CAMINHOS CRÍTICOS DO SISTEMA

### DATASVR (192.168.0.72) - HD 500GB
```
Raiz Samba: /home/master/LAN/
Acesso Windows: \\192.168.0.72\lan

Pastas Importantes:
├── BACKUP_CRITICO/          ← BACKUP PRINCIPAL
├── MEMORIES/                ← Memórias compartilhadas
├── LOGS/                    ← Logs do sistema
├── Emails/                  ← Emails processados
└── Stark_Output/
    └── Financeiro/
        └── Nubank/
            ├── Extratos/    ← CSVs dos bancos
            ├── Transacoes/  ← Dados processados
            └── transacoes.db ← Database SQLite
```

### Stark (CT 100)
```
Workspace: /root/.openclaw/workspace/
Arquivos Vitais:
├── MEMORY.md                ← Memória principal
├── AGENTS.md               ← Regras dos agentes
├── USER.md                 ← Dados do usuário
├── SOUL.md                 ← Personalidade
├── TOOLS.md                ← Configurações locais
├── HEARTBEAT.md            ← IPs e status
├── RECOVERY_MASTER.md      ← ESTE ARQUIVO
└── memory/
    └── 2026-04-05.md      ← Logs diários
```

### Pendrive Físico (57GB)
```
Montagem: /mnt/meu-pendrive/
Backup: /mnt/meu-pendrive/Stark_Backup/
```

---

## 🆘 PROCEDIMENTO DE RECUPERAÇÃO TOTAL

### CENÁRIO 1: Recuperação do Stark (CT 100)

**Passo 1: Acessar DATASVR**
```bash
ssh root@192.168.0.72
# Senha: Rcmp@814k$1982
```

**Passo 2: Verificar backup**
```bash
ls -la /home/master/LAN/BACKUP_CRITICO/
```

**Passo 3: Copiar para Stark**
```bash
scp /home/master/LAN/BACKUP_CRITICO/* root@192.168.0.21:/root/.openclaw/workspace/
```

**Passo 4: Recriar estrutura**
```bash
mkdir -p /root/.openclaw/workspace/memory
mkdir -p /root/.openclaw/logs
```

**Passo 5: Reiniciar OpenClaw**
```bash
systemctl restart openclaw-gateway
systemctl status openclaw-gateway
```

---

### CENÁRIO 2: Recriação Completa do Sistema

Se todo o Proxmox cair:

**Passo 1: Reinstalar Proxmox no hardware**
- IP: 192.168.0.192
- Nome: pve1

**Passo 2: Recriar os 8 containers**
Use este script como referência:
```bash
# CT 100 - Stark
create_container 100 "Stark" 192.168.0.21

# CT 101 - MailBot  
create_container 101 "MailBot" 192.168.0.240

# CT 102 - DATASVR
create_container 102 "DATASVR" 192.168.0.72

# CT 103 - Supervisor
create_container 103 "Supervisor" 192.168.0.42

# CT 104 - Vorcaro
create_container 104 "Vorcaro" 192.168.0.172

# CT 105 - OfficeBoy
create_container 105 "OfficeBoy" 192.168.0.117

# CT 106 - Seguranca
create_container 106 "Seguranca" 192.168.0.231

# CT 107 - SAMU
create_container 107 "SAMU" 192.168.0.64
```

**Passo 3: Restaurar dados do DATASVR**
```bash
# No CT 102 (DATASVR)
mkdir -p /home/master/LAN/BACKUP_CRITICO
mkdir -p /home/master/LAN/MEMORIES
mkdir -p /home/master/LAN/LOGS
mkdir -p /mnt/data/LAN

# Restaurar do pendrive ou backup externo
```

**Passo 4: Instalar OpenClaw em cada CT**
```bash
# Em cada container
npm install -g openclaw
openclaw setup
# Configurar gateway token: 84c98cf437f99f67f42553f4ec2639b49bf7991ee616d6ae
```

**Passo 5: Configurar Ollama**
```bash
# Instalar Ollama
curl -fsSL https://ollama.com/install.sh | sh

# Pull do modelo
ollama pull minimax-m2.7:cloud
```

**Passo 6: Restaurar configurações**
```bash
# Copiar MEMORY.md, AGENTS.md, USER.md, SOUL.md, TOOLS.md
# Para /root/.openclaw/workspace/ em cada agente
```

---

### CENÁRIO 3: Perda do DATASVR

Se o CT 102 falhar:

**Passo 1: Recriar CT 102**
```bash
# No Proxmox
pct create 102 /var/lib/vz/template/cache/ubuntu-24.04-standard.tar.zst \
  --hostname DATASVR \
  --storage local-zfs \
  --rootfs 50 \
  --memory 4096 \
  --swap 2048 \
  --net0 name=eth0,bridge=vmbr0,ip=192.168.0.72/24,gw=192.168.0.1
```

**Passo 2: Configurar Samba**
```bash
apt update && apt install -y samba

# Configurar /etc/samba/smb.conf:
#[LAN]
#   comment = DATASVR - LAN
#   path = /home/master/LAN
#   browseable = yes
#   read only = no
#   guest ok = no
#   valid users = master
#   admin users = master

systemctl restart smbd
```

**Passo 3: Restaurar dados do pendrive**
```bash
mount /dev/sdb1 /mnt/meu-pendrive  # ajustar device
cp -r /mnt/meu-pendrive/Stark_Backup/* /home/master/LAN/
```

---

## 🔧 COMANDOS ÚTEIS DE EMERGÊNCIA

### Verificar status de todos os CTs
```bash
for ct in 100 101 102 103 104 105 106 107; do
  echo "CT $ct: $(pct status $ct 2>/dev/null || echo 'OFFLINE')"
done
```

### SSH rápido para cada agente
```bash
# Stark (sem senha, usa chave)
ssh root@192.168.0.21

# Outros (com senha)
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.240  # MailBot
sshpass -p 'Rcmp@814k$1982' ssh -o StrictHostKeyChecking=no root@192.168.0.72  # DATASVR
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.42  # Supervisor
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.172 # Vorcaro
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.117 # OfficeBoy
sshpass -p 'Rcmp814k' ssh -o StrictHostKeyChecking=no root@192.168.0.231   # Seguranca
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@192.168.0.64  # SAMU
```

### Reiniciar OpenClaw Gateway
```bash
systemctl restart openclaw-gateway
systemctl status openclaw-gateway
journalctl -u openclaw-gateway -f
```

### Verificar logs
```bash
# Stark
ls -la /root/.openclaw/logs/

# Supervisor
cat /root/supervisor/team.log

# Guardian
cat /root/.openclaw/guardian/guardian.log
```

---

## 📊 DADOS FINANCEIROS

### Database Location
```
/home/master/Stark_Output/Financeiro/Nubank/transacoes.db
```

### Extratos CSV Disponíveis
```
/home/master/Stark_Output/Financeiro/Nubank/Extratos/
├── 554_NU_9860801747_27FEV2026_03ABR2026.csv  (PJ65)
├── 135_NU_118844303_01JAN2026_03ABR2026.csv    (PJ20)
└── NOVO_PF_JAN2026.csv                          (PF)
```

### Fornecedores Principais
- Aplicação RDB
- ALL PRO IMPORTS
- ROGERIO ESPEDITO
- ATACADAO
- ATUAL PECAS (Silvana/Rogerio)
- HOUTER DO BRASIL

---

## 🛡️ PROTOCOLOS DE SEGURANÇA

### Palavra de Emergência
```
LIBERAR
```
Ativa o modo emergência no Guardian (CT 106) - aciona SAMU + Supervisor

### Comandos Guardian
```bash
/guard save        # Salvar estado
/guard emergencia  # Modo emergência
/guard normal      # Modo normal
/guard status      # Verificar status
```

### Red Lines (Requerem Autorização)
- ❌ Deletar arquivos
- ❌ Remover bancos de dados
- ❌ Formatar discos
- ❌ Remover containers
- ❌ Alterar credenciais

---

## 📞 CONTATOS DE EMERGÊNCIA

| Tipo | Contato |
|------|---------|
| **Stark (Maestro)** | CT 100 / 192.168.0.21 |
| **Supervisor** | CT 103 / 192.168.0.42 |
| **SAMU (Emergências)** | CT 107 / 192.168.0.64 |
| **DATASVR (Dados)** | CT 102 / 192.168.0.72 |
| **Telegram** | @Acib_Abbade |

---

## 📝 CHECKLIST PÓS-RECUPERAÇÃO

Após qualquer recuperação, verifique:

- [ ] Todos os 8 CTs estão ONLINE
- [ ] OpenClaw Gateway rodando em todos
- [ ] Ollama disponível e modelo carregado
- [ ] Samba acessível em \\192.168.0.72\lan
- [ ] Arquivos de memória presentes
- [ ] Telegram bot funcionando
- [ ] Email (MailBot) processando
- [ ] Supervisor monitorando
- [ ] Banco de dados financeiro acessível
- [ ] Backups automáticos configurados

---

## 🔄 SINCRONIZAÇÃO AUTOMÁTICA

Lembrete: Memórias são sincronizadas automaticamente a cada 60 minutos entre:
- Stark (CT 100)
- DATASVR (CT 102)
- Pendrive (/mnt/meu-pendrive/)

---

## ⚠️ ÚLTIMO RECURSO

Se TUDO falhar e você não tiver acesso a nada:

1. **Acesse o hardware fisicamente**
2. **Boot pelo pendrive Ventoy**
3. **Localize:** `Stark_Backup/`
4. **Recupere:** MEMORY.md, AGENTS.md, USER.md, SOUL.md, TOOLS.md
5. **Reconstrua** a partir destes arquivos

---

**Arquivo criado:** 2026-04-05 11:40  
**Última atualização:** 2026-04-05 11:40  
**Versão:** 1.0  

> 🆘 **GUARDE ESTE ARQUIVO COMO OURO. ELE É SEU PLANO DE EMERGÊNCIA.**
