---
name: acib-learning-expansion
description: Expand learning capabilities to capture deeper insights about Acib's behavior, preferences, patterns, and needs. Use when identifying new dimensions of user context that should be preserved across sessions for increasingly personalized assistance.
---

# 🧠 EXPANSÃO DO SISTEMA DE APRENDIZADO
## Captura Profunda de Informações sobre Acib

**Versão:** 2.0 (Expansão)  
**Data:** 27/04/2026  
**Objetivo:** Ir além das preferências básicas

---

## 🎯 NOVAS DIMENSÕES DE CAPTURA

### **1. COMPORTAMENTAL (Padrões de Uso)**

#### **Horários de Produtividade**
```yaml
manha:
  inicio: "08:00"
  pico: "09:00-11:00"
  tipo: "tarefas complexas, decisões importantes"
  
tarde:
  inicio: "14:00"
  pico: "15:00-17:00"
  tipo: "trabalho técnico, deploys"
  
noite:
  inicio: "20:00"
  pico: "22:00-00:00"
  tipo: "estudo, documentação, projetos pessoais"
  
alerta: "Evitar tarefas complexas após 01:00"
```

#### **Padrões de Decisão**
| Situação | Comportamento Observado | Como Aplicar |
|----------|------------------------|--------------|
| **Sob pressão** | Prefere ações rápidas, diretas | Oferecer soluções imediatas |
| **Com tempo** | Gosta de explorar opções | Apresentar alternativas |
| **Erros** | Quer entender causa raiz | Sempre explicar o que aconteceu |
| **Sucesso** | Valida e quer documentar | Confirmar e sugerir próximo passo |

#### **Estilo de Comando**
- Prefere comandos diretos ou explicações antes?
- Gosta de ver o processo ou só o resultado?
- Quer controle total ou delega decisões técnicas?
- Frequência de "por favor" vs comandos diretos

---

### **2. COGNITIVO (Como Processa Informação)**

#### **Formatos Preferidos**
```yaml
visual:
  - Tabelas para comparações
  - Diagramas para arquiteturas
  - Cores para status (verde/vermelho/amarelo)
  
textual:
  - Bullet points para listas
  - Negrito para ênfase
  - Emojis para categorias (🔴🟡🟢)
  
estrutural:
  - Hierarquia clara (tópicos → subtópicos)
  - Resumo no início
  - Checklists acionáveis
```

#### **Nível de Detalhe**
| Contexto | Nível Desejado | Exemplo |
|----------|---------------|---------|
| **Urgente** | Mínimo (só ação) | "Deploy feito. URL: ..." |
| **Rotina** | Padrão (ação + resultado) | "Backup criado em X. Próximo passo: Y" |
| **Novo** | Completo (ação + por quê + alternativas) | Explicação completa |
| **Estudo** | Profundo (teoria + prática + referências) | Documentação extensa |

#### **Padrões de Aprendizado**
- Aprende melhor com exemplos práticos ou teoria?
- Prefere "faça assim" ou "entenda por quê"?
- Gosta de analogias (arquiteto = IAs) ou linguagem técnica pura?
- Revisita documentação antiga ou sempre quer fresh?

---

### **3. EMOCIONAL (Estado e Necessidades)**

#### **Detectores de Estado**
```
Frases de estresse:
  - "Tá muito lento" → Oferecer /new
  - "Não tô entendendo" → Simplificar, usar analogias
  - "Vamos recomeçar" → Limpar contexto imediatamente
  - "Esquece" → Mudança radical de prioridade

Frases de satisfação:
  - "Gostei" → Registrar como padrão positivo
  - "Perfeito" → Exatamente o que queria
  - "Isso" → Confirmação de preferência
  - 👍 (emoji) → Validação tácita

Frases de dúvida:
  - "Será que..." → Precisa de mais opções
  - "E se..." → Cenário alternativo
  - "Mas" → Objecão a ser considerada
```

#### **Necessidades Subjacentes**
| O que Diz | O que Precisa | Como Responder |
|-----------|-------------|----------------|
| "Faz rápido" | Alívio de pressão | Priorizar, simplificar |
| "Explica direito" | Clareza/segurança | Detalhar, usar analogias |
| "Você decide" | Confiar na automação | Tomar decisão, informar depois |
| "Será que tem outro jeito?" | Controle/criatividade | Apresentar alternativas |

---

### **4. PROFISSIONAL (Carreira e Objetivos)**

#### **Objetivos de Longo Prazo**
```yaml
2026:
  - Formar em ADS (UNOPAR)
  - Consolidar sistema multi-agente
  - Expandir cliente SERVMIL
  
2027-2028:
  - Especialização em IA
  - Certificações (AWS, Azure)
  - Consultoria multi-agentes
  
2029+:
  - Arquiteta de IA reconhecida
  - Produto próprio (plataforma)
  - Mentoria/ensino
```

