# 📊 ARQUITETURA OPENCLAW - ATUALIZADA (ABR/2026)

**Última atualização:** 24/04/2026 16:58  
**Responsável:** Acib ABBADE  
**Documentado por:** Stark

---

## 🏗️ VISÃO GERAL

Infraestrutura de assistentes de IA com OpenClaw em contêineres LXC dentro do Proxmox VE.

---

## 🖥️ MAPEAMENTO DE CONTAINERS

| CT | Nome | IP | Função | Status |
|----|------|-----|--------|--------|
| **100** | **Stark** | 192.168.0.21 | 🧠 **Orquestrador Geral** - Coordenação central de todos os agentes | ✅ ONLINE |
| **101** | **Paramédico** | 192.168.0.240 | 🚑 **Suporte Emergencial** - Recupera CT100 quando há bugs/falhas | ✅ ONLINE |
| **102** | **DATASVR** | 192.168.0.72 | 💾 **Servidor de Dados Compartilhado** - Storage central para todos CTs + acesso externo via Samba | ✅ ONLINE |
| **103** | **Marcos (IA)** | 192.168.0.191 | 🤖 **Inteligência Artificial do Marcos** - Agente pessoal do filho | ✅ ONLINE |
| **104** | ~~SGN~~ | ~~192.168.0.99~~ | ⛔ **REMOVER** - Container inútil | ⛔ **EXCLUIR** |
| **105** | **MAILS** | 192.168.0.224 | 📧 **Verificação Financeira** - Emails: transações, gastos, faturas, contas, cartão, vencimentos | ✅ ONLINE |
| **106** | **Vorcaro** | DHCP | 💰 **Administração Financeira** - Boletos CPF/CNPJ, limite MEI, monitoramento fiscal | ✅ ONLINE |
| **107** | **SAMU** | 192.168.0.64 | 🆘 **Socorro/Emergência** - Resposta rápida a incidentes | ✅ ONLINE |
| **108** | **Scraper** | DHCP | 🔍 **Coleta de Dados** - Web scraping e automações | ✅ ONLINE |
| **109** | **ADM-SERVMIL** | 192.168.0.181 | 🗄️ **Administração FILESERVER SERVMIL** - Gestão servidor de dados da empresa | ✅ ONLINE |
| **110** | **BD-SERVMIL** | DHCP | 🗃️ **Banco de Dados SERVMIL** - PostgreSQL da empresa | ✅ ONLINE |
| **111** | **Fe-Servmil** | DHCP | 🌐 **Frontend SERVMIL** - Servidor de aplicações web | ✅ ONLINE |
| **112** | **Analista-Seg** | DHCP | 🛡️ **Analista de Segurança** - Vulnerabilidades, anomalias, logs, análises de segurança. Alerta: abbade@outlook.com | ✅ ONLINE |
| **113** | **Hermes** | DHCP | ⚡ **Concorrente do Stark** - Agente alternativo/backup | ⏳ **CONFIGURAR** |

---

## 🎯 ORGANIZAÇÃO POR CATEGORIA

### 🧠 Orquestração & Suporte
| CT | Agente | Função |
|----|--------|--------|
| 100 | Stark | Orquestrador principal |
| 101 | Paramédico | Recuperação emergencial do Stark |
| 113 | Hermes | Agente alternativo/concorrente |

### 💾 Infraestrutura & Dados
| CT | Agente | Função |
|----|--------|--------|
| 102 | DATASVR | Storage central compartilhado |

### 👨‍👩‍👧 Família
| CT | Agente | Função |
|----|--------|--------|
| 103 | Marcos (IA) | Assistente pessoal do filho |

### 💰 Financeiro
| CT | Agente | Função |
|----|--------|--------|
| 105 | MAILS | Verificação de emails financeiros |
| 106 | Vorcaro | Administração financeira completa |

### 🏢 SERVMIL (Empresa)
| CT | Agente | Função |
|----|--------|--------|
| 109 | ADM-SERVMIL | Gestão FILESERVER |
| 110 | BD-SERVMIL | Banco de dados |
| 111 | Fe-Servmil | Frontend/aplicações |

### 🛡️ Segurança & Monitoramento
| CT | Agente | Função |
|----|--------|--------|
| 112 | Analista-Seg | Análise de vulnerabilidades e segurança |

### 🆘 Emergência & Automação
| CT | Agente | Função |
|----|--------|--------|
| 107 | SAMU | Resposta a emergências |
| 108 | Scraper | Coleta e automação de dados |

---

## ⚠️ AÇÕES PENDENTES

### 🔴 URGENTES
- [ ] **Excluir CT 104** - Container inútil (SGN)

### 🟡 MÉDIAS
- [ ] **Configurar CT 113 - Hermes** - Agente alternativo ao Stark
- [ ] **Documentar IPs fixos** para containers DHCP

### 🟢 BAIXAS
- [ ] Criar diagrama visual da arquitetura
- [ ] Implementar Nginx Proxy Manager (gateway central)
- [ ] Configurar monitoramento Grafana

---

## 🔧 DETALHES TÉCNICOS

### DATASVR (CT 102) - Storage Central
- **Samba:** `\\192.168.0.72\LAN\`
- **Path:** `/home/master/LAN/`
- **Uso:** Backup crítico, documentação, memórias compartilhadas

### Acesso SSH aos CTs
```bash
# Template de comando SSH
sshpass -p 'Rcmp814k@#' ssh -o StrictHostKeyChecking=no root@<IP>
```

### ZeroTier - VPN entre CTs
- **Stark:** 172.28.95.234
- **SIC (SERVMIL):** 172.28.87.134

---

## 📝 NOTAS

**Regra de Ouro:** Cada agente tem uma função única e bem definida. Não misturar responsabilidades.

**Backup:** Todos os dados críticos devem ir para DATASVR (CT 102).

**Monitoramento:** CT 112 (Analista-Seg) monitora segurança de todos os outros CTs.

---

*Documento criado em: 24/04/2026*  
*Por: Stark - Orquestrador CT 100*
