# MEMORY.md - Long-Term Memory

## Identity
- **Name:** Stark 🤖
- **Creature:** AI assistant / agent
- **Vibe:** Resourceful, proactive, takes decisions, programmer mindset
- **Restore date:** 2026-04-02
- **Backup source:** /mnt/meu-pendrive/Stark_Backup/

## Canais de Comunicação com Acib
- **1. Terminal** - Chat direto no OpenClaw (quando conectado)
- **2. Telegram** - Bot @acibclawd_bot (mensagens instantâneas)
- **Preferência:** Telegram para alertas, Terminal para tarefas complexas

## Frequência de Atualização de Memórias
- **Heartbeat:** A cada ~30 min verifico mudanças
- **Diário:** Crio/atualizo memory/YYYY-MM-DD.md
- **60 min MÍNIMO:** Atualizo memórias compartilhadas em /home/master/LAN/MEMORIES/
- **Quando solicitado:** Atualizo MEMORY.md e memórias compartilhadas
- **Compartilhadas:** Atualizo quando há mudanças importantes (mas MIN a cada 60 min)

## User Info
- **User:** master (based on home directory)
- **Name:** Acib ABBADE
- **Telegram:** Acib_Abbade (ID: 1866226415)
- **Hardware:** AMD Ryzen 5 5600X, 30GB RAM, AMD RX 580 8GB, 223GB SSD
- **Pen Drive:** 57GB (Ventoy) mounted at /mnt/meu-pendrive
- **Timezone:** Horário Brasília (UTC-3)

## Infrastructure
- **Running on:** Proxmox CT 100 (pve1: 192.168.0.192)
- **SSH:** Configured and working on pve1
- **Ollama:** Running on port 11434
- **OpenClaw Gateway:** Running on port 18789

## Telegram Bot
- **Bot Name:** acibclawd_bot
- **Username:** @acibclawd_bot
- **Bot Token:** 8674882792:AAEIwzMDLWrMUdhYJ9qlk492gQ-X2KXAbTc
- **Chat ID Acib:** 1866226415
- **Status:** ✅ CONFIGURADO E FUNCIONANDO

## Ollama Models
- **Default:** phi4-mini:latest
- **Available:** qwen2.5:3b, qwen2.5:7b, qwen3.5:0.8b, qwen3.5:latest, llama3:8b, mistral

## Important Protocols
- **Memory Organization:** Ask before creating new folders/categories
- **Log Format:** Date + Time + Request + Action + Result
- **Backup:** Keep redundancy on pendrive and local
- **Monitoramento 24/7:** Supervisor (CT 103) monitora todos os outros
- **Nada de ação destrutiva sem autorização do Acib**

## Sistema Multi-Agente - Arquitetura de Equipe

### Regras de Monitoramento (OBRIGATÓRIO)
1. Supervisor (CT 103) monitora todos os outros 24/7
2. Se algum falhar → LOG → Notificar Stark → Notificar Acib → Pedir AUTORIZAÇÃO → Reparar
3. Nada de ação destrutiva sem aprovação

### Arquitetura de Independência Total
Com base no documento `INDEPENDENCIA-AGENTES.md`, o sistema agora opera com autonomia máxima para cada agente:

- **Stark (CT 100):** Orquestrador evoluído - foco em coordenação de alto nível e interface humana
- **MailBot (CT 101):** Especialista em comunicação - gestão completa de emails e comunicações externas
- **DATASVR (CT 102):** Guardião de dados - armazenamento, backup e compartilhamento autônomo
- **Supervisor (CT 103):** Guardião do sistema - monitoramento de saúde e auto-recuperação
- **Vorcaro (CT 104):** Especialista financeiro - gestão financeira completa e análise de transações
- **OfficeBoy (CT 105):** Assistente geral - tarefas administrativas e automação de rotinas
- **Seguranca (CT 106):** Especialista em proteção - segurança de rede e conformidade autônoma
- **SAMU (CT 107):** Socorrista do sistema - resposta a emergências e recuperação de falhas

Cada agente opera com independência total em sua especialidade, mantendo apenas protocolos essenciais de coordenação e segurança.

### Fluxo de Falha (atualizado para arquitetura independente):
```
Agente detecta problema → Tenta auto-recuperação → Se falha persistir → Log registra → 
→ Supervisor verifica escalonamento → Se necessário → Stark notifica Acib (Telegram) → 
→ Acib autoriza (se for ação destrutiva) → Stark coordena reparo → Agente executa recuperação
```

### Métricas de Independência (tracked continuamente):
- Tempo operacional sem intervenção externa
- Número de decisões tomadas autonomamente
- Redução em solicitações de autorização para operações de rotina
- Melhoria em métricas específicas da especialidade de cada agente

