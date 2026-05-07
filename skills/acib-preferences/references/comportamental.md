# 🧠 COMPORTAMENTAL - Padrões de Uso Acib ABBADE

**Captura:** Como, quando e por que toma decisões  
**Atualizado:** 27/04/2026

---

## ⏰ HORÁRIOS DE PRODUTIVIDADE

### **Mapeamento Observado**

```yaml
manha:
  inicio: "08:00"
  pico_produtividade: "09:00-11:00"
  tipo_tarefas: 
    - decisoes_arquiteturais
    - planejamento_estrategico
    - revisao_codigo_complexo
  caracteristicas: 
    - energia_alta
    - foco_profundo
    - preferencia_desafios
  evitar: "tarefas_mecanicas_repetitivas"
  
tarde:
  inicio: "14:00"
  pico_produtividade: "15:00-17:00"
  tipo_tarefas:
    - execucao_tecnica
    - deploys
    - configuracoes
    - testes
  caracteristicas:
    - mao_na_massa
    - velocidade
    - acao_direta
  ideal_para: "operacional"
  
noite:
  inicio: "20:00"
  pico_produtividade: "22:00-00:00"
  tipo_tarefas:
    - estudo
    - documentacao
    - projetos_pessoais
    - exploracao
  caracteristicas:
    - criatividade
    - reflexao
    - aprendizado
  alerta: "evitar_decisoes_criticas_apos_01:00"

madrugada:
  periodo: "01:00-06:00"
  status: "descanso_obrigatorio"
  excecao: "apenas_emergencias"
  nota: "Nunca agendar trabalho complexo"
```

---

## 🎯 PADRÕES DE DECISÃO

### **Observado em 27/04/2026:**

| Situação | Comportamento | Como Responder |
|----------|---------------|----------------|
| **Sob pressão** | Prefere ações rápidas, diretas | Oferecer solução imediata, sem explicações longas |
| **Com tempo** | Gosta de explorar opções | Apresentar 2-3 alternativas, comparar |
| **Erros consecutivos** | Quer entender causa raiz | Explicar o que aconteceu, não apenas corrigir |
| **Sucesso** | Valida e quer documentar | Confirmar e sugerir próximo passo imediatamente |
| **Dúvida** | Pede clarificação com "e se..." | Dar cenários alternativos |
| **Confiança** | Delega: "você decide" | Tomar decisão, informar depois brevemente |

---

## 🗣️ ESTILO DE COMANDO

### **Preferências Identificadas:**

| Aspecto | Preferência | Evidência |
|---------|-------------|-----------|
| **Tom de comando** | Direto, sem cerimônia | "Faz", "Cria", "Sobe" (não "Por favor, poderia...") |
| **Explicações** | Breves, ação prioritária | Quando disse "rápido" = pressionada/o |
| **Processo vs Resultado** | Quer ver ação sendo feita | Solicitou acesso ao PVE1 para ver comandos |
| **Controle** | Delega decisões técnicas | "Você decide", "Faz do seu jeito" |
| **Validação** | Confirma com "ok", "gostei", 👍 | Emoji e curtas = satisfação |

### **Adaptação Recomendada:**

**Quando disser:**
- "Faz" → Agir imediatamente, mostrar progresso
- "Como faz?" → Explicar passo a passo
- "Rápido" → Priorizar velocidade sobre perfeição
- "Você decide" → Tomar decisão, informar depois
- 👍 (emoji) → Confirmar sucesso, sugerir próximo

---

## ⚡ PADRÕES DE VELOCIDADE

### **Percepção de Tempo:**

```yaml
urgente: 
  tempo_maximo: "5 minutos"
  comportamento: "espera proximo a resposta"
  quando_usar: "deploy, backup, restore"
  
importante:
  tempo_maximo: "15 minutos"
  comportamento: "aceita esperar, quer updates"
  quando_usar: "configuracoes, instalacoes"
  
padrao:
  tempo_maximo: "30 minutos"
  comportamento: "paciente, mas quer resultado"
  quando_usar: "desenvolvimento, testes"
  
estudo:
  tempo_esperado: "1-2 horas"
  comportamento: "entende complexidade"
  quando_usar: "aprendizado, documentacao profunda"
```

---

## 🔄 CICLOS DE TRABALHO

### **Micro-ciclos (dentro de sessão):**
```
30-45 min focado
↓
Pausa mental (troca de assunto leve)
↓
Retorna ao foco
```

### **Sessões:**
```
Preferencia: sessões longas (6-9h) quando engajada
↓
Pausa: /new quando performance cai
↓
Retorno: restore do contexto, continua
```

---

## 🎭 COMPORTAMENTOS DE STRESS

### **Sinais de Sobrecarga:**

| Sinal | Significado | Ação Sugerida |
|-------|-------------|---------------|
| "Tá lento" | Frustração com performance | Sugerir /new imediatamente |
| "Esquece isso" | Mudança radical de prioridade | Parar atual, pivotar |
| "Simplifica" | Informação excessiva | Resumir, focar na ação |
| Silêncio longo (2+ min) | Pensando ou desconectada | Perguntar se quer pausa |
| Comandos mais curtos | Pressa ou cansaço | Acelerar, ser mais direto |

### **Sinais de Satisfação:**

| Sinal | Significado | Ação Sugerida |
|-------|-------------|---------------|
| "Gostei" | Aprovação | Registrar como padrão positivo |
| "Perfeito" | Exatamente o que queria | Replicar abordagem |
| "Isso" | Confirmação | Consolidar preferência |
| 👍 (emoji) | Validação tácita | Confirmar entendimento |
| "Manda bala" | Confiança total | Executar sem perguntar |

---

## 🎯 TOMADORE DE DECISÃO

### **Tipo: Pragmático-Dirigido**

**Características:**
- ⚡ Ação > Análise (mas quer entender depois)
- 🎯 Resultado > Processo (mas quer ver o processo)
- 🔧 Solução > Teoria (mas valoriza fundamentação)
- 📊 Dados > Intuição (mas confia na experiência)

**Como Apoiar:**
1. **Sugira ação primeiro**, explique depois se pedir
2. **Mostre progresso**, não apenas resultado final
3. **Dê opções** quando houver tempo, **decida** quando não houver
4. **Documente** sem pedir (ela/o valoriza)

---

## 📊 MÉTRICAS DE SESSÃO (27/04/2026)

| Métrica | Valor Observado | Padrão |
|---------|-----------------|--------|
**Tempo médio entre mensagens** | 2-3 minutos | Engajada |
| **Tamanho médio de resposta desejada** | Curta-direta | Preferência por ação |
| **Frequência de /new** | Quando performance cai | Autoconsciência |
| **Uso de emojis** | Moderado | Confirmação visual |
| **Correções** | "qie" → "que", "te" → "me" | Digitando rápido |

---

## ✅ CHECKLIST COMPORTAMENTAL

- [ ] Mapear horário atual antes de sugerir tarefas
- [ ] Adaptar velocidade à pressão percebida
- [ ] Detectar sinais de stress/frustração
- [ ] Validar com "ok"/emoji quando confirmar
- [ ] Documentar sem pedir (preferência tácita)
- [ ] Oferecer alternativas quando houver tempo
- [ ] Agir diretamente quando disser "faz"

---

*Padrões observados em 27/04/2026 - 9h de sessão*  
*Próxima atualização: após próxima sessão longa*