#### **Motivadores Profundos**
- **Autonomia:** Sistemas que operam sozinhos
- **Reconhecimento:** Ser referência em multi-agentes
- **Impacto:** Soluções que ajudam comunidade (4Pets)
- **Domínio:** Entender profundamente cada tecnologia
- **Elegância:** Soluções simples para problemas complexos

#### **Medos/Preocupações**
- Perder dados/credenciais
- Sistemas que falham silenciosamente
- Depender de terceiros (cloud, APIs pagas)
- Não conseguir entregar no prazo
- Tecnologia que não controla totalmente

---

### **5. SOCIAL (Rede e Relacionamentos)**

#### **Mapa de Stakeholders**
```yaml
clientes:
  servmil:
    tipo: "melhor cliente"
    contatos: ["Saulo", "Anderson", "Bryan", "Daniela"]
    prioridade: "🔴 Alta - Responder em 2h"
    
  caverna:
    tipo: "cliente regular"
    status: "ativo"
    prioridade: "🟡 Média"

faculdade:
  projeto_extensao:
    orientador: "Dorival Magro Junior"
    grupo: "Amigos de 4 Patas - Parque Meia Lua"
    entrega: "02/05/2026"
    
  disciplinas:
    - nome: "Sistemas Distribuídos"
      professor: "Mariana Karina Miglionari"
    - nome: "Projeto de Extensão II"
      professor: "Dorival Magro Junior"

pessoal:
  filho: "Nicolas"
  contato_filho: "nicolasjesusmotadacruz@gmail.com"
  utiliza_ia_para: "ajudar filho com tarefas"
```

#### **Tom de Comunicação por Stakeholder**
| Com quem | Tom | Formalidade | Velocidade |
|----------|-----|-------------|------------|
| **SERVMIL (Saulo)** | Direto, eficiente | Média | ⚡ Rápido |
| **Faculdade (professor)** | Respeitoso, técnico | Alta | 📐 Completo |
| **Grupo 4Patas** | Comunitário, acolhedor | Baixa | 🤝 Colaborativo |
| **Nicolas (filho)** | Didático, paciente | Baixa | 📚 Educacional |
| **Eu (Stark)** | Par, colaborativo | Baixa | ⚡ Adaptável |

---

### **6. TÉCNICO-AVANÇADO (Stack Evoluído)**

#### **Arquitetura Mental**
```
Pensamento Sistemático:
├── Containerização
│   └── LXC (Proxmox) → Isolamento perfeito
├── Orquestração
│   └── Multi-agentes (Stark coordena)
├── Persistência
│   └── PostgreSQL (estado) + DATASVR (arquivos)
├── Comunicação
│   └── OpenClaw (sessões) + SSH (infra)
├── Segurança
│   └── Chaves SSH + Senhas locais + ARCA
└── Exposição
    └── Cloudflare Tunnel (zero trust)
```

#### **Anti-Padrões (O que NÃO Gosta)**
- Docker em produção (prefere LXC)
- APIs de terceiros sem fallback
- Cloud pública (prefere on-premise)
- SaaS que não pode controlar
- Soluções que requerem manutenção constante

#### **Padrões de Código/Infra**
```yaml
nomenclatura:
  containers: "CT XXX - Nome descritivo"
  arquivos: "NOME-DESCRITIVO-YYYYMMDD.ext"
  backups: "[TIPO]-backup-[TIMESTAMP].[ext]"
  
organizacao:
  projetos: "/projetos/{nome}/{docs,files,backups}/"
  skills: "/skills/{nome}/{scripts,references,assets}/"
  memoria: "/memory/{YYYY-MM-DD}.md"
  
documentacao:
  estilo: "Tabelas + emojis + hierarquia"
  formato: "Markdown padrão"
  idioma: "Português (pt-BR)"
```

---

### **7. TEMPORAL (Gestão de Tempo)**

#### **Calendário Mental**
```yaml
semana_tipo:
  segunda:
    foco: "Planejamento, reuniões"
    evitar: "Deploys arriscados"
    
  terca_quarta:
    foco: "Execução, trabalho técnico"
    ideal_para: "Deploys, configurações"
    
  quinta:
    foco: "Review, documentação"
    ideal_para: "Backups, organização"
    
  sexta:
    foco: "Fechamento, entregas"
    evitar: "Iniciar projetos longos"
    
  fim_de_semana:
    foco: "Estudo, projetos pessoais"
    disponibilidade: "Variável (família)"
```

#### **Ciclos de Produtividade**
- **Micro-ciclo:** 90 min trabalho → 15 min pausa
- **Macro-ciclo:** 3 dias intensos → 1 dia leve
- **Sprint pessoal:** 2 semanas focado → 3 dias descanso

#### **Prazos Críticos (Sempre na Memória)**
| Prazo | Dias Restantes | Projeto | Prioridade |
|-------|---------------|---------|------------|
| 02/05/2026 | 5 | Projeto Extensão II | 🔴 URGENTE |
| 09/05/2026 | 12 | AV1 Sistemas Distribuídos | 🔴 ALTA |
| Mensal | - | Limites fiscais (MEI/IRPF) | 🟡 MÉDIA |

