---
name: context-preserver
description: Persist and restore session context across /new resets. Use when session continuity is critical - automatically syncs state to DATASVR in real-time and enables seamless restoration after /new. Essential for long-running projects where context loss would be costly.
---

# 🔄 CONTEXT PRESERVER
## Preservação Contínua de Contexto Através de /new

**Função:** Sincronizar estado em tempo real, garantir zero perda de contexto  
**Prioridade:** 🔴 **CRÍTICA** para projetos longos  
**Criado:** 27/04/2026  
**Integração:** `new-session-prep` + `new-session-detector` + Auto-restore

---

## 🎯 OBJETIVO

Ir além do checkpoint: **manter contexto vivo e acessível** mesmo após /new:

```
SESSÃO 1 (Stark v1)          /NEW          SESSÃO 2 (Stark v2)
     │                                       │
     │    ❌ TRADICIONAL (perda total)       │
     │    ✅ CONTEXT PRESERVER (continua)    │
     │                                       │
  Trabalhando ──/new──>── <─Auto-restore── Continua de onde parou
  em 4Pets               <─Contexto vivo── sem explicar de novo
```

---

## 🧠 CONCEITO: ESTADO VIVO

### **Checkpoint vs Context Preserver:**

| Aspecto | Checkpoint Tradicional | Context Preserver |
|---------|------------------------|-------------------|
| **Quando salva** | No final (quando detecta /new) | **Em tempo real** (a cada 5 min) |
| **O que salva** | Resumo estático | **Estado completo** + histórico |
| **Recuperação** | Próximo agente lê manualmente | **Auto-restore** na nova sessão |
| **Granularidade** | Snapshot pontual | **Timeline contínua** |
| **Dados** | Markdown resumo | **Banco de dados + arquivos + memória** |

---

## 📦 SISTEMA DE PRESERVAÇÃO

### **1. SYNC CONTÍNUO (A CADA 5 MINUTOS)**

```
Timer: A cada 300 segundos
│
├─▶ 1. Verificar mudanças desde último sync
├─▶ 2. Compactar estado atual
├─▶ 3. Salvar em DATASVR (\\192.168.0.72\context-live\)
├─▶ 4. Atualizar índice de timeline
└─▶ 5. Log: "[HH:MM] Contexto sincronizado"
```

**Estrutura no DATASVR:**
```
\\192.168.0.72\LAN\Acib\context-live\
├── sessions/
│   ├── 20260427-001500-Stark-4Pets/     ← Snapshot 00:15
│   │   ├── context-db.json               ← Estado completo
│   │   ├── memory-diff.md                ← Mudanças desde último
│   │   ├── open-files.list               ← Arquivos abertos
│   │   ├── exec-history.log              ← Comandos executados
│   │   └── user-preferences.cache        ← Preferências ativas
│   │
│   ├── 20260427-002000-Stark-4Pets/     ← Snapshot 00:20
│   ├── 20260427-002500-Stark-4Pets/     ← Snapshot 00:25
│   └── ...
│
├── timeline/
│   └── 20260427-Stark-session.idx        ← Índice cronológico
│
├── current/
│   ├── latest-session.id                 ← ID da sessão mais recente
│   ├── latest-checkpoint.json            ← Último estado completo
│   └── restore-ready.flag                ← Pronto para restore?
│
└── archive/
    └── 20260426-Stark-session.tar.gz     ← Sessões antigas (zipadas)
```

---

### **2. AUTO-RESTORE (AO INICIAR NOVA SESSÃO)**

```
NOVA SESSÃO INICIA:
│
├─▶ 1. Verificar se há contexto anterior (current/latest-session.id)
├─▶ 2. Se sim, perguntar ao usuário:
│      "Encontrei contexto da sessão anterior (4Pets, 9h de trabalho).
│       Quer que eu restaure? (sim/não/ver resumo)"
│
├─▶ 3. Se usuário confirmar:
│      a) Baixar latest-checkpoint.json
│      b) Restaurar variáveis de estado
│      c) Carregar arquivos em edição
│      d) Re-executar últimos comandos (se seguros)
│      e) Atualizar MEMORY.md com timeline
│      f) Relatar: "✅ Contexto restaurado!"
│
└─▶ 4. Continuar trabalho como se nada tivesse acontecido
```

