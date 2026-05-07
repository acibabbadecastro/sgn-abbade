# Skill: Preparar Novo Contexto

## Descrição
Skill especializada em preparar sessões para `/new` com segurança total:
- Backup automático de todos os arquivos modificados
- Gravação de atualizações pendentes
- Sincronização de memórias (local + ARCA)
- Geração de resumo pré-/new
- Validação de integridade antes do reset

## Quando Usar
- Antes de executar `/new` (sessões longas >6 horas)
- Quando usuário solicitar "preparar para /new" ou "otimizar sessão"
- Automaticamente quando detectar sessão longa (>8 horas)
- Antes de mudanças críticas no sistema
- Ao final de projetos importantes

## Fluxo de Execução

### 1️⃣ ANÁLISE DO CONTEXTO ATUAL
```bash
# Verificar tempo de sessão
session_status

# Listar arquivos modificados hoje
find /root/.openclaw/workspace -name "*.md" -mtime -1
find /root/.openclaw/workspace -name "*.html" -mtime -1
find /root/.openclaw/workspace -name "*.py" -mtime -1

# Verificar sub-agentes ativos
subagents list

# Checar processos em background
process list
```

### 2️⃣ BACKUP AUTOMÁTICO
**Local:** `/mnt/data/LAN/Acib/BACKUP-SESSAO-YYYY-MM-DD-HHMM/`

**O que backupar:**
- ✅ Arquivos `.md` modificados nas últimas 24h
- ✅ Arquivos de projeto (.html, .py, .js)
- ✅ Memórias diárias (`memory/YYYY-MM-DD.md`)
- ✅ Configurações locais (TOOLS.md, HEARTBEAT.md)
- ✅ Logs de execução

**Comando:**
```bash
mkdir -p /mnt/data/LAN/Acib/BACKUP-SESSAO-$(date +%Y-%m-%d-%H%M)
cp -r /root/.openclaw/workspace/memory/*.md /mnt/data/LAN/Acib/BACKUP-SESSAO-.../
cp /root/.openclaw/workspace/*.md /mnt/data/LAN/Acib/BACKUP-SESSAO-.../
tar -czf /mnt/data/LAN/Acib/BACKUP-SESSAO-.../workspace.tar.gz /root/.openclaw/workspace/
```

### 3️⃣ GRAVAR ATUALIZAÇÕES PENDENTES
**Verificar e salvar:**
- [ ] Projetos concluídos hoje → `memory/PROJETO-XXX-CONCLUIDO.md`
- [ ] Lições aprendidas → `memory/LICOES-YYYY-MM-DD.md`
- [ ] Tarefas pendentes → Atualizar `memory/TAREFAS-PENDENTES.md`
- [ ] Compromissos → `memory/COMPROMISSOS-YYYY-MM-DD.md`
- [ ] Configurações alteradas → Atualizar TOOLS.md/HEARTBEAT.md

### 4️⃣ SINCRONIZAR MEMÓRIAS
**Local → ARCA:**
```bash
# Copiar memórias diárias
cp /root/.openclaw/workspace/memory/*.md /mnt/data/LAN/MEMORIES/

# Copiar MEMORY.md (se existir)
cp /root/.openclaw/workspace/MEMORY.md /mnt/data/LAN/Acib/

# Copiar backups críticos
cp /root/.openclaw/workspace/memory/*.json /mnt/data/LAN/MEMORIES/

# Gerar log de sincronização
echo "$(date): Sync concluído - $(ls memory/*.md | wc -l) arquivos" >> /mnt/data/LAN/MEMORIES/sync.log
```

**Validar integridade:**
```bash
# Verificar se arquivos foram copiados
ls -la /mnt/data/LAN/MEMORIES/ | tail -10
diff /root/.openclaw/workspace/MEMORY.md /mnt/data/LAN/Acib/MEMORY.md
```

### 5️⃣ GERAR RESUMO PRÉ-/NEW
**Arquivo:** `memory/RESUMO-PRE-NEW-YYYY-MM-DD.md`

**Estrutura:**
```markdown
# Resumo Pré-/New - YYYY-MM-DD HH:MM

## 📊 Estatísticas da Sessão
- Duração: X horas
- Tokens usados: ~XXXk
- Projetos concluídos: X
- Arquivos criados: X

## ✅ Projetos Concluídos
1. Projeto A - Status: Pronto
2. Projeto B - Status: Pronto

## ⏳ Em Andamento
1. Projeto C - Status: 80% (falta X)
2. Projeto D - Status: Aguardando usuário

## 📋 Tarefas Pendentes
- [ ] Tarefa 1 (prioridade alta)
- [ ] Tarefa 2 (prioridade média)

## 🔧 Configurações Alteradas
- Tool X: adicionado Y
- Config Z: modificado para W

## 📁 Arquivos Importantes Criados
- /caminho/arquivo1.md
- /caminho/arquivo2.html

## 🎯 Próximos Passos (pós-/new)
1. Ação imediata 1
2. Ação imediata 2
```

