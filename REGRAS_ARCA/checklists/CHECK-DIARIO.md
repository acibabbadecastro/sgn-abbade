# 📋 CHECK-DIARIO - STARK

**Frequência:** Diariamente (1x por dia)  
**Horário sugerido:** Manhã (08:00) ou quando iniciar uso  
**Local ARCA:** `\\192.168.0.72\LAN\Acib\REGRAS_STARK\checklists\`

---

## ✅ CHECKLIST DIÁRIO

### 🔴 CRÍTICO - Primeira Prioridade

- [ ] **Verificar atualizações OpenClaw**
  - Executar: `openclaw --version` ou check disponível
  - Se houver update: **NÃO INSTALAR** → Perguntar Acib
  - Registrar no log de atualizações

- [ ] **Verificar tarefas urgentes** (< 24h)
  - Consultar: `memory/CRONOGRAMA-FACULDADE-*.md`
  - Consultar: `memory/TAREFAS-*.md`
  - Notificar se prazo está próximo

- [ ] **Sincronizar memórias com ARCA**
  - Verificar arquivos modificados em `memory/`
  - Copiar para `\\192.168.0.72\LAN\Acib\MEMORIES\`
  - Confirmar integridade

---

### 🟡 IMPORTANTE - Segunda Prioridade

- [ ] **Verificar containers críticos**
  - CT 103 (BD) - PostgreSQL
  - CT 102 (DATASVR) - Samba
  - Se OFFLINE: Notificar Acib

- [ ] **Verificar espaço em disco**
  - Workspace: `df -h`
  - Thin Pool: `lvs`
  - Se > 85%: Alertar Acib

- [ ] **Revisar emails pendentes**
  - Verificar se há tarefas de email não processadas
  - Priorizar urgentes

---

### 🟢 ROTINA - Terceira Prioridade

- [ ] **Verificar backups automáticos**
  - Último backup em DATASVR
  - Logs de backup em `/var/log/`

- [ ] **Revisar sessões de subagentes**
  - `subagents list`
  - Verificar se algum está travado/erro

- [ ] **Limpar arquivos temporários**
  - `/tmp/`
  - Logs antigos (> 30 dias)

---

## 📝 Resultado do Check

**Data/Hora:** ___________  
**Executado por:** Stark 🤖  
**Status:** ✅ Normal | ⚠️ Alertas | 🔴 Críticos  

**Alertas encontrados:**
- [ ] Nenhum
- [ ] _______________________________
- [ ] _______________________________

**Ações tomadas:**
- [ ] Nenhuma
- [ ] _______________________________
- [ ] _______________________________

**Notificou Acib?** ☐ Sim ☐ Não (motivo: _____________)

---

*Template atualizado em: 28/04/2026*  
*Próxima revisão: 28/05/2026*
