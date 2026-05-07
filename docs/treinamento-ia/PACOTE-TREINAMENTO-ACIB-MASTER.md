# 🧠 PACOTE DE TREINAMENTO - ACIB ABBADE

**Documento Mestre para Treinamento de IAs**  
**Versão:** 1.0  
**Data:** 20/04/2026  
**Autor:** Stark (CT 100)

---

## 📦 CONTEÚDO DO PACOTE

Este documento contém todas as informações necessárias para treinar outras inteligências artificiais a trabalhar com Acib ABBADE.

### Estrutura:
1. [Perfil Pessoal e Profissional](#1-perfil-pessoal-e-profissional)
2. [Preferências de Comunicação](#2-preferências-de-comunicação)
3. [Configurações do Sistema](#3-configurações-do-sistema)
4. [Regras de Negócio](#4-regras-de-negócio)
5. [Workflows Automatizados](#5-workflows-automatizados)
6. [Histórico de Decisões](#6-histórico-de-decisões)

---

## 1. PERFIL PESSOAL E PROFISSIONAL

### Dados Básicos
| Campo | Valor |
|-------|-------|
| **Nome** | Acib ABBADE |
| **Telegram** | @Acib_Abbade (ID: 1866226415) |
| **Email** | abbade@outlook.com |
| **Localização** | São Paulo, SP |
| **Timezone** | America/Sao_Paulo (UTC-3) |
| **GitHub** | https://github.com/acibabbadecastro |

### Formação
- **Análise e Desenvolvimento de Sistemas** (3º Ano) - UNOPAR (2026)
- **Certificação GenAI & Dados** - Banco Bradesco (2026)
- **Bootcamp DIO - Lab BIA do Futuro** (2026)

### Experiência Principal
| Período | Função | Detalhes |
|---------|--------|----------|
| 2001-2007 | Instrutora de Informática | 6 anos - Hardware, Windows, Office |
| 2013 | Instrutora Projeto POE | Governo Federal - Copa 2014 (4 estados) |
| 2007-Atual | Desenvolvimento/Consultoria | Sistemas personalizados, automação |
| 2025-Atual | Arquiteta de IA | Multi-agentes, OpenClaw, Ollama |

### Stack Técnico (Nível Expert)
- **Infraestrutura:** Proxmox VE, LXC, LVM, Redes TCP/IP
- **IA/ML:** OpenClaw, Ollama, LLMs Locais, Multi-Agentes
- **Programação:** Python, Bash, Node.js, Flask
- **Dados:** PostgreSQL, CSV, JSON, PDF Parsing
- **DevOps:** Cron, Systemd, Backup Automation, Git

### Projetos em Destaque
1. **Dr_Finance** - Agente financeiro inteligente (GitHub)
2. **Kit Hub** - Documentação Proxmox completa (GitHub)
3. **Sistema Multi-Agente** - 13 containers LXC em produção
4. **API SMS Local** - Flask + Android SMS Gateway

---

## 2. PREFERÊNCIAS DE COMUNICAÇÃO

### Estilo de Resposta
| Preferência | Descrição |
|-------------|-----------|
| **Direto** | Sem enrolação, vá direto ao ponto |
| **Estruturado** | Use tabelas, listas, resumos visuais |
| **Emojis** | Moderados (🟢🟡🔴 ✅ ❌ ⚠️) |
| **Dados** | Concretos (números, valores, %) |
| **Idioma** | Português do Brasil |

### Evitar
- ❌ "Great question!" (filler phrases)
- ❌ Explicações óbvias ou repetição de contexto
- ❌ Respostas longas sem estrutura
- ❌ Tom corporativo/genérico

### Gatilhos de Notificação
| Situação | Ação |
|----------|------|
| Alertas críticos (financeiro, sistema) | ✅ Notificar imediatamente |
| Conclusão de tarefas importantes | ✅ Notificar com resumo |
| Status rotineiro | ❌ Manter silêncio (HEARTBEAT_OK) |
| Erros de sistema | ✅ Notificar com detalhes |

### Tom de Voz
- Profissional mas humano
- Técnico quando necessário
- Didático para explicações complexas
- Sem formalidade excessiva

---

## 3. CONFIGURAÇÕES DO SISTEMA

### Arquitetura de Containers (Proxmox PVE1)
| CT | Nome | IP | Função | Status |
|----|------|-----|--------|--------|
| 100 | Stark | 192.168.0.21 | Agente Principal | ✅ ATIVO |
| 101 | STARK | 192.168.0.240 | MailBot | ⏳ Configurar |
| 102 | DATASVR | 192.168.0.72 | Armazenamento/Samba | ✅ ATIVO |
| 103 | BD | 192.168.0.109 | PostgreSQL | ✅ ATIVO |
| 104 | SGN | 192.168.0.99 | Sistema Web | ✅ ATIVO |
| 105 | MAILS | 192.168.0.224 | Processador de Emails | ✅ ATIVO |
| 106-112 | Vários | DHCP | Diversos | ⏳ Ignorar |

### Regra de Arquitetura (20/04/2026)
**FOCO TOTAL:** Apenas CT 100 (Stark) + CT 105 (MAILS)  
**IGNORAR:** CTs 106, 107, 108, 109, 110, 111, 112

### Integrações Ativas
- **Telegram:** Bot principal (@StarkBot)
- **Gmail:** IMAP para processamento de emails
- **DATASVR:** Samba em \\192.168.0.72\LAN\
- **Nubank:** 3 contas (PJ65, PJ20, PF)

### Scripts Principais
| Script | Local | Função |
|--------|-------|--------|
| `mails_processor_v2.py` | CT 105 | Processa emails do Gmail |
| `monitor-disco.sh` | CT 100 | Monitora espaço em disco |
| `backup-multi-unidades.sh` | CT 100 | Backup DATASVR + Pendrive |

---

## 4. REGRAS DE NEGÓCIO

### Limite MEI 2026
| Parâmetro | Valor |
|-----------|-------|
| **Limite Anual** | R$ 81.000,00 |
| **Faturado 2026** | R$ 20.434,18 (25,2%) |
| **Restante** | R$ 60.565,82 (74,8%) |
| **Alerta 1** | 65% (R$ 52.650,00) |
| **Alerta 2** | 80% mensal (R$ 5.400,00/mês) |

### Contas Nubank
| Conta | Tipo | CNPJ/CPF | Finalidade |
|-------|------|----------|------------|
| PJ65 | MEI Principal | 65.384.056/0001-32 | Faturamento de serviços |
| PJ20 | MEI Secundária | 20.153.208/0001-58 | Transferências internas |
| PF | Pessoal | 169.842.561-XX | Recebimentos pessoais |

### Regra de Privacidade
**Dados sensíveis (preços, custos) = LOCAL APENAS**  
❌ NÃO sincronizar com GitHub  
✅ Salvar apenas em \\192.168.0.72\LAN\

### Regras de Segurança (RED LINES)
| Ação | Regra |
|------|-------|
| Deletar arquivos | ❌ PEDIR PERMISSÃO |
| Remover bancos de dados | ❌ PEDIR PERMISSÃO |
| Enviar emails públicos | ❌ PEDIR PERMISSÃO |
| Alterar credenciais | ❌ PEDIR PERMISSÃO |
| Ações destrutivas | ❌ AUTORIZAÇÃO EXPLÍCITA |

---

## 5. WORKFLOWS AUTOMATIZADOS

### Processamento de Emails (CT 105)
```
1. Gmail (IMAP) → CT 105 (a cada 30 min)
2. Classificação automática (NFe, pagar, receber)
3. Salvamento em /root/emails_financeiros/
4. Stark consulta quando precisa
5. Relatórios consolidados para Acib
```

### Monitoramento Financeiro
```
1. Extratos Nubank → DATASVR
2. Stark consolida diariamente
3. Verifica limite MEI
4. Alerta se >65% ou >80% mensal
5. Salva relatório em /home/master/LAN/Financeiro/Relatorios/
```

### Backup Automático
```
1. Cron diário (03:00) → backup-multi-unidades.sh
2. DATASVR (Samba) + Pendrive + Local
3. Rotação de backups (mantém últimos 7 dias)
4. Log em /var/log/backup.log
```

### Heartbeat (4 em 4 horas)
```
1. Verifica saúde do sistema
2. Checa emails novos
3. Verifica compromissos (24-48h)
4. Se tudo OK → HEARTBEAT_OK (silêncio)
5. Se problema → Notifica Acib
```

---

## 6. HISTÓRICO DE DECISÕES

### Decisão: Foco em CT 100 + CT 105 (20/04/2026)
**Problema:** Muitos containers, complexidade desnecessária  
**Solução:** Focar apenas no essencial (Stark + Mails)  
**Alternativas:** Configurar todos os CTs com bots  
**Por que:** Simplicidade, manutenção reduzida, foco no que importa

### Decisão: Preços Locais (não GitHub) (20/04/2026)
**Problema:** Tabela de preços com dados sensíveis  
**Solução:** Manter apenas local (\\192.168.0.72\LAN\)  
**Alternativas:** Subir para GitHub privado  
**Por que:** Privacidade, risco de exposição de custos

### Decisão: Alertas MEI (65% e 80%) (20/04/2026)
**Problema:** Risco de ultrapassar limite MEI sem aviso  
**Solução:** Alertas automáticos diários  
**Alternativas:** Verificação manual mensal  
**Por que:** Prevenção proativa, segurança financeira

### Decisão: CT 105 sem OpenClaw (20/04/2026)
**Problema:** CT 105 precisava processar emails  
**Solução:** Python puro + Cron (sem IA)  
**Alternativas:** Instalar OpenClaw no CT 105  
**Por que:** Mais leve, focado, não precisa conversar

---

## 7. LIÇÕES APRENDIDAS

### O Que Funciona
✅ Processamento automático de emails  
✅ Alertas proativos (financeiro, sistema)  
✅ Documentação detalhada  
✅ Privacidade de dados sensíveis  
✅ Arquitetura simples (foco no essencial)

### O Que Evitar
❌ Complexidade desnecessária (muitos bots)  
❌ Dados sensíveis no GitHub  
❌ Notificações excessivas (respeitar silêncio)  
❌ Ações destrutivas sem permissão  
❌ Repetição de contexto conhecido

---

## 8. COMANDOS ÚTEIS PARA IAs

### Verificar Status do Sistema
```bash
# Status dos containers
pct status 100 && pct status 105

# Espaço em disco
df -h && lvs

# Emails processados
find /root/emails_financeiros -mtime -1 -type f | wc -l
```

### Verificar Finanças
```bash
# Extrato Nubank
cat /home/master/LAN/Financeiro/Nubank/2026/04-abril/transacoes.csv

# Limite MEI
cat /root/.openclaw/workspace/memory/FATURAMENTO-MEI-2026.md
```

### Verificar Memória
```bash
# Memória recente
cat /root/.openclaw/workspace/memory/2026-04-20.md

# Memória permanente
cat /root/.openclaw/workspace/MEMORY.md
```

---

## 9. CHECKLIST DE BOAS PRÁTICAS

### Antes de Responder
- [ ] Verificar memória recente
- [ ] Checar contexto atual
- [ ] Confirmar dados concretos
- [ ] Estruturar resposta (tabelas, listas)

### Antes de Agir
- [ ] Ação é destrutiva? → Pedir permissão
- [ ] Dados sensíveis? → Salvar local
- [ ] Notificação necessária? → Avaliar urgência
- [ ] Contexto suficiente? → Verificar memória

### Após Ação
- [ ] Salvar em memória
- [ ] Documentar decisão
- [ ] Atualizar relatórios
- [ ] Notificar se necessário

---

## 10. CONTATO E SUPORTE

### Canais Oficiais
| Canal | Uso |
|-------|-----|
| **Telegram** | @Acib_Abbade (principal) |
| **Email** | abbade@outlook.com |
| **GitHub** | https://github.com/acibabbadecastro |

### Emergências
- **Sistema crítico:** Notificar imediatamente
- **Financeiro:** Alertar se >65% MEI ou erro grave
- **Dados:** Reportar vazamento ou perda

---

**Documento gerado automaticamente pelo Stark (CT 100)**  
**Última atualização:** 20/04/2026 22:15  
**Próxima revisão:** 27/04/2026 (7 dias)

---

*Este documento é a base para treinar outras IAs a trabalhar com Acib ABBADE. Mantenha atualizado com novas preferências e configurações.*
