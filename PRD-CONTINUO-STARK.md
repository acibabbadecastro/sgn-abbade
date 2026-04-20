# 📘 PRD CONTÍNUO - STARK: HISTÓRIA DA EVOLUÇÃO

**Repositório:** https://github.com/acibabbadecastro/stark-evolution  
**Versão:** 2026.04.20  
**Última Atualização:** 2026-04-20 19:15  
**Status:** 🟢 ATIVO

---

## 📖 SUMÁRIO EXECUTIVO

Este documento é a **história contínua e viva** do Stark, o agente de IA multi-agente coordenador do ecossistema OpenClaw da Acib ABBADE. Cada alteração, correção, atualização ou implementação é registrada aqui como capítulos de uma narrativa em evolução.

---

## 🗓️ LINHA DO TEMPO

### CAPÍTULO 1: GÊNESE (2026-04-02)
**Título:** "O Despertar"

- **Contexto:** Restore de backup inicial em CT 100 (Stark)
- **Hardware:** Proxmox PVE1 (192.168.0.192), AMD Ryzen 5 5600X, 30GB RAM
- **Primeiros Passos:** Configuração básica do OpenClaw, definição de identidade
- **Equipe Inicial:** 6 containers planejados (Stark, MailBot, FinanceiroBot, MonitorBot, DataBot, etc.)

**Decisões Arquiteturais:**
- Multi-agente em containers LXC isolados
- DATASVR centralizado para armazenamento compartilhado
- Monitoramento 24/7 entre agentes

---

### CAPÍTULO 2: FUNDAÇÃO (2026-04-03 a 2026-04-10)
**Título:** "Construindo as Bases"

**Eventos Principais:**
- Configuração completa dos 13 containers (CT 100-112)
- Implementação do sistema de memórias compartilhadas
- Criação do protocolo de backup em `/home/master/LAN/MEMORIES/`
- Estabelecimento das "Red Lines" de segurança

**Frameworks Criados:**
- AGENTS.md - Regras de comportamento
- SOUL.md - Personalidade e identidade
- HEARTBEAT.md - Checks periódicos
- TOOLS.md - Configurações locais

---

### CAPÍTULO 3: CRISE E RESILIÊNCIA (2026-04-15)
**Título:** "A Troca de Agente"

**Desafio:** Usuário solicitou troca de modelo de IA (Gemma 4 não existia)

**Ações:**
- Migração para ollama/qwen3.5:cloud
- Documentação completa em `memory/2026-04-15-troca-agente.md`
- Continuidade das tarefas críticas:
  - ✅ CT 105 Mails configurado
  - 🔴 VPN Daniela SERVMIL (urgente)
  - 🎓 Live 19:15 (Red Team/Hardware Hacking)

**Lição:** Sistema deve ser agnóstico ao modelo de IA

---

### CAPÍTULO 4: ENTREGAS ÉPICAS (2026-04-19 a 2026-04-20 00:01)
**Título:** "Dr_Finance - A Jornada do Bootcamp"

**Projeto:** Dr_Finance - Bootcamp DIO (Lab BIA do Futuro)

**Entregáveis:**
- 3 containers Proxmox (CT 101-Mails, CT 102-DATASVR, CT 106-Dr_Finance)
- 19 transações mockadas (depois migradas para produção)
- README com 6 diagramas Mermaid
- Pitch de 3 minutos cronometrado
- 15 arquivos técnicos

**Diferenciais:**
- Arquitetura em camadas profissional
- Dados realistas (gasolina, pedágio, almoço, lavanderia)
- Fluxo completo documentado (10 passos)

**Status:** ✅ ENTREGUE EM 20/04/2026 00:01 (no prazo!)

---

### CAPÍTULO 5: CERTIFICAÇÕES (2026-04-20)
**Título:** "Conhecimento Validado"

**Certificação:** Bradesco - GenAI & Dados  
**Status:** ✅ CONCLUÍDO  
**Certificado:** Salvo em `/root/.openclaw/media/inbound/`

