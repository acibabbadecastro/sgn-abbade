---
name: monitor-fiscal-acib
description: Monitoramento automático de limites fiscais (MEI e IRPF) para Acib ABBADE. Verifica emails bancários do Nubank (PJ65, PJ20, PF), processa extratos CSV, calcula acumulados mensais/anuais e alerta quando próximo dos limites (70%, 85%, 95%, 100%). Sugere migração para conta da esposa ou PF quando necessário. Use quando há novos extratos bancários, verificação periódica de limites fiscais, ou decisão sobre qual conta usar para receber pagamentos.
---

# Monitor Fiscal - Acib ABBADE

## Objetivo
Monitorar automaticamente os limites fiscais das contas bancárias (MEI e IRPF) e alertar quando próximo de estourar, sugerindo alternativas (conta da esposa ou PF).

## Limites Fiscais 2026

### MEI (Microempreendedor Individual)
- **Limite anual:** R$ 81.000,00
- **Contas:** PJ65 (65.384.056/0001-32) + PJ20 (20.153.208/0001-58)
- **Média mensal máxima:** R$ 6.750,00

### IRPF (Isenção)
- **Limite anual:** R$ 28.559,70
- **Conta:** PF (307.572.858-64)

## Sistema de Alertas

| Percentual | Cor | Nível | Ação Sugerida |
|------------|-----|-------|---------------|
| < 70% | 🟢 | Normal | Continuar normal |
| 70% | 🟡 | Atenção | Planejar migração próximos meses |
| 85% | 🟠 | Crítico | Começar a migrar vendas para PF |
| 95% | 🔴 | Emergência | Migrar IMEDIATAMENTE para Esposa ou PF |

## Contas Disponíveis

1. **PJ65 (Nubank)** - MEI - CNPJ 65.384.056/0001-32
2. **PJ20 (Nubank)** - MEI - CNPJ 20.153.208/0001-58  
3. **PF (Nubank)** - Pessoa Física - CPF 307.572.858-64
4. **ESPOSA** - Conta reserva quando MEI próximo do limite

## Scripts

### verificar_emails.py
Verifica emails do Gmail em busca de extratos Nubank, processa CSVs e calcula totais.

```bash
python3 ~/.openclaw/skills/monitor-fiscal-acib/scripts/verificar_emails.py
```

**Funcionalidades:**
- Busca emails do Nubank (últimos 3 dias)
- Extrai anexos CSV
- Identifica conta (PJ65, PJ20, PF)
- Calcula entradas/saídas
- Verifica proximidade dos limites
- Gera alertas quando necessário
- Salva relatório JSON em `/root/.openclaw/logs/monitor_fiscal_report.json`

## Uso Manual

### Verificar status atual:
```bash
python3 ~/.openclaw/skills/monitor-fiscal-acib/scripts/verificar_emails.py
```

### Ver relatório:
```bash
cat /root/.openclaw/logs/monitor_fiscal_report.json
```

## Automação (Cron Job)

Adicionar ao `/root/.openclaw/cron/jobs.json`:

```json
{
  "id": "monitor-fiscal-diario",
  "name": "Monitor Fiscal Diário",
  "schedule": {
    "expr": "0 9,15,21 * * *",
    "kind": "cron",
    "tz": "America/Sao_Paulo"
  },
  "payload": {
    "kind": "systemEvent",
    "text": "Verificar emails Nubank e monitorar limites fiscais"
  },
  "sessionTarget": "main"
}
```

## Integração com Outros Sistemas

### SGN (CT 103)
- Dados salvos em banco PostgreSQL (schema: financeiro)
- Tabela: `financeiro.movimentacao_contas`

### DATASVR (CT 102)
- Relatórios salvos em: `\\192.168.0.72\LAN\RELATORIOS\fiscal\`

### Notificações
- Alertas críticos (85%+): Notificar Acib via Telegram
- Alertas emergência (95%+): Notificar IMEDIATAMENTE + sugerir ação

## Configuração

Arquivo: `/root/.openclaw/config/monitor_fiscal_config.json`

```json
{
  "ano_fiscal": 2026,
  "limites": {
    "mei": 81000.00,
    "irpf": 28559.70
  },
  "alertas": {
    "70": true,
    "85": true,
    "95": true
  },
  "contas_alternativas": {
    "esposa": true,
    "pf": true
  }
}
```

## Regras de Decisão

### Quando receber pagamento:

1. **Verificar acumulado MEI (PJ65 + PJ20)**
2. **Se < 70% do limite:** Usar PJ (MEI)
3. **Se 70-85%:** Preferir PF, MEI apenas se necessário
4. **Se 85-95%:** Usar PF ou conta Esposa
5. **Se > 95%:** OBRIGATÓRIO usar Esposa ou PF

### Prioridade de Contas:
1. PJ65 (MEI) - preferencial
2. PJ20 (MEI) - secundário
3. PF (IRPF) - quando MEI cheio
4. Esposa - emergência

## Logs

- **Operações:** `/root/.openclaw/logs/monitor_fiscal.log`
- **Relatórios:** `/root/.openclaw/logs/monitor_fiscal_report.json`
- **Extratos:** `/root/.openclaw/media/inbound/`

## Manutenção

- Verificar autenticação Gmail mensalmente
- Atualizar tokens de API quando expirar
- Revisar limites fiscais anualmente (novo ano)

## Contato

**Responsável:** Stark (CT 100)
**Notificações:** Telegram @Acib_Abbade (ID: 1866226415)
**Urgências:** Alertas > 85% são sempre notificados
