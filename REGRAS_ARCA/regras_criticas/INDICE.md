# 🔴 REGRAS CRÍTICAS - ÍNDICE

**Local:** `\\192.168.0.72\LAN\Acib\REGRAS_STARK\regras_criticas\`  
**Última atualização:** 28/04/2026  
**Total de regras:** 3 ativas

---

## 📋 Regras Ativas

| ID | Nome | Arquivo | Prioridade | Data |
|----|------|---------|------------|------|
| RC-001 | Atualizações OpenClaw | REGRA-ATUALIZACOES-OPENCLAW.md | 🔴 CRÍTICA | 28/04/2026 |
| RC-002 | Compatibilidade de Telas | REGRA-COMPATIBILIDADE-TELAS.md | 🔴 CRÍTICA | 28/04/2026 |
| RC-003 | Ações Destrutivas | REGRA-ACOES-DESTRUTIVAS.md | 🔴 CRÍTICA | 28/04/2026 |

---

## 📝 Descrição das Regras

### RC-001: Atualizações OpenClaw
- **O quê:** Perguntar antes de instalar qualquer update
- **Quando:** 1x por dia (check de atualizações)
- **Por quê:** Prevenir quebras no sistema
- **Ver também:** CHECK-ATUALIZACOES.md

### RC-002: Compatibilidade de Telas  
- **O quê:** Verificar se tela é "com aro" ou "sem aro"
- **Quando:** Toda consulta de compatibilidade de telas
- **Por quê:** Telas com aro não são compatíveis com alguns modelos
- **Ver também:** MEMORY.md (seção técnicas)

### RC-003: Ações Destrutivas
- **O quê:** Pedir autorização explícita antes de deletar/remover
- **Quando:** Qualquer ação que delete dados
- **Por quê:** Proteção contra perda acidental
- **Ver também:** AGENTS.md (Red Lines)

---

## ➕ Adicionar Nova Regra Crítica

1. Criar arquivo: `REGRA-[NOME].md`
2. Usar template em `../documentacao/TEMPLATE-NOVA-REGRA.md`
3. Atualizar este índice
4. Sincronizar com ARCA
5. Notificar Acib

---

## 🔄 Sincronização

- **Local workspace:** `~/.openclaw/workspace/REGRAS_ARCA/regras_criticas/`
- **Backup ARCA:** `\\192.168.0.72\LAN\Acib\REGRAS_STARK\regras_criticas\`
- **Frequência:** Após cada nova regra ou alteração

---

*Índice atualizado em: 28/04/2026*
