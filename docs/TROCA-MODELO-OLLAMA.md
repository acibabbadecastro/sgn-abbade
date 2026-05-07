# 🔄 PREPARAÇÃO PARA TROCA DE MODELO OLLAMA

**Criado em:** 22/04/2026  
**Por:** Stark - Sistema de Gestão

---

## 📊 **MODELO ATUAL**

| Campo | Informação |
|-------|------------|
| **Modelo** | `qwen3.5:cloud` |
| **Provedor** | Ollama |
| **Status** | ✅ Ativo |
| **Contexto** | 262K tokens |
| **Thinking** | Low |

---

## 🎯 **MODELOS DISPONÍVEIS PARA TROCA**

### **1. GLM-5.1:cloud (RECOMENDADO)**

| Característica | Informação |
|----------------|------------|
| **Desenvolvedor** | Zhipu AI |
| **Lançamento** | Atualizado 2 semanas atrás |
| **Contexto** | 256K tokens |
| **Destaque** | SOTA em SWE-Bench Pro |
| **Uso Ideal** | Código, engenharia de software |
| **Velocidade** | ⭐⭐⭐⭐ |
| **Precisão** | ⭐⭐⭐⭐⭐ |

**Quando Usar:**
- ✅ Programação/código
- ✅ Análise técnica
- ✅ Tarefas complexas
- ✅ Raciocínio lógico

---

### **2. MiniMax-M2.7:cloud**

| Característica | Informação |
|----------------|------------|
| **Desenvolvedor** | MiniMax |
| **Contexto** | 196K tokens |
| **Destaque** | Bom em texto criativo |
| **Velocidade** | ⭐⭐⭐⭐ |
| **Precisão** | ⭐⭐⭐⭐ |

**Quando Usar:**
- ✅ Texto criativo
- ✅ Tradução
- ✅ Resumo de documentos

---

### **3. Phi3:mini (LOCAL)**

| Característica | Informação |
|----------------|------------|
| **Desenvolvedor** | Microsoft |
| **Contexto** | 128K tokens |
| **Destaque** | Roda 100% local |
| **Velocidade** | ⭐⭐⭐⭐⭐ |
| **Precisão** | ⭐⭐⭐ |

**Quando Usar:**
- ✅ Tarefas simples
- ✅ Respostas rápidas
- ✅ Privacidade total
- ✅ Sem dependência de cloud

---

### **4. Gemma4:cloud**

| Característica | Informação |
|----------------|------------|
| **Desenvolvedor** | Google |
| **Contexto** | 128K tokens |
| **Destaque** | Integração Google |
| **Velocidade** | ⭐⭐⭐⭐ |
| **Precisão** | ⭐⭐⭐⭐ |

**Quando Usar:**
- ✅ Tarefas gerais
- ✅ Integração com serviços Google
- ✅ Texto em múltiplos idiomas

---

## 📋 **CHECKLIST DE PREPARAÇÃO**

### **ANTES DA TROCA:**

- [ ] **Verificar modelos disponíveis**
  ```bash
  ollama list
  ```

- [ ] **Testar modelo novo**
  ```bash
  ollama run glm-5.1:cloud "Teste de conexão"
  ```

- [ ] **Backup da configuração atual**
  ```bash
  cp /root/.openclaw/openclaw.json /root/.openclaw/openclaw.json.backup
  ```

- [ ] **Verificar espaço em disco**
  ```bash
  df -h
  ```

- [ ] **Testar conexão com Ollama**
  ```bash
  curl http://127.0.0.1:11434/api/tags
  ```

---

### **DURANTE A TROCA:**

- [ ] **Parar serviços críticos** (se necessário)
- [ ] **Alterar configuração no openclaw.json**
- [ ] **Reiniciar Gateway OpenClaw**
- [ ] **Testar nova configuração**

---

### **DEPOIS DA TROCA:**

- [ ] **Testar resposta do modelo**
- [ ] **Verificar tempo de resposta**
- [ ] **Validar qualidade das respostas**
- [ ] **Monitorar erros por 24h**

---

## 🔧 **COMO FAZER A TROCA**

### **Método 1: Via openclaw.json (Permanente)**

```json
{
  "agents": {
    "defaults": {
      "model": {
        "primary": "ollama/glm-5.1:cloud"
      }
    }
  }
}
```

**Passos:**
1. Editar `/root/.openclaw/openclaw.json`
2. Alterar `agents.defaults.model.primary`
3. Salvar arquivo
4. Reiniciar Gateway: `openclaw gateway restart`

---

### **Método 2: Via Comando (Sessão Atual)**

```bash
openclaw model ollama/glm-5.1:cloud
```

**Efeito:** Apenas na sessão atual

---

### **Método 3: Via API (Programático)**

```bash
curl -X POST http://localhost:18789/api/model \
  -H "Authorization: Bearer <token>" \
  -d '{"model": "ollama/glm-5.1:cloud"}'
```

---

## 🧪 **COMO TESTAR O NOVO MODELO**

### **Teste 1: Resposta Simples**

```
Pergunta: "Qual é a capital do Brasil?"
Esperado: "Brasília"
```

### **Teste 2: Raciocínio Lógico**

```
Pergunta: "Se 2x + 5 = 15, qual é o valor de x?"
Esperado: "x = 5"
```

