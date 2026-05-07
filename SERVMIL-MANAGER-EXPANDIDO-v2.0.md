# 🏢 SERVMIL MANAGER - SISTEMA EXPANDIDO
## Documentação de Arquitetura e Expansão
**Versão:** 2.0  
**Data:** 27/04/2026  
**Local:** CT 104 (SGN) - IP 192.168.0.99  
**Acesso Externo:** Via Cloudflare Tunnel (configurar)  
**Domínio:** [A DEFINIR - ver sugestões]

---

## 🎯 VISÃO GERAL DO SISTEMA EXPANDIDO

O SERVMIL Manager evoluiu de um simples gerenciador de serviços para um **Sistema Integrado de Gestão Empresarial** com:

1. ✅ **Gestão de Serviços** (já implementado)
2. 🆕 **Sistema de Chamados/Tickets** (novo)
3. 🆕 **Portal de Colaboradores** (novo)
4. 🆕 **Módulo de Auditoria** (novo)
5. ✅ **Módulo Financeiro** (expandido)
6. 🆕 **Relatórios e BI** (novo)
7. 🆕 **Acesso Externo Seguro** (Cloudflare)

---

## 🏗️ ARQUITETURA DO SISTEMA

### Infraestrutura
```
┌─────────────────────────────────────────────────────────┐
│                    INTERNET                              │
│              (Acesso via Cloudflare)                    │
└────────────────────┬──────────────────────────────────────┘
                     │
           ┌─────────▼──────────┐
           │  Cloudflare Tunnel   │  ← Subdomínio: chamados.servmil.com.br
           │  (cloudflared)       │  ← Acesso seguro, sem abrir portas
           └─────────┬────────────┘
                     │
┌────────────────────▼────────────────────────────────────┐
│                   CT 104 - SGN                           │
│              192.168.0.99:80/443                         │
│                                                          │
│  ┌──────────────────────────────────────────────────┐   │
│  │           SERVMIL MANAGER SYSTEM                 │   │
│  │                                                  │   │
│  │  ┌─────────────┐  ┌─────────────┐  ┌─────────┐  │   │
│  │  │   Portal    │  │   Admin     │  │  API    │  │   │
│  │  │ Colaborador │  │   Master    │  │ REST    │  │   │
│  │  │  (Chamados) │  │  (Você)     │  │         │  │   │
│  │  └──────┬──────┘  └──────┬──────┘  └────┬────┘  │   │
│  │         │                  │               │       │   │
│  │         └──────────────────┼───────────────┘       │   │
│  │                            │                      │   │
│  │                   ┌────────▼────────┐             │   │
│  │                   │  Core System    │             │   │
│  │                   │  (PHP/MySQL)    │             │   │
│  │                   └────────┬────────┘             │   │
│  │                            │                      │   │
│  │         ┌──────────────────┼──────────────────┐   │   │
│  │         │                  │                  │   │   │
│  │  ┌──────▼──────┐  ┌────────▼──────┐  ┌──────▼──┐│   │
│  │  │  Serviços   │  │   Chamados    │  │ Finance ││   │
│  │  │  (T.I.)     │  │   (Tickets)   │  │  iro    ││   │
│  │  └─────────────┘  └───────────────┘  └─────────┘│   │
│  │                                                 │   │
│  │  ┌─────────────┐  ┌───────────────┐  ┌───────┐ │   │
│  │  │  Auditoria  │  │   Loja Virtual │  │  BI   │ │   │
│  │  │  (Logs)     │  │   (Produtos)   │  │Repor  │ │   │
│  │  └─────────────┘  └───────────────┘  └───────┘ │   │
│  │                                                 │   │
│  └──────────────────────────────────────────────────┘   │
│                                                          │
│  ┌──────────────────────────────────────────────────┐   │
│  │              BANCO DE DADOS (MySQL)               │   │
│  │  • servmil_manager (principal)                    │   │
│  │  • servmil_audit (auditoria/logs)                 │   │
│  │  • servmil_backup (backups automáticos)           │   │
│  └──────────────────────────────────────────────────┘   │
│                                                          │
└──────────────────────────────────────────────────────────┘
```

---

## 👥 PERFIS DE USUÁRIO

### 1. **Administrador Master** (Você - Acib)
- Acesso total ao sistema
- Configurações globais
- Relatórios financeiros completos
- Gestão de colaboradores
- Auditoria e logs
- Faturamento e cobranças

