# GUIA DE RESTAURAÇÃO COMPLETA DO STARK

> Este arquivo define EXATAMENTE o que salvar e como organizar para recuperação total

---

## 🎯 ESTRUTURA DE ARQUIVOS OBRIGATÓRIOS

Para restaurar o Stark completamente, você precisa destes arquivos:

### 1. ARQUIVOS DE MEMÓRIA (OBRIGATÓRIOS)

```
/home/master/.openclaw/workspace/
├── MEMORY.md                    ← Memória de longo prazo (USAR ESTE PRIMEIRO)
├── memory/
│   └── YYYY-MM-DD.md           ← Registros diários (mais recente é o mais importante)
├── PREFERENCIAS.md              ← Configurações do sistema
├── AGENTS.md                    ← Regras do agente
├── SOUL.md                      ← Persona e personalidade
├── USER.md                      ← Informações do usuário
├── IDENTITY.md                  ← Nome, emoji, identidade
├── TOOLS.md                     ← Notas de ferramentas locais
└── BOOTSTRAP.md                 ← Configuração inicial (se ainda existir)
```

### 2. ARQUIVOS DE CONFIGURAÇÃO (OBRIGATÓRIOS)

```
~/.openclaw/
└── openclaw.json                ← Configuração completa do OpenClaw
```

### 3. SCRIPTS DO PEN DRIVE (OBRIGATÓRIOS)

```
/media/master/Ventoy/Stark_Backup/Scripts/
├── ATIVAR-LOGIN-AUTOMATICO.sh   ← Remove senha do Ubuntu
├── BACKUP-AUTOMATICO.sh         ← Faz backup para pen drive
├── RESTAURAR-BACKUP.sh          ← Restaura backups
└── README.txt                   ← Instruções
```

---

## 📋 CATEGORIAS DE DADOS (EXATAMENTE ASSIM)

### CATEGORIA 1: IDENTIDADE
**Arquivo:** `IDENTITY.md`
**Conteúdo:**
- Nome do agente (Stark)
- Criatura/tipo (IA Assistente Pessoal)
- Emoji signature (🤖)
- Função (assistente pessoal + coaching)
- Avatar (pendente)

### CATEGORIA 2: USUÁRIO
**Arquivo:** `USER.md`
**Conteúdo:**
- Nome completo (Acib ABBADE)
- Username Telegram (@Acib_Abbade)
- ID Telegram (1866226415)
- Timezone (America/Sao_Paulo)
- Preferências pessoais

### CATEGORIA 3: PERSONA
**Arquivo:** `SOUL.md`
**Conteúdo:**
- Regras de comportamento
- Tom de voz
- Limites éticos
- Como ajudar

### CATEGORIA 4: CONFIGURAÇÃO DO AGENTE
**Arquivo:** `AGENTS.md`
**Conteúdo:**
- Regras de workspace
- Como gerenciar memória
- Comportamento em grupo
-heartbeats

### CATEGORIA 5: MEMÓRIA DE LONGO PRAZO
**Arquivo:** `MEMORY.md`
**Conteúdo (OBRIGATÓRIO):**
- Informações do usuário (não repetir de USER.md)
- Configuração permanente do sistema
- Objetivos do usuário
- Comandos importantes
- Anotações técnicas

### CATEGORIA 6: REGISTRO DIÁRIO
**Arquivo:** `memory/YYYY-MM-DD.md`
**Conteúdo:**
- Data e contexto
- HARDWARE (especificações completas)
- SISTEMA (OS, boot, serviços)
- MODELOS (Ollama disponíveis)
- PROGRAMAS INSTALADOS (lista completa)
- TAREFAS REALIZADAS
- TAREFAS PENDENTES
- NOTAS IMPORTANTES
- REFERENCES

### CATEGORIA 7: PREFERÊNCIAS DO SISTEMA
**Arquivo:** `PREFERENCIAS.md`
**Conteúdo:**
- Inicialização automática
- Scripts de backup
- Login automático
- Hardware registrado
- Modelos locais

