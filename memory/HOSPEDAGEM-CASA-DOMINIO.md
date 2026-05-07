# 🏠 HOSPEDAGEM EM CASA + DOMÍNIO PRÓPRIO
## Alternativa ao VPS - Infraestrutura Local

**Data:** 26/04/2026  
**Solicitante:** Acib ABBADE  
**Opção:** Hospedar na infraestrutura própria + comprar só o domínio

---

## 💰 ECONOMIA COMPARATIVA

| Opção | Custo Mensal | Custo Anual | Setup |
|-------|--------------|-------------|-------|
| **VPS Hostinger** | R$ 33-55 | R$ 400-660 | Zero (pronto) |
| **Casa + Domínio** | **R$ 3-8** | **R$ 40-100** | Requer configuração |

**Economia:** ~R$ 300-500 por ano!

---

## ✅ PRÓS DE HOSPEDAR EM CASA

| Vantagem | Descrição |
|----------|-----------|
| **Custo baixo** | Só paga o domínio (~R$ 40/ano) |
| **Controle total** | Você gerencia tudo |
| **Privacidade** | Dados não saem da sua casa |
| **Escalabilidade** | Upgrade de hardware quando quiser |
| **Aprendizado** | Você aprende mais sobre servidores |
| **Sem limites** | Tráfego ilimitado (sua internet) |

## ❌ CONTRAS

| Desvantagem | Solução |
|-------------|---------|
| **IP dinâmico** (muda) | Usar serviço DDNS (No-IP, DuckDNS) |
| **Luz/internet cai** | Site fica fora do ar |
| **Portas liberadas** | Precisa abrir no roteador |
| **Manutenção** | Você cuida de tudo |
| **Energia** | Computador ligado 24h |
| **Velocidade** | Depende do upload da sua internet |

---

## 🛠️ O QUE VOCÊ PRECISA EM CASA

### Hardware Mínimo:
```
💻 Computador/Notebook/Servidor antigo
   ├─ CPU: Dual-core (mínimo)
   ├─ RAM: 4GB (mínimo) / 8GB (recomendado)
   ├─ HD/SSD: 50GB+ livre
   └─ Sistema: Ubuntu 22.04 LTS (recomendado)

🌐 Internet
   ├─ Download: 10Mbps+ (mínimo)
   ├─ Upload: 5Mbps+ (IMPORTANTE!)
   └─ Ping: Estável

🔌 Infraestrutura
   ├─ No-break (recomendado)
   ├─ Ventilação
   └─ Cabo de rede (melhor que WiFi)
```

### Software Necessário:
- **Sistema:** Ubuntu Server 22.04 LTS (grátis)
- **Web Server:** Nginx (grátis)
- **Banco de dados:** PostgreSQL (grátis)
- **Linguagem:** Python 3 + Flask (grátis)
- **DDNS:** No-IP ou DuckDNS (grátis)

---

## 📋 PASSO A PASSO - CONFIGURAÇÃO

### ETAPA 1: Preparar Máquina em Casa

**1.1 Instalar Ubuntu Server**
```bash
# Baixar ISO: https://ubuntu.com/download/server
# Instalar no computador/notebook
# Configurar IP fixo na rede local:
sudo nano /etc/netplan/00-installer-config.yaml
```

```yaml
network:
  version: 2
  ethernets:
    enp0s3:
      dhcp4: no
      addresses:
        - 192.168.0.XXX/24  # IP fixo na sua rede
      routes:
        - to: default
          via: 192.168.0.1   # Gateway (seu roteador)
      nameservers:
        addresses: [8.8.8.8, 8.8.4.4]
```

**1.2 Aplicar configuração**
```bash
sudo netplan apply
```

---

### ETAPA 2: Abrir Portas no Roteador

**2.1 Descobrir IP externo**
```bash
curl ifconfig.me
# Anote esse número (ex: 201.45.67.89)
```

