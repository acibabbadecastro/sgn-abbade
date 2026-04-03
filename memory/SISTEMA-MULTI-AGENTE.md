# Sistema Multi-Agente - ARQUITETURA

## Equipe de Agentes

| CT | Nome | Especialidade | Status |
|----|------|---------------|--------|
| 100 | **Stark** 🤖 | Coordenação/Geral | ✅ ONLINE |
| 101 | **Mails** 📧 | Emails | ✅ Configurado |
| 102 | **DATASVR** 💾 | Armazenamento/Backup | ✅ ONLINE |
| 103 | **Supervisor** 👁️ | Monitoramento 24/7 | ✅ ONLINE |
| 104 | **Vorcaro** 🎯 | Operações Financeiras | 🔜 Configurar |
| 105 | **OfficeBoy** 📋 | Tarefas Administrativas | 🔜 Criar |

## Fluxo de Trabalho

### Fluxo Email → OfficeBoy
```
1. Mails detecta novo email
2. Mails classifica o email (tipo, urgência, assunto)
3. Mails envia resumo para OfficeBoy:
   - O que é
   - Para quem direcionar
   - O que fazer (se aplicável)
4. OfficeBoy executa ou repassa
```

### Fluxo Financeiro → Vorcaro
```
1. Mails/OfficeBoy identificam email financeiro
2. Vorcaro recebeタスク (tarefa)
3. Vorcaro processa e responde
```

## Regras de Comunicação

- **Mails → OfficeBoy**: Novos emails classificados
- **Mails → Vorcaro**: Emails financeiros
- **Stark**: Orquestrador central, delega tarefas
- **Supervisor**: Monitora todos 24/7

## Status de Configuração

### Mails (CT 101) ✅
- Configurado com meli para acibabbadecastro@gmail.com
- App Password: juqqogjysxvpowtu
- Pendente: webhook/cron para verificar emails

### Vorcaro (CT 104) 🎯
- Especialidade: Análise financeira, relatórios, Nubank
- Precisa: API Nubank, acesso aos dados LAN

### OfficeBoy (CT 105) 📋
- Especialidade: Classificação de emails, encaminhamento
- Precisa: Regras de classificação, lista de responsáveis
- Funcionará como "executivo" de tarefas simples

## Tarefas Pendentes

- [ ] Configurar Vorcaro como agente financeiro
- [ ] Criar OfficeBoy (CT 105)
- [ ] Configurar cron Mails para verificar emails
- [ ] Criar regras de classificação de emails
- [ ] Conectar Mails → OfficeBoy via cron/evento