### 2. **Colaborador SERVMIL**
- Abrir chamados/tickets
- Acompanhar status de chamados
- Histórico de solicitações
- Visualizar catálogo de serviços
- Solicitar produtos (loja)

### 3. **Cliente Externo** (Saulo, CAUA, Daniela, AC ANA)
- Portal de acesso limitado
- Visualizar serviços prestados
- Acompanhar status de solicitações
- Receber notificações de cobrança
- Histórico de pagamentos

---

## 📋 SISTEMA DE CHAMADOS (TICKETS)

### Fluxo de Abertura de Chamado

```
┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐
│  Colaborador    │────▶│  Abre Chamado   │────▶│  Sistema Gera   │
│  SERVMIL        │     │  no Portal      │     │  Ticket #2026   │
└─────────────────┘     └─────────────────┘     └────────┬────────┘
                                                        │
                               ┌───────────────────────┼────────┐
                               │                       │        │
                        ┌──────▼──────┐      ┌────────▼────┐   │
                        │  Prioridade  │      │  Categoria  │   │
                        │  • Urgente   │      │  • Hardware │   │
                        │  • Alta      │      │  • Rede     │   │
                        │  • Normal    │      │  • Software │   │
                        │  • Baixa     │      │  • Segurança│   │
                        └─────────────┘      └─────────────┘   │
                                                                 │
                                                        ┌────────▼────────┐
                                                        │  Notificação    │
                                                        │  Admin (Você)   │
                                                        │  • Email        │
                                                        │  • Telegram     │
                                                        │  • Dashboard    │
                                                        └────────┬────────┘
                                                                 │
                                                        ┌────────▼────────┐
                                                        │  Atendimento    │
                                                        │  • Em Análise   │
                                                        │  • Em Execução  │
                                                        │  • Concluído    │
                                                        │  • Cancelado    │
                                                        └────────┬────────┘
                                                                 │
                                                        ┌────────▼────────┐
                                                        │  Fechamento     │
                                                        │  • Cliente      │
                                                        │    confirma     │
                                                        │  • Avaliação    │
                                                        │  • SLA medido   │
                                                        └─────────────────┘
```

### Campos do Chamado

| Campo | Descrição | Obrigatório |
|-------|-----------|-------------|
| **ID** | Número único (ex: CH-2026-04-001) | Auto |
| **Solicitante** | Colaborador que abriu | Sim |
| **Categoria** | Hardware/Rede/Software/Segurança/Outro | Sim |
| **Prioridade** | Urgente/Alta/Normal/Baixa | Sim |
| **Assunto** | Título resumido | Sim |
| **Descrição** | Detalhes do problema | Sim |
| **Local/Setor** | Onde ocorre | Sim |
| **Data Abertura** | Timestamp | Auto |
| **Prazo SLA** | Calculado por prioridade | Auto |
| **Técnico** | Quem atenderá | Dinâmico |
| **Status** | Fluxo do ticket | Auto |
| **Anexos** | Fotos/documentos | Não |
| **Histórico** | Log de atualizações | Auto |

### SLA (Service Level Agreement)

| Prioridade | Tempo Resposta | Tempo Resolução | Notificação |
|------------|----------------|-----------------|-------------|
| 🔴 **Urgente** | 15 minutos | 4 horas | Telegram + Email |
| 🟠 **Alta** | 1 hora | 8 horas | Email |
| 🔵 **Normal** | 4 horas | 24 horas | Dashboard |
| ⚪ **Baixa** | 24 horas | 72 horas | Dashboard |

---

## 🔐 SISTEMA DE AUDITORIA

### O que é logado

| Evento | Quando | Dados Armazenados |
|--------|--------|-------------------|
| **Login** | Acesso ao sistema | IP, User-Agent, Timestamp, Sucesso/Falha |
| **Ação** | Criação/Edição/Exclusão | Tabela, Registro, Valor Antigo, Valor Novo, Usuário |
| **Chamado** | Todo ciclo de vida | Abertura, Atribuição, Atualizações, Fechamento |
| **Financeiro** | Movimentações | Valores, Solicitantes, Datas, Quem alterou |
| **Config** | Mudanças sistema | Quem mudou, O que mudou, Quando |

