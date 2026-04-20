# HEARTBEAT.md - Periodic Checks

## IPs Corretos dos Agentes (ATUALIZADO 2026-04-12 19:00)
| CT | Nome | IP | Porta | Status Real |
|----|------|-----|-------|-------------|
| 100 | Stark | 192.168.0.21 | 18789 | ✅ ONLINE |
| 101 | STARK (ex-Mails) | 192.168.0.240 | 18789 | ✅ ONLINE |
| 102 | DATASVR | 192.168.0.72 | 18789 | ✅ ONLINE |
| 103 | BD | 192.168.0.109 | 18789 | ✅ ONLINE |
| 104 | SGN | 192.168.0.99 | 18789 | ✅ ONLINE |
| 105 | MAILS | 192.168.0.224 | 18789 | ✅ ONLINE |
| 106 | Vorcaro | DHCP | 18789 | ✅ ONLINE |
| 107 | SAMU | 192.168.0.64 | 18789 | ✅ ONLINE |
| 108 | Scraper | DHCP | 18789 | ✅ ONLINE |
| 109 | ADM-SERVMIL | DHCP | 18789 | ✅ ONLINE |
| 110 | bd-servmil | DHCP | 18789 | ✅ ONLINE |
| 111 | Fe-Servmil | DHCP | 18789 | ✅ ONLINE |
| 112 | Analista-Servmil | DHCP | 18789 | ✅ ONLINE |

## ✅ STATUS GERAL:
- **Total containers:** 13 (CT 112 adicionado em 2026-04-12 19:00)
- **Thin Pool:** ~38.5% usado (normal)
- **Acesso SSH:** Todos acessíveis via senha `Rcmp814k@#` + `sshpass` (exceto DATASVR: `Rcmp@814k$1982`)
- **Monitoramento:** Supervisor (CT 103) ativo

## 📊 Arquitetura Completa (13 Containers)
```
CT 100 Stark          → 192.168.0.21    (Orquestrador)
CT 101 STARK          → 192.168.0.240   (MailBot)
CT 102 DATASVR        → 192.168.0.72    (Armazenamento/Samba)
CT 103 BD             → 192.168.0.109   (PostgreSQL)
CT 104 SGN            → 192.168.0.99    (Sistema Web)
CT 105 MAILS          → 192.168.0.224   (Processamento Emails)
CT 106 Vorcaro        → DHCP            (Financeiro)
CT 107 SAMU           → 192.168.0.64    (Socorro/Emergência)
CT 108 Scraper        → DHCP            (Coleta de dados)
CT 109 ADM-SERVMIL    → DHCP            (Administração SERVMIL)
CT 110 bd-servmil     → DHCP            (Banco SERVMIL)
CT 111 Fe-Servmil     → DHCP            (Frontend SERVMIL)
CT 112 Analista-Servmil → DHCP          (Análise de dados SERVMIL)
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
1. Verificar se containers estão RUNNING
2. Verificar Thin Pool (<80% ideal)
3. **REGRA:** Só notificar se houver PROBLEMA ou mudança crítica
4. Status normal = HEARTBEAT_OK silencioso

## 🔄 ATUALIZAÇÃO DE MEMÓRIAS (CONFIGURADO)

### **Frequência:**
```
✅ 4 HORAS: Atualização automática de memórias compartilhadas (NOVA REGRA CRÍTICA 16/04)
📍 Local: /home/master/LAN/MEMORIES/
🔔 Notificações: APENAS FALHAS CRÍTICAS
```

### **Checklist (a cada 4h):**
1. Verificar mudanças em memory/*.md
2. Sincronizar com /home/master/LAN/MEMORIES/
3. **Verificar falhas/saúde do sistema**
4. **Se FALHA CRÍTICA detectada** → Notificar Acib imediatamente
5. **Se tudo OK** → HEARTBEAT_OK (silêncio total)

### **Política de Notificação:**
```
🚨 FALHAS CRÍTICAS: Notificar IMEDIATAMENTE
   • Gateway offline
   • Containers críticos OFFLINE
   • Banco de dados indisponível
   • Serviços essenciais falhando
   • Erros de sistema repetidos

🔕 NÃO NOTIFICAR:
   • Atualizações de rotina
   • Lembretes de compromissos
   • Status normal do sistema
   • Informações informativas

🌅 10:00 e 🌆 19:00:
   • APENAS se houver algo MUITO relevante
   • Caso contrário: silêncio
```

### **Regra de Ouro:**
- Memórias compartilhadas: ATUALIZAR A CADA **4 HORAS** (alterado 16/04/2026)
- Notificações: **APENAS FALHAS CRÍTICAS**
- Se tudo OK → HEARTBEAT_OK (não incomodar)
- Se falha detectada → Verificar e notificar Acib

## 💾 DATASVR (CT 102):
- IP: 192.168.0.72
- Contém: /mnt/data/LAN/ (compartilhado via Samba)
- Backup de sessões e recovery kit

## 🛡️ SEGURANCA (CT 106):
- IP: 192.168.0.231
- Função: Verificação de portas e segurança de rede
- SSH: Requer senha + sshpass (configuração especial)

## 🗄️ BANCO SGN (CT 103 - 192.168.0.109:5432)
| Campo | Valor |
|-------|-------|
| Banco | sgn |
| Usuario | acib |
| Schemas | estoque, clientes, os, financeiro, fornecedores, garantia, agenda |

## 🌐 SGN WEB SERVER (192.168.0.99)
| Página | URL |
|--------|-----|
| SGN Principal | http://192.168.0.99 |
| Admin BD | http://192.168.0.99/admin_bd.php |
| Dashboard | http://192.168.0.99/ |

⚠️ **Nota:** SGN Web roda em servidor dedicado (192.168.0.99), não em container CT específico
| Pasta | Caminho Rede |
|-------|-------------|
| LAN | \\\\192.168.0.72\\LAN\\ |
| MD | \\\\192.168.0.72\\LAN\\MD\\ |
| Documentacao | \\\\192.168.0.72\\LAN\\Documentacao\\ |
| MEMORIES | \\\\192.168.0.72\\LAN\\MEMORIES\\ |

## 🗄️ BANCO SGN (CT 103 - 192.168.0.109:5432)
| Campo | Valor |
|-------|-------|
| Banco | sgn |
| Usuario | acib |
| Schemas | estoque, clientes, os, financeiro, fornecedores, garantia, agenda |

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