# 🖥️ CONFIGURAÇÃO COMPLETA - CT MYROBOT-WEB

**Container:** MYROBOT-WEB (Servidor Web do Projeto MYROBOT)  
**Domínio:** myrobot.com  
**Data:** 28/04/2026  
**Status:** Pronto para criação

---

**ATUALIZADO (28/04/2026 11:21):**
> **CT CRIADO PELO ACIB:**
> - **CT ID:** 108
> - **Nome:** myrobot-root  
> - **IP:** 192.168.0.112
> - **Senha:** Rcmp814k@#$
> 
> ⚠️ **Nota:** CT 113 não foi criado. Usando CT 108.

---

## 📋 INFORMAÇÕES ATUALIZADAS DO CT
| **Sistema** | Debian 12 (Standard) | Leve, estável |
| **RAM** | 2048 MB (2GB) | Pode aumentar depois |
| **Cores** | 2 vCPU | |
| **Storage** | 20 GB SSD | |
| **Swap** | 512 MB | |

---

## 🚀 COMANDOS PARA CRIAR NO PROXMOX

### 1. Criar Container (via SSH no PVE1)

```bash
# Acessar PVE1
ssh root@192.168.0.192

# Verificar templates disponíveis
ls /var/lib/vz/template/cache/

# CRIAR O CONTAINER
pct create 113 \
  /var/lib/vz/template/cache/debian-12-standard_12.2-1_amd64.tar.zst \
  --hostname myrobot-web \
  --memory 2048 \
  --cores 2 \
  --swap 512 \
  --net0 name=eth0,bridge=vmbr0,ip=192.168.0.113/24,gw=192.168.0.1 \
  --rootfs local-lvm:20 \
  --password Rcmp814k@# \
  --unprivileged 1

# Iniciar container
pct start 113

# Verificar se iniciou
pct status 113
```

### 2. Configurar Dentro do Container

```bash
# Entrar no container
pct exec 113 -- /bin/bash

# Atualizar sistema
apt update && apt upgrade -y

# Instalar pacotes essenciais
apt install -y \
  curl \
  wget \
  git \
  vim \
  nano \
  htop \
  nginx \
  certbot \
  python3-certbot-nginx \
  ufw \
  fail2ban \
  logrotate

# Instalar Node.js (para builds)
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt install -y nodejs

# Verificar instalações
nginx -v
node -v
npm -v
```

---

## 🔧 CONFIGURAÇÃO DO NGINX

### 1. Criar estrutura de diretórios

```bash
# Diretório do site
mkdir -p /var/www/myrobot.com/public_html
mkdir -p /var/www/myrobot.com/logs
mkdir -p /var/www/myrobot.com/backups

# Permissões
chown -R www-data:www-data /var/www/myrobot.com
chmod -R 755 /var/www/myrobot.com

# Página inicial temporária
cat > /var/www/myrobot.com/public_html/index.html << 'EOF'
<!DOCTYPE html>
<html>
<head>
    <title>MYROBOT - Em Construção</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            padding-top: 100px;
            background: #1a1a2e;
            color: #fff;
        }
        h1 { color: #00d4ff; }
        .logo { font-size: 48px; margin: 20px; }
    </style>
</head>
<body>
    <div class="logo">🤖</div>
    <h1>MYROBOT</h1>
    <p>Plataforma de Inteligência Artificial Personalizada</p>
    <p><em>Site em construção...</em></p>
    <p style="margin-top: 50px; color: #888;">
        Contato: Acib ABBADE
    </p>
</body>
</html>
EOF
```

### 2. Configurar Virtual Host

```bash
# Criar configuração Nginx
cat > /etc/nginx/sites-available/myrobot.com << 'EOF'
server {
    listen 80;
    listen [::]:80;
    
    server_name myrobot.com www.myrobot.com 192.168.0.113;
    
    root /var/www/myrobot.com/public_html;
    index index.html index.htm index.php;
    
    # Logs
    access_log /var/www/myrobot.com/logs/access.log;
    error_log /var/www/myrobot.com/logs/error.log;
    
    # Gzip
    gzip on;
    gzip_vary on;
    gzip_proxied any;
    gzip_comp_level 6;
    gzip_types text/plain text/css text/xml application/json application/javascript application/rss+xml application/atom+xml image/svg+xml;
    
    # Cache estático
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }
    
    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    
    # Locations
    location / {
        try_files $uri $uri/ =404;
    }
    
    # API endpoint (para futuro)
    location /api {
        proxy_pass http://localhost:3000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_cache_bypass $http_upgrade;
    }
}
EOF

# Ativar site
ln -s /etc/nginx/sites-available/myrobot.com /etc/nginx/sites-enabled/

# Remover default
rm -f /etc/nginx/sites-enabled/default

# Testar configuração
nginx -t

# Reiniciar Nginx
systemctl restart nginx
systemctl enable nginx
```

---

## 🛡️ CONFIGURAÇÃO DE SEGURANÇA

### 1. Firewall (UFW)

```bash
# Configurar UFW
ufw default deny incoming
ufw default allow outgoing

# Liberar portas
ufw allow 22/tcp    # SSH
ufw allow 80/tcp    # HTTP
ufw allow 443/tcp   # HTTPS
ufw allow 18789/tcp # OpenClaw (se necessário)

# Ativar
ufw enable

# Verificar status
ufw status verbose
```