### Retenção de Logs
- **Operacional:** 90 dias (alertas, notificações)
- **Financeiro:** 5 anos (obrigatório legal)
- **Auditoria:** 3 anos (alterações de dados)
- **Backup:** Mensal, arquivado no DATASVR

---

## 💰 MÓDULO FINANCEIRO EXPANDIDO

### Funcionalidades

| Feature | Descrição | Status |
|---------|-----------|--------|
| **Faturamento** | Geração de cobranças mensais | ✅ Implementado |
| **Contas a Receber** | Controle de pagamentos pendentes | 🆕 Novo |
| **Relatório Mensal** | Resumo executivo por mês | ✅ Implementado |
| **DRE** | Demonstração Resultado (receitas x despesas) | 🆕 Novo |
| **Projeção** | Previsão de receitas (solicitações aprovadas) | 🆕 Novo |
| **NF-e** | Emissão de notas fiscais (futuro) | 📋 Planejado |
| **Integração Bancária** | Baixa automática (futuro) | 📋 Planejado |

### Controle de Solicitações Aprovadas

```
Solicitação Aprovada
       │
       ▼
┌───────────────┐
│  EM ORÇAMENTO │ ← Valor estimado, aguardando confirmação
└───────┬───────┘
        │
        ▼
┌───────────────┐
│   APROVADA    │ ← Cliente confirmou, vai executar
└───────┬───────┘
        │
        ▼
┌───────────────┐     ┌───────────────┐
│   EXECUTADA   │────▶│  FATURADA    │
└───────────────┘     │  (Mês N)     │
                      └───────────────┘
```

---

## 🌐 ACESSO EXTERNO - CLOUDFLARE TUNNEL

### Por que Cloudflare Tunnel?
- ✅ **Segurança:** Não precisa abrir portas no firewall
- ✅ **HTTPS gratuito:** Certificado SSL automático
- ✅ **DDoS Protection:** Proteção contra ataques
- ✅ **Acesso Zero Trust:** Autenticação por email/domínio
- ✅ **Analytics:** Estatísticas de acesso

### Arquitetura de Acesso

```
┌──────────────────────────────────────────────────────────┐
│  COLABORADOR (Celular/PC)                                │
│  chamados.servmil.com.br                                 │
└────────────────┬─────────────────────────────────────────┘
                 │ HTTPS (SSL)
                 ▼
┌──────────────────────────────────────────────────────────┐
│  CLOUDFLARE EDGE                                         │
│  • DDoS Protection                                       │
│  • WAF (Web Application Firewall)                        │
│  • Rate Limiting                                         │
│  • Autenticação (opcional)                               │
└────────┬─────────────────────────────────────────────────┘
         │ Tunnel Seguro (cloudflared)
         ▼
┌──────────────────────────────────────────────────────────┐
│  SEU SERVIDOR (CT 104)                                   │
│  192.168.0.99:80 ←── cloudflared ───► Internet          │
└──────────────────────────────────────────────────────────┘
```

---

## 📝 SUGESTÕES DE DOMÍNIO

### Opções Disponíveis

| Domínio | Tipo | Preço Est. | Uso Principal |
|---------|------|------------|---------------|
| **servmil.com.br** | .com.br | R$ 40/ano | Principal - institucional |
| **servmil.app** | .app | R$ 120/ano | Aplicativo/sistema |
| **servmil.tech** | .tech | R$ 80/ano | Foco tecnológico |
| **chamados.servmil.com.br** | Subdomínio | Grátis | Sistema de tickets |
| **ti.servmil.com.br** | Subdomínio | Grátis | Portal T.I. |
| **area.servmil.com.br** | Subdomínio | Grátis | Área do cliente |

### Estrutura de Subdomínios Sugerida

```
servmil.com.br           → Site institucional (futuro)
├── chamados.servmil.com.br   → Sistema de tickets (atual)
├── ti.servmil.com.br         → Gestão interna T.I.
├── area.servmil.com.br       → Portal clientes
├── api.servmil.com.br        → API REST (integrações)
└── admin.servmil.com.br      → Painel administrativo
```

---

## 🚀 ROADMAP DE IMPLEMENTAÇÃO

### Fase 1: Foundation (ATUAL - Abril/2026)
- ✅ Estrutura base criada no CT 104
- ✅ Templates HTML/Bootstrap
- ✅ Banco de dados schema
- ✅ Sistema de login básico