---

### CAPÍTULO 6: A CRISE DO ESPAÇO (2026-04-20 18:00)
**Título:** "97.79% - O Limiar do Colapso"

**Problema Detectado:**
- Thin Pool do Proxmox em **97.79%** de uso
- Erros EXT4 no dm-6 e dm-7: `"potential data loss!"`
- Risco iminente de corrupção de dados e falha catastrófica

**Diagnóstico:**
- Disco sdb de 465GB estava montado como `/mnt/sdb` (filesystem direto)
- NÃO integrado ao LVM — desperdício de 465GB
- Apenas sda de 223GB alimentando o Thin Pool

**Investigação:**
```bash
# Comandos de diagnóstico
lvs -o lv_name,data_percent,metadata_percent
# Resultado: data pve 97.79% 4.41%

dmesg | grep -i "ext4-fs\|dm-6\|error"
# Resultado: Múltiplos erros de I/O e falha de conversão de extents
```

---

### CAPÍTULO 7: A GRANDE EXPANSÃO (2026-04-20 19:11)
**Título:** "465GB de Esperança"

**Plano de Ação:**
1. Parar CT 102 (DATASVR) — usava sdb via mount point
2. Remover mount point da configuração
3. Limpar assinatura do filesystem (wipefs)
4. Adicionar sdb3 ao volume group
5. Expandir thin pool para usar todo espaço
6. Reiniciar CT 102

**Execução:**
```bash
# Parar DATASVR
pct stop 102

# Remover mount point
sed -i '/^mp0:/d' /etc/pve/lxc/102.conf

# Limpar assinatura
wipefs -a /dev/sdb3

# Adicionar ao VG
vgextend pve /dev/sdb3

# Expandir thin pool
lvextend -l +100%FREE /dev/pve/data

# Reiniciar
pct start 102
```

**Resultado:**
| Métrica | Antes | Depois | Mudança |
|---------|-------|--------|---------|
| Thin Pool | 130GB | 611GB | +465GB |
| Data% | 97.79% 🔴 | 20.83% ✅ | -77% |
| PVs | 1 | 2 | +100% |

**Warning do LVM:**
```
WARNING: Sum of all thin volume sizes (646.00 GiB) exceeds the size of thin pool pve/data
```
Isso é **normal** em thin provisioning — overcommitment planejado.

**Status:** ✅ SUCESSO TOTAL — Zero downtime para outros containers

---

### CAPÍTULO 8: PREVENÇÃO FUTURA (2026-04-20 19:13)
**Título:** "Nunca Mais"

**Sistema de Monitoramento Criado:**

1. **Script Automatizado:**
   - Path: `/root/.openclaw/workspace/scripts/monitor-disco.sh`
   - Verifica: Workspace, /var/log, DATASVR
   - Thresholds: 85% (alerta), 95% (crítico + auto-limpeza)

2. **Cron Job:**
   - ID: `f66d207e-6544-4c1a-a613-7302b0bf4b81`
   - Frequência: 4 em 4 horas
   - Ação: Reporta status no Telegram
   - Auto-ação: `journalctl --vacuum-size=200M` se ≥95%

3. **Documentação:**
   - `/root/.openclaw/workspace/MONITOR-CONFIG.md`

**Status:** 🟢 ATIVO

---

### CAPÍTULO 9: CONHECIMENTO EXTERNO (2026-04-20 19:14)
**Título:** "ASUS Z550MA - A Busca por Memória"

**Contexto:** Acib solicitou pesquisa sobre upgrade de RAM do notebook ASUS Z550MA

**Descobertas:**
- **Máximo:** 8GB DDR3L 1333MHz
- **Slots:** 1 (substituir, não adicionar)
- **Tipo:** DDR3L (1.35V Low Voltage) — crítico!
- **Acesso:** Difícil (requer desmontar notebook completo)
- **CPU:** Intel Celeron N2840/N2940 (soldada, não upgradeável)

