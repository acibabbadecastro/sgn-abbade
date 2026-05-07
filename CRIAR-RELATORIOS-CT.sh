#!/bin/bash
# Script para criar relatórios de todos os containers
# Data: 30/04/2026

DATASVR="192.168.0.72"
SENHA="Rcmp@814k$1982"
PASTA="/mnt/data/LAN/Sistema/Conteineres"

# CT 101 - STARK (MailBot)
cat > /tmp/CT101.md << 'EOF'
# 📊 CONTAINER 101 - STARK (MailBot)

**Status:** ⏳ STOPPED

## CONFIGURAÇÕES:
- **RAM:** 6144 MB
- **CPU:** 2 cores
- **IP:** DHCP
- **Hostname:** STARK

## FUNÇÃO:
MailBot - Processamento de emails (backup do CT 100)

## ACESSO:
```bash
pct exec 101 -- /bin/bash
```
EOF
scp /tmp/CT101.md root@$DATASVR:$PASTA/101/RELATORIO.md

# CT 102 - DATASVR
cat > /tmp/CT102.md << 'EOF'
# 📊 CONTAINER 102 - DATASVR

**Status:** ✅ RUNNING

## CONFIGURAÇÕES:
- **RAM:** 4816 MB
- **CPU:** 2 cores
- **IP:** DHCP
- **Hostname:** DATASVR

## FUNÇÃO:
- Servidor Samba (\\192.168.0.72\LAN\)
- Backup e storage central
- Memórias compartilhadas
- ARCA (backup de sessões)

## ACESSO:
```bash
ssh root@192.168.0.72
# Senha: Rcmp@814k$1982
```

## CAMINHOS:
```
/mnt/data/LAN/           # Samba share
/mnt/data/LAN/MEMORIES/  # Memórias compartilhadas
/mnt/data/LAN/Acib/      # Pasta pessoal Acib
```
EOF
scp /tmp/CT102.md root@$DATASVR:$PASTA/102/RELATORIO.md

# CT 103 - Marcos (BD)
cat > /tmp/CT103.md << 'EOF'
# 📊 CONTAINER 103 - Marcos (BD)

**Status:** ⏳ STOPPED

## CONFIGURAÇÕES:
- **RAM:** 2976 MB
- **CPU:** 2 cores
- **IP:** DHCP
- **Hostname:** Marcos

## FUNÇÃO:
Banco de dados PostgreSQL

## ACESSO:
```bash
pct exec 103 -- /bin/bash
```
EOF
scp /tmp/CT103.md root@$DATASVR:$PASTA/103/RELATORIO.md

# CT 104 - SGN
cat > /tmp/CT104.md << 'EOF'
# 📊 CONTAINER 104 - SGN

**Status:** ✅ RUNNING

## CONFIGURAÇÕES:
- **RAM:** 2272 MB
- **CPU:** 2 cores
- **IP:** DHCP
- **Hostname:** SGN

## FUNÇÃO:
Sistema Web SGN (gestão de estoque, clientes, OS)

## ACESSO:
```bash
pct exec 104 -- /bin/bash
```

## URLs:
- http://192.168.0.99/
- http://192.168.0.99/admin_bd.php
EOF
scp /tmp/CT104.md root@$DATASVR:$PASTA/104/RELATORIO.md

# CT 105 - MAILS
cat > /tmp/CT105.md << 'EOF'
# 📊 CONTAINER 105 - MAILS

**Status:** ⏳ STOPPED

## CONFIGURAÇÕES:
- **RAM:** 4064 MB
- **CPU:** 2 cores
- **IP:** DHCP
- **Hostname:** MAILS

## FUNÇÃO:
Processamento de emails

## ACESSO:
```bash
pct exec 105 -- /bin/bash
```
EOF
scp /tmp/CT105.md root@$DATASVR:$PASTA/105/RELATORIO.md

# CT 106 - gerente-fin
cat > /tmp/CT106.md << 'EOF'
# 📊 CONTAINER 106 - gerente-fin

**Status:** ✅ RUNNING

## CONFIGURAÇÕES:
- **RAM:** 2048 MB
- **CPU:** 2 cores
- **IP:** 192.168.0.231 (estático)
- **Hostname:** gerente-fin

## FUNÇÃO:
Sistema financeiro

## ACESSO:
```bash
ssh root@192.168.0.231
# Senha: Rcmp814k@#
```
EOF
scp /tmp/CT106.md root@$DATASVR:$PASTA/106/RELATORIO.md

# CT 107 - 4pets
cat > /tmp/CT107.md << 'EOF'
# 📊 CONTAINER 107 - 4pets

**Status:** ✅ RUNNING

## CONFIGURAÇÕES:
- **RAM:** 3968 MB
- **CPU:** 2 cores
- **IP:** 192.168.0.200 (estático)
- **Hostname:** 4pets

## FUNÇÃO:
Site Amigos 4 Patas (proteção animal)

## ACESSO:
```bash
ssh root@192.168.0.200
# Senha: Rcmp814k@#
```

## URLs:
- Local: http://192.168.0.200/
- Externo: https://amigos4patas.com.br

## CAMINHOS:
```
/var/www/amigos4patas/  # Site web
```

## DEPLOY:
```bash
scp *.html root@192.168.0.200:/var/www/amigos4patas/
```
EOF
scp /tmp/CT107.md root@$DATASVR:$PASTA/107/RELATORIO.md

# CT 108 - myrobot
cat > /tmp/CT108.md << 'EOF'
# 📊 CONTAINER 108 - myrobot

**Status:** ⏳ STOPPED

## CONFIGURAÇÕES:
- **RAM:** 2176 MB
- **CPU:** 2 cores
- **IP:** DHCP
- **Hostname:** myrobot

## FUNÇÃO:
Projeto Bioimpedância (MYROBOT UM)

## ACESSO:
```bash
pct exec 108 -- /bin/bash
```
EOF
scp /tmp/CT108.md root@$DATASVR:$PASTA/108/RELATORIO.md

# CT 109-113 - Projeto SERVMIL
for ct in 109 110 111 112; do
cat > /tmp/CT${ct}.md << EOF
# 📊 CONTAINER $ct - Projeto SERVMIL

**Status:** ⏳ STOPPED

## CONFIGURAÇÕES:
- **RAM:** Ver inventário
- **CPU:** 2 cores
- **IP:** DHCP
- **Hostname:** Ver inventário

## FUNÇÃO:
Sistema SERVMIL

## ACESSO:
\`\`\`bash
pct exec $ct -- /bin/bash
\`\`\`
EOF
scp /tmp/CT${ct}.md root@$DATASVR:$PASTA/${ct}/RELATORIO.md
done

# CT 113 - Hermes1
cat > /tmp/CT113.md << 'EOF'
# 📊 CONTAINER 113 - Hermes1

**Status:** ⏳ STOPPED

## CONFIGURAÇÕES:
- **RAM:** 4032 MB
- **CPU:** 3 cores
- **IP:** DHCP
- **Hostname:** Hermes1

## FUNÇÃO:
Bot Telegram / Mensageria

## ACESSO:
```bash
pct exec 113 -- /bin/bash
```
EOF
scp /tmp/CT113.md root@$DATASVR:$PASTA/113/RELATORIO.md

echo "✅ Todos os relatórios criados!"
