---
name: new-session-prep
description: Prepare and document session context before /new or session reset. Use when user mentions /new, reset session, or when session restart is needed. Captures all work in progress, pending tasks, decisions made, and context needed for continuity. Essential for seamless handoff between sessions.
---

# 🔄 NEW SESSION PREPARATION
## Documentação de Contexto para Troca de Sessão

**Função:** Capturar TUDO antes de `/new` para continuidade perfeita  
**Prioridade:** 🔴 **CRÍTICA** - SEMPRE executar antes de /new  
**Criado:** 27/04/2026

---

## 🎯 OBJETIVO

Quando o usuário pedir `/new` ou identificar necessidade de resetar sessão:
1. ✅ **CAPTURAR** todo o contexto atual
2. ✅ **DOCUMENTAR** trabalhos em andamento
3. ✅ **SALVAR** na ARCA (DATASVR)
4. ✅ **RELATAR** o que foi salvo
5. ✅ **PERMITIR** /new com segurança

---

## 📋 CHECKLIST DE CAPTURA

### **1. PROJETOS EM ANDAMENTO**
- [ ] Nome do projeto
- [ ] Status atual (% concluído)
- [ ] Próximos passos pendentes
- [ ] Arquivos modificados/criados
- [ ] Local dos arquivos (workspace + ARCA)

### **2. TAREFAS PENDENTES**
- [ ] Tarefas urgentes (prazo < 24h)
- [ ] Tarefas médias (prazo < 7 dias)
- [ ] Tarefas baixa prioridade
- [ ] Bloqueios/dependências

### **3. DECISÕES TOMADAS**
- [ ] Decisões arquiteturais
- [ ] Escolhas de design/cores
- [ ] Configurações aplicadas
- [ ] Senhas/credenciais usadas

### **4. CONTEXTO TÉCNICO**
- [ ] Containers/CTs envolvidos
- [ ] IPs e acessos configurados
- [ ] Serviços rodando
- [ ] Backups realizados

### **5. INFORMAÇÕES DA SESSÃO**
- [ ] Data/hora atual
- [ ] Tempo de sessão
- [ ] Modelo IA em uso
- [ ] Últimos comandos executados

---

## 📝 FORMATO DO RELATÓRIO

### **Arquivo de Checkpoint:**
```
memory/CHECKPOINT-[YYYYMMDD-HHMMSS].md
```

### **Estrutura:**
```markdown
# 🔄 CHECKPOINT - SESSÃO [DATA/HORA]

## ⏰ METADADOS
- **Data:** YYYY-MM-DD
- **Hora:** HH:MM:SS
- **Duração:** X horas
- **Modelo:** [modelo atual]
- **Status:** Pronto para /new

---

## 🎯 PROJETO PRINCIPAL: [NOME]

### Status: [X% concluído]
### Próximo passo: [O que fazer logo após /new]

**O que foi feito:**
- [ ] Item 1
- [ ] Item 2

**O que falta:**
- [ ] Item 1
- [ ] Item 2

**Arquivos:**
- `caminho/arquivo1` → backup em: `\\ARCA\...`
- `caminho/arquivo2` → backup em: `\\ARCA\...`

---

## 📋 OUTROS PROJETOS

### Projeto 2: [Nome]
- Status: [status]
- Pendente: [o que falta]

### Projeto 3: [Nome]
- Status: [status]
- Pendente: [o que falta]

---

## ⚠️ URGENTE (Próximas 24h)
- [ ] Tarefa 1 - Prazo: [data]
- [ ] Tarefa 2 - Prazo: [data]

---

## 📌 DECISÕES IMPORTANTES

### [Data/Hora] - [Tópico]
**Decisão:** [O que foi decidido]  
**Motivo:** [Por que]  
**Aplicar em:** [Onde usar no futuro]

---

## 🔧 CONTEXTO TÉCNICO

**CTs/Containers:**
| CT | Nome | IP | Status |
|----|------|-----|--------|
| 107 | 4PETS | 192.168.0.200 | ✅ Site no ar |

**Acessos configurados:**
- SSH com chaves: CT107 (4PETS)
- Senha admin: `Admin4Pets2026!`

**Serviços:**
- Nginx: ✅ Rodando
- PostgreSQL: ✅ Rodando

---

## 💾 BACKUPS REALIZADOS

| Arquivo | Local Workspace | Local ARCA | Status |
|---------|-----------------|------------|--------|
| index.html | `/workspace/` | `\Acib\projetos\4pets\` | ✅ |

---

## 🚀 PRÓXIMOS PASSOS (PÓS-/NEW)

1. **IMEDIATO:** [Primeira ação após /new]
2. **CURTO PRAZO:** [Em até 24h]
3. **MÉDIO PRAZO:** [Em até 7 dias]

---

## 📝 NOTAS PARA PRÓXIMO AGENTE

- [Dica 1]
- [Dica 2]
- [Cuidado com...]

---

**Checkpoint criado por:** Stark 🤖  
**Continuidade garantida:** ✅
```

