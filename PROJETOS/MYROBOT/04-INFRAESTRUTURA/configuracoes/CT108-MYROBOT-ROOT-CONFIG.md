# 🖥️ CONFIGURAÇÃO CT 108 - MYROBOT-ROOT

**Container:** CT 108  
**Nome:** myrobot-root  
**IP:** 192.168.0.112  
**Senha:** Rcmp814k@#$  
**Projeto:** MYROBOT (myrobot.com)  
**Data:** 28/04/2026  
**Status:** ✅ CT Criado - Configuração pendente

---

## 📋 INFORMAÇÕES DO CONTAINER

| Campo | Valor |
|-------|-------|
| **CT ID** | 108 |
| **Hostname** | myrobot-root |
| **IP** | 192.168.0.112 |
| **Senha Root** | Rcmp814k@#$ |
| **Sistema** | (Verificar no CT) |
| **Status** | ⏳ A configurar |

---

## 🚀 ACESSO AO CONTAINER

```bash
# Via Proxmox (PVE1)
ssh root@192.168.0.192
pct enter 108

# Via SSH direto (se configurado)
ssh root@192.168.0.112
# Senha: Rcmp814k@#$
```

---

## 🔧 CONFIGURAÇÃO INICIAL NECESSÁRIA

### 1. Verificar Sistema
```bash
# Entrar no container
pct exec 108 -- /bin/bash

# Verificar sistema
cat /etc/os-release
uname -a

# Ver IP
ip addr show
```

### 2. Atualizar Sistema
```bash
apt update && apt upgrade -y
```

### 3. Instalar Stack Web
```bash
apt install -y \
  nginx \
  certbot \
  python3-certbot-nginx \
  ufw \
  fail2ban \
  git \
  curl \
  vim \
  nano \
  htop

# Node.js (para builds)
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt install -y nodejs
```

---

## 🌐 CONFIGURAÇÃO DO MYROBOT.COM

### 1. Criar Estrutura
```bash
mkdir -p /var/www/myrobot.com/public_html
mkdir -p /var/www/myrobot.com/logs
chown -R www-data:www-data /var/www/myrobot.com
```

### 2. Configurar Nginx
```bash
cat > /etc/nginx/sites-available/myrobot.com << 'EOF'
server {
    listen 80;
    listen [::]:80;
    
    server_name myrobot.com www.myrobot.com 192.168.0.112;
    
    root /var/www/myrobot.com/public_html;
    index index.html;
    
    access_log /var/www/myrobot.com/logs/access.log;
    error_log /var/www/myrobot.com/logs/error.log;
    
    gzip on;
    
    location / {
        try_files $uri $uri/ =404;
    }
}
EOF

ln -s /etc/nginx/sites-available/myrobot.com /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

nginx -t
systemctl restart nginx
systemctl enable nginx
```

### 3. Página Inicial Temporária
```bash
cat > /var/www/myrobot.com/public_html/index.html << 'EOF'
<!DOCTYPE html>
<html>
<head>
    <title>MYROBOT - Em Construção</title>
    <meta charset="UTF-8">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            padding-top: 100px;
            background: #1a1a2e;
            color: #fff;
        }
        h1 { color: #00d4ff; font-size: 48px; }
        .logo { font-size: 72px; margin: 20px; }
        p { font-size: 18px; margin: 20px; }
        .ip { 
            background: #333; 
            padding: 10px 20px; 
            border-radius: 5px;
            display: inline-block;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="logo">🤖</div>
    <h1>MYROBOT</h1>
    <p>Plataforma de Inteligência Artificial Personalizada</p>
    <p><em>Site em construção...</em></p>
    <div class="ip">IP: 192.168.0.112</div>
    <p style="margin-top: 50px; color: #888; font-size: 14px;">
        © 2026 Acib ABBADE
    </p>
</body>
</html>
EOF
```

---

## 🛡️ SEGURANÇA

### Firewall
```bash
ufw default deny incoming
ufw default allow outgoing
ufw allow 22/tcp
ufw allow 80/tcp
ufw allow 443/tcp
ufw enable
```

### Fail2ban
```bash
systemctl enable fail2ban
systemctl start fail2ban
```

---

## 📊 STATUS

- [x] CT 108 criado
- [x] IP configurado: 192.168.0.112
- [x] Senha definida: Rcmp814k@#$
- [ ] Sistema atualizado
- [ ] Nginx instalado
- [ ] Site configurado
- [ ] Firewall ativo
- [ ] Testado

---

## 🌐 ACESSO

**URL Local:** http://192.168.0.112  
**Domínio (futuro):** http://myrobot.com

---

*Configuração atualizada em: 28/04/2026 11:21*  
*CT: 108 | IP: 192.168.0.112*
