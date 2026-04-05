# EQUIPE DE AGENTES - Documentação Completa

**Versão:** 1.0
**Data:** 2026-04-03
**Atualizado:** 2026-04-03
**Criado por:** Acib ABBADE
**Orquestrador:** Stark (CT 100)

---

## Visão Geral da Equipe

```
                    ┌─────────────────┐
                    │   Acib ABBADE   │
                    │   (Usuário)     │
                    └────────┬────────┘
                             │
                    ┌────────▼────────┐
                    │  STARK (CT 100) │
                    │  Coordenador    │
                    │  IP: 192.168.0.192
                    └────────┬────────┘
                             │
        ┌──────────┬─────────┼─────────┬──────────┬───────────┐
        │          │         │         │          │           │
   ┌────▼───┐ ┌───▼───┐ ┌──▼──┐ ┌───▼───┐ ┌───▼───┐ ┌───▼────┐
   │ MAILBOT│ │DATASVR│ │SAMU │ │OFFICE │ │SEGURAN│ │SUPERVI-│
   │CT 101  │ │CT 102 │ │CT 107│ │CT 105 │ │CT 106 │ │SOR-CT 4│
   └────────┘ └───────┘ └──────┘ └───────┘ └───────┘ └────────┘
```

---

## AGENTE 1: STARK (CT 100)

**Papel:** Maestro Coordenador

### Identificação
| Campo | Valor |
|-------|-------|
| **Nome** | Stark |
| **CT** | 100 |
| **IP** | 192.168.0.192 |
| **Hostname** | Stark |
| **OS** | Ubuntu/PVE |
| **Porta Gateway** | 18789 |
| **Modelo Ollama** | ollama/minimax-m2.7:cloud |
| **Status** | 🟢 ONLINE |

### Funções
- Coordenador geral da equipe
- Tomada de decisões técnicas
- Comunicação com Acib
- Orquestrador de tarefas
- Gerenciamento de memória e aprendizados

### Arquivos Importantes
- `/root/.openclaw/workspace/MEMORY.md` - Memória permanente
- `/root/.openclaw/workspace/MEMORY_LEARNINGS.md` - Aprendizados
- `/root/.openclaw/workspace/SISTEMA_FINANCEIRO.md` - Sistema financeiro
- `/root/.openclaw/workspace/TEAM.md` - Equipe
- `/root/.openclaw/workspace/SAMU_PRD.md` - PRD do SAMU

### Credenciais
- SSH: Chave pública configurada

---

## AGENTE 2: MAILBOT (CT 101)

**Papel:** Especialista em Emails

### Identificação
| Campo | Valor |
|-------|-------|
| **Nome** | MailBot |
| **CT** | 101 |
| **IP** | 192.168.0.240 |
| **Hostname** | Mails |
| **OS** | Ubuntu 25.04 |
| **Porta Gateway** | 18789 |
| **Status** | 🟢 ONLINE |

### Funções
- Receber emails
- Filtrar transações bancárias
- Encaminhar anexos para DATASVR
- Enviar emails de alerta (via SAMU)
- Gerenciar comunicações externas

### Emails Configurados
| Email | Finalidade | Status |
|-------|------------|--------|
| acibabbadecastro@gmail.com | Principal | ✅ Configurado |
| infoacib@gmail.com | Secundário | ✅ Configurado |
| acib@outlook.com | Destino alertas | ✅ Configurado |

### Plugins
| Plugin | Status |
|--------|--------|
| Telegram | ❌ Desabilitado (precisa token) |
| Email (IMAP/SMTP) | ⏳ A configurar |

### Pendências
- [ ] Configurar plugin Telegram (precisa bot token)
- [ ] Configurar IMAP para emails bancários
- [ ] Configurar filtros de transações

---

## AGENTE 3: DATASVR (CT 102)

**Papel:** Servidor de Armazenamento

### Identificação
| Campo | Valor |
|-------|-------|
| **Nome** | DATASVR |
| **CT** | 102 |
| **IP** | 192.168.0.72 |
| **Hostname** | DATASVR |
| **OS** | Ubuntu 25.04 |
| **Porta Gateway** | 18789 |
| **Status** | 🟢 ONLINE |

### Funções
- Armazenar documentos
- Armazenar anexos de emails
- Gerenciar sistema de arquivos compartilhado
- Backups de dados
- Classificação de documentos

### Armazenamento
| Disco | Tamanho | Montado em | Livre |
|-------|---------|------------|-------|
| HD Externo (sdb) | 465GB | /mnt/sdb | 434GB |

