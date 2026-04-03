# PROJETO - Sistema Multi-Agente com Containers (PRECIOSO)

## FASE 1 - Arquitetura Base (2026-04-03)

### Visão Geral
Sistema multi-agent onde cada container tem especialidade própria, coordenados por um agente orquestrador (Stark), com monitoramento 24/7 de toda a equipe.

---

## Estrutura de Containers

| Container | Especialidade | Status |
|-----------|---------------|--------|
| Stark (CT 100) | Orquestrador/Maestro | ✅ ATIVO |
| EmailBot (CT 101) | Emails | 🔜 Fase 2 |
| FinanceiroBot (CT 3) | Finanças | 🔜 Fase 2 |
| DataBot (CT 5) | Backups/Arquivos/Dados | 🔜 Fase 2 |
| MonitorBot/Supervisor (CT 4) | Monitoramento 24/7 + Auxílio ao Stark | 🔜 Fase 2 |

---

## Regras de Operação (OBRIGATÓRIO)

### Fluxo de Dados
1. Cada bot gera logs em locations padrão
2. Cada bot gera backups em locations padrão
3. MonitorBot vigia todos os outros 24/7
4. Stark detecta falhas e notifica Acib
5. **Stark SOLICITA AUTORIZAÇÃO antes de intervir**
6. **NADA de ação destrutiva sem consentimento**

### Fluxo de Falha
```
Bot falha → Supervisor detecta → Log registra → Stark verifica 
→ Stark notifica Acib → Acib autoriza → Stark intervém → Log atualiza
```

### Locais Padrão de Logs/Backups
- `/mnt/data/logs/` — logs de todos os bots
- `/mnt/data/backups/` — backups de todos os bots
- `/mnt/data/emails/` — emails (EmailBot)
- `/mnt/data/financeiros/` — dados financeiros (FinanceiroBot)
- `/mnt/data/contratos/` — documentos (DataBot)
- `/mnt/data/faturas/` — faturas (DataBot)
- `/mnt/data/agenda/` — agenda/lembretes

### Notificação de Falhas
- Stark detecta problema → notifica Acib via Telegram
- Acib autoriza → Stark executa reparo
- Sem autorização → Stark NÃO age

---

## Fase 1 - Concluída ✅
- [x] Stark configurado e funcionando (CT 100)
- [x] Protocolo de backup implementado
- [x] Memória permanente estabelecida
- [x] Estrutura de monitoramento definida

## Fase 2 - Próximos Passos
- [ ] Configurar DataBot (CT 5) — servidor de dados
- [ ] Configurar MonitorBot (CT 4) — monitoramento
- [ ] Configurar EmailBot (CT 101) — emails
- [ ] Configurar FinanceiroBot (CT 3) — finanças

---

## Memória Permanente: SIM
- Este documento deve ser lembrado SEMPRE
- Não pode ser apagado ou sobrescrito
- Atualizar apenas com aprovação de Acib

