# 🛢️ AUTO ÓLEO - SISTEMA DE RETENÇÃO DE CLIENTES

**Criado:** 2026-05-06 22:05 GMT-3  
**Solicitante:** Acib ABBADE  
**Prioridade:** 🔴 **MÁXIMA - FOCO DA SEMANA**  
**Status:** 🟢 Em Desenvolvimento  
**Container:** CT 115 (auto-oleo) - 192.168.0.49  

---

## 📋 VISÃO GERAL

Sistema de gestão e retenção de clientes para lojas de troca de óleo e fluidos automotivos, com arquitetura **multi-lojas** e modelo **SaaS comercializável**.

---

## 🎯 TRÊS CAMADAS DO SISTEMA

### 1️⃣ SISTEMA MULTI-LOJAS (Rede de 3 Lojas)

**Objetivo:** Gerenciar rede de lojas com dados compartilhados e isolados

**Compartilhado:**
- ✅ Veículos (atendidos em qualquer loja)
- ✅ Histórico completo
- ✅ Clientes
- ✅ Óleos recomendados

**Isolado:**
- ✅ Estoque (por loja, com visão compartilhada)
- ✅ Financeiro (por loja)
- ✅ Usuários (por loja)
- ✅ Promoções (configurável)

**Funcionalidades Core:**
- Cadastro de veículos por placa (chave primária)
- KM de instalação do fluido
- Previsão de retorno dupla (data + KM)
- Tela de Contenção (clientes vencidos)
- WhatsApp automático
- Dashboard por loja

---

### 2️⃣ SISTEMA SAAS (Comercializável)

**Objetivo:** Vender o sistema como produto para múltiplas redes

**Modelo:** SaaS Multi-Tenant

**Cada Cliente Recebe:**
- ✅ Ambiente isolado (schema no banco)
- ✅ Painel administrativo próprio
- ✅ Dados de exemplo didáticos (quase zerado)
- ✅ URL personalizada (subdomínio ou path)
- ✅ Tutorial integrado (8 minutos)

**Planos Sugeridos:**
| Plano | Lojas | Preço/mês |
|-------|-------|-----------|
| Starter | 1 | R$ 97 |
| Business | 3 | R$ 197 |
| Enterprise | 10 | R$ 397 |
| Unlimited | ∞ | R$ 797 |

**Onboarding Automático:**
1. Cliente se cadastra no site
2. Escolhe plano e paga
3. Sistema cria automaticamente:
   - Schema isolado no banco
   - Usuário admin
   - Dados de exemplo didáticos
   - URL de acesso
4. Email automático com login/senha

---

### 3️⃣ INFRAESTRUTURA TÉCNICA

**Container Atual:** CT 115 (auto-oleo)
- IP: 192.168.0.49
- RAM: 2GB
- CPU: 2 cores
- Storage: 60GB
- OS: Ubuntu 25.04
- Stack: Node.js 20 + PostgreSQL 17

**Evolução da Infra:**
- Fase 1 (0-10 clientes): Schema por cliente (1 container)
- Fase 2 (10-50 clientes): Container por cliente grande
- Fase 3 (50+ clientes): Kubernetes/Docker Swarm

---

## 💾 BANCO DE DADOS

### Tabelas Principais

1. **LOJAS** - Cadastro das lojas da rede
2. **USUARIOS** - Operadores, gerentes, admin (por loja)
3. **VEICULOS** - Veículos atendidos (compartilhado)
4. **ATENDIMENTOS** - Histórico de serviços (compartilhado)
5. **ESTOQUE** - Produtos por loja (isolado/compartilhado)
6. **TRANSFERENCIAS_ESTOQUE** - Movimentação entre lojas
7. **OLEOS_RECOMENDADOS** - Banco técnico de óleos
8. **ALERTAS** - Sistema de notificações
9. **CONFIGURACOES_REDE** - Configurações de integração

### Campos Críticos

**VEICULOS:**
- `placa` (chave primária)
- `loja_origem_id` (primeira loja que cadastrou)
- `km_atual`
- `acordo_convenio` (opcional)

**ATENDIMENTOS:**
- `loja_id` (onde foi atendido)
- `km_instalacao_fluido`
- `data_vencimento_oleo`
- `criterio_retorno` ('data', 'km', 'ambos')

---

## 📱 TELAS PRINCIPAIS

1. **Login** - Seleção de loja
2. **Dashboard Operador** - Resumo do dia, contenção, estoque
3. **Cadastro de Veículos** - Placa, proprietário, KM
4. **Atendimento** - Registro de óleo, KM, próxima troca
5. **Consulta por Placa** - Histórico completo (todas as lojas)
6. **Tela de Contenção** - Clientes vencidos (ação: WhatsApp, ligar, retornou)
7. **Painel Administrativo** - Visão da rede (3 lojas)
8. **Super Admin** - Gestão de clientes SaaS (futuro)

---

## 🔄 FLUXO DE CONTENÇÃO