**2.2 Configurar roteador (192.168.0.1)**
```
┌─────────────────────────────────────────┐
│  ROTEADOR - Port Forwarding              │
├─────────────────────────────────────────┤
│  Porta externa 80  → IP: 192.168.0.XXX  │
│  Porta externa 443 → IP: 192.168.0.XXX  │
│  Porta externa 22  → IP: 192.168.0.XXX  │
└─────────────────────────────────────────┘
```

**Portas necessárias:**
- **80:** HTTP (site)
- **443:** HTTPS (site seguro)
- **22:** SSH (acesso remoto)
- **5432:** PostgreSQL (banco - opcional, pode manter local)

---

### ETAPA 3: Configurar DDNS (IP dinâmico)

**Problema:** Seu IP de internet muda!
**Solução:** DDNS (Dynamic DNS)

**Opções gratuitas:**

| Serviço | Gratuito? | Domínio | Facilidade |
|---------|-----------|---------|------------|
| **DuckDNS** | ✅ Sim | nome.duckdns.org | ⭐⭐⭐ Fácil |
| **No-IP** | ✅ Sim | nome.no-ip.biz | ⭐⭐⭐ Fácil |
| **Cloudflare** | ✅ Sim | Seu domínio | ⭐⭐ Médio |

**3.1 Usar DuckDNS (mais fácil):**
```bash
# 1. Cadastrar em: https://www.duckdns.org
# 2. Escolher nome: amigos4patasparquemeialua.duckdns.org
# 3. Instalar cliente:

mkdir ~/duckdns
cd ~/duckdns
nano duck.sh
```

```bash
#!/bin/bash
echo url="https://www.duckdns.org/update?domains=SEU_NOME&token=SEU_TOKEN&ip=" | curl -k -o ~/duckdns/duck.log -K -
```

```bash
chmod 700 duck.sh
crontab -e
# Adicionar:
*/5 * * * * ~/duckdns/duck.sh >/dev/null 2>&1
```

---

### ETAPA 4: Comprar Domínio

**Onde comprar (Brasil):**

| Registrador | Preço .com.br | Preço .com | Painel |
|-------------|---------------|------------|--------|
| **Registro.br** | R$ 40/ano | - | Oficial |
| **Hostinger** | R$ 40/ano | R$ 50/ano | Fácil |
| **GoDaddy** | R$ 50/ano | R$ 60/ano | Fácil |
| **Namecheap** | R$ 45/ano | R$ 55/ano | Fácil |

**Recomendado:** Registro.br (oficial do Brasil) ou Hostinger

**4.1 Configurar DNS apontando pra casa:**
```
Tipo A:
┌────────────────────────────────────────┐
│ Nome      │ Tipo │ Valor               │
├────────────────────────────────────────┤
│ @         │ A    │ 201.45.67.89 (seu IP) │
│ www       │ A    │ 201.45.67.89 (seu IP) │
└────────────────────────────────────────┘
```

---

### ETAPA 5: Instalar Stack (Linux)

**5.1 Atualizar sistema**
```bash
sudo apt update && sudo apt upgrade -y
```

**5.2 Instalar Nginx**
```bash
sudo apt install nginx -y
sudo systemctl enable nginx
sudo systemctl start nginx
```

**5.3 Instalar PostgreSQL**
```bash
sudo apt install postgresql postgresql-contrib -y
sudo systemctl enable postgresql
```

**5.4 Instalar Python e ambiente**
```bash
sudo apt install python3 python3-pip python3-venv -y
sudo apt install libpq-dev python3-dev -y
```

