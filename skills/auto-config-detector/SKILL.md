---
name: auto-config-detector
description: Automatically detect, scan, and document all existing configurations, credentials, API keys, SSH keys, and access tokens from the system. Use when you want to avoid repeatedly providing logins, passwords, and keys to AI assistants. The skill scans standard locations (.env, .ssh/, config files, environment variables), extracts credentials securely, and auto-documents them for future AI sessions without exposing sensitive data in plain text.
---

# 🔍 AUTO CONFIG DETECTOR
## Detector Automático de Configurações e Acessos

**Função:** Varre o sistema, detecta credenciais/configs existentes e documenta automaticamente  
**Prioridade:** 🔴 **ALTA** - Execução única ou periódica  
**Criado:** 27/04/2026

---

## 🎯 OBJETIVO

Eliminar a necessidade de **repetir logins, senhas, keys e URLs** toda vez que uma nova IA/Agente iniciar.

**Problema:**
```
Nova IA: "Qual a senha do Proxmox?"
Você: "Rcmp814k@#"

Nova IA: "Como acesso o DATASVR?"
Você: "IP 192.168.0.72, senha Rcmp@814k$1982"

Nova IA: "GitHub token?"
Você: "ghp_xxxxxxxx..."
```

**Solução:**
```
Nova IA: "Detectei suas configurações. Posso usar?"
✅ Proxmox: Configurado
✅ DATASVR: Configurado  
✅ GitHub: Configurado
✅ SSH Keys: 3 chaves encontradas
```

---

## 🔧 O QUE DETECTA

### **1. SSH Keys**
```bash
~/.ssh/
├── id_rsa          → Servidor X
├── id_ed25519      → Proxmox/Github
├── github_key      → GitHub API
└── known_hosts     → Hosts confiáveis
```

### **2. Environment Variables**
```bash
~/.bashrc | ~/.zshrc | ~/.profile
├── DATABASE_URL
├── API_KEYS
├── TOKENS
└── SSH_AGENT
```

### **3. Config Files**
```
~/.config/
├── git/config          → User/Email Git
├── himalaya/config.toml → IMAP/SMTP
├── openclaw/
└── outros apps
```

### **4. Dotenv Files**
```bash
./.env | ./.env.local | ./.env.production
├── DB_HOST, DB_PASS
├── API_KEY_XYZ
├── SECRET_KEY
└── SERVICE_URLS
```

### **5. Application Configs**
```
/var/www/*/config.php     → DBs web
/etc/nginx/sites-enabled/ → Domínios/VHosts
/etc/hosts                → IPs estáticos
~/.my.cnf                 → MySQL/MariaDB
```

### **6. URLs e Endpoints**
```
https://github.com/acibabbadecastro/...
https://amigos4patas.com.br
https://192.168.0.192:8006 (PVE)
https://192.168.0.72 (DATASVR)
```

---

## 🛡️ SEGURANÇA

### **NUNCA expõe em plain text:**
- ❌ Senhas completas nos logs
- ❌ Keys em mensagens de chat
- ❌ Tokens em arquivos não criptografados

### **Referencia segura:**
```yaml
proxmox:
  host: 192.168.0.192
  user: root
  # SENHA: Ver arquivo: ~/.openclaw/secure/pve-vault.md
  # Acesso: sshpass -p $(cat ~/.secure/pve)
```

### **Vault Local:**
```
~/.openclaw/secure/
├── pve-vault.md      (chmod 600)
├── datasvr-vault.md  (chmod 600)
├── github-vault.md   (chmod 600)
└── master-vault.md   (index de todos)
```

---

## 📋 ESTRUTURA DE DOCUMENTAÇÃO

### **Arquivo Gerado:** `references/acessos-auto-detect.md`

```markdown
# 🔐 ACESSOS AUTO-DETECTADOS
## Gerado: 27/04/2026 01:15
## Por: auto-config-detector v1.0

---

## 🖥️ INFRAESTRUTURA

### Proxmox (PVE1)
```yaml
detectado_em: /root/.ssh/config
host: 192.168.0.192
user: root
senha_location: ~/.openclaw/secure/pve-vault.md
acesso_ssh: ssh root@192.168.0.192
chave_ssh: ~/.ssh/id_ed25519
status: ✅ Funcionando
```

### DATASVR (CT 102)
```yaml
detectado_em: /root/.ssh/known_hosts
host: 192.168.0.72
user: root
senha_location: ~/.openclaw/secure/datasvr-vault.md
acesso_samba: \\192.168.0.72\LAN\
acesso_ssh: ssh root@192.168.0.72
status: ✅ Funcionando
```

## 🐙 DESENVOLVIMENTO

### GitHub
```yaml
detectado_em: ~/.gitconfig
user: acibabbadecastro
email: abbade@outlook.com
ssh_key: ~/.ssh/github_key
repositorios:
  - user-context-maximizer
  - dr-finance
  - kit-hub
