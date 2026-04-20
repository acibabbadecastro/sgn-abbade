# 📊 Sistema de Monitoramento Automático - Stark

## ✅ Criado em: 2026-04-20 18:53

---

## 🖥️ Monitor de Espaço em Disco

### Script
**Local:** `/root/.openclaw/workspace/scripts/monitor-disco.sh`

### O que monitora:
1. **Workspace** (`/root/.openclaw/workspace`)
2. **Logs** (`/var/log` e journal)
3. **DATASVR** (`192.168.0.72:/mnt/data`)

### Thresholds:
| Nível | Porcentagem | Ação |
|-------|-------------|------|
| ✅ Normal | < 85% | Apenas log |
| 🟠 Alerta | 85-94% | Notifica Acib |
| 🔴 Crítico | ≥ 95% | **Limpeza automática** + Notificação |

### Ação Automática (Crítico):
```bash
journalctl --vacuum-size=200M
```
Libera ~2GB automaticamente quando atinge 95%.

### Cron Job:
- **Frequência:** A cada 4 horas
- **Job ID:** `f66d207e-6544-4c1a-a613-7302b0bf4b81`
- **Notificação:** Telegram (@Acib_Abbade)

---

## 🧠 Monitor de Contexto

### Status Atual:
- **Limite:** 262k tokens
- **Alerta:** 80% (210k tokens)
- **Crítico:** 95% (249k tokens)

### Verificação:
```bash
/session_status
```

### Quando alerta:
- **80%+:** Considerar iniciar nova sessão
- **95%+:** Sugerir `/new` urgente

---

## 📋 Comandos Úteis

### Verificar espaço manualmente:
```bash
/root/.openclaw/workspace/scripts/monitor-disco.sh
```

### Verificar contexto:
```bash
/session_status
```

### Verificar cron jobs:
```bash
openclaw cron list
```

### Limpar journal manualmente:
```bash
journalctl --vacuum-size=200M
```

---

## 🔧 Configuração de Alertas

### Espaço em Disco:
- **Script:** `monitor-disco.sh`
- **Threshold Alerta:** 85%
- **Threshold Crítico:** 95%
- **Ação Auto:** Vacuum do journal

### Contexto:
- **Monitor:** Via `/session_status`
- **Threshold Alerta:** 80%
- **Threshold Crítico:** 95%
- **Ação:** Sugerir nova sessão

---

## 📊 Status Atual (2026-04-20 18:53)

| Recurso | Uso | Status |
|---------|-----|--------|
| **Workspace** | 52% (55G livre) | ✅ |
| **Journal** | 2.5G | ⚠️ (pode limpar) |
| **DATASVR** | 1% (432G livre) | ✅ |
| **Contexto** | 21% (56k/262k) | ✅ |

---

## 🎯 Próximos Passos (Opcionais)

1. **Adicionar monitoramento de Thin Pool** (requer acesso ao host PVE1)
2. **Alertas de saúde de disco** (smartctl no host)
3. **Backup automático** antes de limpezas críticas

---

*Documento atualizado automaticamente pelo Stark*