### 2. Fail2ban

```bash
# Configurar Fail2ban
cat > /etc/fail2ban/jail.local << 'EOF'
[DEFAULT]
bantime = 3600
findtime = 600
maxretry = 3

[sshd]
enabled = true
port = ssh
filter = sshd
logpath = /var/log/auth.log

[nginx-http-auth]
enabled = true
filter = nginx-http-auth
port = http,https
logpath = /var/log/nginx/error.log
EOF

systemctl restart fail2ban
systemctl enable fail2ban
```

### 3. SSH Seguro

```bash
# Editar /etc/ssh/sshd_config
sed -i 's/#PermitRootLogin prohibit-password/PermitRootLogin no/' /etc/ssh/sshd_config
sed -i 's/#PasswordAuthentication yes/PasswordAuthentication no/' /etc/ssh/sshd_config

# Criar usuário deploy
useradd -m -s /bin/bash deploy
usermod -aG sudo deploy
usermod -aG www-data deploy

# Reiniciar SSH
systemctl restart sshd
```

---

## 📂 ESTRUTURA DE DIRETÓRIOS

```
/var/www/myrobot.com/
├── public_html/          ← Arquivos do site
│   ├── index.html
│   ├── css/
│   ├── js/
│   ├── images/
│   └── assets/
├── logs/                 ← Logs de acesso
│   ├── access.log
│   └── error.log
├── backups/              ← Backups automáticos
└── config/               ← Configurações específicas
```

---

## 🔄 DEPLOY AUTOMÁTICO (Git)

```bash
# Instalar webhook para deploy automático
apt install -y webhook

# Criar script de deploy
cat > /var/www/myrobot.com/deploy.sh << 'EOF'
#!/bin/bash

cd /var/www/myrobot.com/public_html
git pull origin main

# Se usar Node.js para build:
# npm install
# npm run build

# Reiniciar Nginx se necessário
# systemctl reload nginx

echo "Deploy realizado em: $(date)" >> /var/www/myrobot.com/logs/deploy.log
EOF

chmod +x /var/www/myrobot.com/deploy.sh

# Configurar webhook (opcional)
```

---

## 📊 MONITORAMENTO

```bash
# Instalar monitoramento básico
apt install -y net-tools

# Script de monitoramento
cat > /usr/local/bin/check-myrobot.sh << 'EOF'
#!/bin/bash

# Verificar se Nginx está rodando
if ! pgrep -x "nginx" > /dev/null; then
    echo "$(date): Nginx não está rodando!" >> /var/log/myrobot-monitor.log
    systemctl restart nginx
fi

# Verificar espaço em disco
DISK_USAGE=$(df / | tail -1 | awk '{print $5}' | sed 's/%//')
if [ $DISK_USAGE -gt 85 ]; then
    echo "$(date): Uso de disco alto: ${DISK_USAGE}%" >> /var/log/myrobot-monitor.log
fi
EOF

chmod +x /usr/local/bin/check-myrobot.sh

# Adicionar ao cron (a cada 5 minutos)
echo "*/5 * * * * root /usr/local/bin/check-myrobot.sh" | crontab -
```

---

## 🌐 ACESSO E TESTES

### Após configuração:

```bash
# Testar Nginx
systemctl status nginx

# Ver logs em tempo real
tail -f /var/www/myrobot.com/logs/access.log
tail -f /var/www/myrobot.com/logs/error.log

# Testar acesso local
curl -I http://localhost

# Verificar porta 80
netstat -tlnp | grep :80
```

### Acesso externo:
- **Local:** http://192.168.0.113
- **Domínio (configurar DNS):** http://myrobot.com

---

## 📋 CHECKLIST PÓS-CRIAÇÃO

- [ ] Container criado (CT 113)
- [ ] IP configurado (192.168.0.113)
- [ ] Sistema atualizado
- [ ] Nginx instalado e configurado
- [ ] Firewall ativo (UFW)
- [ ] Fail2ban configurado
- [ ] Página inicial funcionando
- [ ] Logs configurados
- [ ] Backups agendados
- [ ] Monitoramento ativo
- [ ] Registro em HEARTBEAT.md

---

## 🔗 INTEGRAÇÃO COM OUTROS CTs

### Comunicação com CTs auxiliares:

```bash
# CT 114 - MYROBOT-SEC (Segurança)
# CT 115 - MYROBOT-DATA (Coletor)

# Permitir comunicação interna (se necessário)
# Configurar no firewall:
# ufw allow from 192.168.0.114
# ufw allow from 192.168.0.115
```

---

## 📝 COMANDOS ÚTEIS

```bash
# Entrar no container
pct exec 113 -- /bin/bash

# Ver status
pct status 113

# Reiniciar
pct restart 113

# Backup do container
vzdump 113 --compress zstd --dumpdir /var/lib/vz/dump/

# Ver recursos
pct exec 113 -- free -h
pct exec 113 -- df -h
```

---

**Configuração pronta para execução!** 🚀  
*Execute os comandos no PVE1 (192.168.0.192)*
