# 📧 BACKUP MAILBOT (CT 101) - CONFIGURAÇÃO COMPLETA
**Criado:** 2026-04-05 11:56  
**Status:** Container será EXCLUÍDO  
**Propósito:** Backup de todas as configurações para recriação futura

---

## 🖥️ INFORMAÇÕES DO SISTEMA

| Campo | Valor |
|-------|-------|
| **CT** | 101 |
| **Nome** | MailBot |
| **IP** | 192.168.0.240 |
| **Hostname** | mailbot |
| **Gateway Port** | 18789 |
| **OpenClaw Token** | 507de523881f4ba3b8647da3aa4f80408c34013b6f478ec0 |
| **Versão OpenClaw** | 2026.4.2 |
| **Modelo AI** | ollama/minimax-m2.7:cloud |

---

## 🔐 CREDENCIAIS

### OpenClaw Gateway
```json
{
  "gateway": {
    "auth": {
      "mode": "token",
      "token": "507de523881f4ba3b8647da3aa4f80408c34013b6f478ec0"
    },
    "mode": "local"
  },
  "meta": {
    "lastTouchedVersion": "2026.4.2",
    "lastTouchedAt": "2026-04-03T22:12:15.067Z"
  },
  "plugins": {
    "entries": {
      "telegram": {
        "enabled": true
      }
    }
  },
  "channels": {
    "telegram": {
      "enabled": true,
      "botToken": "8674882792:AAEIwzMDLWrMUdhYJ9qlk492gQ-X2KXAbTc"
    }
  },
  "agents": {
    "defaults": {
      "model": {
        "primary": "ollama/minimax-m2.7:cloud"
      }
    }
  }
}
```

### Telegram
- **Bot Token:** 8674882792:AAEIwzMDLWrMUdhYJ9qlk492gQ-X2KXAbTc
- **Status:** Ativo
- **Pairing:** telegram-pairing.json (em /root/.openclaw/credentials/)

---

## 📦 PACOTES INSTALADOS (Importantes para Email)

```
getmail6                    # Mail retriever (POP3, IMAP4)
neomutt                     # Command line mail reader
postfix                     # Mail transport agent (MTA)
python3-imapclient          # Python IMAP client library
libnotmuch5                # Email index/search/tagging
mailcap                    # Mailcap system
```

---

## 📁 ESTRUTURA DE DIRETÓRIOS

### /root/.openclaw/
```
/root/.openclaw/
├── canvas/                          # Canvas data
├── credentials/
│   └── telegram-pairing.json       # Telegram pairing info
├── devices/                         # Device configs
├── identity/
│   ├── device-auth.json            # Device authentication
│   └── device.json                 # Device identity
├── logs/                            # OpenClaw logs
├── tasks/                           # Background tasks
├── telegram/
│   ├── command-hash-default-b6492c66b1482a13.txt
│   └── update-offset-default.json   # Telegram message offset
├── openclaw.json                    # Main config
├── openclaw.json.bak               # Backup v1
├── openclaw.json.bak.1             # Backup v2
├── openclaw.json.bak.2             # Backup v3
├── openclaw.json.bak.3             # Backup v4
├── openclaw.json.bak.4             # Backup v5
└── update-check.json               # Update info
```

---

## 🔧 SERVIÇOS E PROCESSOS

### Processos em Execução
```
/usr/bin/node /usr/lib/node_modules/openclaw/dist/index.js gateway --port 18789
```

### Crons
- **Nenhum crontab configurado**

### Serviços SystemD
- OpenClaw rodando manualmente (não como serviço systemd)

---

## 🌐 CONFIGURAÇÃO DE REDE

```
Interface: eth0@if8
MAC: bc:24:11:c1:e3:b8
IP: 192.168.0.240/24
Gateway: 192.168.0.1 (implied)
Broadcast: 192.168.0.255
DNS: (via DHCP)
```

---

## 🔑 SSH HOST KEYS (Para reconhecimento)

```
ECDSA:   SHA256:kqQuAOZ7KSrhDnSTlLpADK+CcfyOa6EsrL+0IEFiPJo
RSA:     SHA256:XYZnEs8NkZGOpAB+4nGiuUOn+8IQ5pDO3buE1ADiUBw
ED25519: SHA256:PCvj099Hr6c37U2BE75Jim9/i/+94DAyWunDmH3aL4Q
```

---

## 📝 PASSOS PARA RECRIAR MAILBOT

### 1. Criar Container
```bash
pct create 101 /var/lib/vz/template/cache/ubuntu-24.04-standard.tar.zst \
  --hostname mailbot \
  --storage local-zfs \
  --rootfs 20 \
  --memory 4096 \
  --swap 2048 \
  --net0 name=eth0,bridge=vmbr0,ip=192.168.0.240/24,gw=192.168.0.1
```

### 2. Instalar Dependências
```bash
apt update
apt install -y getmail6 neomutt postfix python3-imapclient
```

### 3. Instalar OpenClaw
```bash
npm install -g openclaw
```

### 4. Configurar OpenClaw
Criar `/root/.openclaw/openclaw.json` com o conteúdo acima.

### 5. Configurar Diretórios
```bash
mkdir -p /root/.openclaw/{credentials,devices,identity,logs,tasks,telegram}
chmod 700 /root/.openclaw/credentials
```

### 6. Iniciar Gateway
```bash
openclaw gateway --port 18789
```

---

## 🗂️ DADOS DE EMAIL (Processamento)

**Nota:** O MailBot processava emails de:
- acibabbadecastro@gmail.com (553+ emails)
- infoacib@gmail.com (configurado mas inativo)

**Scripts de processamento:** Verificar em `/home/master/LAN/Emails/` no DATASVR

---

## ⚠️ NOTAS IMPORTANTES

1. **Token OpenClaw é diferente** do Stark (CT 100 usa token diferente)
2. **Telegram Bot Token é o MESMO** usado pelo Stark (@acibclawd_bot)
3. **Sem workspace personalizado** - MailBot não tinha arquivos .md customizados
4. **Função:** Processamento de emails IMAP, download de anexos, classificação

---

## 📞 CONTATO E RECUPERAÇÃO

| Item | Valor |
|------|-------|
| **Container original** | CT 101 (será excluído) |
| **IP** | 192.168.0.240 |
| **Senha Root** | Rcmp814k@# |
| **Acesso** | sshpass -p 'Rcmp814k@#' ssh root@192.168.0.240 |

---

**Backup criado em:** 2026-04-05 11:56  
**Status:** Aguardando exclusão do container  
**Próximo passo:** Recriar quando necessário usando este guia

---

> ⚠️ **ATENÇÃO:** Este container será EXCLUÍDO. Salve este arquivo em local seguro!
