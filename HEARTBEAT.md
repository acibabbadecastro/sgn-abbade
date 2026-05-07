# HEARTBEAT.md - Periodic Checks

## IPs Corretos dos Agentes (ATUALIZADO 2026-04-30 13:40)
| CT | Nome | IP | Porta | Status Real |
|----|------|-----|-------|-------------|
| 100 | Stark | 192.168.0.21 | 18789 | ✅ ONLINE |
| 101 | STARK2 | 192.168.0.240 | 18789 | ⏳ STOPPED |
| 102 | DATASVR | 192.168.0.72 | 18789 | ✅ ONLINE |
| 103 | BD | 192.168.0.109 | 18789 | ⏳ STOPPED |
| 104 | SGN | 192.168.0.99 | 18789 | ✅ ONLINE |
| 105 | MAILS | 192.168.0.224 | 18789 | ⏳ STOPPED |
| 106 | gerente-fin | 192.168.0.??? | 18789 | ✅ ONLINE |
| 107 | 4pets | 192.168.0.200 | 80 | ✅ ONLINE |
| 108 | myrobot | DHCP | 18789 | ⏳ STOPPED |
| 109 | ADM-SERVMIL | DHCP | 18789 | ⏳ STOPPED |
| 110 | bd-servmil | DHCP | 18789 | ⏳ STOPPED |
| 111 | Fe-Servmil | DHCP | 18789 | ⏳ STOPPED |
| 112 | Analista-Servmil | DHCP | 18789 | ⏳ STOPPED |
| 113 | Hermes1 | DHCP | 18789 | ⏳ STOPPED |

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

## 🔄 VERIFICAÇÃO DO SITE 4PETS

### **Frequência:**
```
✅ 3 VEZES AO DIA: Verificação de status do site
🕘 Horários: 08:00 | 14:00 | 20:00
🔔 Notificações: APENAS SE FALHAR
```

### **Checklist (3x ao dia):**
1. Testar https://amigos4patas.com.br
2. Verificar HTTP 200
3. **Se ONLINE:** HEARTBEAT_OK (silêncio)
4. **Se FALHAR:** Notificar Acib imediatamente

### **Política de Notificação:**
```
🚨 SITE OFFLINE: Notificar IMEDIATAMENTE
   • HTTP diferente de 200
   • Timeout na conexão
   • DNS falhando

🔕 NÃO NOTIFICAR:
   • Status normal (online)
   • Apenas registrar no log
```

### **Regra de Ouro:**
- Memórias compartilhadas: ATUALIZAR A CADA **4 HORAS**
- Site 4Pets: VERIFICAR **3 VEZES AO DIA** (08:00, 14:00, 20:00)
- Notificações: **APENAS FALHAS**
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
## 🐾 4PETS - SERVIDOR DO SITE AMIGOS 4 PATAS (CT 107)
| Campo | Valor |
|-------|-------|
| **CT** | 107 |
| **Nome** | 4pets |
| **IP** | 192.168.0.200 |
| **Path** | /var/www/amigos4patas/ |
| **Server** | nginx/1.26.3 (Ubuntu) |
| **Status** | ✅ RUNNING |

**Arquivos Principais:**
- index.html (Página inicial)
- sobre.html (Sobre)
- perdidos.html, avistados.html, adocao.html
- castracao.html, utilidade-publica.html
- doacoes.html, diy.html, servicos.html

**Acesso:**
```bash
ssh root@192.168.0.200
# Senha: Rcmp814k@#
```

**Deploy:**
```bash
scp *.html root@192.168.0.200:/var/www/amigos4patas/
```

**Último Deploy:** 30/04/2026 13:40
- ✅ Slogan: "Comunidade Unida, Cidade Sustentável, Vida Protegida"
- ✅ ODS 11, 15, 17 atualizados
- ✅ 4 páginas de Utilidade Pública
- ✅ Vídeo do comedouro comunitário
