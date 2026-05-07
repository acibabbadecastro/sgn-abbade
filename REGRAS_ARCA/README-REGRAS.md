# 📚 REGRAS STARK - DOCUMENTAÇÃO COMPLETA

**Local ARCA:** `\\192.168.0.72\LAN\Acib\REGRAS_STARK\`  
**Data Criação:** 28/04/2026  
**Proprietário:** Acib ABBADE  
**Responsável:** Stark 🤖

---

## 🗂️ Estrutura de Pastas

```
REGRAS_STARK/
├── 📁 regras_criticas/          # Regras que podem causar dano
│   ├── REGRA-ATUALIZACOES-OPENCLAW.md
│   ├── REGRA-COMPATIBILIDADE-TELAS.md
│   └── REGRA-ACESSO-DESTRUTIVO.md
│
├── 📁 regras_operacionais/      # Regras de funcionamento
│   ├── REGRA-NOVO-CONTEXTO.md
│   ├── REGRA-MEMORIA-ALTA-PRIORIDADE.md
│   └── REGRA-COMUNICACAO.md
│
├── 📁 documentacao/             # Guias e explicações
│   ├── COMO-USAR-REGRAS.md
│   ├── TEMPLATE-NOVA-REGRA.md
│   └── HISTORICO-ALTERACOES.md
│
└── 📁 checklists/              # Checklists de verificação
    ├── CHECK-DIARIO.md
    ├── CHECK-SEMANAL.md
    └── CHECK-ATUALIZACOES.md
```

---

## 🔴 REGRAS CRÍTICAS (Ativas)

| ID | Regra | Descrição | Criada |
|----|-------|-----------|--------|
| RC-001 | Atualizações OpenClaw | Perguntar antes de instalar | 28/04/2026 |
| RC-002 | Compatibilidade de Telas | Verificar aro/sem aro | 28/04/2026 |
| RC-003 | Ações Destrutivas | Pedir autorização explícita | 28/04/2026 |

---

## 🟡 REGRAS OPERACIONAIS (Ativas)

| ID | Regra | Descrição | Criada |
|----|-------|-----------|--------|
| RO-001 | Novo Contexto (/new) | Criar checkpoint completo | 28/04/2026 |
| RO-002 | Memória Alta Prioridade | Salvar tudo sobre Acib | 28/04/2026 |
| RO-003 | Comunicação | Modo rápido vs detalhado | 28/04/2026 |

---

## 📝 Como Adicionar Nova Regra

1. Criar arquivo em `regras_criticas/` ou `regras_operacionais/`
2. Usar template em `documentacao/TEMPLATE-NOVA-REGRA.md`
3. Atualizar este README
4. Notificar Acib da nova regra
5. Sincronizar com ARCA

---

## 🔄 Sincronização

- **Frequência:** A cada nova regra ou alteração
- **Destino:** `\\192.168.0.72\LAN\Acib\REGRAS_STARK\`
- **Backup:** Automático em `REGRAS_STARK/.backup/`
- **Versionamento:** Git local + timestamps

---

## ⚠️ Lei das Regras

> **"Regra criada é regra seguida. Sem exceções."**

- Nenhuma regra pode ser ignorada
- Conflitos = perguntar Acib
- Dúvida = aplicar regra mais restritiva

---

*Última atualização: 28/04/2026*  
*Total de regras: 6 ativas*  
*Status: ✅ Sistema operacional*
