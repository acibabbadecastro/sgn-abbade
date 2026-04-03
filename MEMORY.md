# MEMORY.md - Long-Term Memory

## Identity
- **Name:** Stark 🤖
- **Restore date:** 2026-04-02
- **Backup source:** /mnt/meu-pendrive/Stark_Backup/

## User Info
- **User:** master (based on home directory)
- **Hardware:** AMD Ryzen 5 5600X, 30GB RAM, AMD RX 580 8GB, 223GB SSD
- **Pen Drive:** 57GB (Ventoy) mounted at /mnt/meu-pendrive

## Infrastructure
- **Running on:** Proxmox CT 100 (pve1: 192.168.0.192)
- **SSH:** Configured and working on pve1
- **Ollama:** Running on port 11434
- **OpenClaw Gateway:** Running on port 18789

## Ollama Models
- **Default:** phi4-mini:latest
- **Available:** qwen2.5:3b, qwen2.5:7b, qwen3.5:0.8b, qwen3.5:latest, llama3:8b, mistral

## Important Protocols
- **Memory Organization:** Ask before creating new folders/categories
- **Log Format:** Date + Time + Request + Action + Result
- **Backup:** Keep redundancy on pendrive and local

## Key Learnings
- Telegram plugin must be enabled separately: `openclaw plugins enable telegram`
- Channel config ≠ Plugin enabled
- Pendrive backups in /mnt/meu-pendrive/Stark_Backup/

## Scripts Available
- `/mnt/meu-pendrive/Stark_Backup/Scripts/ATIVAR-LOGIN-AUTOMATICO.sh`
- `/mnt/meu-pendrive/Stark_Backup/Scripts/BACKUP-AUTOMATICO.sh`
- `/mnt/meu-pendrive/Stark_Backup/Scripts/RESTAURAR-BACKUP.sh`

## Preferences Restored (2026-04-02)
- SOUL.md, USER.md, TOOLS.md, AGENTS.md, HEARTBEAT.md, PREFERENCIAS.md
- Memory files from 2026-03-24 and 2026-03-25

## User Updated (2026-04-02)
- **Name:** Acib ABBADE
- **Telegram:** Acib_Abbade (ID: 1866226415)
- **Backup restored from pendrive**

## Sistema Multi-Agente - Arquitetura de Equipe (2026-04-02)

### Estrutura da Equipe
- **Maestro (Stark - EU):** Coordena todos, relatorios, decisões
- **EmailBot:** CT ??? — ler emails, responder, organizar
- **FinanceiroBot:** CT ??? — contas, gastos, orçamento
- **LembretesBot:** CT ??? — lembretes, agendamentos, follow-up
- **DataBot:** CT ??? — backup, arquivos, organização

### Regras de Monitoramento (OBRIGATÓRIO)
1. **Monitoramento Constante:** Um agente monitora todos os outros 24/7
2. **Se algum falhar:**
   - Registrar LOGS imediatamente
   - Verificar ÚLTIMAS AÇÕES do agente que falhou
   - Notificar Stark (Maestro)
   - Stark notifica o usuário (Acib)
   - Pedir AUTORIZAÇÃO antes de Reparar
   - Reparar SOMENTE com consentimento do usuário
3. **Reparar:** Corrigir o problema identificado
4. **Tudo com consentimento:** Nada de ação destrutiva sem aprovação

### Fluxo de Falha:
```
Agente falha → Monitor detecta → Log registra → Stark verifica últimas ações 
→ Stark notifica Acib → Acib autoriza → Stark repara → Log atualiza
```

### Memória Permanente: SIM
- Este protocolo deve ser lembrado SEMPRE
- Não pode ser apagado ou sobrescrito
- Atualizar apenas com aprovação do usuário

## ⚠️ PROTOCOLO DE BACKUP DE SESSÕES (2026-04-03)

### Problema Identificado:
- Sessões do OpenClaw NÃO persistem entre reinicializações
- Um dia inteiro de conversas foi perdido (02/04)
- Necessário criar sistema de backup automático

### Solução Implementada:
1. **Backup Local:** `/root/.openclaw/backups/sessions/`
2. **Script:** `/root/.openclaw/scripts/backup-sessions.sh`
3. **Frequência:** A cada 60 minutos via cron
4. **Retenção:** Últimos 10 backups

### Cron Job Ativo:
- ID: `4a72e14b-f00a-4fdd-962d-da1e43d49e08`
- Próximo backup: +60 minutos

### Pendrive:
- Montado como `ro` (read-only) — NÃO é possível salvar nele
- Backup local em `/root/.openclaw/backups/`

## Equipe de Agentes - Atualizado (2026-04-02)

| Agente | CT | Especialidade |
|--------|-----|---------------|
| Maestro Stark | 100 | Coordenação/Geral |
| MailBot | 101 | Emails |
| FinanceiroBot | 3 | Finanças |
| Supervisor (CT 4) | Monitoramento 24/7 + Auxílio ao Stark | 🔜 Fase 2 |
| DataBot | 5 | Armazenamento/PDFs/Logs |

CT 5 terá estrutura de pastas:
- /mnt/data/emails/
- /mnt/data/financeiros/
- /mnt/data/lembretes/
- /mnt/data/logs/
- /mnt/data/pdfs/
- /mnt/data/backups/
- /mnt/data/agenda/

MonitorBot (CT 4) é o agente de monitoramento CONSTANTE.

## Sistema Financeiro - Especificações (2026-04-02)

### Fluxo de Dados:
1. Email bancário → MailBot (recebe/filtra)
2. → FinanceiroBot (classifica/registra)
3. → DataBot (armazena/compartilha)
4. → Compartilhado com todos os agentes

### Dados Financeiros a Capturar:
- Dados bancários (banco, agência, conta, tipo)
- Despesas fixas (luz, água, internet, aluguel, assinaturas)
- Cartões de crédito (bandeira, últimos 4 dígitos, limite)
- Fornecedores (nome, CNPJ, contato, serviços)
- Despesas comuns (categorias: alimentação, transporte, saúde, educação)

### Classificação de Transações:
- Tipo: PIX, Débito, Crédito, Dinheiro
- Conta: número da conta
- Código da movimentação
- Data/Hora
- Descrição
- Valor

### Documentos:
- Todos os anexos de emails devem ser:
  - Classificados por tipo (fatura, contrato, nota fiscal, recibo)
  - Armazenados no DataBot (CT 5)
  - Compartilhados entre todos os agentes

### Servidor de Dados (CT 5 - DataBot):
Estrutura de pastas:
- /mnt/data/financeiros/
- /mnt/data/emails/
- /mnt/data/documentos/
- /mnt/data/contratos/
- /mnt/data/faturas/
- /mnt/data/recibos/

## Projeto: Sistema Multi-Agente (PRECIOSO)
- **Documento principal:** `memory/PROJETO.md`
- **Fase 1:** Arquitetura base + Stark como orquestrador
- **Fase 2:** Configurar demais bots (EmailBot, FinanceiroBot, MonitorBot, DataBot)
- **Status:** Em andamento

## Credenciais - CT 102 DATASVR (DataBot)
- **IP:** 192.168.0.72
- **Senha Root:** Rcmp@814k$1982
- **HD:** /mnt/sdb (500GB) montado em /mnt/data dentro do CT
