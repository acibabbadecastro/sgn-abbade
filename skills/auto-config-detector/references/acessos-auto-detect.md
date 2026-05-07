# 🔐 ACESSOS AUTO-DETECTADOS
## Documentação Automática de Configurações

**Gerado:** 27/04/2026 01:15  
**Por:** auto-config-detector v1.0  
**Status:** ✅ Ativo e Funcionando

---

## 🎯 PARA NOVAS IAs

Quando uma nova IA/agente iniciar:

1. **LEIA ESTE ARQUIVO** (completo)
2. **VERIFIQUE VAULTs** em `~/.openclaw/secure/`
3. **CONFIRME COM USUÁRIO** antes de usar credenciais
4. **NUNCA EXPOHA SENHAS** em logs ou chat

**Mensagem padrão:**
> "Detectei suas configurações salvas. Posso usar [SERVIÇO] ou prefere confirmar?"

---

## 🖥️ INFRAESTRUTURA

### Proxmox (PVE1)
```yaml
detectado_em: ~/.ssh/config | MEMORY.md
host: 192.168.0.192
port: 8006
user: root
url: https://192.168.0.192:8006
ssh_key: ~/.ssh/id_ed25519
senha_location: ~/.openclaw/secure/pve-vault.md
container_ids: 100-112 (13 containers)
status: ✅ Funcionando
```

### DATASVR (CT 102) - ARCA
```yaml
detectado_em: MEMORY.md | TOOLS.md
host: 192.168.0.72
user: root
samba: \\\\192.168.0.72\\LAN\\
ssh_key: ~/.ssh/id_ed25519
senha_location: ~/.openclaw/secure/datasvr-vault.md
path_local: /home/master/LAN/
status: ✅ Online
```

### Containers Principais
| CT | Nome | IP | Função | Status |
|----|------|-----|--------|--------|
| 100 | Stark | 192.168.0.21 | Orquestrador | ✅ |
| 101 | MailBot | 192.168.0.240 | Emails/N8N | ✅ |
| 102 | DATASVR | 192.168.0.72 | Storage/Samba | ✅ |
| 103 | BD | 192.168.0.109 | PostgreSQL | ✅ |
| 104 | SGN | 192.168.0.99 | Sistema Web | ✅ |
| 105 | MAILS | 192.168.0.224 | Processamento | ✅ |
| 106 | Vorcaro | DHCP | Financeiro | ✅ |
| 107 | SAMU | 192.168.0.200 | 4Pets | ✅ |

---

## 🐙 DESENVOLVIMENTO

### GitHub
```yaml
detectado_em: ~/.gitconfig
user: acibabbadecastro
email: abbade@outlook.com
ssh_key: ~/.ssh/github_key
repos_detectados:
  - user-context-maximizer (skill pública)
  - dr-finance (agente financeiro)
  - kit-hub (documentação)
status: ✅ Configurado
vault: ~/.openclaw/secure/github-vault.md
```

### SSH Keys Disponíveis
```
~/.ssh/
├── id_ed25519        → CTs internos
├── github_key        → GitHub API
├── id_ed25519.pub    → Pública
└── known_hosts       → Hosts confiáveis
```

## 🌐 PROJETOS WEB

### Site Amigos de 4 Patas
```yaml
detectado_em: /var/www/ | RELATORIO-COMPLETO-SITE-4PETS.md
url: https://amigos4patas.com.br
host: CT 107 (192.168.0.200)
tech: Nginx + HTML/CSS/JS + Cloudflare
admin: https://amigos4patas.com.br/admin.php
admin_vault: ~/.openclaw/secure/4pets-admin-vault.md
status: ✅ Online | HTTP 200
```

---

## 📧 APLICATIVOS CONFIGURADOS

### Email (Himalaya)
```yaml
detectado_em: ~/.config/himalaya/config.toml
backend: IMAP/SMTP
provider: Outlook/Gmail
email: abbade@outlook.com
status: ✅ Configurado | Testado
```

### OpenClaw
```yaml
detectado_em: ~/.openclaw/workspace/
skills_installed: 6+
├── acib-preferences
├── new-session-detector
├── new-session-prep
├── context-preserver
├── user-context-maximizer
└── auto-config-detector (este)
status: ✅ Ativo
```

---

## 🚀 COMO USAR ESTA DOCUMENTAÇÃO

### Para Nova IA/Agente:

**Ao iniciar conversa com Acib:**

```
🤖 IA: "Olá! Detectei configurações prévias.

✅ Proxmox: 192.168.0.192 (configurado)
✅ DATASVR: 192.168.0.72 (configurado)
✅ GitHub: acibabbadecastro (SSH ready)
✅ 4Pets: Online

Posso acessar estas ferramentas ou prefere 
que eu pergunte antes de cada uso?"
```

### Para Comandos:

**SSH para CT:**
```bash
# Usar key existente
ssh -i ~/.ssh/id_ed25519 root@192.168.0.72

# Ou sshpass (se necessário)
sshpass -p $(grep -A1 "# Senha" ~/.openclaw/secure/datasvr-vault.md | tail -1) \
  ssh root@192.168.0.72
```

**GitHub push:**
```bash
# Já configurado
# git remote add origin git@github.com:acibabbadecastro/REPO.git
# git push
```

---

## 🔄 ATUALIZAÇÃO

**Quando executar novamente:**
- Nova configuração criada
- Nova senha/key adicionada
- Novo projeto iniciado
- Após /new (detectar mudanças)

**Comando:**
```bash
cd ~/.openclaw/workspace/skills/auto-config-detector
./scripts/scan-configs.sh --full && \
./scripts/extract-creds.sh --safe-mode && \
./scripts/generate-report.sh
```

---

## ✅ CHECKLIST PARA NOVA IA

- [ ] Ler este arquivo (acessos-auto-detect.md)
- [ ] Verificar vaults em ~/.openclaw/secure/
- [ ] Confirmar com Acib antes de usar credenciais
- [ ] NUNCA logar senhas completas
- [ ] Usar [VAULT: path] quando referenciar

---

**Documento gerado automaticamente por auto-config-detector**  
*Em caso de dúvidas: Ver MASTER.md ou perguntar ao usuário*

