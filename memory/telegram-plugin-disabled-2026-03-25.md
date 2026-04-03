# 📚 Aprendizado: Plugin Telegram Desativado

**Data:** 25/03/2026  
**Autor:** Stark 🤖  
**Categoria:** Configuração / Troubleshooting  
**Severidade:** 🔴 Crítico (impede funcionamento do canal)

---

## 🎯 **Problema**

O bot do Telegram **não respondia** às mensagens do usuário, mesmo com:

- ✅ Gateway rodando
- ✅ Bot token configurado e válido
- ✅ Configurações do canal corretas (dmPolicy, allowFrom, etc.)
- ✅ Mensagens chegando via API (getUpdates)

---

## 🔍 **Sintomas**

| Sintoma | Observação |
|---------|------------|
| Bot não respondia | Usuário enviava mensagens, sem resposta |
| Updates pendentes | `pending_update_count` aumentava (2 → 3 → ...) |
| Canal vazio no status | `openclaw status` mostrava tabela vazia em "Channels" |
| Envio via API funcionava | `sendMessage` funcionava normalmente |
| Gateway rodando | Processo ativo, porta 18789 ocupada |

---

## 🕵️ **Diagnóstico**

### **Comandos Executados:**

```bash
# 1. Verificar status do gateway
openclaw status --deep
# Resultado: Channels vazio (nenhum canal listado)

# 2. Verificar plugins
openclaw plugins list
# Resultado: telegram = disabled ❌

# 3. Verificar updates pendentes
curl https://api.telegram.org/bot<TOKEN>/getUpdates
# Resultado: 3 updates pendentes (não processados)

# 4. Verificar configuração
openclaw config get channels.telegram
# Resultado: Configuração correta ✅
```

### **Descoberta Chave:**

```
│ Telegram │ telegram │ openclaw │ disabled │ stock:telegram/index.js │
```

O **plugin do Telegram estava desativado** (`disabled`), mesmo com o canal configurado em `channels.telegram.enabled: true`.

---

## 🧠 **Causa Raiz**

**Problema:** O plugin `@openclaw/telegram` estava em estado `disabled` no registro de plugins.

**Por que aconteceu:**
1. Instalação inicial do OpenClaw não habilita plugins automaticamente
2. Configuração do canal (`channels.telegram.enabled: true`) ≠ Plugin habilitado
3. O gateway carrega apenas plugins com estado `loaded`

**Diferença crítica:**

| Configuração | Plugin |
|--------------|--------|
| `channels.telegram.enabled: true` | `openclaw plugins enable telegram` |
| Habilita o **canal** | Habilita o **plugin** |
| Necessário, mas não suficiente | **Obrigatório** para funcionar |

---

## ✅ **Solução**

### **Comando Corretivo:**

```bash
# 1. Habilitar o plugin
openclaw plugins enable telegram

# 2. Reiniciar o gateway
killall -9 openclaw-gateway
openclaw gateway

# 3. Verificar status
openclaw plugins list | grep telegram
# Deve mostrar: loaded ✅

openclaw status | grep -A5 "Channels"
# Deve mostrar: Telegram │ ON │ OK
```

### **Verificação:**

```bash
# Updates pendentes devem zerar
curl https://api.telegram.org/bot<TOKEN>/getUpdates
# pending_update_count: 0 ✅

# Canal deve aparecer no status
openclaw status --deep
# Channels: Telegram │ ON │ OK ✅
```

---

## 📋 **Lição Aprendida**

### **Para Configurar Telegram Corretamente:**

1. **Configurar canal:**
   ```bash
   openclaw config set channels.telegram.enabled true
   openclaw config set channels.telegram.botToken "<TOKEN>"
   openclaw config set channels.telegram.dmPolicy "pairing"
   openclaw config set channels.telegram.allowFrom '["<USER_ID>"]'
   ```

2. **Habilitar plugin (CRUCIAL):**
   ```bash
   openclaw plugins enable telegram
   ```

3. **Reiniciar gateway:**
   ```bash
   killall -9 openclaw-gateway
   openclaw gateway
   ```

4. **Verificar:**
   ```bash
   openclaw plugins list | grep telegram  # Deve ser: loaded
   openclaw status | grep -A5 Channels   # Deve ser: ON / OK
   ```

---

## ⚠️ **Armadilhas Comuns**

| Erro | Sintoma | Solução |
|------|---------|---------|
| Plugin disabled | Bot não responde | `openclaw plugins enable telegram` |
| Gateway não restartado | Config não aplica | `killall -9 openclaw-gateway` |
| allowFrom vazio | Mensagens descartadas | Adicionar ID do usuário |
| dmPolicy "open" sem "*" | Erro de validação | Usar pairing ou `["*"]` |

---

## 🔧 **Comandos de Diagnóstico Rápido**

```bash
# 1. Plugin está habilitado?
openclaw plugins list | grep telegram
# Esperado: loaded

# 2. Canal está ativo?
openclaw status | grep -A5 "Channels"
# Esperado: Telegram │ ON │ OK

# 3. Updates sendo processados?
curl https://api.telegram.org/bot<TOKEN>/getUpdates?offset=0&timeout=1
# Esperado: pending_update_count: 0

# 4. Gateway rodando?
ps aux | grep openclaw-gateway
# Esperado: 1 processo ativo
```

---

## 📝 **Checklist para Futuras Configurações**

- [ ] Plugin habilitado (`openclaw plugins enable <canal>`)
- [ ] Canal configurado (`channels.<canal>.enabled: true`)
- [ ] Gateway reiniciado após mudanças
- [ ] Status mostra canal como `ON / OK`
- [ ] Updates pendentes = 0
- [ ] Bot responde a `/start` ou `oi`

---

## 🎓 **Conceitos Chave**

| Conceito | Explicação |
|----------|------------|
| **Plugin** | Código que implementa o canal (ex: telegram.js) |
| **Canal** | Configuração que define comportamento (ex: dmPolicy) |
| **Gateway** | Processo que roda os plugins e canais |
| **Long Polling** | Método do Telegram para receber mensagens |
| **Pairing** | Código de segurança para autorizar usuários |

---

## 💡 **Dica Pro**

Sempre verifique **plugins** antes de **configurações**:

```bash
# Ordem correta de troubleshooting:
openclaw plugins list          # 1. Plugin está loaded?
openclaw status --deep         # 2. Canal aparece em Channels?
openclaw config get channels   # 3. Configuração está correta?
curl .../getUpdates            # 4. Updates sendo processados?
```

---

## 📚 **Referências**

- OpenClaw Docs: `https://docs.openclaw.ai/channels/telegram`
- Telegram Bot API: `https://core.telegram.org/bots/api`
- ClawHub Skills: `https://clawhub.com`

---

*Stark 🤖 - Documento criado para aprendizado persistente*  
*Última atualização: 25/03/2026 03:24 UTC*
