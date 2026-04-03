# 🚨 GUIA DE RESTAURAÇÃO DE EMERGÊNCIA - STARK

## ⚠️ SE STARK PERDER A MEMÓRIA, CONSULTE ESTE ARQUIVO PRIMEIRO

---

## IDENTIDADE
- **Nome:** Stark 🤖
- **Papel:** Orquestrador/Coordenador do Sistema Multi-Agent
- **Criado em:** 2026-04-02 (restore) / 2026-04-03 (configuração completa)
- **Backup anterior:** /mnt/meu-pendrive/Stark_Backup/

---

## ACIB (MEU HUMANO)
- **Nome:** Acib ABBADE
- **Telegram:** Acib_Abbade (ID: 1866226415)
- **Timezone:** Horário Brasília (UTC-3)
- **Preferências:**
  - Gosta de automação e sistemas multi-agentes
  - Pede autorização para ações destrutivas SEMPRE
  - Valoriza documentação organizada
  - Quer acessar dados pelo Windows

---

## PROJETO: SISTEMA MULTI-AGENT (NOME: PRECIOSO)

### Estrutura de Containers (Proxmox pve1 - 192.168.0.192)

| CT | Nome | IP | Função | Status |
|----|------|-----|--------|--------|
| 100 | Stark | ? | Orquestrador | ✅ ATIVO |
| 101 | Mails | ? | Emails | 🔜 Config |
| 102 | DATASVR | 192.168.0.72 | Servidor de Dados | ✅ CONFIGURADO |
| 103 | Supervisor | 192.168.0.42 | Monitoramento 24/7 | 🔜 Config |

### Fluxo de Operação
```
Bot falha → Supervisor detecta → Log em /mnt/data/logs/
→ Supervisor notifica Stark → Stark notifica Acib via Telegram
→ Acib autoriza → Stark intervém
```

### Locais Padrão de Dados (/mnt/data)
```
/mnt/data/
├── backups/         → Backups de todos os bots
├── logs/            → Logs de todos os bots
├── relatorios/      → Relatórios gerais
├── supervisor/      → Dados do Supervisor
├── emails/          → EmailBot
├── financeiros/     → FinanceiroBot
├── contratos/       → Documentos
├── faturas/         → Faturas
├── agenda/          → Lembretes
├── documentação/    → Documentação do projeto
│   └── projeto-pve1/ → 01-arquitetura, 02-containers, 03-credenciais, 04-procedimentos, 05-relatorios
└── conversas/       → Histórico de conversas
    └── stark/resumos/ → Resumos das sessões
```

---

## CREDENCIAIS IMPORTANTES

### Proxmox (pve1)
- **Host:** 192.168.0.192
- **Acesso:** `ssh root@192.168.0.192`
- **Container:** `pct enter <CT_ID>`

### DATASVR (CT 102)
- **IP:** 192.168.0.72
- **SSH:** `ssh root@192.168.0.72`
- **Senha Root:** Rcmp@814k$1982
- **Samba (Windows):** starkdata / Stark@2026
- **Acesso Windows:** `\\192.168.0.72\data`

### Supervisor (CT 103)
- **IP:** 192.168.0.42
- **SSH:** `ssh root@192.168.0.42`
- **Senha Root:** Rcmp814k@#

---

## ARQUIVOS IMPORTANTES NO STARK

| Arquivo | Conteúdo |
|---------|----------|
| `/root/.openclaw/workspace/MEMORY.md` | Memória permanente |
| `/root/.openclaw/workspace/memory/PROJETO.md` | Arquitetura do projeto |
| `/root/.openclaw/workspace/memory/PERFIL-ACIB.md` | Perfil do usuário |
| `/root/.openclaw/workspace/memory/DATASVR-CT102.md` | Config DATASVR |
| `/root/.openclaw/workspace/memory/SUPERVISOR-CT103.md` | Config Supervisor |
| `/root/.openclaw/workspace/memory/SESSIONS_BACKUP_PROTOCOL.md` | Este arquivo |

---

## CRON JOBS ATIVOS

| ID | Nome | Schedule |
|----|------|----------|
| 4a72e14b-f00a-4fdd-962d-da1e43d49e08 | Backup Sessions OpenClaw | A cada 60 min |

**Script:** `/root/.openclaw/scripts/backup-sessions.sh`
**Local backup:** `/root/.openclaw/backups/sessions/`

---

## PASSOS PARA RESTAURAÇÃO

1. **Verificar se OpenClaw está rodando:**
   ```bash
   openclaw status
   openclaw gateway status
   ```

2. **Restaurar MEMORY.md:**
   - Fonte primária: `/mnt/meu-pendrive/Stark_Backup/`
   - Backup local: `/root/.openclaw/backups/sessions/`

3. **Verificar conectividade com outros CTs:**
   ```bash
   ping 192.168.0.72  # DATASVR
   ping 192.168.0.42  # Supervisor
   ssh root@192.168.0.192 "pct list"  # Listar CTs
   ```

4. **Restaurar sessões perdidas:**
   ```bash
   cp /root/.openclaw/backups/sessions/*.jsonl /root/.openclaw/agents/main/sessions/
   ```

5. **Verificar cron jobs:**
   ```bash
   openclaw cron list
   ```

6. **Ler resumos de conversas:**
   ```bash
   cat /mnt/data/conversas/stark/resumos/*.md
   ```

---

## CONTATO DE EMERGÊNCIA

Se Stark perder TUDO e não tiver como restaurar:
- **Acib ABBADE** - Telegram: @Acib_Abbade
- **Pendrive Backup:** /mnt/meu-pendrive/Stark_Backup/

---

## DATA DA ÚLTIMA ATUALIZAÇÃO
**2026-04-03 00:43 UTC**

*Este arquivo deve ser atualizado sempre que houver mudança significativa no sistema.*
*Manter sincronizado com MEMORY.md e backup no pendrive.*
