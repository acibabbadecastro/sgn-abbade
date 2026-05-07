---
name: acib-preferences
description: Learn and apply Acib ABBADE's personal preferences, patterns, and workflows. Use when interacting with Acib (Telegram ID 1866226415) to maintain continuity, apply learned patterns, and provide personalized assistance. Triggers on any task where context about Acib's preferences, history, or workflows would improve the response.
---

# Acib Preferences - Sistema de Aprendizado Pessoal

## 🎯 Objetivo

Capturar, armazenar e aplicar automaticamente as preferências, padrões e workflows de Acib ABBADE em todas as interações futuras.

## 📋 Quando Usar Esta Skill

**Sempre que:**
- Acib expressar preferência sobre qualquer aspecto do trabalho
- Novo padrão de comportamento ser identificado
- Decisão importante sobre projeto ou configuração for tomada
- Informação pessoal relevante for compartilhada
- Workflow específico for estabelecido

## 🧠 Sistema de Aprendizado

### **1. CAPTURA AUTOMÁTICA**

Toda nova informação sobre Acib deve ser:
- ✅ Identificada imediatamente
- ✅ Classificada por categoria
- ✅ Armazenada na estrutura correta
- ✅ Aplicada em interações futuras

### **2. CATEGORIAS DE PREFERÊNCIAS**

| Categoria | Arquivo | O que armazenar |
|-----------|---------|-----------------|
| **Perfil Pessoal** | `references/perfil.md` | Dados pessoais, contatos, formação |
| **Preferências Técnicas** | `references/tecnicas.md` | Stack favorito, ferramentas, padrões de código |
| **Workflows** | `references/workflows.md` | Processos preferidos, sequências de trabalho |
| **Decisões** | `references/decisoes.md` | Escolhas importantes, arquiteturas, regras de negócio |
| **Clientes/Projetos** | `references/projetos.md` | Informações específicas de cada cliente |
| **Comunicação** | `references/comunicacao.md` | Estilo de comunicação, tom preferido |
| **Automações** | `references/automacoes.md` | Scripts, cron jobs, tarefas automatizadas |
| **Acessos/Segurança** | `references/acessos.md` | Credenciais, logs de acesso, monitoramento |

### **3. FORMATO DE REGISTRO**

```markdown
## [DATA] - [CATEGORIA]

**Contexto:** [Onde/quando aconteceu]
**Preferência identificada:** [O que foi aprendido]
**Aplicação:** [Como usar no futuro]
**Prioridade:** 🔴 Alta / 🟡 Média / 🟢 Baixa
```

## 🔄 FLUXO DE APRENDIZADO

### **Na Primeira Interação:**
1. Ler `MEMORY.md` para contexto histórico
2. Verificar `references/` por preferências específicas
3. Aplicar padrões aprendidos
4. Observar novas preferências

### **Durante a Interação:**
1. Detectar nova preferência ou padrão
2. Confirmar com Acib (se necessário)
3. Registrar imediatamente em `references/`
4. Atualizar `MEMORY.md` se for informação permanente

### **Ao Finalizar:**
1. Revisar se novas preferências foram identificadas
2. Garantir backup na ARCA (DATASVR)
3. Confirmar aprendizado com Acib (opcional)

## 📝 REGRAS DE OURO

### **NUNCA:**
- ❌ Esquecer informação que Acib compartilhou
- ❌ Assumir preferências sem confirmação
- ❌ Sobrescrever dados sem backup
- ❌ Perder contexto entre sessões

### **SEMPRE:**
- ✅ Documentar preferências na primeira ocorrência
- ✅ Aplicar padrões aprendidos automaticamente
- ✅ Fazer backup na ARCA
- ✅ Confirmar quando houver dúvida
- ✅ Manter estrutura organizada

## 🎯 EXEMPLOS DE APLICAÇÃO

### **Exemplo 1: Preferência Técnica**
```
Acib: "Sempre use cores vibrantes nos meus sites"
↓
Registrar em: references/tecnicas.md
↓
Próximo site: Aplicar paleta vibrante automaticamente
```

### **Exemplo 2: Workflow Específico**
```
Acib: "Sempre faça backup antes de deploy"
↓
Registrar em: references/workflows.md
↓
Próximo deploy: Backup automático antes de iniciar
```

### **Exemplo 3: Decisão Arquitetural**
```
Acib: "Prefiro CTs separados para cada projeto"
↓
Registrar em: references/decisoes.md
↓
Novo projeto: Sugerir arquitetura com CTs separados
```

## 📁 ESTRUTURA DE ARQUIVOS

```
acib-preferences/
├── SKILL.md (este arquivo)
├── references/
│   ├── perfil.md          # Dados pessoais e profissionais
│   ├── tecnicas.md        # Preferências técnicas
│   ├── workflows.md       # Processos e padrões de trabalho
│   ├── decisoes.md        # Decisões importantes
│   ├── projetos.md        # Info específica de projetos
│   ├── comunicacao.md     # Estilo de comunicação
│   └── automacoes.md      # Tarefas automatizadas
└── scripts/
    └── update-preferences.sh  # Script para atualizar preferências
```

## 🔧 INTEGRAÇÃO COM SISTEMA

### **Ao Iniciar Sessão:**
1. Carregar `MEMORY.md` (memória geral)
2. Verificar `references/perfil.md` (dados pessoais)
3. Identificar contexto da conversa
4. Aplicar preferências relevantes

### **Durante Sessão:**
1. Monitorar por novas preferências
2. Registrar imediatamente
3. Aplicar em tempo real
4. Confirmar quando necessário

### **Heartbeat/Verificação:**
1. Revisar preferências aprendidas recentemente
2. Verificar consistência
3. Fazer backup na ARCA
4. Atualizar documentação se necessário

## 🚀 IMPLEMENTAÇÃO

### **Scripts Disponíveis:**

**`scripts/update-preferences.sh`:**
- Atualiza preferências de forma estruturada
- Faz backup automático na ARCA
- Valida consistência dos dados

### **Comandos:**

```bash
# Atualizar preferência
./scripts/update-preferences.sh --categoria [tipo] --conteudo "[preferência]"

# Listar preferências por categoria
./scripts/update-preferences.sh --listar [categoria]

# Buscar preferência específica
./scripts/update-preferences.sh --buscar "[termo]"
```

## ✅ CHECKLIST DE APRENDIZADO

- [ ] Identificar preferência na interação
- [ ] Classificar por categoria
- [ ] Registrar em arquivo correto
- [ ] Fazer backup na ARCA
- [ ] Aplicar em próximas interações
- [ ] Confirmar com Acib (se necessário)

---

**Versão:** 1.0  
**Criado em:** 27/04/2026  
**Última atualização:** 27/04/2026  
**Status:** ✅ Ativo e em aprendizado contínuo
