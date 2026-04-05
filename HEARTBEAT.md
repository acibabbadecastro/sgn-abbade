# HEARTBEAT.md - Periodic Checks

## IPs Corretos dos Agentes (ATUALIZADO 2026-04-05 11:10)
| CT | Nome | IP | Porta | Status Real |
|----|------|-----|-------|-------------|
| 100 | Stark | 192.168.0.192 | 18789 | ✅ ONLINE |
| 101 | MailBot | 192.168.0.240 | 18789 | ✅ ONLINE |
| 102 | DATASVR | 192.168.0.72 | 18789 | ✅ ONLINE |
| 103 | Supervisor | 192.168.0.42 | 18789 | ✅ ONLINE |
| 104 | Vorcaro | 192.168.0.172 | 18789 | ✅ ONLINE |
| 105 | OfficeBoy | 192.168.0.117 | 18789 | ✅ ONLINE |
| 106 | Seguranca | 192.168.0.231 | 18789 | ✅ ONLINE (sshpass) |
| 107 | SAMU | 192.168.0.64 | 18789 | ✅ ONLINE |

## ✅ STATUS GERAL:
- **Todos os 8 containers estão RUNNING**
- **Thin Pool:** ~53% usado (normal)
- **Acesso SSH:** Todos acessíveis via senha `Rcmp814k` + `sshpass` (exceto onde chave SSH configurada)
- **Monitoramento:** Supervisor (CT 103) ativo

## 📊 IPs vs Hostnames
```
CT 100 Stark    → 192.168.0.192 (pve1)
CT 101 MailBot  → 192.168.0.240
CT 102 DATASVR  → 192.168.0.72
CT 103 Supervisor → 192.168.0.42
CT 104 Vorcaro  → 192.168.0.172
CT 105 OfficeBoy → 192.168.0.117
CT 106 Seguranca → 192.168.0.231
CT 107 SAMU     → 192.168.0.64
```

## 🔧 ACESSO SSH
Use:
```bash
sshpass -p 'Rcmp814k' ssh -o StrictHostKeyChecking=no -o PreferredAuthentications=password -o PubkeyAuthentication=no root@<IP>
```

Exemplo:
```bash
sshpass -p 'Rcmp814k' ssh -o StrictHostKeyChecking=no -o PreferredAuthentications=password -o PubkeyAuthentication=no root@192.168.0.231 "hostname"
```

## 📋 CHECK DE STATUS (a cada heartbeat):
1. ✅ Verificar se Supervisor está rodando (pct status 103)
2. ✅ Verificar se todos os containers estão RUNNING
3. ✅ Verificar logs recentes: /root/supervisor/team.log
4. ✅ Verificar Thin Pool (<80% ideal)
5. Se mudança crítica → Notificar Acib via Telegram

## 🔄 SUPERVISOR (CT 103):
- ✅ Monitora a cada 10 minutos (cron configurado)
- ✅ Verifica via pgrep openclaw (SSH)
- ✅ Notifica Stark quando detecta OFFLINE
- Script: /root/supervisor/team_monitor.sh
- Log: /root/supervisor/team.log

## 💾 DATASVR (CT 102):
- IP: 192.168.0.72
- Contém: /mnt/data/LAN/ (compartilhado via Samba)
- Backup de sessões e recovery kit

## 🛡️ SEGURANCA (CT 106):
- IP: 192.168.0.231
- Função: Verificação de portas e segurança de rede
- SSH: Requer senha + sshpass (configuração especial)

## 🤖 RESPONSABILIDADES DE INDEPENDÊNCIA

Agora que o sistema opera com independência total dos agentes, cada heartbeat verifica também:

### 🎯 Independência Operacional
- Cada agente mantém autonomia em sua especialidade
- Decisões técnicas são tomadas localmente sem consulta
- Protocolos de auto-recuperação estão ativos

### 📊 Métricas de Autonomia
- Tempo desde última intervenção externa
- Número de decisões autônomas tomadas
- Redução em solicitações de autorização para operações de rotina

### 🔄 Ciclo de Melhoria Contínua
- Agentes atualizam documentação de aprendizados
- Compartilhamento de boas práticas via memórias compartilhadas
- Ajustes finos em thresholds e políticas baseado em experiência

## 📋 CHECK DE INDEPENDÊNCIA (a cada heartbeat):
1. Verificar se agentes estão operando dentro de suas especialidades
2. Confirmar que nenhuma ação requer autorização pendente
3. Validar que métricas de autonomia estão melhorando
4. Confirmar compartilhamento de conhecimento em /home/master/LAN/MEMORIES/
5. Se agente requer suporte especializado → Notificar via OpenClaw session

## ⚠️ PROTOCOLOS DE ESCALONAMENTO

Apesar da independência, certas situações ainda requerem coordenação:

### Escalar para Stark (CT 100):
- Conflitos de recursos entre agentes
- Decisões de política que afetam múltiplos domínios
- Situações de segurança que requerem julgamento de valor

### Escalar para Acib (Human):
- Ações que requerem autorização explícita (conforme Red Lines)
- Decisões estratégicas de alto nível
- Situações que excedem o escopo de autonomia definida

Lembrete: A independência não significa isolamento total, mas sim autonomia máxima com coordenação minimalista e eficaz.