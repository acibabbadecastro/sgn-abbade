# SISTEMA MULTI-AGENTE - ARQUITETURA COMPLETA

## 🎯 Visão Geral
Sistema multi-agent coordenado por **Stark** (orquestrador), onde cada agente tem especialidade e comunica via OpenClaw sessions.

```
                    ┌──────────────────────────────────────────────┐
                    │                    STARK                     │
                    │            (Orquestrador/Central)            │
                    │                    CT 100                     │
                    └──────────────────────────────────────────────┘
                                       │
           ┌───────────────────┬────────┴────────┬────────────────┐
           ▼                   ▼                 ▼                ▼
    ┌─────────────┐    ┌─────────────┐  ┌─────────────┐  ┌─────────────┐
    │   MAILS     │    │  VORCARO    │  │ SUPERVISOR  │  │OFFICEBOY    │
    │   CT 101    │    │   CT 104    │  │   CT 103    │  │  CT 105     │
    │   📧 Emails │    │   💰 Financ │  │   👁️ Monitor│  │   📋 Admin  │
    └─────────────┘    └─────────────┘  └─────────────┘  └─────────────┘
           │                   │                 │                │
           └───────────────────┴────────┬────────┴────────────────┘
                                       │
                               ┌───────▼───────┐
                               │   DATASVR     │
                               │    CT 102     │
                               │    💾 Dados   │
                               └───────────────┘
```

## AGENTES

### Stark (CT 100) - Orquestrador
**Função:** Coordenação central, delega tarefas, comunica com Acib
**Status:** ✅ ONLINE

### Mails (CT 101) - Email
**Função:** Monitorar emails, classificar, identificar urgências
**Status:** ✅ Configurado (meli)
**Email:** acibabbadecastro@gmail.com

### Vorcaro (CT 104) - Operações Financeiras / API Finance
**Função:** 
- TODOS assuntos financeiros (Nubank, Mercado Pago, etc)
- Chatbot Telegram para consultas financeiras
- Geração de relatórios e análises
- Acessar dados, fazer cruzamentos
**Status:** 🔜 Configurar
**Dados:** `/root/DOCS/LAN/Documentos/Financeiros/Nubank/`

### Supervisor (CT 103) - Monitoramento
**Função:** Monitora todos agentes 24/7, reporta falhas
**Status:** ✅ ONLINE
**IP:** 192.168.0.42

### OfficeBoy (CT 105) - Administrativo
**Função:** Recebe emails classificados, executa/encaminha tarefas
**Status:** 🔜 Criar (precisa novo CT)

### DATASVR (CT 102) - Dados
**Função:** Armazenamento central, backups
**Status:** ✅ ONLINE
**IP:** 192.168.0.72
**Pasta:** /mnt/data/

## 📂 DADOS COMPARTILHADOS
**Pasta:** `/root/DOCS/LAN/`
- Todos os agentes leem/gravam na mesma estrutura
- Vorcaro usa dados de: Nubank, Mercado Pago, Infinity Pay
- Mails classifica emails na mesma base
- Base JSON unificada para cruzamentos

## FLUXO DE TRABALHO

### Fluxo 1: Email → Classificação
```
Mails detecta email → Classifica → OfficeBoy processa → Vorcaro analisa se financeiro
```

### Fluxo 2: Tarefa Financeira (via Vorcaro)
```
Acib (Telegram) → Vorcaro consulta dados → Responde
                    ↓
              Stark coordena (se precisa aprovação)
```

### Fluxo 3: OfficeBoy
```
Recebe email classificado → Executa ou encaminha → Reporta para Stark
```

## CRON JOBS CONFIGURADOS

| Job | Frequência | Ação |
|-----|------------|------|
| backup-sessions | 60 min | Backup sessões OpenClaw |
| mail-check | 15 min | Verificar emails novos |
| supervisor-ping | 5 min | Verificar agentes |

## COMANDOS DE COMUNICAÇÃO

### Enviar para Agente
```bash
openclaw sessions send <session_key> <mensagem>
```

### Listar Sessions
```bash
openclaw sessions list
```

## PRÓXIMOS PASSOS

- [ ] Criar CT 105 para OfficeBoy
- [ ] Configurar Vorcaro (CT 104) com API Nubank
- [ ] Configurar cron Mails para verificar emails
- [ ] Criar regras de classificação OfficeBoy
- [ ] Conectar Mails → OfficeBoy via sessions

## CREDENCIAIS DOS CTs

| CT | IP | Senha Root |
|----|----|------------|
| DATASVR (102) | 192.168.0.72 | Rcmp@814k$1982 |
| Supervisor (103) | 192.168.0.42 | Rcmp814k@# |
| Mails (101) | - | - |
| Vorcaro (104) | - | - |
| OfficeBoy (105) | - | - |
