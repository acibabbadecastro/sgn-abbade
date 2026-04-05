# STARK - Comandos de Recuperação

## Como Acordar o Stark

Quando o Stark ficar offline, siga esta ordem:

### 1. Verificar se o CT está rodando
```bash
ssh root@192.168.0.192 "pct status 100"
```

### 2. Se CT estiver parado, iniciar:
```bash
ssh root@192.168.0.192 "pct start 100"
```

### 3. Verificar se o Gateway está rodando
```bash
ssh root@192.168.0.192 "pct exec 100 -- systemctl --user status openclaw-gateway"
```

### 4. Se Gateway parado, iniciar:
```bash
ssh root@192.168.0.192 "pct exec 100 -- systemctl --user start openclaw-gateway"
```

### 5. Se Stark "dormindo" (sem resposta), acordar com:
```bash
ollama launch openclaw --model ollama/minimax-m2.7:cloud
```

---

## Fluxo de Recuperação

```
CT Parado?
    ↓ SIM → pct start 100
    ↓
Gateway Parado?
    ↓ SIM → systemctl --user start openclaw-gateway
    ↓
Stark sem resposta?
    ↓ SIM → ollama launch openclaw --model ollama/minimax-m2.7:cloud
    ↓
Ainda com problemas?
    ↓ SIM → Verificar logs: journalctl --user -u openclaw-gateway.service
```

---

## Comandos Úteis

### Verificar status do Stark
```bash
openclaw gateway status
```

### Verificar processos
```bash
ps aux | grep openclaw
```

### Ver logs
```bash
tail -f /tmp/openclaw/openclaw-$(date +%Y-%m-%d).log
```

### Reiniciar gateway
```bash
systemctl --user restart openclaw-gateway
```

---

## IPs dos Serviços

| Serviço | IP |
|---------|-----|
| Stark (CT 100) | 192.168.0.192 |
| pve1 (Host) | 192.168.0.192 |
| MailBot | 192.168.0.240 |
| Supervisor | 192.168.0.42 |
| SAMU | 192.168.0.64 |

---

## SAMU e Supervisor

### SAMU (CT 107)
- Verifica Stark a cada 10 minutos
- Se detectar offline → tenta restartar automaticamente
- Envia alerta via Telegram

### Supervisor (CT 103)
- Verifica todos os agentes a cada 60 segundos
- Se detectar problema → tenta startar o CT
- Se Stark offline → notifica SAMU

---

## Prevenção

- CT 100 configurado com `onboot: 1` (inicia automático)
- Gateway com `enabled` no systemd
- SAMU e Supervisor rodando 24/7

---

*Última atualização: 2026-04-03 20:51 (Brasília)*
