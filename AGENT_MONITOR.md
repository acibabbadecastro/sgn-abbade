# AGENT MONITOR - Sistema de Monitoramento da Equipe

## Função
Este é o "olho que nunca dorme" — monitora todos os agentes em tempo real.

## Agentes sob Monitoramento
| ID | Nome | Especialidade | Status | Última Verificação |
|----|------|---------------|--------|-------------------|
| ??? | EmailBot | Emails | ❓ | - |
| ??? | FinanceiroBot | Finanças | ❓ | - |
| ??? | LembretesBot | Lembretes | ❓ | - |
| ??? | DataBot | Backup/Arquivos | ❓ | - |

## Comandos de Verificação

### Verificar Status de Todos
```bash
# Verificar se todos os CTs estão online
for ct in 101 102 103 104; do
  pct status $ct
done
```

### VerificarGateway de Cada Agente
```bash
# Verificar se o gateway do agente está rodando
pct exec CT_ID -- systemctl status openclaw
```

### Verificar Últimos Logs
```bash
# Ver logs de um agente específico
pct exec CT_ID -- tail -50 /tmp/openclaw/openclaw-$(date +%Y-%m-%d).log
```

## Fluxo de Detecção de Falha

```
1. Monitor detecta: agente não responde
2. Verifica: gateway online? processo ativo? logs?
3. Registra: salva em /root/.openclaw/workspace/logs/agente-YYYY-MM-DD.log
4. Notifica Stark (Maestro)
5. Stark notifica Acib
6. Aguarda autorização
7. Repara (se autorizado)
```

## Status Codes
- ✅ ONLINE — agente funcionando normally
- ⚠️ WARNING — agente lento ou com problemas menores
- ❌ OFFLINE — agente não responde
- 🔧 REPARANDO — em processo de reparo (aguardando autorização)
- ⏸️ PAUSADO — agente pausado pelo usuário