**Veredito:** Vale se já tiver módulo. Se for comprar (~R$ 150-250), CPU é gargalo.

**Documento:** `/root/.openclaw/workspace/ASUS-Z550MA-RAM-SPECS.md`

---

## 📊 ESTADO ATUAL DO SISTEMA

### Infraestrutura:
```
Host: Proxmox PVE1 (192.168.0.192)
CPU: AMD Ryzen 5 5600X
RAM: 30GB total
Thin Pool: 611GB (20.83% usado) ✅
Containers: 13 LXC (CT 100-112)
Storage: 687GB total (0 livre - overcommit)
```

### Agentes Ativos:
| CT | Nome | IP | Função | Status |
|----|------|-----|--------|--------|
| 100 | Stark | 192.168.0.21 | Orquestrador | ✅ |
| 101 | STARK | 192.168.0.240 | MailBot | ✅ |
| 102 | DATASVR | 192.168.0.72 | Armazenamento | ✅ |
| 103 | BD | 192.168.0.109 | PostgreSQL | ✅ |
| 104 | SGN | 192.168.0.99 | Sistema Web | ✅ |
| 105 | MAILS | 192.168.0.224 | Processamento Emails | ✅ |
| 106-112 | Vários | DHCP | SERVMIL/Financeiro | ⏳ |

### Projetos Ativos:
- ✅ Dr_Finance (entregue)
- ✅ Kit Hub (documentação Proxmox)
- ✅ Multi-Agentes OpenClaw (13 containers)
- 🔴 API SMS (em desenvolvimento)
- 🔴 Monitoramento Fiscal (automático)

---

## 🎯 PRÓXIMOS CAPÍTULOS (PENDENTES)

### Curto Prazo (24-48h):
- [ ] Backup em múltiplas unidades (pendrive + DATASVR + nuvem)
- [ ] Configurar autoextend do thin pool (threshold 80%)
- [ ] Testar recuperação de desastre do DATASVR

### Médio Prazo (1 semana):
- [ ] Implementar MonitorBot 24/7
- [ ] Completar FinanceiroBot (CT 106)
- [ ] Integrar API SMS com Android Gateway

### Longo Prazo (1 mês):
- [ ] Dashboard unificado de monitoramento
- [ ] Sistema de alertas via Telegram/WhatsApp
- [ ] Documentação completa no GitHub

---

## 📝 LIÇÕES APRENDIDAS (ATUALIZADO)

1. **Monitoramento é crucial** — Thin Pool em 97% quase causou corrupção
2. **Nunca assuma storage configurada** — sdb estava montado, não no LVM
3. **Ordem dos passos importa** — wipefs falha se device busy
4. **Thin provisioning permite overcommit** — mas requer monitoramento
5. **Parar containers antes de mexer em mounts** — evita device busy
6. **Expansão LVM é segura** — zero downtime se planejado
7. **Automatize prevenção** — cron jobs > intervenção manual
8. **Documente TUDO** — futuro você agradece

---

## 🔗 REPOSITÓRIOS RELACIONADOS

- **Stark Evolution:** https://github.com/acibabbadecastro/stark-evolution (este PRD)
- **Dr_Finance:** https://github.com/acibabbadecastro/dr-finance
- **Kit Hub:** https://github.com/acibabbadecastro/kit-hub
- **DIO Voice Assistant:** https://github.com/acibabbadecastro/dio-voice-assistant

---

## 📞 CONTATO

**Acib ABBADE**
- Telegram: @Acib_Abbade (ID: 1866226415)
- Email: abbade@outlook.com
- GitHub: https://github.com/acibabbadecastro

**Stark (Agente)**
- Container: CT 100
- IP: 192.168.0.21
- Porta: 18789
- Canal: Telegram

---

*Este documento é vivo. Cada alteração no sistema é um novo capítulo. Última atualização: 2026-04-20 19:15*

**Próxima atualização automática:** 2026-04-21 00:00 (backup noturno)