**5.5 Configurar SSL (HTTPS grátis - Let's Encrypt)**
```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d amigos4patas.com.br -d www.amigos4patas.com.br
```

---

### ETAPA 6: Deploy do Site Amigos 4 Patas

**6.1 Criar estrutura**
```bash
sudo mkdir -p /var/www/amigos4patas
sudo chown -R $USER:$USER /var/www/amigos4patas
```

**6.2 Criar ambiente Python**
```bash
cd /var/www/amigos4patas
python3 -m venv venv
source venv/bin/activate
pip install flask sqlalchemy psycopg2-binary pillow gunicorn
```

**6.3 Configurar Nginx**
```bash
sudo nano /etc/nginx/sites-available/amigos4patas
```

```nginx
server {
    listen 80;
    server_name amigos4patas.com.br www.amigos4patas.com.br;

    location / {
        include proxy_params;
        proxy_pass http://unix:/var/www/amigos4patas/app.sock;
    }

    location /static/ {
        alias /var/www/amigos4patas/static/;
    }

    location /uploads/ {
        alias /var/www/amigos4patas/uploads/;
    }
}
```

```bash
sudo ln -s /etc/nginx/sites-available/amigos4patas /etc/nginx/sites-enabled
sudo nginx -t
sudo systemctl restart nginx
```

---

## 💡 VANTAGENS ESPECÍFICAS PRO SEU PROJETO

### 1. **Você já tem infraestrutura!**
- Proxmox rodando (PVE1)
- Containers LXC disponíveis
- Pode criar CT novo só pro site!

### 2. **Opção recomendada pra você:**
```
┌─────────────────────────────────────────┐
│           CT NOVO (Ex: CT 200)          │
│         "Amigos4Patas-Web"              │
│  ┌─────────────────────────────────┐    │
│  │  IP: 192.168.0.200            │    │
│  │  Ubuntu 22.04 LTS             │    │
│  │  2 CPU, 4GB RAM, 50GB disco   │    │
│  │                                │    │
│  │  ├─ Nginx                     │    │
│  │  ├─ PostgreSQL                │    │
│  │  ├─ Python/Flask              │    │
│  │  └─ Site Amigos 4 Patas       │    │
│  └─────────────────────────────────┘    │
│                                          │
│  Porta 80/443 redirecionada no roteador  │
│  do PVE1 (192.168.0.192) para 192.168.0.200│
└─────────────────────────────────────────┘
```

### 3. **Vantagens de usar seu Proxmox:**
- ✅ Backup automático (você já tem!)
- ✅ Snapshot antes de alterações
- ✅ Isolamento do sistema
- ✅ Se der problema, restaura em minutos
- ✅ Pode clonar o CT pra testar atualizações
- ✅ Economiza luz (servidor já tá ligado)

---

## 🎯 RESUMO - O QUE VOCÊ PRECISA COMPRAR

### Opção Econômica (Casa):
| Item | Custo | Onde comprar |
|------|-------|--------------|
| **Domínio .com.br** | R$ 40/ano | Registro.br |
| Configuração técnica | **EU FAÇO!** | - |
| **TOTAL ANUAL** | **R$ 40** | - |

### Opção VPS (Hostinger):
| Item | Custo | Onde comprar |
|------|-------|--------------|
| VPS KVM 1 | R$ 396/ano | Hostinger |
| Domínio | R$ 40/ano | Incluso ou separado |
| Configuração técnica | **EU FAÇO!** | - |
| **TOTAL ANUAL** | **R$ 436** | - |

**Economia em casa:** R$ 396 por ano (~R$ 33/mês)

---

## ⚠️ RECOMENDAÇÃO PRA VOCÊ

**Se você quer:**
- ✅ Economizar R$ 400/ano
- ✅ Aprender mais sobre servidores
- ✅ Ter controle total
- ✅ Usar seu Proxmox (já tem infra!)

**→ HOSPEDE EM CASA** + compre só o domínio

**Se você quer:**
- ✅ Zero trabalho de infraestrutura
- ✅ Site online 99,9% do tempo
- ✅ Não depender da sua internet/luz
- ✅ Focar só no projeto

**→ Compre VPS Hostinger**

---

## 🤔 DECISÃO

**Qual você prefere?**

**A)** Hospedar em casa (economia + aprendizado) - Eu configuro tudo no seu Proxmox

**B)** VPS Hostinger (praticidade) - Paga mais, mas não se preocupa com infra

Me diz que eu preparo o passo a passo específico! 🚀
