# 🏦 IDs de Transações - Nubank

## Sistema de IDs

### Formato
```
{BANCO}-{TIPO_CONTA}-{DATA}-{SEQ}
```
**Exemplo:** `NUB-PJ65-20260404-0001`

---

## Referência de Contas

| Conta | Nome | ID Curto | Exemplo ID |
|-------|------|----------|-------------|
| 169842561 | ACIB ABBADE DE CASTRO | PF | NUB-PF-20260404-0001 |
| 986080174-7 | ABBADE Informatica | PJ65 | NUB-PJ65-20260404-0001 |
| 118844303 | (segunda PJ) | PJ20 | NUB-PJ20-20260404-0001 |

---

## Como Consultar

### Por ID específico:
```
/consulta NUB-PJ65-20260404-0001
```

### Por período:
```
/resumo NUB-PJ65-202604     ← todo mês
/resumo NUB-PJ65-2026        ← todo ano
/resumo NUB-PF-20260401-20260430  ← período específico
```

### Por tipo:
```
/transacoes NUB-PJ65 tipo=PIX_ENTRADA
/transacoes NUB-PF tipo=TED_SAIDA
```

### Balancete completo:
```
/balancete 2026-04
/balancete PF 2026-03
/balancete TODOS 2026-04
```

---

## Comandos Rápidos (futuro)

| Comando | Retorno |
|---------|---------|
| `/saldo` | Saldo atual de todas contas |
| `/receitas 2026-04` | Total receitas do mês |
| `/despesas 2026-04` | Total despesas do mês |
| `/lucro 2026-04` | Balanço do mês |
| `/cliente Nome` | Todas transações do cliente |
| `/categoria Alimentação` | Gastos por categoria |