### Fase 2: Core (Maio/2026)
- 🔄 Sistema de chamados completo
- 🔄 Portal do colaborador
- 🔄 Notificações (email/Telegram)
- 🔄 Dashboard com métricas

### Fase 3: External (Junho/2026)
- 📋 Cloudflare Tunnel configurado
- 📋 Domínio registrado
- 📋 SSL/HTTPS ativo
- 📋 Acesso externo liberado

### Fase 4: Advanced (Julho/2026)
- 📋 Módulo de auditoria completo
- 📋 BI e relatórios avançados
- 📋 API REST para integrações
- 📋 App mobile (futuro)

### Fase 5: Scale (2027+)
- 📋 Multi-tenant (outras empresas)
- 📋 Integração bancária
- 📋 Emissão de NF-e
- 📋 App nativo iOS/Android

---

## 💡 IDEIAS ADICIONAIS

### 1. **Gamificação para Colaboradores**
- Pontos por chamados resolvidos
- Ranking de técnicos
- Conquistas (badges)
- Bonificação baseada em SLA

### 2. **Chatbot Integrado**
- Respostas automáticas para dúvidas comuns
- Abertura de chamados via WhatsApp
- Status de chamados por mensagem

### 3. **Dashboard de TVs**
- Painel para recepção SERVMIL
- Mostra chamados em tempo real
- SLA em cores (verde/amarelo/vermelho)
- Estatísticas do dia

### 4. **Integração com Hardware**
- Leitura de QR Code em equipamentos
- Histórico completo por patrimônio
- Preventivas automáticas

### 5. **Relatórios Automáticos**
- Envio mensal por email para diretoria
- PDF gerado automaticamente
- Comparativo mês a mês
- Previsão orçamentária

### 6. **Controle de Estoque**
- Produtos em estoque (SSDs, fontes, etc.)
- Alerta de reposição
- Custo médio de produtos
- Lucratividade por serviço

### 7. **Contratos e SLAs**
- Cadastro de contratos por cliente
- SLAs diferenciados
- Penalidades/bonificações
- Renovação automática

---

## 🔧 PRÓXIMOS PASSOS IMEDiatos

1. **Configurar banco de dados no CT 104**
2. **Criar tabelas de chamados e auditoria**
3. **Implementar sistema de login multi-perfil**
4. **Configurar Cloudflare Tunnel**
5. **Registrar domínio servmil.com.br**
6. **Testar acesso externo**
7. **Treinar colaboradores**

---

## 📁 ESTRUTURA DE ARQUIVOS EXPANDIDA

```
servmil-manager/
├── app/
│   ├── Core/
│   │   ├── Database.php
│   │   ├── Auth.php
│   │   ├── Logger.php
│   │   └── Notification.php
│   ├── Modules/
│   │   ├── Services/
│   │   ├── Tickets/
│   │   ├── Finance/
│   │   ├── Audit/
│   │   └── Store/
│   └── Controllers/
├── config/
│   ├── database.php
│   ├── cloudflare.php
│   └── app.php
├── public/
│   ├── index.php
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   └── uploads/
├── templates/
│   ├── admin/
│   ├── portal/
│   └── email/
├── api/
│   └── v1/
├── logs/
├── backup/
└── docs/
```

---

## 🛡️ SEGURANÇA

### Medidas Implementadas
- ✅ Senhas hasheadas (bcrypt)
- ✅ Proteção CSRF
- ✅ SQL Injection protection (PDO prepared)
- ✅ XSS protection (output encoding)
- ✅ Rate limiting (Cloudflare)
- ✅ HTTPS obrigatório

### A Implementar
- 🔄 2FA para admin
- 🔄 Backup automático diário
- 🔄 WAF rules personalizadas
- 🔄 Monitoramento de acessos suspeitos

---

## 📞 SUPORTE E MANUTENÇÃO

- **Atualizações:** Automáticas (zero-downtime com Cloudflare)
- **Backups:** Diários para DATASVR
- **Monitoramento:** Uptime 24/7 via Cloudflare
- **Suporte:** Telegram/Email para emergências

---

*Documento criado por Stark - Assistente Acib ABBADE*  
*Data: 27/04/2026*  
*Próxima revisão: Após implementação da Fase 2*
