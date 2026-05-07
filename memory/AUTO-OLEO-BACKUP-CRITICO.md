# 💾 MEMÓRIA CRÍTICA: BACKUP AUTOMÁTICO INVISÍVEL + MANUAL

**Criado:** 07/05/2026 10:12  
**Prioridade:** 🔴 **CRÍTICO - NÃO PODE PERDER**  
**Solicitante:** Acib ABBADE  

---

## 🎯 REQUISITO CRÍTICO

**Backup deve ter DUAS CAMADAS:**

### **1. Automático Invisível**
- ✅ Acontece SEMPRE às 03:00 da madrugada
- ✅ Cliente NÃO vê, NÃO sabe, NÃO é notificado
- ✅ Sistema faz em segundo plano
- ✅ Salva na pasta padrão do sistema
- ✅ Mantém últimos 30 backups
- ✅ Log oculto (não mostrar para cliente)

### **2. Manual Opcional**
- ✅ Cliente vê botão "💾 Fazer Backup Agora"
- ✅ Cliente ESCOLHE onde salvar (pasta, USB, rede, nuvem)
- ✅ Cliente NOMEIA o arquivo
- ✅ Cliente vê histórico de backups manuais
- ✅ Ilimitado (quantas vezes quiser)

---

## 🔧 REGRAS CRÍTICAS

1. **Automático acontece SEMPRE** (cliente não precisa fazer nada)
2. **Manual é OPCIONAL** (cliente decide se quer)
3. **Automático: 1x por dia** (03:00, invisível)
4. **Manual: Ilimitado** (cliente faz quando quiser)
5. **NÃO PODE PERDER** - Implementar obrigatoriamente

---

## 📊 FLUXO

```
AUTOMÁTICO (Invisível):
03:00 → Backup automático → Pasta fixa → Log oculto → Cliente não vê

MANUAL (Opcional):
Cliente clica → Escolhe local → Nomeia → Sistema faz → Mostra histórico
```

---

## 📍 LOCAIS DE ARMAZENAMENTO

**Documentação:**
- `/root/.openclaw/workspace/projetos/auto-oleo/docs/REQUISITO-BACKUP-AUTOMATICO-MEMORIA.md`

**GitHub:**
- https://github.com/AcibAbbade/luz/blob/main/docs/REQUISITO-BACKUP-AUTOMATICO-MEMORIA.md

**ARCA (DATASVR):**
- `\\192.168.0.72\LAN\Acib\PROJETOS\AUTO-OLEO\REQUISITO-BACKUP-AUTOMATICO-MEMORIA.md`

**Memória:**
- `/root/.openclaw/workspace/memory/AUTO-OLEO-BACKUP-CRITICO.md`

---

**Status:** 📝 **Documentado e Salvo em Múltiplos Locais**

*Stark - CT 100 | 07/05/2026 10:12*