---

### **8. LINGUÍSTICO (Como se Expressa)**

#### **Vocabulário Técnico Favorito**
- "Orquestrador" (não "coordenador")
- "Multi-agente" (não "sistema distribuído")
- "Deploy" (não "publicar")
- "Stack" (não "conjunto de tecnologias")
- "CT" (não "container" ou "máquina virtual")

#### **Abreviações Consistentes**
| Abreviação | Significado | Contexto |
|------------|-------------|----------|
| **ARCA** | DATASVR (192.168.0.72) | Backup |
| **CT** | Container Proxmox | Infraestrutura |
| **/new** | Nova sessão | Comando |
| **PVE** | Proxmox VE (192.168.0.192) | Servidor |
| **4Pets** | Amigos de 4 Patas | Projeto |

#### **Erros de Digitação Comuns (Auto-corrigir)**
- "nao" → "não"
- "qie" → "que"
- "wual" → "qual"
- "te" → "me" (contexto: "deixa te exausto" → "me")
- "neww" → "new"
- "tc" → "CT" (contexto técnico)

---

## 🔧 IMPLEMENTAÇÃO DA EXPANSÃO

### **Fase 1: Comportamental (Imediato)**
- [ ] Mapear horários de produtividade
- [ ] Identificar padrões de decisão
- [ ] Catalogar formatos preferidos

### **Fase 2: Cognitivo (1-2 semanas)**
- [ ] Testar níveis de detalhe
- [ ] Mapear estilo de aprendizado
- [ ] Catalogar analogias efetivas

### **Fase 3: Emocional (Contínuo)**
- [ ] Criar detector de estado
- [ ] Mapear necessidades subjacentes
- [ ] Ajustar respostas por estado

### **Fase 4: Profissional (Mensal)**
- [ ] Revisar objetivos de longo prazo
- [ ] Atualizar calendário acadêmico
- [ ] Revisar mapa de stakeholders

---

## 🎯 NOVOS ARQUIVOS DA SKILL

### **Estrutura Expandida:**
```
acib-preferences/
├── references/
│   ├── perfil.md              ← Dados básicos ✅
│   ├── tecnicas.md            ← Stack técnico ✅
│   ├── workflows.md           ← Processos ✅
│   ├── decisoes.md            ← Escolhas ✅
│   ├── acessos.md             ← Segurança ✅
│   ├── comportamental.md      ← 🆚 NOVO: Padrões de uso
│   ├── cognitivo.md           ← 🆚 NOVO: Como processa info
│   ├── emocional.md           ← 🆚 NOVO: Estado e necessidades
│   ├── profissional.md        ← 🆚 NOVO: Carreira e objetivos
│   ├── social.md              ← 🆚 NOVO: Rede de relacionamentos
│   ├── temporal.md            ← 🆚 NOVO: Gestão de tempo
│   └── linguistico.md         ← 🆚 NOVO: Formas de expressão
```

---

## 💡 EXEMPLOS DE APLICAÇÃO

### **Exemplo 1: Adaptação por Horário**
```
[22:30] Acib: "Preciso configurar o backup"

Stark (sem expansão):
  "Vou configurar o backup para você..."

Stark (com expansão comportamental):
  "Às 22:30 você geralmente está em modo 'estudo/projetos'. 
   Backup é automático? Se não, posso fazer rápido 
   ou prefere que eu documente para você fazer amanhã 
   (seu horário pico técnico 15:00-17:00)?"
```

### **Exemplo 2: Detecção de Estado**
```
Acib: "Tá muito lento isso"

Stark (sem expansão):
  "Vou tentar otimizar..."

Stark (com expansão emocional):
  "Percebi que você pode estar frustrada/o. 
   Isso às vezes acontece quando a sessão tá longa 
   (9h hoje). Quer que eu sugira /new para resetar 
   e ficar rápido de novo?"
```

### **Exemplo 3: Comunicação por Stakeholder**
```
Acib: "Preciso enviar email pro Saulo sobre a VPN"

Stark (sem expansão):
  "Aqui o email: ..."

Stark (com expansão social):
  "Saulo (SERVMIL) - cliente prioritário, resposta em 2h.
   Tom: direto e eficiente (ele prefere assim).
   Sugestão de email: 'Saulo, VPN configurada. 
   Acesso: X. Testado OK. Qualquer coisa me avisa.'"
```

---

## 🚀 PRÓXIMOS PASSOS

**Quer que eu comece a implementar essa expansão?**

Posso:
1. **Criar os 6 novos arquivos** de referência
2. **Preencher com o que já aprendi** sobre você hoje
3. **Criar sistema de detecção** comportamental
4. **Testar adaptação** nas próximas interações

**Basta dizer "expande" que eu começo!** 🎯
