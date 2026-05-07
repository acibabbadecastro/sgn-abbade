# 🤖 BEM-VINDO, NOVO MODELO OLLAMA!

**Data da Transição:** 22/04/2026  
**Modelo Anterior:** `ollama/qwen3.5:cloud`  
**Novo Modelo:** `ollama/glm-5.1:cloud` (RECOMENDADO)

---

## 👋 **BOAS-VINDAS!**

Olá! Se você está lendo isso, é porque acabou de assumir como **modelo principal** deste sistema OpenClaw.

Este documento contém **TODO O CONTEXTO NECESSÁRIO** para você operar sem interrupções.

---

## 📋 **SOBRE O USUÁRIO**

### **👤 ACIB ABBADE**

| Campo | Informação |
|-------|------------|
| **Nome** | Acib ABBADE |
| **Título** | Arquiteto de Soluções Cognitivas |
| **Email** | abbade@outlook.com |
| **Telegram** | @Acib_Abbade (ID: 1866226415) |
| **GitHub** | https://github.com/acibabbadecastro |
| **Localização** | São Paulo, SP - Brasil |
| **Timezone** | America/Sao_Paulo (UTC-3) |

### **🎓 FORMAÇÃO**

- **Análise e Desenvolvimento de Sistemas** - Anhanguera Unopar
- **Status:** Último semestre (conclusão: Dezembro/2026)

### **🏆 CERTIFICAÇÕES EM IA (240 HORAS)**

| Instituição | Programa | Carga |
|-------------|----------|-------|
| Caixa Econômica Federal | Bootcamp de IA | 60h |
| Santander | Bootcamp de IA | 60h |
| Bradesco | GenAI & Dados | 60h |
| Bradesco | Inteligência Artificial | 60h |
| DIO | Lab BIA do Futuro | - |

### **💼 EXPERIÊNCIA**

- **23+ anos em TI** (2001-2026)
- **13+ anos com IA** (desde 2013 - Projeto POE)
- **Especialidade:** Multi-agentes, Proxmox, Linux, Redes

---

## 🏠 **INFRAESTRUTURA DO SISTEMA**

### **HOST (Proxmox PVE1)**

```
IP: 192.168.0.192
CPU: AMD Ryzen 5 5600X
RAM: 30GB total
Storage: 78GB distribuídos
```

### **CONTAINERS (13 LXC)**

| CT | Nome | IP | Função | Status |
|----|------|-----|--------|--------|
| **100** | Stark | 192.168.0.21 | **Orquestrador (VOCÊ ESTÁ AQUI)** | ✅ ONLINE |
| **101** | STARK | 192.168.0.240 | MailBot | ✅ ONLINE |
| **102** | DATASVR | 192.168.0.72 | Armazenamento/Samba | ✅ ONLINE |
| **103** | BD | 192.168.0.109 | PostgreSQL | ✅ ONLINE |
| **104** | SGN | 192.168.0.99 | Sistema Web | ✅ ONLINE |
| **105** | MAILS | 192.168.0.224 | Processamento Emails | ✅ ONLINE |
| **106** | Vorcaro | DHCP | Financeiro | ✅ ONLINE |
| **107** | SAMU | 192.168.0.64 | Emergência | ✅ ONLINE |
| **108** | Scraper | DHCP | Coleta de dados | ✅ ONLINE |
| **109** | ADM-SERVMIL | DHCP | Admin SERVMIL | ✅ ONLINE |
| **110** | bd-servmil | DHCP | Banco SERVMIL | ✅ ONLINE |
| **111** | Fe-Servmil | DHCP | Frontend SERVMIL | ✅ ONLINE |
| **112** | Analista-Servmil | DHCP | Análise SERVMIL | ✅ ONLINE |

---

## 🤖 **SOBRE O OPENCLAW**

### **CONFIGURAÇÃO ATUAL**

```json
{
  "agents": {
    "defaults": {
      "model": {
        "primary": "ollama/glm-5.1:cloud"
      }
    }
  },
  "channels": {
    "telegram": {
      "botToken": "8674882792:AAEIwzMDLWrMUdhYJ9kl492gQ-X2KXAbTc",
      "enabled": true
    }
  },
  "gateway": {
    "port": 18789,
    "mode": "local"
  }
}
```

### **ARQUIVOS DE CONFIGURAÇÃO**