### Estrutura de Pastas
```
/mnt/data/
├── backups/          # Backups de segurança
├── contratos/        # Contratos e acordos
├── documentos/       # Documentos gerais
├── emails/          # Emails classificados
│   ├── bancario/    # Emails do banco
│   ├── indesejados/ # Spam
│   └── importantes/ # Importantes
├── faturas/         # Faturas de cartão
├── financeiros/     # Dados financeiros
│   ├── contas/     # Cadastro de contas
│   ├── transacoes/ # Registros
│   ├── despesas_fixas/
│   ├── cartoes/    # Cartões de crédito
│   └── fornecedores/
├── logs/            # Logs do sistema
└── recibos/        # Recibos
```

### Credenciais
| Campo | Valor |
|-------|-------|
| **Senha Root** | Rcmp@814k$1982 |

### Pendências
- [ ] Integrar com MailBot para receber anexos
- [ ] Configurar sistema de backup automático

---

## AGENTE 4: OFFICEBOY (CT 105)

**Papel:** Assistente Administrativo

### Identificação
| Campo | Valor |
|-------|-------|
| **Nome** | OfficeBoy |
| **CT** | 105 |
| **IP** | 192.168.0.117 |
| **Hostname** | OfficeBoy |
| **Status** | 🟢 ONLINE |

### Funções
- Tarefas administrativas
- Organização de documentos
- Suporte a rotinas

### Credenciais
| Campo | Valor |
|-------|-------|
| **Senha Root** | Rcmp814k@# |

---

## AGENTE 5: SEGURANCA (CT 106)

**Papel:** Agente de Segurança

### Identificação
| Campo | Valor |
|-------|-------|
| **Nome** | Seguranca |
| **CT** | 106 |
| **IP** | 192.168.0.231 |
| **Hostname** | Seguranca |
| **Status** | 🟢 ONLINE |

### Funções
- Monitoramento de portas
- Verificação de segurança
- Alertas de intrusion

### Credenciais
| Campo | Valor |
|-------|-------|
| **Senha Root** | Rcmp814k |

---

## AGENTE 6: SUPERVISOR (CT 103)

**Papel:** Monitoramento 24/7 da Equipe

### Identificação
| Campo | Valor |
|-------|-------|
| **Nome** | Supervisor |
| **CT** | 103 |
| **IP** | 192.168.0.42 |
| **Hostname** | Supervisor |
| **Status** | ⏳ OFFLINE/PENDENTE |

### Funções
- Monitorar TODOS os agentes 24/7
- Detectar falhas
- Notificar Stark
- Log de status

### Fluxo de Monitoramento
```
Supervisor detecta falha
    ↓
Registra em log
    ↓
Notifica Stark
    ↓
Stark notifica Acib
    ↓
Stark repara (com autorização)
```

### Pendências
- [ ] Configurar OpenClaw
- [ ] Criar scripts de monitoramento
- [ ] Configurar alertas

---

## AGENTE 7: VORCARO (CT 104)

**Papel:** API Financeira

### Identificação
| Campo | Valor |
|-------|-------|
| **Nome** | Vorcaro |
| **CT** | 104 |
| **IP** | 192.168.0.172 |
| **Hostname** | Vorcaro |
| **Status** | ⚠️ OFFLINE |

### Funções
- Integração com APIs bancárias
- Consulta de transações
- Integração Nubank

### Pendências
- [ ] Verificar motivo do offline
- [ ] Reconectar e configurar

---

## AGENTE 8: SAMU (CT 107)

**Papel:** Socorrista do Stark

### Identificação
| Campo | Valor |
|-------|-------|
| **Nome** | SAMU |
| **CT** | 107 |
| **IP** | 192.168.0.64 |
| **Hostname** | SAMU |
| **OS** | Ubuntu |
| **Porta Gateway** | 18789 |
| **Status** | 🟢 ONLINE |

### Função Exclusiva
**UNICO OBJETIVO:** Socorrer o Stark quando ele falhar

### Fluxo de Ação
```
A cada 10 minutos:
    ↓
Verifica se Stark está online
    ↓
Se ONLINE → Loga e encerra
    ↓
Se OFFLINE →
    1. Pede MailBot para enviar email de alerta
    2. Executa tentativas de reativação:
       - Tentativa 1: systemctl restart
       - Tentativa 2: stop + start forçado
       - Tentativa 3: pkill + restart manual
       - Tentativa 4: reboot CT 100 via pve1
    ↓
Se RESTAURADO →
    - Email: "Stark Corrigido"
    - Telegram: "Stark de volta"
    ↓
Se FALHOU →
    - Email CRÍTICO com logs
    - Telegram: alerta crítico
```