### 6️⃣ VALIDAÇÃO FINAL
**Checklist:**
- [ ] Backup criado com sucesso
- [ ] Memórias sincronizadas (local + ARCA)
- [ ] Resumo pré-/new gerado
- [ ] Sub-agentes finalizados ou preservados
- [ ] Processos críticos salvos
- [ ] Nenhuma escrita pendente

**Comando de validação:**
```bash
# Verificar backup
ls -la /mnt/data/LAN/Acib/BACKUP-SESSAO-*/ | tail -5

# Verificar memórias
ls /mnt/data/LAN/MEMORIES/*.md | wc -l

# Verificar resumo
cat /root/.openclaw/workspace/memory/RESUMO-PRE-NEW-*.md | head -20
```

### 7️⃣ ENTREGAR RELATÓRIO AO USUÁRIO
**Mensagem padrão:**

```
✅ **PREPARAÇÃO PARA /new CONCLUÍDA!**

## 📦 Backup Realizado
- Local: `/mnt/data/LAN/Acib/BACKUP-SESSAO-YYYY-MM-DD-HHMM/`
- Tamanho: XX MB
- Arquivos: XX itens

## 🔄 Memórias Sincronizadas
- Local → ARCA: ✅ Concluído
- Arquivos sync: XX
- Última sync: HH:MM

## 📄 Resumo Gerado
- Arquivo: `memory/RESUMO-PRE-NEW-YYYY-MM-DD.md`
- Projetos concluídos: X
- Pendências: X

## ✅ Validação
- Backup: ✅ OK
- Memórias: ✅ OK
- Integridade: ✅ OK

---

**PODE DIGITAR `/new` COM SEGURANÇA!** 🚀

Assim que reiniciar, eu:
1. Leio o resumo automaticamente
2. Restauro contexto em 5 segundos
3. Continuamos de onde paramos
```

## Comandos Disponíveis

### `preparar_novo_contexto` (principal)
Executa todo o fluxo acima.

**Uso:**
```
/preparar_novo_contexto
ou
preparar para /new
otimizar sessão
backup pré-new
```

### `verificar_backup`
Valida integridade do último backup.

### `restaurar_backup [data]`
Restaura backup específico (apenas com autorização explícita).

## Regras de Segurança

### ⚠️ NUNCA FAZER:
- Deletar arquivos originais após backup
- Fazer /new automaticamente sem confirmação
- Ignorar erros de escrita na ARCA
- Pular validação de integridade

### ✅ SEMPRE FAZER:
- Confirmar com usuário antes de /new
- Validar checksum dos backups
- Manter pelo menos 7 backups diários
- Logar todas as ações executadas

## Integração com Sistema

### Gatilhos Automáticos:
- Sessão >8 horas → Sugerir skill
- Usuário digita "/new" → Executar skill primeiro
- Heartbeat detecta sessão longa → Oferecer skill

### Pós-/new:
- Ler automaticamente `RESUMO-PRE-NEW-*.md`
- Restaurar contexto mencionado
- Oferecer continuidade imediata

## Exemplo de Uso

**Usuário:** "Quero fazer /new"

**Skill:**
1. Detecta comando
2. Executa fluxo completo (backup → sync → resumo)
3. Entrega relatório
4. Aguarda confirmação
5. Usuário digita `/new`
6. Pós-/new: Lê resumo e restaura contexto

## Arquivos da Skill

```
~/.openclaw/workspace/skills/preparar-novo-contexto/
├── SKILL.md (este arquivo)
├── prepare_new_context.py (script principal)
├── backup_utils.py (funções de backup)
├── sync_utils.py (sincronização ARCA)
├── summary_generator.py (geração de resumos)
└── validate.py (validação de integridade)
```

## Métricas de Sucesso

- ✅ Zero perda de dados após /new
- ✅ Backup sempre recuperável
- ✅ Memórias 100% sincronizadas
- ✅ Contexto restaurado em <10 segundos
- ✅ Usuário confiante para usar /new

---

**Criado por:** Stark para Acib ABBADE  
**Data:** 30/04/2026  
**Versão:** 1.0  
**Status:** Pronto para instalação
