#!/bin/bash
# BACKUP E DEPLOY - Site 4PETS
# Executar no PVE1 (Proxmox) antes de subir nova versão

# === CONFIGURAÇÕES ===
CT_ID="107"
SITE_DIR="/var/www/amigos4patas"
BACKUP_DIR="/root/backups-4pets"
DATA_BACKUP="/home/master/LAN/Acib/projetos/4pets/backups"

# === CRIAR DIRETÓRIOS DE BACKUP ===
echo "📁 Criando diretórios de backup..."
pct exec $CT_ID -- mkdir -p $BACKUP_DIR
mkdir -p $DATA_BACKUP

# === DATA E HORA ===
TIMESTAMP=$(date +"%Y-%m-%d_%H-%M-%S")

# === BACKUP INDEX.HTML ATUAL ===
echo "💾 Fazendo backup do index.html atual..."
pct exec $CT_ID -- cp $SITE_DIR/index.html $BACKUP_DIR/index-backup-$TIMESTAMP.html

# === BACKUP DE TODAS AS PÁGINAS ===
echo "💾 Fazendo backup completo do site..."
pct exec $CT_ID -- bash -c "cd $SITE_DIR && tar -czf $BACKUP_DIR/site-completo-backup-$TIMESTAMP.tar.gz ."

# === COPIAR BACKUP PARA DATASVR ===
echo "📤 Copiando backup para ARCA..."
pct exec $CT_ID -- cat $BACKUP_DIR/index-backup-$TIMESTAMP.html > $DATA_BACKUP/index-backup-$TIMESTAMP.html

# === LISTAR BACKUPS ===
echo ""
echo "✅ BACKUP CONCLUÍDO!"
echo ""
echo "📂 Backups criados:"
pct exec $CT_ID -- ls -lh $BACKUP_DIR/ | grep $TIMESTAMP
echo ""
echo "📂 Backup na ARCA:"
ls -lh $DATA_BACKUP/index-backup-$TIMESTAMP.html
echo ""
echo "🕐 Timestamp: $TIMESTAMP"
echo ""
echo "⚠️  Pronto para deploy da nova versão!"
echo "   Execute: pct push 107 /caminho/novo/index.html /var/www/amigos4patas/index.html"
