# 🔐 PROJETO: SEGURANÇA DE CREDENCIAIS

**Data de Criação:** 22/04/2026  
**Prioridade:** 🔴 **ALTA**  
**Status:** ⏳ **Em Planejamento**

---

## 🎯 **OBJETIVO**

Implementar sistema seguro para armazenamento de credenciais, chaves de acesso e tokens sensíveis, eliminando texto claro em arquivos de configuração.

---

## 📊 **SITUAÇÃO ATUAL (DIAGNÓSTICO)**

### **Arquivos com Credenciais em Texto Claro:**

| Arquivo | Local | Conteúdo Sensível | Risco |
|---------|-------|-------------------|-------|
| **`.msmtprc`** | `/root/.msmtprc` | SMTP password | 🔴 Alto |
| **`openclaw.json`** | `/root/.openclaw/openclaw.json` | Telegram bot token, Gateway token | 🔴 Alto |
| **`TOOLS.md`** | `/root/.openclaw/workspace/TOOLS.md` | Senhas SSH, Samba | 🟡 Médio |
| **`HEARTBEAT.md`** | `/root/.openclaw/workspace/HEARTBEAT.md` | Senhas SSH containers | 🟡 Médio |

### **Arquivos com Permissões Incorretas:**

| Arquivo | Permissão Atual | Permissão Ideal | Status |
|---------|-----------------|-----------------|--------|
| `/root/.msmtprc` | 644 (legível) | 600 (só root) | ❌ Crítico |
| `/root/.openclaw/openclaw.json` | 644 | 600 | ❌ Crítico |
| `/root/.ssh/github_key` | 600 | 600 | ✅ OK |
| `/root/.ssh/id_ed25519` | 600 | 600 | ✅ OK |

---

## 🎯 **SOLUÇÕES EM PESQUISA**

### **Opção 1: Variáveis de Ambiente (.env)**

**Vantagens:**
- ✅ Simples de implementar
- ✅ Amplamente adotado
- ✅ Fácil integração
- ✅ Separa código de configuração

**Desvantagens:**
- ⚠️ Arquivo .env ainda em texto claro
- ⚠️ Precisa de permissões corretas
- ⚠️ Vaza em logs se não tomar cuidado

**Implementação:**
```bash
# /root/.openclaw/.env (chmod 600)
SMTP_PASSWORD=juqqogjysxvpowtu
TELEGRAM_BOT_TOKEN=8674882792:AAEI...
GATEWAY_TOKEN=84c98cf437f9...
SSH_PASSWORD=Rcmp814k
DATASVR_PASSWORD=Rcmp@814k$1982
```

```json
// openclaw.json
{
  "channels": {
    "telegram": {
      "botToken": "${TELEGRAM_BOT_TOKEN}"
    }
  }
}
```

---

### **Opção 2: Password Store (`pass`)**

**Vantagens:**
- ✅ Criptografia GPG forte
- ✅ Hierarquia de pastas
- ✅ CLI simples
- ✅ Integração com scripts

**Desvantagens:**
- ⚠️ Curva de aprendizado
- ⚠️ Precisa de GPG configurado
- ⚠️ Mais complexo para automação

**Implementação:**
```bash
# Instalar
apt install pass

# Inicializar
pass init "acibabbadecastro@gmail.com"

# Adicionar credenciais
pass insert Email/SMTP_Password
pass insert Telegram/Bot_Token
pass insert SSH/Containers_Password

# Usar em scripts
SMTP_PASS=$(pass Email/SMTP_Password)
```

---

### **Opção 3: HashiCorp Vault**

**Vantagens:**
- ✅ Enterprise-grade
- ✅ Audit trail
- ✅ Rotação automática
- ✅ Controle de acesso fino
- ✅ API REST

**Desvantagens:**
- ⚠️ Overkill para uso local
- ⚠️ Complexo de configurar
- ⚠️ Consome recursos
- ⚠️ Curva de aprendizado alta

**Implementação:**
```bash
# Rodar Vault em container
docker run -d --name vault -p 8200:8200 vault server-dev

# Acessar via CLI
vault kv put secret/email/smtp password=juqqogjysxvpowtu
vault kv get -field=password secret/email/smtp
```

---

### **Opção 4: KeePassXC (Arquivo Criptografado)**

**Vantagens:**
- ✅ Arquivo único criptografado
- ✅ GUI amigável
- ✅ CLI disponível (`keepassxc-cli`)
- ✅ Multi-plataforma
- ✅ Backup fácil

**Desvantagens:**
- ⚠️ Precisa de senha mestra
- ⚠️ CLI menos intuitiva
- ⚠️ Não é feito para automação

**Implementação:**
```bash
# Criar banco
keepassxc-cli create /root/.passwords.kdbx

# Adicionar entradas
keepassxc-cli add /root/.passwords.kdbx "Email/SMTP"

# Ler em scripts
keepassxc-cli show /root/.passwords.kdbx "Email/SMTP" --password
```

---

### **Opção 5: SSH Secrets + OpenClaw Native**

**Vantagens:**
- ✅ Integrado com OpenClaw
- ✅ Usa infraestrutura existente
- ✅ Menos dependências externas

**Desvantagens:**
- ⚠️ Limitado ao ecossistema OpenClaw
- ⚠️ Em desenvolvimento

