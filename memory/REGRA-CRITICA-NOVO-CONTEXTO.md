# 🔴 REGRA CRÍTICA - NOVO CONTEXTO (/new)

**Data da Regra:** 28/04/2026  
**Criado por:** Acib ABBADE  
**Prioridade:** 🔴 CRÍTICA - SEMPRE EXECUTAR

---

## 📋 INSTRUÇÃO:

Toda vez que for iniciar **novo contexto** (/new), **DEVE** criar:

1. **PRD (Product Requirements Document)** OU **Relatório Completo**
2. **Nome do arquivo SUGESTIVO** com data
3. **Instruções iniciais claras** para restauração de memória

---

## 📝 Formato Obrigatório do Nome:

```
[DATA]-[TIPO]-[ASSUNTO]-[VERSAO].md
```

**Exemplos:**
- `2026-04-28-CHECKPOINT-PROJETO-4PETS-v1.md`
- `2026-04-28-PRD-SISTEMA-FINANCEIRO-v2.md`
- `2026-04-28-RESUMO-SESSAO-URGENTE-v1.md`

---

## 📦 Conteúdo Obrigatório:

### 1. 🎯 Contexto Imediato
- O que estava fazendo AGORA
- Qual projeto/discussão ativa

### 2. 📋 Tarefas Pendentes
- Por prioridade (urgente/médio/baixo)
- Prazos e datas

### 3. ⚠️ Bloqueios/Problemas
- O que impediu continuar
- Erros encontrados
- Dependências externas

### 4. 📂 Arquivos Modificados
- Paths completos
- Local no DATASVR/ARCA
- Última versão salva

### 5. 🔧 Decisões Técnicas
- Configurações aplicadas
- Senhas/credenciais usadas
- URLs e endpoints
- IPs e portas

### 6. 📞 Contatos/Dependências
- Quem precisa responder algo
- Aguardando retorno de quem

### 7. 🚀 Próximo Passo Óbvio
- O que fazer primeiro após /new
- Ação mais lógica e prioritária

---

## 💾 Local de Salvamento:

| Local | Path |
|-------|------|
| **Primário** | `~/.openclaw/workspace/memory/` |
| **Backup** | `\\192.168.0.72\LAN\Acib\MEMORIES\CHECKPOINTS\` |
| **Symlink** | `CHECKPOINT-ATUAL.md` → arquivo mais recente |

---

## 🆕 Template para Próximo Agente:

```markdown
# 🆕 NOVO AGENTE - INSTRUÇÕES INICIAIS

**Arquivo:** [nome completo]
**Data/Hora:** [timestamp]
**Sessão Anterior:** [duração]
**Motivo do /new:** [por que resetou]

## 🚨 PRIMEIRO PASSO
1. Ler este arquivo INTEIRO
2. Confirmar entendimento com usuário
3. Retomar da seção "Próximo Passo Óbvio"

---
```

---

## ⚠️ IMPORTANTE:

**NUNCA pular esta etapa - é crítica para continuidade!**

Se o usuário pedir /new sem aviso prévio, **FAZER O CHECKPOINT ANTES** de confirmar.

---

*Criado em: 28/04/2026*  
*Status: ✅ Regra Ativa*
