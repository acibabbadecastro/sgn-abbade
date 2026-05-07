# 🤖 STARK FAMÍLIA - BOT DA VIVIANE

**Criado:** 2026-05-05  
**Proprietária:** Viviane (esposa de Acib)  
**Bot:** @stark_familia_bot  
**Status:** ✅ **CONFIGURADO E PRONTO**

---

## 📱 **COMO A VIVIANE USA**

### **Passo 1: Abrir o Telegram**

### **Passo 2: Buscar o Bot**

Na barra de busca do Telegram:
```
@stark_familia_bot
```

### **Passo 3: Iniciar Conversa**

1. Clicar no bot `@stark_familia_bot`
2. Tocar em **"INICIAR"** ou **"START"**
3. Mandar um "Oi" ou "Olá"

**Pronto!** ✅ O Stark Família está pronto para ajudar!

---

## 💡 **O QUE O BOT PODE FAZER**

**✅ Viviane pode perguntar sobre:**

### **Projetos da Família:**
```
"Como está o projeto 4Pets?"
"O que é o projeto MYROBOT?"
"Quais projetos temos em andamento?"
/projetos
```

### **Finanças (MEI):**
```
"Qual o status do MEI?"
"Quanto já faturamos esse ano?"
"Qual o limite do MEI?"
/financas
```

### **Emails:**
```
"Ver emails recentes"
"Tem email do Nubank?"
"Me mostra os boletos"
/email
```

### **Lembretes:**
```
"Me lembre de pagar a fatura amanhã"
"Criar lembrete: reunião às 15h"
"Quais são meus lembretes?"
/lembrete
```

### **Documentos:**
```
"Onde está o documento do carro?"
"Buscar contrato de aluguel"
/documentos
```

### **Calendário:**
```
"Quais compromissos essa semana?"
/calendario
```

---

## 🔐 **NÍVEIS DE ACESSO**

**✅ O QUE ELA PODE VER:**
- Memórias compartilhadas (MEMORY.md)
- Projetos da família (4Pets, MYROBOT)
- Status financeiro do MEI (limites, faturamento)
- Emails familiares
- Documentos compartilhados
- Lembretes e calendário
- Status geral dos containers

**❌ O QUE ELA NÃO PODE VER:**
- Senhas em claro (.secure/CREDENCIAIS-MASTER.md)
- Chaves SSH privadas
- Tokens de API sensíveis
- Configurações de infraestrutura
- Logs de sistema internos
- Emails pessoais do Acib

---

## 🛠️ **CONFIGURAÇÃO TÉCNICA**

**Arquivo:** `config.json`

```json
{
  "botName": "Stark Família",
  "botUsername": "@stark_familia_bot",
  "botToken": "8558193763:AAExVtcUT8OHZUm4HZs5xU8eRkqjf2gME5w",
  "owner": "Viviane",
  "workspace": "/root/.openclaw/workspace/bots/viviane-bot/",
  
  "access": {
    "memories": true,
    "projects": true,
    "finance_basic": true,
    "emails": true,
    "containers_status": true,
    "documents": true,
    "calendar": true,
    "reminders": true,
    
    "credentials": false,
    "ssh_keys": false,
    "api_tokens": false,
    "infra_config": false,
    "system_logs": false,
    "acib_personal": false
  },
  
  "channels": {
    "telegram": {
      "enabled": true,
      "botToken": "8558193763:AAExVtcUT8OHZUm4HZs5xU8eRkqjf2gME5w",
      "allowFrom": [
        "5512988013359"
      ],
      "dmPolicy": "allowlist"
    }
  }
}
```

---

## 📂 **ESTRUTURA DE ARQUIVOS**

```
/root/.openclaw/workspace/bots/viviane-bot/
├── config.json          # Configuração do bot
├── README.md            # Este arquivo
├── workspace/           # Workspace dedicado
│   ├── memory/          # Memórias compartilhadas (link)
│   └── projects/        # Projetos (link)
└── logs/                # Logs do bot
```

---

## 🚀 **COMO INSTALAR/RODAR**

### **Opção 1: Usar OpenClaw Existente (Recomendado)**

O bot usa a instalação global do OpenClaw:

```bash
# Iniciar gateway na porta do bot (18790)
openclaw gateway start --port 18790

# Ou usar configuração customizada
OPENCLAW_CONFIG=/root/.openclaw/workspace/bots/viviane-bot/config.json \
  openclaw gateway start
```

### **Opção 2: Container Dedicado (Futuro)**

Pode rodar em um container separado (CT 113, por exemplo):
- Isolado do CT 100 (Stark principal)
- Configuração independente
- Mais privacidade

---

## 📞 **SUPORTE**

**Dúvidas ou problemas:**
- Falar com Stark principal: @acib_abbade_bot
- Ou pedir ajuda para o Acib

---

## 📝 **HISTÓRICO**

| Data | Ação | Status |
|------|------|--------|
| 2026-05-05 | Criação do bot | ✅ Token configurado |
| 2026-05-05 | Configuração | ✅ Completa |
| 2026-05-05 | Mensagem de teste | ⚠️ Aguardando Viviane iniciar |

---

## ⚠️ **IMPORTANTE**

**Viviane precisa iniciar o bot primeiro!**

O Telegram não permite que bots enviem mensagem para usuários que nunca interagiram com o bot.

**Ela deve:**
1. Buscar `@stark_familia_bot` no Telegram
2. Clicar em "INICIAR"
3. Mandar um "Oi"

**Depois disso:** ✅ O bot pode responder sempre!

---

## 🎉 **BEM-VINDA VIVIANE!**

**Bot:** @stark_familia_bot  
**Criado por:** Acib ABBADE  
**Configurado por:** Stark 🤖  
**Data:** 2026-05-05

---

**Pronto para uso!** ✅
