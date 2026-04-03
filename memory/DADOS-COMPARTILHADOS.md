# ESTRUTURA DE DADOS COMPARTILHADA

**Pasta Base:** `/root/DOCS/LAN/`  
**Todos os agentes leem/gravam nesta estrutura.**

---

## 📁 Estrutura de Pastas

```
/root/DOCS/LAN/
├── Documentos/
│   ├── Financeiros/
│   │   ├── Nubank/
│   │   │   ├── ContaPJ_65.384.056/
│   │   │   │   ├── 2026-03/Faturas/
│   │   │   │   ├── 2026-03/Movimentacoes/
│   │   │   │   └── 2026-03/Extratos/
│   │   │   └── Caixinha/
│   │   │       └── 2026-03/
│   │   │   ├── ContaAntiga_20.153.208/
│   │   │   │   └── 2026-03/
│   │   │   └── relatorio_marco2026.json  ← BASE COMPARTILHADA
│   │   ├── MercadoPago/
│   │   └── InfinityPay/
│   │       └── Viviane/
│   ├── Pessoais/
│   └── Viviane/
│
├── Relatorios/
│   ├── Financeiros/
│   │   ├── ANALISE_COMPLETA_MARCO_2026.md
│   │   └── (futuros relatórios)
│   ├── Impostos/
│   └── Contratos/
│
└── Backups/
```

---

## 🔗 Agentes e seus Dados

| Agente | Lê | Grava |
|--------|-----|-------|
| **Stark** | Todos | Configs, logs |
| **Mails** | Emails | Emails classificados |
| **Vorcaro** | Financeiros | Relatórios, alertas |
| **OfficeBoy** | Classificados | Tarefas, logs |
| **Supervisor** | Todos | Logs, status |

---

## 📊 Base de Dados Vorcaro

**Arquivo principal:** `relatorio_marco2026.json`

Contém todas 128 transações da Conta PJ com campos:
- Data, Valor, Identificador, Descrição
- Tipo (PIX, RDB, Compra, etc)
- Contraparte (cliente/fornecedor)
- Categoria

---

## 🔄 Fluxo de Dados

```
Mails baixa email → Officeboy classifica → Vorcaro analisa
                                    ↓
                            Stark coordena
                                    ↓
                            DATASVR guarda
```

---

## ✅ Status Atual

| Dados | Status |
|-------|--------|
| Nubank PJ (Março) | ✅ Organizado |
| Nubank Caixinha | ✅ Organizado |
| Nubank Conta Antiga | ✅ Organizado |
| Base JSON | ✅ Criada |
| Mercado Pago | ⏳ Pendente |
| Infinity Pay | ⏳ Pendente |