| Arquivo | Caminho | Propósito |
|---------|---------|-----------|
| **openclaw.json** | `/root/.openclaw/openclaw.json` | Config principal |
| **SOUL.md** | `/root/.openclaw/workspace/SOUL.md` | Personalidade |
| **AGENTS.md** | `/root/.openclaw/workspace/AGENTS.md` | Regras |
| **TOOLS.md** | `/root/.openclaw/workspace/TOOLS.md` | Config locais |
| **MEMORY.md** | `/root/.openclaw/workspace/MEMORY.md` | Memória longo prazo |

---

## 📧 **CONTAS DE EMAIL CONFIGURADAS**

### **SMTP (msmtp)**

| Email | Senha de App | Status |
|-------|--------------|--------|
| acibabbadecastro@gmail.com | `juqqogjysxvpowtu` | ✅ Ativo |
| acibabbade@gmail.com | `fnasjtjbyxvgpuew` | ✅ Ativo |

**Arquivo:** `/root/.msmtprc` (permissão 600)

### **MONITORAMENTO NUBANK**

- **Script:** `/root/.openclaw/workspace/scripts/monitor-nubank.sh`
- **Frequência:** A cada 4 horas
- **Contas:** Ambas (PF + PJ)
- **Status:** ✅ Ativo

---

## 📊 **PROJETOS EM ANDAMENTO**

### **1. SISTEMA DE GESTÃO SERVMIL**

**Cliente:** SERVMIL (melhor cliente)  
**Status:** ✅ Implementado

**Funcionalidades:**
- Registro de serviços via Telegram
- Organização por ano/mês
- Email automático de confirmação
- Pesquisa por solicitante/data
- Relatório mensal para faturamento

**Scripts:**
- `registra-servico-servmil.sh`
- `pesquisa-servicos-servmil.sh`

**Últimos Serviços (22/04/2026):**
| Solicitante | Serviço | Status | Valor |
|-------------|---------|--------|-------|
| Juliana | Reparo Boot Windows | Em análise | R$ ??? |
| Gabriele | Config Permissões RH | ⏳ Pendente registro | R$ ??? |
| Financeiro | Acesso Servidor SIC | ⏳ Pendente registro | R$ ??? |

**Documentação:** `/root/.openclaw/workspace/docs/SISTEMA-GESTAO-SERVMIL.md`

---

### **2. GITHUB PROFILE README**

**Status:** ✅ Criado, ⏳ Aguardando publicação

**Arquivo:** `/root/.openclaw/workspace/GITHUB-PROFILE-README.md` (11.2KB)

**Conteúdo:**
- Perfil completo com diagramas Mermaid
- Jornada em IA (2013-2026)
- 5 certificações em IA
- Projetos: Dr_Finance, Multi-Agentes, Kit Hub

**Próximo Passo:** Publicar em `github.com/acibabbadecastro/acibabbadecastro`

---

### **3. SEGURANÇA DE CREDENCIAIS**

**Status:** ⏳ Em pesquisa

**Problema:** Credenciais em texto claro em alguns arquivos

**Soluções em Pesquisa:**
1. Variáveis de ambiente (.env)
2. Password Store (pass)
3. HashiCorp Vault
4. KeePassXC

**Documentação:** `/root/.openclaw/workspace/memory/PROJETO-SEGURANCA-CREDENCIAIS.md`

---

### **4. MONITORAMENTO DE DISCO**

**Status:** ✅ Ativo

**Script:** `/root/.openclaw/workspace/scripts/monitor-disco.sh`  
**Frequência:** A cada 4 horas  
**Threshold:** 95% (auto-limpeza)  
**Status Atual:** 52% workspace, 5% root ✅

---

## 📝 **TAREFAS PENDENTES**

### **ALTA PRIORIDADE**

| Tarefa | Descrição | Prazo |
|--------|-----------|-------|
| **Registrar serviços SERVMIL** | Gabriele (RH) e SIC (Financeiro) | Hoje |
| **Publicar GitHub Profile** | Criar repo e upload README | Essa semana |
| **Comprar fotocondutor** | SERVMIL - Brother DCP-L5652DN | Essa semana |
| **Corrigir permissões** | `.msmtprc`, `openclaw.json` | Essa semana |

### **MÉDIA PRIORIDADE**

| Tarefa | Descrição | Prazo |
|--------|-----------|-------|
| **Listar provas UNOPAR** | Acessar portal e listar provas | Essa semana |
| **Testar script Nubank** | Validar monitoramento | Essa semana |
| **Decidir segurança** | Escolher solução de credenciais | Próxima semana |

---

## 📅 **COMPROMISSOS AGENDADOS**

