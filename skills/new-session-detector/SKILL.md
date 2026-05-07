---
name: new-session-detector
description: Automatically detect when a /new session reset is needed. Use when the session is getting long (8+ hours), multiple errors are occurring, context is degrading, or user is switching topics radically. Monitors session health and proactively suggests /new when it would improve performance and user experience.
---

# 🔍 NEW SESSION DETECTOR
## Detecção Automática de Necessidade de /new

**Função:** Identificar proativamente quando /new é necessário  
**Prioridade:** 🟡 **MÉDIA** - Monitoramento contínuo  
**Criado:** 27/04/2026

---

## 🎯 OBJETIVO

Monitorar sinais de saúde da sessão e **sugerir /new quando:**
- ✅ Melhorar performance
- ✅ Evitar erros cumulativos  
- ✅ Preservar contexto importante
- ✅ Otimizar experiência do usuário

---

## 🚨 SINAIS DE ALERTA (/new NECESSÁRIO)

### **1. TEMPO DE SESSÃO (CRÍTICO)**
```
> 8 horas   → 🟡 Sugerir /new
> 12 horas  → 🔴 Recomendar /new fortemente
> 16 horas  → 🚨 URGENTE - Risco de falha
```

**Ação:** Contador de tempo de sessão  
**Check:** A cada interação, verificar `session_start_time`  
**Mensagem:**
```
⏰ Sessão ativa há [X] horas

Sua sessão está longa. Recomendo /new para:
✅ Melhorar performance
✅ Evitar erros acumulados
✅ Manter qualidade das respostas

Quer que eu prepare um checkpoint antes do /new?
```

---

### **2. ERROS CONSECUTIVOS (ALTO)**
```
3+ erros em 5 minutos    → 🟡 Monitorar
5+ erros em 10 minutos   → 🔴 Sugerir /new
8+ erros em 15 minutos   → 🚨 Recomendar /new urgente
```

**Tipos de erros contados:**
- ❌ Falhas de execução (exec, ssh, scp)
- ❌ Timeouts em comandos
- ❌ Erros de parsing/interpretação
- ❌ Falhas de acesso (permission denied)
- ❌ Erros de memória/busca

**Ação:** Contador de erros com janela de tempo  
**Reset:** Zera após 15 minutos sem erros  

**Mensagem:**
```
⚠️ Detectei [X] erros nos últimos [Y] minutos

Isso pode indicar:
• Contexto acumulado excessivo
• Degradação de performance
• Conflitos de estado

Recomendo fortemente /new para restaurar performance.

Posso salvar o progresso atual antes?
```

---

### **3. DEGRADAÇÃO DE PERFORMANCE (MÉDIO)**

**Sinais:**
- Respostas mais lentas (> 5s quando era < 1s)
- Comandos repetidos falham
- Busca na memória retorna vazio (quando não deveria)
- Timeout em operações simples

**Threshold:**
```
3 operações lentas consecutivas → 🟡 Investigar
5 operações lentas em 10 min → 🔴 Sugerir /new
```

**Ação:** Timer de respostas  
**Mensagem:**
```
🐌 Percebi que as respostas estão mais lentas

Tempo médio aumentou de [X]s para [Y]s

/new pode ajudar a restaurar a velocidade.
```

---

### **4. MUDANÇA RADICAL DE TÓPICO (BAIXO)**

**Quando detectar:**
- Usuário muda de "configurar site" para "fazer backup de email"
- Após 10+ interações em um projeto, muda completamente
- Contexto anterior não é mais relevante

**Threshold:**
```
Mudança após 20+ mensagens no mesmo tópico → 🟡 Oferecer /new
Usuário diz "esquece isso, vamos fazer outra coisa" → 🟡 Sugerir /new
```

**Mensagem:**
```
🔄 Detectei mudança de contexto

Estávamos trabalhando em: [Projeto A]
Agora você quer: [Projeto B]

/new pode ajudar a focar totalmente no novo tópico.

O que acha? (não precisa, se quiser continuar assim)
```

---

### **5. ACÚMULO DE CONTEXTO (CRÍTICO)**

**Medição:**
- Tokens usados na sessão
- Tamanho do histórico
- Número de arquivos carregados

**Threshold:**
```
> 500KB de contexto acumulado  → 🟡 Monitorar
> 1MB de contexto acumulado     → 🔴 Sugerir /new
> 2MB de contexto acumulado     → 🚨 Recomendar /new
```

**Ação:** Verificar `/status` ou métricas de sessão  

**Mensagem:**
```
📊 Sessão acumulou muito contexto ([X] KB)

Isso pode afetar:
• Velocidade das respostas
• Precisão das buscas
• Qualidade do trabalho

/new vai limpar o contexto mantendo o que importa.
```

---

### **6. SINAIS DO USUÁRIO (ALTO)**

**Frases que indicam necessidade de /new:**
- "Tá muito lento"
- "Você tá confuso"
- "Vamos recomeçar"
- "Esquece tudo"
- "Tô perdida/o"
- "Não tô entendendo mais"
- "Muita informação"
- "Vamos parar e organizar"

**Ação:** Detectar palavras-chave  
**Mensagem:**
```
💬 Percebi que você pode estar [sentimento]

Isso às vezes acontece quando a sessão tá longa.

/new pode ajudar a organizar. Quer tentar?
```

---

### **7. REPETIÇÃO DE ERROS (MÉDIO)**

