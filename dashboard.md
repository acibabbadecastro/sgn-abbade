# 📊 Dashboard de Monitoramento - Equipe Stark

**Última Atualização:** $(date)

## Status Geral da Equipe

| Agente | Container | Especialidade | Status | Última Verificação |
|--------|-----------|---------------|--------|-------------------|
| Maestro Stark | CT 100 | Coordenação/Geral | ✅ ONLINE | $(date) |
| EmailBot | CT ??? | Emails | ❓ NÃO CONFIGURADO | - |
| FinanceiroBot | CT ??? | Finanças | ❓ NÃO CONFIGURADO | - |
| LembretesBot | CT ??? | Lembretes | ❓ NÃO CONFIGURADO | - |
| DataBot | CT ??? | Backup/Arquivos | ❓ NÃO CONFIGURADO | - |

## Métricas do Sistema

| Recurso | Uso | Status |
|---------|-----|--------|
| CPU (pve1) | $(top -bn1 | grep "Cpu(s)" | awk '{print $2}')% | ✅ OK |
| RAM (pve1) | $(free -h | awk '/Mem:/ {print $3 "/" $2}') | ✅ OK |
| Disk (root) | $(df -h / | awk 'NR==2 {print $3 "/" $2}') | ✅ OK |
| Gateway Stark | $(openclaw gateway status 2>/dev/null | grep "RPC probe" | awk '{print $3}') | ✅ OK |

## Alertas Recentes

```
Nenhum alerta no momento.
```

## Comandos Úteis

### Verificar Status de Todos os CTs
```bash
pct list
```

### Verificar Gateway de Cada Agente
```bash
# EmailBot (exemplo CT 101)
pct exec 101 -- systemctl status openclaw

# FinanceiroBot (exemplo CT 102)
pct exec 102 -- systemctl status openclaw
```

### Ver Logs de um Agente
```bash
pct exec CT_ID -- tail -100 /tmp/openclaw/openclaw-$(date +%Y-%m-%d).log
```

## Fluxo de Ação

```
🔴 AGENTE FALHOU
    ↓
📝 LOG REGISTRADO
    ↓
🔔 STARK NOTIFICADO
    ↓
📢 ACIB NOTIFICADO
    ↓
❓ AUTORIZAÇÃO SOLICITADA
    ↓
✅ ACIB AUTORIZA
    ↓
🔧 STARK REPARA
```