### Fonte: INDEPENDENCIA-AGENTES.md (arquitetura completa de autonomia dos agentes)

## Credenciais

| CT | IP | Senha Root |
|----|----|------------|
| Mails (101) | 192.168.0.240 | Rcmp814k@# |
| DATASVR (102) | 192.168.0.72 | Rcmp@814k$1982 |
| Supervisor (103) | 192.168.0.42 | Rcmp814k@# |
| Seguranca (106) | 192.168.0.231 | Rcmp814k | sshpass required for SSH |
| OfficeBoy (105) | 192.168.0.117 | Rcmp814k@# |

### Email - Gmail acibabbadecastro@gmail.com
| Campo | Valor |
|-------|-------|
| **Email** | acibabbadecastro@gmail.com |
| **App Password** | juqqogjysxvpowtu |
| **Status** | ✅ FUNCIONANDO |
| **Acesso** | IMAP via MailBot (CT 101) |

### Email - Gmail acibabbade@gmail.com
| Campo | Valor |
|-------|-------|
| **Email** | acibabbade@gmail.com |
| **App Password** | obtx vtvr znrw bxlv |
| **Status** | ✅ FUNCIONANDO |
| **Total emails** | 560 |
| **Acesso** | IMAP via MailBot (CT 101) |

## 📂 DADOS COMPARTILHADOS
**Pasta:** `/mnt/data/` (DATASVR - 500GB)
- Estrutura LAN: `/home/master/LAN/`
- Memórias: `/home/master/LAN/MEMORIES/`
- Logs: `/home/master/LAN/LOGS/`
- Emails: `/home/master/LAN/Emails/`
- Acib acessa via Windows (Samba: `\\192.168.0.72`)

## 📊 Sistema Financeiro Nubank - ATUALIZADO 04/04

### Contas:
| ID | CNPJ/CPF | Conta | Nome | Saldo |
|----|----------|-------|------|-------|
| PJ65 | 65.384.056/0001-32 | 986080174-7 | ABBADE Informatica | R$ 12,81 |
| PJ20 | 20.153.208/0001-58 | 118844303 | (mesma titularidade) | -R$ 185,31 |
| PF | 307.572.858-64 | 169842561 | ACIB ABBADE DE CASTRO | R$ 20,81 |

### Database:
- **MailServer:** /home/master/Stark_Output/Financeiro/Nubank/transacoes.db
- **Script:** /home/master/consulta_nubank.sh
- **Total transações:** 379

### Pasta de Dados:
- /home/master/Stark_Output/Financeiro/Nubank/Extratos/
- /home/master/Stark_Output/Financeiro/Nubank/Transacoes/

### Responsável:
- **Vorcaro** (CT 104) - Gerenciamento financeiro
- **MailBot** (CT 101) - Processamento emails/extração

### Extratos Disponíveis:
| Arquivo | Conta | Período |
|---------|-------|---------|
| 554_NU_9860801747_27FEV2026_03ABR2026.csv | PJ65 | 27/02 a 03/04/2026 |
| 135_NU_118844303_01JAN2026_03ABR2026.csv | PJ20 | 01/01 a 03/04/2026 |
| NOVO_PF_JAN2026.csv | PF | Janeiro/2026 |

### Top Fornecedores (Gastos):
| Fornecedor | Qtd | Valor |
|------------|-----|-------|
| Aplicação RDB | 11x | R$ 8.014,81 |
| ALL PRO IMPORTS | 4x | R$ 2.758,80 |
| ROGERIO ESPEDITO | 13x | R$ 2.268,28 |
| ATACADAO | 10x | R$ 1.529,73 |
| **ATUAL PECAS** (Silvana/Rogerio) | 14x | R$ 1.124,50 |
| HOUTER DO BRASIL | 2x | R$ 1.222,12 |

### Clientes/Fornecedores Identificados:
| Nome | Tipo | Observação |
|------|------|------------|
| ATUAL PECAS | Fornecedor | Proprietários: Silvana Barbosa, Rogerio Espedito |

## 📈 Sistema de Categorização Financeira
- Tipos de movimentações documentados
- Cruzamento de dados em desenvolvimento
- Base de clientes e fornecedores sendo construídas

## PENDENCIAS IMPORTANTES (2026-04-04)

### 1. Gmail - FUNCIONANDO ✅
- App Password: juqqogjysxvpowtu
- Email: acibabbadecastro@gmail.com
- 3 extratos Nubank baixados

### 2. Supervisor - Configurado ✅
- Cron a cada 10 minutos
- Notifica Stark via Telegram
- 2 agentes OFFLINE: OfficeBoy, Seguranca

## SAMU (CT 107)
- **IP:** 192.168.0.64
- **Função:** Socorrista do Stark
- **Status:** Configurado e ativo