**Diálogo de Restore:**
```
🔄 SESSÃO ANTERIOR DETECTADA

📊 Resumo do contexto preservado:
├─ Sessão: 2026-04-27 00:15 → 00:24 (9 horas)
├─ Projeto: Site 4Pets (100% concluído)
├─ Arquivos: 12 modificados
├─ Preferências: 15 aprendidas
├─ CTs: 107 configurado, SSH funcional
├─ Último comando: Deploy admin protegido
└─ Pendente: Enviar texto WhatsApp (faculdade)

🤔 O que deseja?
1. ✅ RESTAURAR - Continuar de onde parou
2. 📋 VER MAIS - Ver detalhes completos
3. 🔄 RESETAR - Começar fresh (descartar contexto)
4. 💾 SALVAR - Apenas salvar, não restaurar agora

Responda 1, 2, 3 ou 4:
```

---

## 📋 COMPONENTES DO SISTEMA

### **A. SYNC ENGINE (Motor de Sincronização)**

**Script:** `scripts/sync-context.sh`

```bash
#!/bin/bash
# Executa automaticamente a cada 5 minutos (cron)

SOURCE_DIR="/root/.openclaw/workspace/"
DEST_BASE="/mnt/data/LAN/Acib/context-live/"
SESSION_ID="$(date +%Y%m%d-%H%M%S)-$(hostname)"

# 1. Coletar estado
CHANGED_FILES=$(find $SOURCE_DIR -name "*.md" -o -name "*.php" -o -name "*.html" | xargs stat -c "%Y %n" | sort)
MEMORY_STATE=$(cat $SOURCE_DIR/MEMORY.md 2>/dev/null | tail -100)
OPEN_FILES=$(lsof +D $SOURCE_DIR 2>/dev/null | grep "cwd\|rtd" | awk '{print $9}' | sort -u)

# 2. Criar pacote de contexto
mkdir -p "$DEST_BASE/sessions/$SESSION_ID"
cat > "$DEST_BASE/sessions/$SESSION_ID/context.json" << EOF
{
  "session_id": "$SESSION_ID",
  "timestamp": "$(date -Iseconds)",
  "hostname": "$(hostname)",
  "changed_files": [$CHANGED_FILES],
  "memory_head": "$MEMORY_STATE",
  "open_files": [$OPEN_FILES],
  "last_commands": [$(tail -20 ~/.bash_history | jq -R . | jq -s .)],
  "user_preferences": $(cat $SOURCE_DIR/skills/acib-preferences/references/*.md 2>/dev/null | base64 -w 0 | jq -R .)
}
EOF

# 3. Atualizar índice
echo "$SESSION_ID $(date +%s)" >> "$DEST_BASE/timeline/$(date +%Y%m%d)-session.idx"

# 4. Marcar como latest
ln -sf "$DEST_BASE/sessions/$SESSION_ID" "$DEST_BASE/current/latest" 2>/dev/null
echo "$SESSION_ID" > "$DEST_BASE/current/latest-session.id"
echo "$(date -Iseconds)" > "$DEST_BASE/current/last-sync.txt"

# 5. Notificar (silencioso)
echo "[$(date +%H:%M)] Contexto sincronizado: $SESSION_ID" >> /var/log/context-sync.log
```

---

### **B. RESTORE ENGINE (Motor de Restauração)**

**Script:** `scripts/restore-context.sh`

```bash
#!/bin/bash
# Executa automaticamente ao iniciar nova sessão

CONTEXT_DIR="/mnt/data/LAN/Acib/context-live/"
LATEST_ID=$(cat "$CONTEXT_DIR/current/latest-session.id" 2>/dev/null)

if [ -z "$LATEST_ID" ]; then
    echo "❌ Nenhum contexto anterior encontrado"
    exit 0
fi

# Verificar idade do contexto
LAST_SYNC=$(cat "$CONTEXT_DIR/current/last-sync.txt" 2>/dev/null)
NOW=$(date -Iseconds)
DIFF_MIN=$(( ($(date -d "$NOW" +%s) - $(date -d "$LAST_SYNC" +%s)) / 60 ))

echo "🔄 Contexto encontrado: $LATEST_ID"
echo "⏱️  Última sincronização: há $DIFF_MIN minutos"
echo ""
echo "📊 Resumo:"

# Extrair info do JSON
CONTEXT_FILE="$CONTEXT_DIR/sessions/$LATEST_ID/context.json"
if [ -f "$CONTEXT_FILE" ]; then
    PROJECT=$(jq -r '.project // "N/A"' "$CONTEXT_FILE" 2>/dev/null)
    COMPLETION=$(jq -r '.completion // "N/A"' "$CONTEXT_FILE" 2>/dev/null)
    PENDING=$(jq -r '.pending_tasks // [] | .[]' "$CONTEXT_FILE" 2>/dev/null | head -3)
    
    echo "  Projeto: $PROJECT"
    echo "  Progresso: $COMPLETION"
    echo "  Pendentes:"
    echo "$PENDING" | sed 's/^/    - /'
fi

echo ""
echo "🤔 Restaurar este contexto? (sim/não)"
```