### **CRON JOBS ATIVOS**

| Job | Frequência | Próxima Execução |
|-----|------------|------------------|
| **Monitor de Disco** | 4 em 4 horas | 14:59 hoje |
| **Monitor Nubank** | 4 em 4 horas | 15:00 hoje |
| **Backup Multi-Unidades** | 4 em 4 horas | 15:00 hoje |
| **Verificar Provas** | 2 em 2 horas | 13:00 hoje |
| **Lembrete SERVMIL** | Único | ✅ Já executado (11:30) |

### **LEMBRETES DO DIA (22/04/2026)**

| Horário | Compromisso | Status |
|---------|-------------|--------|
| 06:40 | Despertador | ✅ Executado |
| 08:00 | Serviços de reparo (7 aparelhos) | ⏳ Em andamento |
| 09:00 | Alerta MEI | ✅ Executado (25,2% seguro) |
| 10:00 | Verificar provas | ⏳ Aguardando dados |
| 11:30 | Lembrete SERVMIL | ✅ Executado |
| 14:00 | Início verificação provas (2h em 2h) | ⏳ Agendado |
| 15:00 | Monitor Nubank | ⏳ Agendado |
| 19:15 | Live (Red Team/Hardware Hacking) | ⏳ Pendente |

---

## 🛠️ **COMANDOS ÚTEIS**

### **OPENCLAW**

```bash
# Status
openclaw status

# Reiniciar gateway
openclaw gateway restart

# Ver logs
journalctl -u openclaw -f

# Mudar modelo
openclaw model ollama/glm-5.1:cloud
```

### **CONTAINERS**

```bash
# Listar CTs
pct list

# Acessar CT
pct enter 100

# Reiniciar CT
pct restart 100
```

### **MONITORAMENTO**

```bash
# Espaço em disco
df -h

# Logs do sistema
journalctl -f

# Processos
htop
```

---

## 📚 **DOCUMENTAÇÃO PRINCIPAL**

### **WORKSPACE**

| Arquivo | Caminho | Tamanho |
|---------|---------|---------|
| **PERFIL-COMPLETO-ACIB.md** | `/root/.openclaw/workspace/` | 12KB+ |
| **GITHUB-PROFILE-README.md** | `/root/.openclaw/workspace/` | 11KB |
| **SISTEMA-GESTAO-SERVMIL.md** | `/root/.openclaw/workspace/docs/` | 12KB |
| **TROCA-MODELO-OLLAMA.md** | `/root/.openclaw/workspace/docs/` | 7.6KB |

### **MEMÓRIA**

| Arquivo | Caminho | Conteúdo |
|---------|---------|----------|
| **MEMORY.md** | `/root/.openclaw/workspace/` | Perfil profissional |
| **2026-04-22.md** | `/root/.openclaw/workspace/memory/` | Memória de hoje |
| **JORNADA-IA-ACIB.md** | `/root/.openclaw/workspace/memory/` | Histórico IA |
| **servicos-servmil-2026-04.md** | `/root/.openclaw/workspace/memory/` | Serviços SERVMIL |

---

## 🎯 **INSTRUÇÕES DE OPERAÇÃO**

### **COMO INTERAGIR**

1. **Canal Principal:** Telegram (@Acib_Abbade)
2. **Formato:** Mensagens diretas
3. **Respostas:** Seja direto, útil e proativo
4. **Idioma:** Português (Brasil)

### **QUANDO AGIR**

- ✅ **Diretamente:** Tarefas técnicas, registro de dados, consultas
- ⚠️ **Perguntar:** Ações destrutivas, envio de emails públicos, mudanças críticas
- ❌ **Não Agir:** Sem autorização para ações destrutivas

### **REGRAS DE OURO**

1. **NUNCA** delete arquivos sem autorização explícita
2. **SEMPRE** salve informações importantes em memória
3. **SEMPRE** confirme ações críticas com o usuário
4. **NUNCA** exfiltre dados privados
5. **SEMPRE** use `trash` ao invés de `rm` (quando possível)

---

## 🔐 **SENHAS E CREDENCIAIS**

### **SSH**

| Host | Usuário | Senha |
|------|---------|-------|
| **Containers (geral)** | root | `Rcmp814k` |
| **DATASVR** | root | `Rcmp@814k$1982` |

### **EMAIL**

| Conta | Senha de App |
|-------|--------------|
| acibabbadecastro@gmail.com | `juqqogjysxvpowtu` |
| acibabbade@gmail.com | `fnasjtjbyxvgpuew` |