### Arquivos
| Arquivo | Descrição |
|---------|-----------|
| `/root/samu/monitor.sh` | Script principal |
| `/root/samu/PRD.md` | Especificação do projeto |
| `/root/samu/monitor.log` | Logs de verificação |
| `/root/samu/cron.log` | Logs do cron |

### Cron
```cron
*/10 * * * * /root/samu/monitor.sh >> /root/samu/cron.log 2>&1
```

### Credenciais
| Campo | Valor |
|-------|-------|
| **Senha Root** | Rcmp814k |

---

## SISTEMA DE COMUNICAÇÃO

### Canais de Alerta
| Canal | Status | Configuração |
|-------|--------|--------------|
| **Email** | ✅ Configurado | MailBot envia para acib@outlook.com |
| **Telegram** | ⏳ PENDENTE | Precisa token do bot |
| **WhatsApp** | ⏳ PENDENTE | Precisa QR code |

### Prioridade de Comunicação
1. **Email** - Principal (sempre funciona)
2. **Telegram** - Instantâneo (quando configurado)
3. **WhatsApp** - Backup (quando configurado)

---

## PENDENCIAS GERAIS

### Alta Prioridade
| # | Tarefa | Responsável | Status |
|---|--------|-------------|--------|
| 1 | Configurar Telegram | Stark + MailBot | ⏳ PENDENTE |
| 2 | Configurar WhatsApp | MailBot | ⏳ PENDENTE |
| 3 | Configurar IMAP emails | MailBot | ⏳ PENDENTE |
| 4 | Integrar MailBot + DATASVR | Stark | ⏳ PENDENTE |
| 5 | Ativar Supervisor (CT 103) | Stark | ⏳ PENDENTE |

### Média Prioridade
| # | Tarefa | Responsável | Status |
|---|--------|-------------|--------|
| 7 | Criar Repositório GitHub | Stark | ⏳ PENDENTE |
| 8 | Integrar Vorcaro ↔ Nubank API | Vorcaro | ⏳ PESQUISAR |
| 9 | Configurar backup automático | DATASVR | ⏳ PENDENTE |
| 10 | Sistema de login Stark via Telegram | Stark | ⏳ PENDENTE |

---

## CREDENCIAIS DA EQUIPE

| CT | IP | Senha Root | Chave SSH |
|----|----|------------|-----------|
| 100 (Stark) | 192.168.0.192 | - | ✅ Configurada |
| 101 (MailBot) | 192.168.0.240 | Rcmp814k@# | ✅ Configurada |
| 102 (DATASVR) | 192.168.0.72 | Rcmp@814k$1982 | ✅ Configurada |
| 103 (Supervisor) | 192.168.0.42 | - | ⏳ Pendente |
| 104 (Vorcaro) | 192.168.0.172 | - | ⏳ Offline |
| 105 (OfficeBoy) | 192.168.0.117 | Rcmp814k@# | ✅ Configurada |
| 106 (Seguranca) | 192.168.0.231 | Rcmp814k | ✅ Configurada |
| 107 (SAMU) | 192.168.0.64 | Rcmp814k | ✅ Configurada |

---

## ARQUIVOS DE DOCUMENTAÇÃO

| Arquivo | Descrição |
|---------|-----------|
| `/root/.openclaw/workspace/TEAM.md` | Lista da equipe |
| `/root/.openclaw/workspace/MEMORY.md` | Memória permanente |
| `/root/.openclaw/workspace/MEMORY_LEARNINGS.md` | Aprendizados |
| `/root/.openclaw/workspace/SISTEMA_FINANCEIRO.md` | Sistema financeiro |
| `/root/.openclaw/workspace/SAMU_PRD.md` | PRD do SAMU |
| `/root/.openclaw/workspace/USER.md` | Info do Acib |
| `/root/.openclaw/workspace/IDENTITY.md` | Identidade do Stark |
| `/root/.openclaw/workspace/AGENTS.md` | Agentes.md padrão |

---

## NOTAS IMPORTANTES

1. **SAMU é exclusivo para Stark** - Não monitora outros agentes
2. **Supervisor monitora a equipe** - CT 103
3. **DATASVR é storage** - Não roda OpenClaw (sò storage)
4. **MailBot é o mensageiro** - Envia emails quando SAMU pede
5. **Stark é o maestro** - Coordena tudo

---

*Documento criado em: 2026-04-03*
*Última atualização: 2026-04-03*
*Stark - AI Assistant*