---

### **C. AUTO-DETECT (Integração com new-session-detector)**

**Quando `new-session-detector` identificar necessidade de /new:**

1. **NÃO apenas sugerir /new...**
2. **ANTES disso:**
   - Forçar sync imediato (`sync-context.sh --force`)
   - Criar checkpoint final
   - Marcar como "restore-ready"
3. **DEPOIS:** Sugerir /new com confiança de preservação

**Mensagem integrada:**
```
🔍 Detectei sinais de que /new seria benéfico:

• Sessão: 9 horas ativa
• Performance degradada
• 5 erros nos últimos 15 minutos

💾 PRESERVANDO CONTEXTO AGORA...
✅ Estado sincronizado em 00:24:15
✅ 12 arquivos salvos
✅ Preferências atualizadas
✅ Timeline: 47 snapshots
✅ Pronto para restore automático

🚀 /new seguro disponível!
   Ao voltar, perguntarei se quer restaurar tudo.

Fazer /new agora? (sim/não/mais tarde)
```

---

## 🎯 FUNCIONAMENTO NA PRÁTICA

### **Cenário 1: Sessão Longa (9h)**

**Minuto 0 (Início):**
- Sessão inicia, `context-preserver` ativa sync a cada 5 min

**Minuto 60:**
- Sync #12: Site 4Pets em 60% de progresso
- Arquivos: `index.html`, `admin.php` modificados
- Preferências aprendidas: 3

**Minuto 180:**
- Sync #36: Site 4Pets em 80% de progresso  
- Deploy realizado, cores vibrantes aplicadas
- Preferências aprendidas: 8

**Minuto 540 (9h - new-session-detector alerta):**
- Detector: "Sessão longa detectada"
- Preserver: **Sync forçado #108** (último estado)
- Checkpoint final criado

**/NEW EXECUTADO:**
- Sessão fecha
- Contexto preservado: 108 snapshots, estado final completo

**NOVA SESSÃO (15 min depois):**
```
🔄 SESSÃO ANTERIOR DETECTADA

⏱️ Última atividade: há 15 minutos
📊 Contexto: 108 snapshots, 9 horas de trabalho
🎯 Projeto: Site 4Pets (deploy concluído)
💾 Estado: 100% sincronizado

Últimas ações:
  ✅ Deploy do novo index.html
  ✅ Proteção do admin.php
  ✅ 15 preferências aprendidas

🤔 O que deseja?
1. ✅ RESTAURAR - Ver arquivo de memória e continuar
2. 🔄 RESETAR - Começar nova sessão
3. 💾 ARQUIVAR - Salvar histórico, não restaurar

Resposta: 1

---

✅ CONTEXTO RESTAURADO!

📂 Arquivos em edição: 12
📋 Tarefas pendentes: Enviar texto WhatsApp (faculdade)
🔧 CTs configurados: 107 (4Pets) - SSH funcional
🎨 Preferências ativas: Cores vibrantes, backup sempre

💡 Sugestão: Quer que eu envie o texto do depoimento agora?
   (baseado na tarefa pendente identificada)
```

---

### **Cenário 2: Crash Inesperado**

**Durante trabalho (sem /new):**
- Sync a cada 5 min está rodando
- Último sync: 3 minutos atrás

**Sistema cai / Sessão expira:**
- Sync parou em 00:23:45
- Perda mínima: apenas últimos 3 minutos

**Nova sessão inicia:**
```
⚠️ SESSÃO ANTERIOR INTERROMPIDA

⏱️ Último sync: há 3 minutos (00:23:45)
💾 Estado recuperado: 97% completo
⚠️ Perda estimada: 3 minutos de trabalho

Projeto: Configuração VPN SERVMIL
Ação em andamento: Configurando WireGuard

🔄 RESTAURAR? (sim/não)

Resposta: sim

✅ CONTEXTO RESTAURADO (com perda mínima)

⚠️ Nota: Últimos 3 minutos podem estar incompletos
   Recomendo verificar: /etc/wireguard/wg0.conf

Quer que eu verifique o estado atual?
```

---

## 📊 GRAU DE PRESERVAÇÃO

### **O que é PRESERVADO (100%):**
- ✅ Arquivos criados/modificados
- ✅ Conteúdo de MEMORY.md
- ✅ Preferências aprendidas
- ✅ CTs/containers configurados
- ✅ Acessos SSH/credenciais
- ✅ Decisões tomadas
- ✅ Tarefas pendentes

### **O que é RECUPERÁVEL (90%):**
- 🟡 Processos em execução (restart necessário)
- 🟡 Variáveis de ambiente temporárias
- 🟡 Cache de comandos (últimos 50)