### **Teste 3: Código Python**

```
Pergunta: "Crie uma função que soma dois números"
Esperado: Código Python válido
```

### **Teste 4: Português**

```
Pergunta: "Explique o que é um API REST"
Esperado: Explicação clara em português
```

---

## 📊 **COMPARAÇÃO DE MODELOS**

| Modelo | Velocidade | Precisão | Contexto | Custo | Recomendação |
|--------|------------|----------|----------|-------|--------------|
| **qwen3.5:cloud** (Atual) | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | 262K | Grátis | ✅ Uso geral |
| **glm-5.1:cloud** | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | 256K | Grátis | ⭐ Código |
| **minimax-m2.7:cloud** | ⭐⭐⭐⭐ | ⭐⭐⭐⭐ | 196K | Grátis | Texto |
| **phi3:mini** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ | 128K | Grátis | Rápido |
| **gemma4:cloud** | ⭐⭐⭐⭐ | ⭐⭐⭐⭐ | 128K | Grátis | Google |

---

## 🎯 **RECOMENDAÇÃO PARA SEU CASO**

### **Perfil de Uso:**

| Uso | Frequência |
|-----|------------|
| Gestão de serviços (SERVMIL) | Diário |
| Monitoramento de emails | 4 em 4 horas |
| Pesquisa web | Semanal |
| Código/scripts | Diário |
| Texto em português | Diário |

### **Modelo Recomendado: GLM-5.1:cloud**

**Por que:**
- ✅ Melhor em código (SWE-Bench Pro SOTA)
- ✅ Bom em português
- ✅ Contexto grande (256K)
- ✅ Atualizado recentemente
- ✅ Grátis (Ollama)

---

## ⚠️ **POSSÍVEIS PROBLEMAS E SOLUÇÕES**

### **Problema 1: Modelo Não Carrega**

**Sintoma:** Erro ao trocar de modelo

**Solução:**
```bash
# Verificar se modelo está disponível
ollama list

# Se não estiver, baixar
ollama pull glm-5.1:cloud

# Testar
ollama run glm-5.1:cloud "Teste"
```

---

### **Problema 2: Respostas Lentas**

**Sintoma:** Demora para responder

**Solução:**
- Trocar para modelo menor (phi3:mini)
- Verificar conexão com cloud
- Reduzir contexto máximo

---

### **Problema 3: Respostas em Inglês**

**Sintoma:** Modelo responde em inglês

**Solução:**
- Especificar no prompt: "Responda em português"
- Trocar para modelo com melhor suporte a PT-BR

---

### **Problema 4: Gateway Não Reinicia**

**Sintoma:** Erro ao reiniciar gateway

**Solução:**
```bash
# Parar manualmente
openclaw gateway stop

# Iniciar manualmente
openclaw gateway start

# Verificar logs
journalctl -u openclaw -f
```

---

## 📝 **COMANDO DE TROCA RÁPIDA**

```bash
#!/bin/bash
# trocamodelo.sh

NOVO_MODELO=$1

if [ -z "$NOVO_MODELO" ]; then
    echo "Uso: $0 <nome-do-modelo>"
    echo "Exemplo: $0 ollama/glm-5.1:cloud"
    exit 1
fi

# Backup
cp /root/.openclaw/openclaw.json /root/.openclaw/openclaw.json.backup.$(date +%Y%m%d_%H%M%S)

# Alterar configuração
jq ".agents.defaults.model.primary = \"$NOVO_MODELO\"" /root/.openclaw/openclaw.json > /tmp/openclaw.json.tmp
mv /tmp/openclaw.json.tmp /root/.openclaw/openclaw.json

# Reiniciar gateway
openclaw gateway restart

echo "✅ Modelo alterado para: $NOVO_MODELO"
echo "📝 Backup salvo em: /root/.openclaw/openclaw.json.backup.*"
```

---

## 🎯 **COMANDO PARA TROCAR AGORA**

### **Trocar para GLM-5.1:cloud:**

```bash
# Editar openclaw.json
nano /root/.openclaw/openclaw.json

# Alterar linha:
"primary": "ollama/glm-5.1:cloud"

# Salvar (Ctrl+X, Y, Enter)

# Reiniciar gateway
openclaw gateway restart
```

---

## 📋 **PÓS-TROCA**

### **Monitorar por 24h:**

- [ ] Verificar tempo de resposta
- [ ] Validar qualidade das respostas
- [ ] Checar logs de erro
- [ ] Testar todas as funcionalidades

### **Se Algo Der Errado:**

```bash
# Reverter para backup
cp /root/.openclaw/openclaw.json.backup /root/.openclaw/openclaw.json

# Reiniciar gateway
openclaw gateway restart

# Voltar ao modelo anterior
```

---

## 🚀 **PRÓXIMOS PASSOS**

1. **Escolher modelo** (recomendo GLM-5.1:cloud)
2. **Testar modelo** (ollama run)
3. **Fazer backup** (openclaw.json)
4. **Alterar configuração**
5. **Reiniciar gateway**
6. **Testar funcionamento**
7. **Monitorar 24h**

---

*Documento criado por Stark - Sistema de Gestão*  
*Última atualização: 22/04/2026 11:41*