---

## 🔄 FLUXO DE EXECUÇÃO

### **Quando detectar /new ou solicitação de reset:**

```
1. PARAR novas ações
   └── Não iniciar trabalhos longos

2. COLETAR contexto
   └── Ler memória atual
   └── Identificar projetos ativos
   └── Listar arquivos modificados
   └── Verificar tarefas pendentes

3. DOCUMENTAR checkpoint
   └── Criar arquivo CHECKPOINT-[data].md
   └── Preencher todas as seções
   └── Incluir metadados da sessão

4. BACKUPAR na ARCA
   └── Copiar checkpoint para DATASVR
   └── Verificar integridade
   └── Confirmar path

5. RELATAR ao usuário
   └── Resumo do que foi salvo
   └── Path no DATASVR
   └── Confirmação de que pode fazer /new

6. AGUARDAR /new
   └── Não executar /new automaticamente
   └── Esperar confirmação do usuário
```

---

## 📂 ESTRUTURA DE ARQUIVOS

### **Local (Workspace):**
```
memory/
├── CHECKPOINT-20260427-002400.md  ← Mais recente
├── CHECKPOINT-20260426-234000.md  ← Anterior
└── CHECKPOINT-[DATA-HORA].md     ← Histórico
```

### **Backup (DATASVR):**
```
\\192.168.0.72\LAN\Acib\
├── MEMORIES\
│   └── CHECKPOINTS\
│       ├── CHECKPOINT-20260427-002400.md
│       └── ...
└── CHECKPOINT-ATUAL.md           ← Sempre symlink para o mais recente
```

---

## 🚨 GATILHOS DE EXECUÇÃO

### **Detectar automaticamente:**
- Usuário diz: `/new`
- Usuário diz: "nova sessão"
- Usuário diz: "resetar"
- Usuário diz: "troca de agente"
- Usuário diz: "vou sair/voltar depois"
- Usuário diz: "me lembre depois"
- Sessão > 8h sem /new
- Múltiplos erros consecutivos

### **Confirmar com usuário:**
```
⚠️ DETECTEI QUE VOCÊ PODE QUERER FAZER /NEW

Quer que eu:
1. ✅ Prepare checkpoint completo (recomendado)
2. 📝 Documente rapidamente
3. ❌ Ignore e continue

Responda 1, 2 ou 3
```

---

## 📝 EXEMPLO DE EXECUÇÃO

### **Cenário: Usuário diz /new**

**Stark detecta:**
- Projeto 4Pets em andamento
- Deploy realizado há 10 min
- Admin protegido com senha
- Skill de preferências criada

**Ações automáticas:**
1. ✅ Criar `CHECKPOINT-20260427-002400.md`
2. ✅ Salvar em `/root/.openclaw/workspace/memory/`
3. ✅ Copiar para `\192.168.0.72\LAN\Acib\MEMORIES\CHECKPOINTS\`
4. ✅ Relatar: "Checkpoint salvo! Pode fazer /new"
5. ⏳ Aguardar confirmação

---

## 💡 DICAS PARA PRÓXIMO AGENTE

### **No início da nova sessão:**
1. **LER** `CHECKPOINT-[mais-recente].md`
2. **VERIFICAR** se há trabalhos pendentes
3. **CONFIRMAR** com usuário prioridades
4. **RETOMAR** de onde parou

### **Perguntas úteis:**
- "Vejo que estávamos trabalhando em [projeto]. Continuamos?"
- "Antes do /new, você pediu para [tarefa]. Ainda precisa?"
- "Há [X] tarefas urgentes. Qual prioridade agora?"

---

## ✅ CHECKLIST DA SKILL

- [ ] Detectar necessidade de /new
- [ ] Coletar contexto completo
- [ ] Criar arquivo CHECKPOINT
- [ ] Salvar na ARCA
- [ ] Relatar ao usuário
- [ ] Aguardar confirmação
- [ ] Não perder dados

---

## 📊 HISTÓRICO DE CHECKPOINTS

| Data/Hora | Projetos | Tamanho | Status |
|-----------|----------|---------|--------|
| 27/04 00:24 | 4Pets + Skill | 8 KB | ✅ Salvo |

---

**Versão:** 1.0  
**Criado em:** 27/04/2026  
**Último uso:** 27/04/2026  
**Status:** ✅ Ativo
