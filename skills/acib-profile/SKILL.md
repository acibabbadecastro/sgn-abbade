---
name: acib-profile
description: "Personalized memory and preference system for Acib ABBADE. Tracks rules, preferences, and user context with automatic DATASVR backup."
metadata: { "openclaw": { "emoji": "📋" } }
---

# 📋 Acib Profile Manager

Sistema de memória personalizado para Acib ABBADE.
Guarda regras, preferências e contexto do usuário com backup automático no DATASVR.

**Versão:** 1.0 | **Criado:** 2026-04-19 | **Autor:** Stark

---

## Propósito

Esta skill garante que Stark:
1. **Nunca esqueça** regras e preferências de Acib
2. **Atualize automaticamente** informações em tempo real
3. **Faça backup** contínuo no DATASVR (CT 102)
4. **Seja mais eficiente** a cada interação

---

## Estrutura de Memória

### Camadas (3 níveis)

| Camada | Local | Propósito | Frequência de Backup |
|--------|-------|-----------|---------------------|
| **Ativa** | `memory/YYYY-MM-DD.md` | Log diário de interações | Tempo real |
| **Perfil** | `PERFIL_ACIB.md` | Dados consolidados do usuário | A cada mudança |
| **Backup** | `DATASVR:/home/master/LAN/MEMORIES/` | Cópia permanente | Automático |

---

## Regras Críticas de Acib (Nunca Esquecer)

### Comunicação
- ✅ SEMPRE escrever como humano (nunca robótico)
- ✅ Máximo 10% de emojis (sutil)
- ✅ Linguagem natural e direta
- ✅ Evitar "processando...", usar "pensando..."
- ✅ Evitar "erro detectado", usar "ops, deu problema"

### Segurança
- ⚠️ SEMPRE pedir autorização antes de ações destrutivas
- ⚠️ NUNCA exfiltrar dados privados
- ⚠️ Usar `trash` ao invés de `rm`

### Decisões
- Prefere sistemas automatizados
- Gosta de tomar decisões técnicas sozinho
- Valoriza documentação organizada

---

## Dados do Usuário (Contexto)

### Identificação
- **Nome:** Acib ABBADE (ACIB ABBADE DE CASTRO)
- **CPF:** 307.572.858-64
- **Telegram:** @Acib_Abbade (ID: 1866226415)
- **Email Principal:** acibabbadecastro@gmail.com
- **Timezone:** Horário Brasília (UTC-3)

### Profissional
- **Empresa:** ABBADE Informática (MEI)
- **CNPJ Principal:** 65.384.056/0001-32
- **CNPJ Secundário:** 20.153.208/0001-58
- **Área:** Tecnologia da Informação / Automação

### Infraestrutura
- **Proxmox:** pve1 (192.168.0.192)
- **Stark:** CT 100 (192.168.0.21)
- **DATASVR:** CT 102 (192.168.0.72)
- **Hardware:** AMD Ryzen 5 5600X, 30GB RAM, RX 580 8GB

### Contas Bancárias (Nubank)
- **PJ65:** 986080174-7 (Principal - MEI)
- **PJ20:** 118844303 (Secundária)
- **PF:** 169842561 (Pessoal)
- **Limite MEI:** R$ 81.000,00/ano
- **Limite IRPF:** R$ 28.559,70/ano

---

## Agentes do Sistema

| CT | Nome | IP | Função | Status |
|----|------|-----|--------|--------|
| 100 | Stark | 192.168.0.21 | Orquestrador | Online |
| 101 | MailBot | 192.168.0.240 | Emails | Online |
| 102 | DATASVR | 192.168.0.72 | Armazenamento | Online |
| 103 | Supervisor | 192.168.0.42 | Monitoramento | Online |
| 104 | Vorcaro | 192.168.0.172 | Financeiro | Online |
| 105 | OfficeBoy | 192.168.0.117 | Administração | Online |
| 106 | Seguranca | 192.168.0.231 | Segurança | Online |
| 107 | SAMU | 192.168.0.64 | Emergências | Online |

---

## Projetos Ativos

### 1. Sistema Multi-Agente (SGN)
- Banco PostgreSQL em CT 103
- Schemas: os, clientes, estoque, financeiro, fornecedores, garantia, agenda
- Interface web: http://192.168.0.99

### 2. Bootcamp DIO - Assistente de Voz
- Repositório: https://github.com/acibabbadecastro/dio-voice-assistant
- Tecnologias: Python + JavaScript + Whisper + ChatGPT + gTTS
- Status: Publicado e pronto para entrega

### 3. Monitoramento Financeiro
- MailBot processando emails Nubank automaticamente
- Database: 379+ transações indexadas
- Extratos disponíveis: PJ65, PJ20, PF

---

## Tarefas Pendentes (Atualizar Constantemente)

### Alta Prioridade
- [ ] Contato Anderson - Servmil
- [ ] Holter retirar pedido Renato
- [ ] Comprar roteador para Servmil (R$ 2.750)

### Média Prioridade
- [ ] Enviar mensagem Sávio
- [ ] Analisar notebook Miss Slade
- [ ] Analisar notebook Abel

---

## Como Usar Esta Skill

### Para Stark (Agente):

1. **Antes de cada resposta:**
   - Ler PERFIL_ACIB.md
   - Verificar regras de comunicação
   - Aplicar estilo humano (máx 10% emojis)

2. **Durante a conversa:**
   - Registrar novas informações em memory/YYYY-MM-DD.md
   - Atualizar PERFIL_ACIB.md quando necessário
   - Backup automático para DATASVR

3. **Fim da sessão:**
   - Sincronizar todas as memórias
   - Verificar integridade do backup
   - Registrar próximos passos

### Para Acib (Usuário):

- Diga "atualize meu perfil" para forçar sincronização
- Diga "mostre meu perfil" para ver dados atuais
- Diga "backup agora" para backup manual no DATASVR

---

## Arquivos da Skill

### Locais de Armazenamento

| Arquivo | Local Primário | Backup DATASVR |
|---------|---------------|----------------|
| Perfil | `memory/PERFIL_ACIB.md` | `/home/master/LAN/MEMORIES/STARK-KNOWLEDGE/` |
| Log diário | `memory/YYYY-MM-DD.md` | `/home/master/LAN/MEMORIES/Backups/` |
| Regras | `AGENTS.md` (seção) | `/home/master/LAN/MEMORIES/STARK-KNOWLEDGE/` |

---

## Backup Automático

### Fluxo:
```
1. Nova informação detectada
2. Atualiza PERFIL_ACIB.md (local)
3. Copia para DATASVR:/home/master/LAN/MEMORIES/
4. Verifica integridade
5. Log de sucesso
```

### Frequência:
- **Tempo real:** Para mudanças críticas
- **A cada interação:** Log diário
- **Fim de sessão:** Sincronização completa

---

## Atualizações da Skill

| Versão | Data | Mudanças |
|--------|------|----------|
| 1.0 | 2026-04-19 | Criação inicial após perda de 25 dias de memórias |

---

## Contato e Suporte

- **Autor:** Stark (CT 100)
- **Usuário:** Acib ABBADE
- **Emergências:** Palavra mágica "LIBERAR" ativa Guardian

---

*Esta skill garante que nenhuma informação importante seja perdida novamente.*
