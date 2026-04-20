---
name: acib-reminders
description: "Sistema de alertas e lembretes para compromissos de Acib ABBADE - faculdade, trabalho e pessoal"
metadata: { "openclaw": { "emoji": "⏰" } }
---

# ⏰ Acib Reminders

Sistema inteligente de alertas para compromissos de Acib ABBADE.
Verifica prazos, prioriza tarefas e envia notificações no momento certo.

**Versão:** 1.0 | **Criado:** 2026-04-19 | **Autor:** Stark

---

## Propósito

Esta skill garante que Acib:
1. **Nunca perca prazos** importantes
2. **Priorize** tarefas corretamente
3. **Receba alertas** no momento adequado
4. **Mantenha controle** sobre faculdade, trabalho e vida pessoal

---

## Fontes de Compromissos

### 1. Faculdade (Banco CT 103)
**Tabela:** `academico.compromissos`
- 18 atividades em 6 disciplinas
- Provas, trabalhos, lives, AVs
- Datas de entrega e pontuação

**Acesso:** Via PVE1 (pct exec 103)

### 2. Trabalho (SGN Database)
**Tabela:** `agenda.eventos` e `financeiro.servicos_parceiros`
- Ordens de serviço
- Compromissos com clientes
- Prazos de entrega

### 3. Pessoal (Arquivos Locais)
**Local:** `/home/master/LAN/MEMORIES/Compromissos/`
- Tarefas diárias
- Compromissos variados
- Lista de afazeres

---

## Tipos de Alerta

### 🔴 URGENTE (24-48h)
- Provas próximas
- Trabalhos com prazo curto
- Compromissos críticos

**Ação:** Alertar imediatamente via Telegram

### 🟠 ALTA (3-7 dias)
- Entregas importantes
- Reuniões agendadas
- Prazos de projeto

**Ação:** Mostrar no início da conversa

### 🟡 MÉDIA (1-2 semanas)
- Tarefas planejadas
- Preparações necessárias
- Revisões

**Ação:** Listar no resumo diário

### 🟢 BAIXA (>2 semanas)
- Metas de longo prazo
- Planejamentos futuros
- Tarefas não urgentes

**Ação:** Registrar para acompanhamento

---

## Funcionalidades

### 1. Verificação Automática
**Quando:**
- A cada 4 horas (heartbeat)
- No início de cada sessão
- Quando solicitado: "verifique meus compromissos"

**O que faz:**
- Consulta banco da faculdade
- Verifica tarefas pendentes
- Prioriza por data e importância
- Alerta sobre urgências

### 2. Alertas Inteligentes
**Regras:**
- Não incomodar entre 23h e 8h
- Agrupar múltiplos alertas
- Usar linguagem natural (não robótica)
- Respeitar preferências de comunicação

**Formato:**
```
"Acib, você tem [X compromissos] urgentes:

1. [Data] - [Descrição] ([Tipo])
2. [Data] - [Descrição] ([Tipo])

Quer que eu ajude com algum deles?"
```

### 3. Histórico e Acompanhamento
**Registra:**
- Compromissos cumpridos
- Prazos perdidos (aprender com erros)
- Padrões de procrastinação
- Tempo médio por tipo de tarefa

### 4. Ajuda na Organização
**Sugere:**
- Dividir trabalhos grandes em partes
- Blocos de estudo para provas
- Tempo de preparação necessário
- Priorização quando múltiplos prazos

---

## Comandos Disponíveis

### Para Acib usar:

| Comando | O que faz |
|---------|-----------|
| "compromissos" ou "tarefas" | Lista todos os pendentes |
| "urgentes" | Mostra só os urgentes (24-48h) |
| "faculdade" | Lista compromissos acadêmicos |
| "trabalho" | Lista tarefas profissionais |
| "próximos 7 dias" | Mostra tudo para a próxima semana |
| "concluí [número]" | Marca tarefa como feita |
| "adiar [tarefa] para [data]" | Remarca compromisso |
| "lembre-me em [X horas]" | Cria alerta personalizado |

---

## Estrutura de Arquivos

```
skills/acib-reminders/
├── SKILL.md              # Este arquivo
├── config.json           # Configurações
├── check-reminders.sh    # Script de verificação
├── database/
│   └── compromissos.db   # Cache local de tarefas
└── logs/
    └── alertas.log       # Histórico de notificações
```

---

## Integração com Sistema

### Com acib-profile:
- Lê preferências de comunicação
- Sabe seu timezone (UTC-3)
- Respeita regras de notificação

### Com memory-never-forget:
- Registra padrões de comportamento
- Aprende quais alertas são úteis
- Evita spam de notificações

### Com DATASVR:
- Backup de compromissos
- Sincronização entre sessões
- Persistência de dados

---

## Configurações

### Padrão (config.json):
```json
{
  "check_interval_hours": 4,
  "alert_before_hours": 48,
  "quiet_hours": { "start": 23, "end": 8 },
  "telegram_alerts": true,
  "group_similar": true,
  "max_alerts_per_day": 5
}
```

### Personalizável por Acib:
- Frequência de verificação
- Horário silencioso
- Tipos de alerta
- Canais de notificação

---

## Privacidade e Segurança

- Dados sensíveis mantidos localmente
- Backup criptografado no DATASVR
- Não compartilha informações externamente
- Acesso apenas para Acib e Stark

---

## Notas de Implementação

**Versão 1.0:**
- Integração básica com banco CT 103
- Alertas por prioridade
- Comandos simples

**Futuro (v2.0):**
- Integração com Google Calendar
- Machine learning para prever atrasos
- Sugestões automáticas de divisão de tarefas
- Relatórios semanais de produtividade

---

**Responsável:** Stark (CT 100)
**Proprietário:** Acib ABBADE
**Aprovado em:** 2026-04-19

---

*Esta skill ajuda Acib a manter o controle da vida sem esquecer o que importa.*