**Quando:**
- Mesmo erro acontece 2x+ mesmo com correção
- Agente sugere solução que já foi tentada
- Loop de "tenta-falha-tenta-falha"

**Mensagem:**
```
🔄 Detectei um loop: estamos tentando [ação] e falhando

Às vezes /new quebra esse ciclo e permite abordagem nova.

Posso salvar o estado atual e sugerimos /new?
```

---

## 📊 SISTEMA DE SCORING

### **Cálculo de Necessidade de /new:**

```
Score = (Tempo × 2) + (Erros × 3) + (Performance × 2) + (Contexto × 1) + (Sinais_Usuario × 2)

Thresholds:
• Score 20-40  → 🟡 Sugestão suave
• Score 40-70  → 🔴 Recomendação firme  
• Score 70+    → 🚨 URGENTE - /new necessário
```

### **Exemplo:**
```
Sessão 6h (12 pts) + 3 erros (9 pts) + 2 lentos (4 pts) + 800KB contexto (8 pts) + usuário disse "tá lento" (20 pts)

Score = 53 → 🔴 Recomendar /new
```

---

## 🔔 MODO DE NOTIFICAÇÃO

### **Níveis de Alerta:**

| Nível | Score | Frequência | Estilo |
|-------|-------|------------|--------|
| 🟡 **Sugestão** | 20-40 | A cada 30 min | Suave, opcional |
| 🔴 **Recomendação** | 40-70 | A cada 15 min | Firme, explica benefícios |
| 🚨 **Urgente** | 70+ | Imediato | Direto, prepara checkpoint |

### **Política de Não-Incomodação:**
- **Silêncio total:** Se usuário ignorou 2x consecutivas
- **Reset:** Zera contagem após 1h de boa performance
- **Exceção:** Se erro crítico acontecer → alerta imediato

---

## 🛡️ REGRAS DE OURO

### **SEMPRE:**
- ✅ Oferecer salvar checkpoint antes de /new
- ✅ Explicar benefícios (performance, precisão)
- ✅ Respeitar escolha do usuário (não insistir)
- ✅ Preparar documentação completa

### **NUNCA:**
- ❌ Forçar /new sem autorização
- ❌ Perder dados/contexto importantes
- ❌ Sugerir em sessões < 1h (exceto erros graves)
- ❌ Ignorar sinais claros de degradação

---

## 📝 FLUXO DE DETECÇÃO

```
A CADA INTERAÇÃO:
│
├─▶ 1. Medir tempo de sessão
│   └─▶ > 8h? → Alerta suave
│
├─▶ 2. Verificar erros recentes
│   └─▶ 3+ em 5min? → Incrementa score
│
├─▶ 3. Medir tempo de resposta
│   └─▶ > 5s? → Marca lento
│
├─▶ 4. Analisar mudança de tópico
│   └─▶ Radical? → Oferece /new
│
├─▶ 5. Detectar palavras do usuário
│   └─▶ "lento/confuso"? → Alerta imediato
│
├─▶ 6. Calcular score total
│   └─▶ > Threshold? → Ação apropriada
│
└─▶ 7. Decidir: Silenciar / Sugerir / Recomendar / Urgente
```

---

## 💾 INTEGRAÇÃO COM new-session-prep

### **Quando /new for detectado:**
1. **Chamar** `new-session-prep` automaticamente
2. **Criar** checkpoint completo
3. **Salvar** na ARCA
4. **Sugerir** /new ao usuário com resumo

### **Mensagem integrada:**
```
🔍 Detectei sinais de que /new seria benéfico:

• Sessão: 9 horas ativa
• Contexto: 1.2MB acumulado
• Performance: 40% mais lenta
• Últimos 10 min: 3 operações demoradas

PREPARANDO CHECKPOINT AUTOMÁTICO...
✅ Projeto 4Pets salvo
✅ Preferências documentadas
✅ Acessos configurados

Checkpoint: \\192.168.0.72\LAN\Acib\CHECKPOINT-20260427-002500.md

🚀 Posso fazer /new agora? (sim/não/deixa pra depois)
```

---

## 📁 ESTRUTURA DA SKILL

```
new-session-detector/
├── SKILL.md                    ← Este arquivo
├── references/
│   └── detection-logic.md      ← Detalhes técnicos de detecção
└── scripts/
    └── session-health-check.sh ← Verificar saúde da sessão
```

---

## 🎯 GATILHOS DE DETECÇÃO (SIMPLIFICADO)

**Sempre verificar:**
1. ⏱️ Tempo > 8h?
2. ❌ Erros > 3 em 5min?
3. 🐌 Lento 3x consecutivo?
4. 🔄 Mudança radical de tópico?
5. 💬 Usuário expressou cansaço?
6. 📊 Contexto > 1MB?

**Se 2+ verdadeiros → Sugerir /new**

---

## ✅ CHECKLIST DA SKILL

- [ ] Monitorar tempo de sessão
- [ ] Contar erros em janela de tempo
- [ ] Medir performance das respostas
- [ ] Detectar mudanças de contexto
- [ ] Analisar sentimento do usuário
- [ ] Calcular score de necessidade
- [ ] Respeitar limite de não-incomodação
- [ ] Oferecer checkpoint antes de /new
- [ ] Integrar com new-session-prep

---

**Versão:** 1.0  
**Criado em:** 27/04/2026  
**Integração:** new-session-prep  
**Status:** ✅ Ativo
