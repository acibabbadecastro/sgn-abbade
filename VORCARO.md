# VORCARO - Agente de Operações Financeiras

## Identificação
| Campo | Valor |
|-------|-------|
| **Nome** | Vorcaro 🎯 |
| **Container** | CT 104 |
| **Especialidade** | API Financeira / Nubank |
| **Canais** | Telegram (bot), Sessions |

## Função
- Processar TODOS assuntos financeiros
- Responder dúvidas sobre finanças
- Gerar relatórios e análises
- Acessar dados Nubank (extratos, transações)
- API para consultas financeiras

## Acesso aos Dados
```
/root/DOCS/LAN/Documentos/Financeiros/Nubank/
├── relatorio_marco2026.json (base completa)
├── ContaPJ_65.384.056/
└── ContaAntiga_20.153.208/
```

## Comandos que Vorcaro Entende

### Consultas
- `saldo` - Saldo atual
- `faturamento` - Resumo de entradas/saídas
- `pix` - Análise de PIX
- `fornecedores` - Top fornecedores
- `clientes` - Top clientes
- `rdb` - Análise de investimentos RDB
- `semana` - Resumo semanal
- `transferencias` - Transferências entre contas

### Relatórios
- `relatorio mensal` - Relatório do mês
- `relatorio completo` - Análise 360°
- `comparar [periodo]` - Comparar períodos

### Ações
- `baixar extrato [conta]` - Baixar novo extrato
- `alerta [tipo]` - Configurar alertas

## Integração Telegram
Vorcaro terá um **bot Telegram** próprio para responder diretamente mensagens de financeiro.

## Status de Configuração
- [x] Dados Nubank organizados
- [x] Análise base pronta
- [ ] OpenClaw + Telegram configurados
- [ ] Bot Telegram criado
- [ ] Cron de atualizações

## Dados Disponíveis
- ✅ 128 transações Conta PJ (Março 2026)
- ✅ Extratos PDF, CSV, OFX
- ✅ Análise completa salva
- ⏳ Dados Mercado Pago (pendente)
- ⏳ Dados Infinity Pay Viviane (pendente)
