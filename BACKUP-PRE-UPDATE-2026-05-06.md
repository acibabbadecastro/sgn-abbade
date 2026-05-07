# 📦 BACKUP PRÉ-UPDATE OPENCLAW

**Data:** 2026-05-06 16:03 GMT-3  
**Motivo:** Update OpenClaw 2026.4.22 → 2026.5.5  
**Solicitante:** Acib ABBADE  

---

## ✅ CHECKLIST PRÉ-UPDATE

### 1. Backup de Configurações
- [ ] Backup openclaw.json
- [ ] Backup config/gateway.json
- [ ] Backup de auth/credenciais
- [ ] Backup de skills personalizadas

### 2. Backup de Memórias
- [ ] MEMORY.md
- [ ] memory/*.md (todos os arquivos diários)
- [ ] TOOLS.md
- [ ] AGENTS.md
- [ ] SOUL.md
- [ ] USER.md
- [ ] IDENTITY.md

### 3. Backup de Projetos
- [ ] PROJETOS/
- [ ] DOCUMENTACAO/
- [ ] Scripts personalizados

### 4. Sincronização ARCA
- [ ] Copiar tudo para \\192.168.0.72\LAN\Acib\
- [ ] Verificar integridade dos arquivos
- [ ] Criar snapshot do container (se possível)

### 5. Update OpenClaw
- [ ] Executar `openclaw update`
- [ ] Reiniciar gateway
- [ ] Validar status
- [ ] Testar channels
- [ ] Testar tools
- [ ] Testar memórias

---

## 📋 ARQUIVOS CRÍTICOS SALVOS

### Configurações
- `/root/.openclaw/openclaw.json`
- `/root/.openclaw/config/`

### Workspace
- `/root/.openclaw/workspace/`

### Memórias
- `/root/.openclaw/workspace/MEMORY.md`
- `/root/.openclaw/workspace/memory/*.md`

### Skills
- `/root/.openclaw/workspace/skills/`

---

## 🔄 STATUS DO BACKUP

| Etapa | Status | Horário |
|-------|--------|---------|
| Início | ⏳ Pendente | - |
| Backup local | ⏳ Pendente | - |
| Backup ARCA | ⏳ Pendente | - |
| Update OpenClaw | ⏳ Pendente | - |
| Validação | ⏳ Pendente | - |

---

*Documento criado automaticamente antes do update*