---

## 📋 **REQUISITOS DO SISTEMA**

### **Funcionais:**
- [ ] Armazenar senhas/tokens de forma criptografada
- [ ] Recuperar credenciais via CLI/scripts
- [ ] Suportar múltiplos serviços (SMTP, SSH, API, etc.)
- [ ] Permitir rotação de credenciais
- [ ] Backup e recuperação

### **Não-Funcionais:**
- [ ] Permissões restritas (600 ou menos)
- [ ] Sem texto claro em repositórios
- [ ] Baixo overhead de performance
- [ ] Fácil automação em scripts Bash/Python
- [ ] Documentação clara

---

## 🎯 **CRITÉRIOS DE DECISÃO**

| Critério | Peso | Opção 1 | Opção 2 | Opção 3 | Opção 4 |
|----------|------|---------|---------|---------|---------|
| **Segurança** | 30% | ⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ |
| **Simplicidade** | 25% | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ | ⭐⭐ | ⭐⭐⭐ |
| **Automação** | 20% | ⭐⭐⭐⭐ | ⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐ |
| **Manutenção** | 15% | ⭐⭐⭐⭐ | ⭐⭐⭐ | ⭐⭐ | ⭐⭐⭐⭐ |
| **Recursos** | 10% | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐ | ⭐⭐⭐⭐ |

---

## 📅 **ROADMAP DO PROJETO**

### **Fase 1: Correções Imediatas (1 dia)**
- [ ] `chmod 600` em arquivos críticos
- [ ] Listar todas as credenciais expostas
- [ ] Criar backup seguro das credenciais atuais

### **Fase 2: Pesquisa e Decisão (2-3 dias)**
- [ ] Testar Opção 1 (.env)
- [ ] Testar Opção 2 (pass)
- [ ] Testar Opção 4 (KeePassXC)
- [ ] Decidir solução final
- [ ] Documentar decisão

### **Fase 3: Implementação (3-5 dias)**
- [ ] Configurar solução escolhida
- [ ] Migrar todas as credenciais
- [ ] Atualizar scripts e configs
- [ ] Testar integrações
- [ ] Validar automação

### **Fase 4: Hardening (2-3 dias)**
- [ ] Implementar rotação de senhas
- [ ] Configurar backup automático
- [ ] Criar documentação de uso
- [ ] Treinar agentes na nova sistemática

### **Fase 5: Monitoramento (Contínuo)**
- [ ] Verificar vazamentos em commits
- [ ] Auditar permissões periodicamente
- [ ] Revisar credenciais a cada 90 dias

---

## 🔬 **PESQUISAS EM ANDAMENTO**

### **Tópicos para Pesquisar:**

1. **Como OpenClaw lida com variáveis de ambiente?**
   - Suporta `${VAR}` em JSON?
   - Há hook nativo para secrets?

2. **Qual o melhor custo-benefício para nosso caso?**
   - 13 containers + serviços locais
   - Múltiplas credenciais por serviço

3. **Como integrar com agentes autônomos?**
   - Agentes precisam acessar credenciais
   - SSH, SMTP, API calls

4. **Backup de secrets:**
   - Como fazer backup criptografado?
   - Onde armazenar chaves de descriptografia?

---

## 📊 **INVENTÁRIO DE CREDENCIAIS (PARA MIGRAR)**

| Serviço | Tipo | Credencial | Local Atual |
|---------|------|------------|-------------|
| **Gmail SMTP** | Email | `juqqogjysxvpowtu` | `.msmtprc` |
| **Telegram Bot** | API Token | `8674882792:AAEI...` | `openclaw.json` |
| **Gateway** | Auth Token | `84c98cf437f9...` | `openclaw.json` |
| **SSH Containers** | Senha | `Rcmp814k` | `HEARTBEAT.md` |
| **DATASVR Samba** | Senha | `Rcmp@814k$1982` | `TOOLS.md` |
| **GitHub SSH** | Chave Privada | `/root/.ssh/github_key` | ✅ OK |
| **Proxmox** | Senha root | `???` | ⚠️ Não documentado |
| **UNOPAR** | Login/Senha | `???` | ⚠️ Não documentado |
| **Nubank** | Login/Senha | `???` | ⚠️ Não documentado |

---

## 🎯 **PRÓXIMOS PASSOS**

| Ação | Responsável | Prazo | Status |
|------|-------------|-------|--------|
| **Corrigir permissões** | Stark | 22/04/2026 | ⏳ Pendente |
| **Testar .env** | Stark | 23/04/2026 | ⏳ Pendente |
| **Testar `pass`** | Stark | 24/04/2026 | ⏳ Pendente |
| **Decidir solução** | Acib | 25/04/2026 | ⏳ Pendente |
| **Implementar** | Stark | 26-30/04/2026 | ⏳ Pendente |

---

## 📚 **REFERÊNCIAS**

- [12 Factor App - Config](https://12factor.net/config)
- [Linux Password Store](https://www.passwordstore.org/)
- [HashiCorp Vault](https://www.vaultproject.io/)
- [KeePassXC](https://keepassxc.org/)
- [OpenClaw Security Best Practices](https://docs.openclaw.ai/security)

---

*Documento criado em 22/04/2026*
*Última atualização: 22/04/2026*
