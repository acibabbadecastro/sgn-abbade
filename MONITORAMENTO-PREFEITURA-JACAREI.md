# 📧 MONITORAMENTO DE EMAILS - PREFEITURA DE JACAREÍ

**Criado:** 07/05/2026  
**Solicitante:** Acib ABBADE  
**Status:** ⏳ Aguardando configuração de email  

---

## 🎯 OBJETIVO

Monitorar emails recebidos da **Prefeitura Municipal de Jacareí** para identificar:
- ✅ Compras Diretas
- ✅ Licitações
- ✅ Cotações
- ✅ Pregões
- ✅ Solicitações de Serviços
- ✅ Dispensas de Licitação
- ✅ Convites

---

## 📋 CONFIGURAÇÃO NECESSÁRIA

### **Opção 1: Configurar Senha do Gmail**

**Arquivo:** `~/.gmail-imap-pass`

**Conteúdo:**
```
SUA_SENHA_AQUI
```

**Comando para criar:**
```bash
echo "sua.senha@gmail.com" > ~/.gmail-imap-pass
chmod 600 ~/.gmail-imap-pass
```

### **Opção 2: Usar App Password (Recomendado)**

Se você tem 2FA no Gmail:
1. Acesse: https://myaccount.google.com/apppasswords
2. Gere senha para "Mail"
3. Use essa senha no arquivo

---

## 🔍 PALAVRAS-CHAVE DE FILTRO

**Emails da Prefeitura:**
- `@jacarei.sp.gov.br`
- `prefeitura.jacarei`

**Assuntos Importantes:**
- "Compra Direta"
- "Licitação"
- "Cotação"
- "Pregão"
- "Dispensa"
- "Convite"
- "Solicitação de Serviços"
- "Cotação de Preços"
- "Tomada de Preços"

---

## 📊 FLUXO DE MONITORAMENTO

```
1. Verificar emails (a cada 30 minutos)
2. Filtrar por remetente (Prefeitura)
3. Buscar palavras-chave no assunto
4. Classificar por prioridade:
   - 🔴 URGENTE: Compra Direta, Licitação Hoje
   - 🟡 ALTA: Pregão, Cotação (próximos dias)
   - 🟢 MÉDIA: Convite, Solicitação (semana)
5. Notificar Acib no Telegram
6. Salvar em memória
7. Aguardar confirmação
```

---

## 📱 NOTIFICAÇÃO NO TELEGRAM

**Modelo de Mensagem:**
```
🔴 OPORTUNIDADE COMERCIAL - PREFEITURA JACAREÍ

📧 De: [remetente]
📅 Data: [data]
📋 Assunto: [assunto]

🎯 TIPO: [Compra Direta/Licitação/Pregão]
⏰ PRAZO: [data/hora limite]
💰 VALOR: [se informado]

📝 RESUMO:
[Descrição breve]

🔗 AÇÕES:
[1] ✅ Ver email completo
[2] 📞 Ligar para contato
[3] 💬 Preparar proposta
[4] ❌ Arquivar (não interessa)

Aguardo confirmação!
```

---

## 💾 ARMAZENAMENTO

**Local:** `/root/.openclaw/workspace/memory/prefeitura-jacarei/`

**Arquivos:**
- `emails-recebidos.md` - Histórico completo
- `oportunidadesativas.md` - Oportunidades em aberto
- `propostas-enviadas.md` - Propostas já enviadas
- `estatisticas.json` - Métricas (ganhos, taxa de sucesso)

---

## ⏰ FREQUÊNCIA DE VERIFICAÇÃO

| Horário | Ação |
|---------|------|
| 08:00 | Verificar emails do dia |
| 10:00 | Verificar novas oportunidades |
| 12:00 | Verificação de almoço |
| 14:00 | Verificação da tarde |
| 16:00 | Última verificação útil |
| 18:00 | Fechamento do dia |

**Total:** 6 verificações/dia

---

## 📊 ESTATÍSTICAS (APÓS IMPLEMENTAÇÃO)

| Métrica | Valor |
|---------|-------|
| Emails Recebidos | 0 |
| Oportunidades Identificadas | 0 |
| Propostas Enviadas | 0 |
| Negócios Fechados | 0 |
| Valor Total Ganho | R$ 0 |

---

## 🚀 PRÓXIMOS PASSOS

1. ⏳ **Acib configura senha do Gmail**
2. ⏳ **Testar acesso aos emails**
3. ⏳ **Configurar cron de verificação**
4. ⏳ **Iniciar monitoramento automático**

---

**Status:** ⏳ **Aguardando configuração de email**

*Stark - CT 100 | 07/05/2026 09:55*