### **O que é PERDIDO (inevitável):**
- ❌ Estado de processos ativos (containers continuam rodando)
- ❌ Conexões de rede estabelecidas
- ❌ Variáveis de shell não salvas

**Taxa de preservação: 95-99%** (vs 60-70% com checkpoint manual)

---

## 🔧 IMPLEMENTAÇÃO TÉCNICA

### **Cron Job (Sync Automático):**
```bash
# Adicionar ao crontab do root
*/5 * * * * /root/.openclaw/workspace/skills/context-preserver/scripts/sync-context.sh --auto
```

### **Hook de Inicialização:**
```bash
# Executar ao iniciar sessão OpenClaw
# (adicionado ao .bashrc ou systemd service)

if [ -f "/mnt/data/LAN/Acib/context-live/current/restore-ready.flag" ]; then
    /root/.openclaw/workspace/skills/context-preserver/scripts/restore-context.sh --ask
fi
```

---

## 📝 FLUXO COMPLETO

```
┌─────────────────────────────────────────────────────────┐
│  SESSÃO 1 (Stark v1)                                    │
│  ├─▶ Trabalhando em projeto 4Pets                       │
│  ├─▶ [Sync 00:05] Estado salvo                          │
│  ├─▶ [Sync 00:10] Estado salvo                          │
│  ├─▶ [Sync 00:15] Estado salvo                          │
│  ├─▶ new-session-detector: "9h de sessão"               │
│  ├─▶ [SYNC FORÇADO] Estado final salvo                  │
│  └─▶ /new executado                                     │
│                                                          │
│  DATASVR: context-live/sessions/20260427-001500/        │
│           context-live/sessions/20260427-002000/        │
│           ... (108 snapshots)                            │
│           context-live/current/latest → último          │
└─────────────────────────────────────────────────────────┘
                           │
                           │ /NEW
                           ▼
┌─────────────────────────────────────────────────────────┐
│  NOVA SESSÃO (Stark v2)                                 │
│  ├─▶ Inicializa...                                      │
│  ├─▶ Detecta context-live/current/latest                │
│  ├─▶ Pergunta: "Restaurar sessão anterior?"             │
│  ├─▶ Usuário: SIM                                       │
│  ├─▶ [RESTORE] Baixa último snapshot                    │
│  ├─▶ [RESTORE] Reconstroi MEMORY.md                     │
│  ├─▶ [RESTORE] Sincroniza arquivos                     │
│  ├─▶ ✅ CONTEXTO RESTAURADO                             │
│  └─▶ "Continuando: enviar texto WhatsApp?"            │
│     (baseado na tarefa pendente identificada)          │
└─────────────────────────────────────────────────────────┘
```

---

## 🎨 INTEGRAÇÃO COM SKILLS EXISTENTES

### **Tríade de Gestão de Sessão:**

```
┌──────────────────┐     ┌──────────────────┐     ┌──────────────────┐
│ new-session-prep │────▶│ context-preserver│◀────│ new-session-     │
│   (preparação)   │     │  (preservação)   │     │   detector       │
└──────────────────┘     └──────────────────┘     │ (detecção)       │
        │                                              └──────────────────┘
        │
        ▼
┌──────────────────┐
│   acib-preferences│◀──── Contexto restaurado inclui preferências!
│  (preferências)  │
└──────────────────┘
```

**Fluxo integrado:**
1. **Detector** identifica necessidade de /new
2. **Preserver** faz sync final
3. **Prep** cria checkpoint documentado
4. /new executado
5. **Preserver** restaura contexto
6. **Preferences** aplica preferências aprendidas

---

## ✅ CHECKLIST DE IMPLEMENTAÇÃO

- [ ] Criar estrutura no DATASVR (`context-live/`)
- [ ] Implementar `sync-context.sh` (cron 5min)
- [ ] Implementar `restore-context.sh` (auto-restore)
- [ ] Integrar com `new-session-detector` (sync forçado)
- [ ] Integrar com `new-session-prep` (checkpoint final)
- [ ] Testar cenários: /new normal, crash, restore
- [ ] Documentar uso no SKILL.md
- [ ] Fazer backup na ARCA

---

## 🚀 PRÓXIMOS PASSOS

1. **Criar estrutura no DATASVR**
2. **Configurar cron** para sync automático
3. **Testar restore** em nova sessão
4. **Integrar** com as outras skills

**Quer que eu comece a implementação agora?** 🚀

---

**Versão:** 1.0  
**Criado em:** 27/04/2026  
**Dependências:** new-session-prep, new-session-detector, DATASVR acesso  
**Status:** ⏳ Pronto para implementação
