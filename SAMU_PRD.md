# PRD - SAMU (Stark Automated Monitoring Unit)

**Versão:** 1.0
**Data:** 2026-04-03
**Autor:** Acib ABBADE
**Agente Responsável:** SAMU (CT 107)

---

## 1. Objetivo

SAMU é o agente responsável por **monitorar a disponibilidade do Stark** e garantir que ele volte a funcionar em caso de falha.

---

## 2. Escopo

### 2.1 Verificação
- Checar a cada **10 minutos** se Stark está online
- Verificar: gateway status, SSH, processo openclaw
- Log de todas as verificações

### 2.2 Restauração Automática
Se Stark ficar offline:
1. Tentar reiniciar o serviço do Stark
2. Verificar causa da falha
3. Documentar em logs

---

## 3. Cenários de Falha

### CENÁRIO 1: SAMU consegue corrigir

**Ação:** SAMU reinicia Stark automaticamente

**Email enviado (via MailBot):**
- **Para:** acib@outlook.com
- **Tema:** "Falha no Stark Corrigida"
- **Conteúdo:**
  - Horário que Stark ficou offline
  - Tempo que ficou offline
  - Motivos (verificar logs)
  - Ação tomada para reativar

---

### CENÁRIO 2: SAMU NÃO consegue resolver

**Ação:** Alerta crítico para o usuário

**Email enviado (via MailBot):**
- **Para:** acib@outlook.com
- **Tema:** "Alerta Crítico - Stark Offline"
- **Conteúdo:**
  - Horário da falha
  - Motivos aparentes
  - Últimas interações do Stark com outros agentes
  - Alterações em portas, configurações
  - Status dos outros agentes (DATASVR, MailBot, etc.)

---

## 4. Requisitos Técnicos

### 4.1 Verificação de Status
```bash
# Verificar se gateway está rodando
openclaw gateway status

# Verificar processo
ps aux | grep openclaw

# Testar SSH
ssh root@192.168.0.192 "echo 'ok'"
```

### 4.2 Ação de Reinício
```bash
# Reiniciar gateway do Stark
ssh root@192.168.0.192 "systemctl --user restart openclaw-gateway"

# Ou iniciar manualmente
ssh root@192.168.0.192 "openclaw launch --model ollama/minimax-m2.7:cloud"
```

### 4.3 Logs a Verificar
- `/tmp/openclaw/openclaw-*.log`
- `journalctl --user -u openclaw-gateway.service`

---

## 5. Fluxo de Execução

```
A cada 10 minutos:
  1. SAMU verifica: Stark está online?
     ├─ SIM → Loga "Stark OK" e encerra
     └─ NÃO → Continua
  
  2. SAMU tenta reiniciar Stark
     ├─ Consegue → Envia email "Falha Corrigida"
     └─ Não consegue → Envia email "Alerta Crítico"
```

---

## 6. Contato

- **Destinatário Email:** acib@outlook.com
- **Originador:** MailBot (CT 101) - acibabbadecastro@gmail.com

---

## 7. Status

- [x] Especificação criada
- [ ] Implementação do script de verificação
- [ ] Configuração do cron (a cada 10 min)
- [ ] Teste do sistema
- [ ] Validação com usuário

---

## 8. Notas

- SAMU é um agente simples, só faz verificação e alerta
- Stark usa modelo: `ollama/minimax-m2.7:cloud`
- IP do Stark: 192.168.0.192
- IP do MailBot: 192.168.0.240