status: ✅ Configurado
```

## 🌐 PROJETOS WEB

### Site 4Pets
```yaml
detectado_em: /var/www/amigos4patas/
url: https://amigos4patas.com.br
host: CT 107 (192.168.0.200)
tech: Nginx + HTML/CSS/JS
deploy: Cloudflare Tunnel
status: ✅ Online
```

## 📧 COMUNICAÇÃO

### Email (Himalaya)
```yaml
detectado_em: ~/.config/himalaya/config.toml
backend: IMAP/SMTP
email: abbade@outlook.com
status: ✅ Configurado
```

---

## 🚀 PARA NOVAS IAs

Quando uma nova IA iniciar, ela DEVE:
1. Ler este arquivo
2. Verificar vaults em ~/.openclaw/secure/
3. Confirmar acessos com usuário ANTES de usar
4. NUNCA expor senhas em logs/chat

**Mensagem padrão:**
"Detectei suas configurações em [ARQUIVO]. 
Posso usar [SERVIÇO] ou prefere confirmar?"
```

---

## 🔄 WORKFLOW DE DETECÇÃO

```
[Iniciar Skill]
    ↓
[Scan Phase 1] → SSH keys, known_hosts
    ↓
[Scan Phase 2] → .env files, config files
    ↓
[Scan Phase 3] → Environment variables
    ↓
[Scan Phase 4] → Application configs (nginx, php, etc)
    ↓
[Validar] → Testar conectividade (ping, curl)
    ↓
[Documentar] → Gerar acessos-auto-detect.md
    ↓
[Vault] → Mover senhas para ~/.openclaw/secure/
    ↓
[Backup] → Sync para DATASVR
    ↓
[Report] → Resumo para usuário
```

---

## 📊 EXEMPLO DE SAÍDA

### **Para Usuário:**
```
🔍 AUTO CONFIG DETECTOR - Resultado

✅ Detectado e Documentado:
├─ 🔑 3 SSH keys
├─ 🖥️  8 servidores/containers
├─ 🐙 GitHub (acibabbadecastro)
├─ 🌐 1 site em produção
├─ 📧 1 conta de email
└─ 🔐 12 credenciais (vault seguro)

⚠️  Necessita atenção:
├─ CT 109-112: Configuráveis (não ativos)
└─ Algumas .env: Não testadas

📁 Documentação: references/acessos-auto-detect.md
🔒 Vault: ~/.openclaw/secure/
💾 Backup: \\192.168.0.72\LAN\Acib\skills\

🤔 Nova IA pode usar estas configs?
[Sim, todas] [Escolher] [Não, manual]
```

---

## 🛠️ SCRIPTS INCLUSOS

### **1. scan-configs.sh**
```bash
# Varre todo o sistema por configs
./scripts/scan-configs.sh --full

# Output: lista de arquivos encontrados
```

### **2. extract-creds.sh**
```bash
# Extrai e vaulta credenciais
./scripts/extract-creds.sh --safe-mode

# Move senhas para ~/.openclaw/secure/
# Substitui originais por [VAULT: path]
```

### **3. validate-access.sh**
```bash
# Testa se acessos funcionam
./scripts/validate-access.sh

# Ping, curl, ssh-test sem login real
```

### **4. generate-report.sh**
```bash
# Gera documentação final
./scripts/generate-report.sh

# Cria acessos-auto-detect.md
```

---

## 🎯 INTEGRAÇÃO COM OUTRAS SKILLS

```
auto-config-detector
    ↓
acib-preferences (acessos.md) ← Atualizado
    ↓
new-session-prep ← Inclui no checkpoint
    ↓
context-preserver ← Sync para DATASVR
    ↓
Nova IA lê → Não pergunta login/senha!
```

---

## 📋 CHECKLIST DE EXECUÇÃO

- [ ] Scan SSH keys (~/.ssh/)
- [ ] Scan git configs (~/.gitconfig, ~/.config/git/)
- [ ] Scan dotenv files (find . -name ".env*")
- [ ] Scan shell configs (.bashrc, .zshrc, .profile)
- [ ] Scan app configs (/var/www/, /etc/nginx/, ~/.config/)
- [ ] Scan known_hosts
- [ ] Scan OpenClaw configs
- [ ] Testar conectividade básica
- [ ] Extrair e vaultar senhas
- [ ] Gerar documentação
- [ ] Backup para DATASVR
- [ ] Reportar para usuário

---

## ⚡ USO RÁPIDO

```bash
# Scan completo (5-10 min)
./scripts/scan-configs.sh --full && \
./scripts/extract-creds.sh --safe-mode && \
./scripts/generate-report.sh

# Resultado: Tudo documentado, vaultado e backupado!
```

---

## 🔄 AUTO-UPDATE

**Recomendado:** Executar a cada:
- Nova instalação de ferramenta
- Nova configuração de serviço
- Mudança de senha/key
- Nova sessão /new (detectar novas configs)

---

**Nunca mais forneça login/senha repetidamente!** 🚀