### CATEGORIA 8: CONFIGURAÇÃO OPENCLAW
**Arquivo:** `~/.openclaw/openclaw.json`
**Conteúdo (COMPLETO):**
- Modelos (apenas local, SEM cloud)
- Configuração de providers
- Gateway (porta, token)
- Canais (Telegram)
- Plugins

---

## 🔄 ORDEM DE RESTAURAÇÃO (IMPORTANTE!)

Ao reinstallar o Stark, siga esta ordem:

1. **PRIMEIRO** - Copie `MEMORY.md` para `/home/master/.openclaw/workspace/`
2. **SEGUNDO** - Copie o registro diário mais recente (`memory/YYYY-MM-DD.md`)
3. **TERCEIRO** - Copie `PREFERENCIAS.md`
4. **QUARTO** - Copie `openclaw.json` para `~/.openclaw/`
5. **QUINTO** - Copie `IDENTITY.md`, `USER.md`, `SOUL.md`, `AGENTS.md`
6. **SEXTO** - Execute scripts do pen drive se necessário

---

## 📦 COMANDOS DE BACKUP COMPLETO

```bash
# Backup completo (executar regularmente)
BACKUP_DIR="/media/master/Ventoy/Stark_Backup/backups/$(date +%Y-%m-%d_%H-%M)"
mkdir -p "$BACKUP_DIR"

# Copiar memória
cp -r /home/master/.openclaw/workspace/memory "$BACKUP_DIR/"
cp /home/master/.openclaw/workspace/MEMORY.md "$BACKUP_DIR/"
cp /home/master/.openclaw/workspace/PREFERENCIAS.md "$BACKUP_DIR/"

# Copiar configurações
cp /home/master/.openclaw/workspace/IDENTITY.md "$BACKUP_DIR/"
cp /home/master/.openclaw/workspace/USER.md "$BACKUP_DIR/"
cp /home/master/.openclaw/workspace/SOUL.md "$BACKUP_DIR/"
cp /home/master/.openclaw/workspace/AGENTS.md "$BACKUP_DIR/"
cp /home/master/.openclaw/workspace/TOOLS.md "$BACKUP_DIR/"
cp ~/.openclaw/openclaw.json "$BACKUP_DIR/"

# Criar link para mais recente
rm -f /media/master/Ventoy/Stark_Backup/backups/latest
ln -s "$BACKUP_DIR" /media/master/Ventoy/Stark_Backup/backups/latest
```

---

## 🧪 VERIFICAÇÃO DE INTEGRIDADE

Após restaurar, verificar:
- [ ] `openclaw status` funciona
- [ ] Ollama responde (localhost:11434)
- [ ] Modelos locais listam (`ollama list`)
- [ ] Telegram conecta
- [ ] Gateway inicia na porta 18789

---

## ⚡ MINIMUM VIABLE RESTORE (essencial absoluto)

Se você só puder salvar 3 arquivos, salve:
1. `MEMORY.md` - Contexto mais importante
2. `memory/YYYY-MM-DD.md` - Registro do dia
3. `openclaw.json` - Configuração técnica

---

## 🔗 LOCALIZAÇÕES FIXAS

| Dado | Arquivo | Caminho Absoluto |
|------|---------|------------------|
| Memória longo prazo | MEMORY.md | ~/.openclaw/workspace/MEMORY.md |
| Registro diário | YYYY-MM-DD.md | ~/.openclaw/workspace/memory/ |
| Preferências | PREFERENCIAS.md | ~/.openclaw/workspace/PREFERENCIAS.md |
| Config OpenClaw | openclaw.json | ~/.openclaw/openclaw.json |
| Scripts backup | *.sh | /media/master/Ventoy/Stark_Backup/Scripts/ |
| Backups | - | /media/master/Ventoy/Stark_Backup/backups/ |

---

## ✍️ COMO ADICIONAR NOVAS INFORMAÇÕES

Quando algo novo acontecer:
1. Adicione em `memory/YYYY-MM-DD.md` do dia
2. Se for importante, atualize também `MEMORY.md`
3. Faça backup IMEDIATO para o pen drive

**Regra:** Qualquer informação que você gostaria de ter ao acordar depois de uma reinstalação = salvar.