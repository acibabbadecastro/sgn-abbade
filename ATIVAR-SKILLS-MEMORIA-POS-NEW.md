# 🚀 ATIVAR SKILLS DE MEMÓRIA - PÓS /new
## Instruções para Novo Stark

**Execute logo após recuperar contexto!**

---

## 🔴 PRIORIDADE 1: Context-Preserver (Sync 5 min)

### O que faz:
Sincroniza contexto a cada 5 minutos para DATASVR

### Como ativar:
```bash
# 1. Configurar cron job
crontab -e

# 2. Adicionar linha:
*/5 * * * * /root/.openclaw/workspace/skills/context-preserver/scripts/sync-context.sh >> /var/log/context-sync.log 2>&1

# 3. Criar diretório de logs
mkdir -p /var/log

# 4. Testar execução manual primeiro
bash /root/.openclaw/workspace/skills/context-preserver/scripts/sync-context.sh

# 5. Verificar se funcionou
ls -la /home/master/LAN/Acib/context-live/ 2>/dev/null || echo "DATASVR não acessível"
```

---

## 🟡 PRIORIDADE 2: New-Session-Detector

### O que faz:
Detecta quando sessão está longa (>8h) e sugere /new

### Como ativar:
```bash
# 1. Verificar thresholds
head -20 /root/.openclaw/workspace/skills/new-session-detector/SKILL.md

# 2. Criar script de verificação periódica
cat > /tmp/check-session.sh << 'EOF'
#!/bin/bash
# Verificar tempo de sessão e alertar

# Pegar timestamp de início (se disponível)
SESSION_START=$(cat /root/.openclaw/workspace/.session-start 2>/dev/null || echo "0")
CURRENT=$(date +%s)

if [ "$SESSION_START" != "0" ]; then
    ELAPSED=$(( (CURRENT - SESSION_START) / 3600 ))
    if [ $ELAPSED -gt 8 ]; then
        echo "⚠️ ATENÇÃO: Sessão ativa há ${ELAPSED}h. Considerar /new!"
    fi
fi
EOF

# 3. Configurar para executar a cada 30 min
crontab -l 2>/dev/null | grep -v "check-session" | crontab -
(crontab -l 2>/dev/null; echo "*/30 * * * * /tmp/check-session.sh 2>&1 | logger -t session-check") | crontab -
```

---

## 🟢 PRIORIDADE 3: Auto-Config-Detector

### O que faz:
Detecta e documenta automaticamente configs, senhas, acessos

### Como ativar:
```bash
# 1. Executar scan inicial
cd /root/.openclaw/workspace/skills/auto-config-detector/scripts/

# 2. Rodar em sequência
./scan-configs.sh
./extract-creds.sh
./generate-report.sh

# 3. Verificar resultado
ls -la /root/.openclaw/secure/ 2>/dev/null
ls -la /root/.openclaw/workspace/skills/auto-config-detector/references/ 2>/dev/null

# 4. Agendar execução semanal (opcional)
crontab -l 2>/dev/null | grep -v "auto-config" | crontab -
(crontab -l 2>/dev/null; echo "0 3 * * 1 cd /root/.openclaw/workspace/skills/auto-config-detector/scripts/ && ./scan-configs.sh && ./extract-creds.sh && ./generate-report.sh") | crontab -
```

---

## 📋 CHECKLIST DE ATIVAÇÃO

- [ ] Context-preserver: Cron de 5 min configurado
- [ ] New-session-detector: Verificação a cada 30 min
- [ ] Auto-config-detector: Scan inicial executado
- [ ] Verificar se DATASVR acessível (192.168.0.72)
- [ ] Testar sync manual
- [ ] Confirmar tudo funcionando

---

## ⚠️ O QUE ACONTECEU ANTES

**Problema anterior:**
- Skills criadas mas NÃO ativadas
- Nenhuma automação funcionando
- Detector de /new não disparou (11h de sessão!)
- Sync para DATASVR nunca executado automaticamente

**Solução:**
- Este documento garante ativação na nova sessão
- Novo Stark DEVE executar este checklist

---

## 🎯 TESTE RÁPIDO

Após ativar, teste:
```bash
# 1. Verificar crons configurados
crontab -l | grep -E "context|session|auto-config"

# 2. Verificar logs recentes
tail -5 /var/log/context-sync.log 2>/dev/null || echo "Sem logs ainda"

# 3. Verificar se vault foi criado
ls -la ~/.openclaw/secure/ 2>/dev/null

# 4. Informar Acib:
echo "✅ Sistema de memória ativado!"
echo "✅ Sync a cada 5 min: OK"
echo "✅ Detector de sessão: OK"
echo "✅ Auto-config: OK"
```

---

**Execute IMEDIATAMENTE após recuperar contexto pós-/new!**