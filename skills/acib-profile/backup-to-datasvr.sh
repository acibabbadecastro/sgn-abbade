#!/bin/bash
# Backup obrigatório para DATASVR:/home/master/LAN/MEMORIES/STARK/
# REGRA CRÍTICA: Sempre executar após mudanças importantes

DATASVR_IP="192.168.0.72"
DATASVR_USER="root"
DATASVR_PASS="Rcmp@814k$1982"
DATASVR_BASE="/home/master/LAN/MEMORIES/STARK"
TIMESTAMP=$(date +%Y-%m-%d_%H-%M)

# Verifica conexão com DATASVR
sshpass -p "$DATASVR_PASS" ssh -o StrictHostKeyChecking=no "$DATASVR_USER@$DATASVR_IP" "echo 'DATASVR online'" >/dev/null 2>&1

if [ $? -ne 0 ]; then
    echo "[ERRO] Não foi possível conectar ao DATASVR"
    exit 1
fi

# Cria estrutura de pastas se não existir
sshpass -p "$DATASVR_PASS" ssh -o StrictHostKeyChecking=no "$DATASVR_USER@$DATASVR_IP" "mkdir -p $DATASVR_BASE/{Profile,Skills,Projects,Backups,Logs}"

# 1. Backup do Perfil
if [ -f "/home/master/LAN/MEMORIES/STARK-KNOWLEDGE/PERFIL_ACIB.md" ]; then
    sshpass -p "$DATASVR_PASS" scp -o StrictHostKeyChecking=no "/home/master/LAN/MEMORIES/STARK-KNOWLEDGE/PERFIL_ACIB.md" "$DATASVR_USER@$DATASVR_IP:$DATASVR_BASE/Profile/PERFIL_ACIB.md"
    sshpass -p "$DATASVR_PASS" scp -o StrictHostKeyChecking=no "/home/master/LAN/MEMORIES/STARK-KNOWLEDGE/PERFIL_ACIB.md" "$DATASVR_USER@$DATASVR_IP:$DATASVR_BASE/Profile/PERFIL_ACIB_$TIMESTAMP.md"
    echo "[OK] Perfil backupado em $DATASVR_BASE/Profile/"
fi

# 2. Backup das Skills
if [ -d "/home/master/LAN/MEMORIES/STARK-KNOWLEDGE/" ]; then
    sshpass -p "$DATASVR_PASS" scp -r -o StrictHostKeyChecking=no "/home/master/LAN/MEMORIES/STARK-KNOWLEDGE/"* "$DATASVR_USER@$DATASVR_IP:$DATASVR_BASE/"
    echo "[OK] Stark-Knowledge backupado em $DATASVR_BASE/"
fi

# 3. Backup dos Projetos
if [ -d "/home/master/LAN/MEMORIES/STARK-KNOWLEDGE/PROJECTS/" ]; then
    sshpass -p "$DATASVR_PASS" scp -r -o StrictHostKeyChecking=no "/home/master/LAN/MEMORIES/STARK-KNOWLEDGE/PROJECTS/" "$DATASVR_USER@$DATASVR_IP:$DATASVR_BASE/Projects/"
    echo "[OK] Projetos backupados em $DATASVR_BASE/Projects/"
fi

# 4. Log da operação
sshpass -p "$DATASVR_PASS" ssh -o StrictHostKeyChecking=no "$DATASVR_USER@$DATASVR_IP" "echo '$TIMESTAMP - Backup completo realizado' >> $DATASVR_BASE/Logs/backup.log"

echo "=========================================="
echo "[SUCESSO] Backup concluído em $TIMESTAMP"
echo "Local: DATASVR:$DATASVR_BASE"
echo "=========================================="