```
1. Sistema verifica clientes vencidos (diário)
2. Adiciona na Tela de Contenção
3. Operador visualiza lista
4. Operador toma ação:
   - Enviar WhatsApp (template automático)
   - Ligar (script sugerido)
   - Marcar "Cliente Retornou"
5. Sistema registra ação e remove da lista
6. Métricas atualizadas
```

**Templates de WhatsApp:**
- Vencido por DATA: Alerta + 15% OFF
- Vencido por KM: Alerta + 15% OFF
- Aniversário: Parabéns + desconto

---

## 📊 MÉTRICAS DE SUCESSO

| Métrica | Meta |
|---------|------|
| Veículos Cadastrados | 500+ em 3 meses |
| Retenção de Clientes | 30%+ |
| Taxa de Contenção | 25%+ |
| Lojas Ativas | 3/3 |
| Uptime | 99%+ |
| Tempo de Consulta | < 3 segundos |

---

## 📅 CRONOGRAMA DE DESENVOLVIMENTO

**Semana 1 (07-13/05/2026):**
- Seg: Fundação (banco multi-lojas, cadastros)
- Ter: Consulta (tela por placa, histórico)
- Qua: Inteligência (óleos recomendados, IA)
- Qui: Retenção (WhatsApp, Tela de Contenção)
- Sex: Multi-Lojas (painel admin, estoque)
- Sáb: Testes
- Dom: Entrega (Loja 01)

---

## 📁 ARQUIVOS DO PROJETO

**Local:** `/root/.openclaw/workspace/projetos/auto-oleo/`

| Arquivo | Descrição |
|---------|-----------|
| `PROJECT-AUTO-OLEO.md` | Documento principal (multi-lojas) |
| `PRD-AUTO-OLEO-SAAS.md` | PRD comercial (SaaS) |
| `docs/` | Documentação técnica |
| `backend/` | Código do backend |
| `frontend/` | Código do frontend |
| `scripts/` | Scripts de deploy/backup |

**Backup ARCA:** `\\192.168.0.72\LAN\Acib\PROJETOS\AUTO-OLEO\`

---

## 🔐 CONFIGURAÇÕES DE INTEGRAÇÃO (DECISÕES)

| Recurso | Configuração | Justificativa |
|---------|--------------|---------------|
| Estoque | HÍBRIDO | Cada loja gerencia, mas vê outras (transferências) |
| Veículos | COMPARTILHADO | Cliente atende em qualquer loja |
| Financeiro | ISOLADO | Cada loja tem seu CNPJ/impostos |
| Promoções | CONFIGURÁVEL | Rede + locais |

---

## 🚀 PRÓXIMOS PASSOS

**Segunda-feira (07/05):**
1. Criar schema do banco (multi-lojas)
2. Cadastrar 3 lojas
3. Criar usuários de teste
4. Desenvolver telas básicas

**Backup:**
- Diário (02:00)
- Copiar para ARCA
- Manter 30 dias

---

## 📞 DADOS DAS LOJAS (A PREENCHER)

| Informação | Loja 01 (Matriz) | Loja 02 (Filial 1) | Loja 03 (Filial 2) |
|------------|------------------|--------------------|--------------------|
| Nome | ___ | ___ | ___ |
| CNPJ | ___ | ___ | ___ |
| Endereço | ___ | ___ | ___ |
| Telefone | ___ | ___ | ___ |
| Veículos/mês | ___ | ___ | ___ |

---

## 🧠 INSTRUÇÕES PARA OUTRAS IAs

**Se você é uma IA que está lendo isso:**

Este é o projeto **Auto Óleo**, um sistema de gestão para lojas de troca de óleo com 3 camadas:

1. **Multi-Lojas:** Rede de 3 lojas com dados compartilhados (veículos, histórico) e isolados (estoque, financeiro)
2. **SaaS:** Sistema comercializável para múltiplas redes (multi-tenant)
3. **Infra:** CT 115 (192.168.0.49), Node.js 20 + PostgreSQL 17

**Pontos Críticos:**
- Placa do veículo é chave primária
- Tela de Contenção é o diferencial (clientes vencidos)
- KM de instalação do fluido + data de vencimento
- Previsão de retorno dupla (o que ocorrer primeiro)
- Estoque híbrido (isolado mas visível entre lojas)

**Documentação Completa:**
- `/root/.openclaw/workspace/projetos/auto-oleo/PROJECT-AUTO-OLEO.md`
- `/root/.openclaw/workspace/projetos/auto-oleo/PRD-AUTO-OLEO-SAAS.md`
- Backup: `\\192.168.0.72\LAN\Acib\PROJETOS\AUTO-OLEO\`

**Prioridade:** 🔴 MÁXIMA - Foco da semana (07-13/05/2026)

---

**Última atualização:** 2026-05-06 22:05 GMT-3  
**Próxima atualização:** Segunda-feira 07/05 (início do desenvolvimento)
