# 🏦 Sistema de Gerenciamento Nubank - ARQUITETURA

## Objetivo
Capturar TODAS as movimentações das contas Nubank via email e estruturar dados para gestão financeira completa.

## Contas Gerenciadas
| Tipo | Número | CNPJ/CPF | Nome |
|------|--------|----------|------|
| PF | 169842561 | 307.572.858-64 | ACIB ABBADE DE CASTRO |
| PJ | 986080174-7 | 65.384.056/0001-32 | ABBADE Informatica |
| PJ | 118844303 | 20.153.208/0001-58 | (segunda conta PJ) |

## Tipos de Email Nubank Processados

### Transações Financeiras
- Transferência realizada (Pix/TED/DOC)
- Você recebeu uma transferência (Pix)
- Pagamento efetuado
- Compra no cartão
- Boleto pago
- Depósito identificado
- Estorno
- Juros/Multa

### Informações de Conta
- Extrato disponível
- Fatura fechada
- vencimento approaching
- Alerta de saldo
- Bloqueio/desbloqueio

## Estrutura de Pastas
```
/home/master/LAN/Emails/Processado/Financeiro/Nubank/
├── Transacoes/
│   ├── Acib_PF/
│   │   └── 2026/04/2026-04-04_transacao.json
│   ├── PJ_65.384.056/
│   │   └── 2026/04/2026-04-04_transacao.json
│   └── PJ_20.153.208/
├── Resumos/
│   ├── diario_2026-04-04.json
│   └── mensal_2026-04.json
├── Categorias/
│   ├── Recebimentos/
│   ├── Pagamentos/
│   ├── Cartão/
│   └── Investimentos/
└── Clientes/        ← Base de clientes identificados
    └── Empresa_XYZ.json
```

## Campos de Cada Transação (COMPLETO)
Ver: memory/NUBANK_MODELO.json

## Categorias Auto-Categorização
- PIX_ENTRADA / PIX_SAIDA
- TED_ENTRADA / TED_SAIDA  
- DOC_ENTRADA / DOC_SAIDA
- DEBITO_CARTAO / CREDITO_CARTAO
- BOLETO
- ESTORNO
- JUROS_MULTA
- INVESTIMENTO_CAIXINHA
- SALDO
- OUTROS


## Sistema de ID de Transações

### Formato do ID:
```
{BANCO}-{TIPO_CONTA}-{DATA_AAAAMMDD}-{SEQ:04d}
```

### Exemplo:
```
NUB-PF-20260404-0001
NUB-PJ65-20260404-0001
NUB-PJ20-20260404-0001
```

### Componentes:
| Campo | Descrição | Exemplo |
|-------|-----------|---------|
| BANCO | Sigla do banco | NUB (Nubank) |
| TIPO_CONTA | Tipo+ID simplificado | PF, PJ65, PJ20 |
| DATA | AnoMêsDia | 20260404 |
| SEQ | Sequencial 0001-9999 | 0001 |

### Tabela de Conversão Contas:
| Conta | ID Curto |
|-------|----------|
| 307.572.858-64 (PF) | PF |
| 65.384.056/0001-32 (PJ) | PJ65 |
| 20.153.208/0001-58 (PJ) | PJ20 |

### Geração de IDs:
- Sequencial reinicia por conta por dia
- Garantia de unicidade via timestamp+hash
- ID previne duplicatas

### Consulta por ID:
- `/consulta NUB-PF-20260404-0001`
- `/resumo NUB-PJ65-202604`
- `/balancete 2026-04`
