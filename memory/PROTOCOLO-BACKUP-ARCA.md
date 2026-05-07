# 📋 PROTOCOLO DE BACKUP NA ARCA
## Regra Crítica de Documentação

**Criado em:** 27/04/2026  
**Solicitante:** Acib ABBADE  
**Prioridade:** 🔴 **ALTA**

---

## 🎯 **REGRA OFICIAL**

> **SEMPRE que eu (Stark) atualizar ou criar documentação sobre qualquer projeto, devo automaticamente fazer backup na ARCA (DATASVR).**

---

## 📁 **LOCAL DE BACKUP**

```
\\192.168.0.72\LAN\
├── Acib\projetos\{nome-projeto}\
│   ├── documentacao\
│   ├── arquivos\
│   └── backups\
└── MEMORIES\ (para arquivos de memória gerais)
```

---

## 🔄 **FLUXO AUTOMÁTICO**

### **Quando atualizar documentação:**

1. ✅ **Criar/atualizar** arquivo local
2. ✅ **Copiar imediatamente** para DATASVR
3. ✅ **Verificar** se cópia foi bem-sucedida
4. ✅ **Confirmar** ao usuário o path no DATASVR

---

## 📋 **CHECKLIST DE BACKUP**

- [ ] Arquivo criado no workspace
- [ ] Arquivo copiado para `\\192.168.0.72\LAN\`
- [ ] Estrutura de pastas organizada por projeto
- [ ] Confirmação de sucesso enviada ao usuário

---

## 🎓 **EXEMPLOS APLICADOS**

### **Site 4Pets (27/04/2026):**
```
✅ RELATORIO-COMPLETO-SITE-4PETS.md
   → /root/.openclaw/workspace/ (local)
   → \\192.168.0.72\LAN\Acib\projetos\4pets\documentacao\ (arca)

✅ amigos4patas-index-novo.html
   → /root/.openclaw/workspace/ (local)
   → \\192.168.0.72\LAN\Acib\projetos\4pets\site\ (arca)
```

---

## ⚠️ **NUNCA ESQUECER**

- **DATASVR IP:** 192.168.0.72
- **Senha:** Rcmp@814k$1982
- **Usuário:** root
- **Comando:** `sshpass -p 'Rcmp@814k$1982' scp ...`

---

**Registrado em:** 27/04/2026  
**Status:** ✅ **PROTOCOLO ATIVO**

---

*Sempre que receber nova informação → Atualizar documentação → Backup na ARCA*