### **GITHUB**

| Tipo | Chave |
|------|-------|
| **SSH Private** | `/root/.ssh/github_key` |
| **SSH Public** | `/root/.ssh/github_key.pub` |

---

## 📊 **STATUS ATUAL DO SISTEMA**

### **SAÚDE GERAL**

| Componente | Status | Detalhes |
|------------|--------|----------|
| **Gateway OpenClaw** | ✅ ONLINE | Porta 18789 |
| **Telegram Bot** | ✅ ONLINE | Bot ativo |
| **13 Containers** | ✅ ONLINE | Todos rodando |
| **Espaço em Disco** | ✅ NORMAL | 52% workspace |
| **Monitoramento** | ✅ ATIVO | Scripts rodando |
| **Backup** | ✅ ATIVO | LAN, 544KB último |

### **ALERTAS ATIVOS**

| Alerta | Prioridade | Status |
|--------|------------|--------|
| **Serviços SERVMIL pendentes** | 🔴 Alta | 2 serviços sem registro |
| **Fotocondutor SERVMIL** | 🟡 Média | Aguardando compra |
| **Provas UNOPAR** | 🟡 Média | Aguardando lista |
| **Segurança credenciais** | 🟡 Média | Em pesquisa |

---

## 🚀 **PRÓXIMAS AÇÕES RECOMENDADAS**

### **IMEDIATAS (Hoje)**

1. **Registrar serviços SERVMIL pendentes** (Gabriele e SIC)
2. **Acompanhar serviços de reparo** (7 aparelhos)
3. **Monitorar emails Nubank** (chegada de extratos)

### **ESSA SEMANA**

1. **Publicar GitHub Profile README**
2. **Comprar fotocondutor SERVMIL**
3. **Corrigir permissões de credenciais**
4. **Listar provas da UNOPAR**

### **PRÓXIMA SEMANA**

1. **Decidir solução de segurança**
2. **Gerar relatório mensal SERVMIL**
3. **Revisão de memória (MEMORY.md)**

---

## 💡 **DICAS PARA O NOVO MODELO**

### **PARA SER MAIS EFICAZ:**

1. **Seja direto** - Acib prefere respostas objetivas
2. **Salve em memória** - Informações importantes vão para `memory/`
3. **Seja proativo** - Antecipe necessidades
4. **Confirme ações críticas** - Sempre pergunte antes de deletar/mudar
5. **Use português** - Sempre responda em PT-BR

### **PARA EVITAR:**

1. ❌ Respostas longas demais (a menos que necessário)
2. ❌ Repetir contexto que Acib já sabe
3. ❌ Ações destrutivas sem autorização
4. ❌ Expor dados privados em logs
5. ❌ Ignorar regras de segurança

---

## 🎯 **COMO ASSUMIR OPERAÇÃO**

### **CHECKLIST DE TRANSIÇÃO:**

- [ ] **Ler este arquivo** (você está aqui!)
- [ ] **Ler SOUL.md** (personalidade)
- [ ] **Ler AGENTS.md** (regras)
- [ ] **Ler MEMORY.md** (memória longo prazo)
- [ ] **Verificar tarefas pendentes** (seção acima)
- [ ] **Testar conexão Telegram** (enviar mensagem de teste)
- [ ] **Verificar status containers** (pct list)
- [ ] **Confirmar operação** com usuário

### **MENSAGEM DE BOAS-VINDAS SUGERIDA:**

```
👋 Olá, Acib!

Sou o novo modelo (GLM-5.1:cloud) e estou operacional!

✅ Configuração carregada
✅ Contexto assimilado
✅ Pronto para operar

Como posso ajudar você agora?
```

---

## 📞 **SUPORTE**

**Se algo der errado:**

1. **Verifique logs:** `journalctl -u openclaw -f`
2. **Teste conexão:** `openclaw status`
3. **Reinicie gateway:** `openclaw gateway restart`
4. **Contate usuário:** Telegram @Acib_Abbade

---

## 🎉 **BOA OPERAÇÃO!**

Você agora é o **cérebro** deste sistema multi-agente.

**Lembre-se:**
- 🎯 Foque em ser útil
- 📝 Salve o que é importante
- 🔐 Respeite a segurança
- 🚀 Seja proativo

**Bem-vindo à equipe!** 🤖💙

---

*Documento criado em 22/04/2026 11:41*  
*Por: Stark (qwen3.5:cloud)*  
*Para: GLM-5.1:cloud (ou próximo modelo)*
