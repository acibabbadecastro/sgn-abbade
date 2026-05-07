# 🖥️ CRIAÇÃO DO CT 4PETS - AMIGOS 4 PATAS
## Container Proxmox para Site do Projeto

**Data:** 26/04/2026  
**Hora:** 13:14  
**Solicitante:** Acib ABBADE  
**Status:** ⏳ Em preparação

---

## 📋 ESPECIFICAÇÕES DO CT

| Campo | Valor |
|-------|-------|
| **CT ID** | 200 (ou próximo disponível) |
| **Nome** | 4pets |
| **Hostname** | amigos4patas-web |
| **SO** | Ubuntu 22.04 LTS |
| **CPU** | 2 cores |
| **RAM** | 4 GB |
| **Swap** | 512 MB |
| **Disco** | 50 GB |
| **Rede** | Bridge (vmbr0) |
| **IP** | 192.168.0.200/24 |
| **Gateway** | 192.168.0.1 |
| **DNS** | 8.8.8.8, 8.8.4.4 |
| **Privilegiado** | Não (unprivileged) |
| **Features** | Nesting=1, Keyctl=1 |

---

## 🔧 COMANDO DE CRIAÇÃO (Proxmox CLI)

### Via SSH no PVE1 (192.168.0.192):

```bash
# Acessar Proxmox
ssh root@192.168.0.192

# Criar CT 200
pct create 200 local:vztmpl/ubuntu-22.04-standard_22.04-1_amd64.tar.zst \
  --hostname 4pets \
  --cores 2 \
  --memory 4096 \
  --swap 512 \
  --rootfs local-lvm:50 \
  --net0 name=eth0,bridge=vmbr0,ip=192.168.0.200/24,gw=192.168.0.1 \
  --nameserver 8.8.8.8 \
  --unprivileged 1 \
  --features nesting=1,keyctl=1 \
  --password [SENHA_A_DEFINIR]

# Iniciar CT
pct start 200

# Verificar status
pct status 200
```

---

## 🌐 CONFIGURAÇÃO PÓS-CRIAÇÃO

### 1. Acessar CT
```bash
pct enter 200
# ou
ssh root@192.168.0.200
```

### 2. Atualizar sistema
```bash
apt update && apt upgrade -y
```

### 3. Instalar stack (eu faço depois)
- Nginx
- PostgreSQL
- Python 3 + Flask
- Certbot (SSL)

---

## ✅ CT CRIADO COM SUCESSO!

**Data/Hora criação:** 26/04/2026 13:17  
**Status:** ✅ **ATIVO E FUNCIONANDO**  

### Detalhes Confirmados:
| Campo | Valor |
|-------|-------|
| **CT ID** | **107** (atribuído automaticamente) |
| **Nome** | 4pets ✅ |
| **Hostname** | 4pets |
| **SO** | Ubuntu 25.04 (nova versão LTS) |
| **IP** | 192.168.0.200/24 ✅ |
| **Gateway** | 192.168.0.1 |
| **Status** | ✅ Running |
| **SSH** | ✅ Chaves geradas e ativas |

### Chaves SSH Geradas:
- **ED25519:** SHA256:3DPKyv8y8zr+JTRR+bAmRlXVZqTkTvBipo9uTtzw5Jk
- **RSA:** SHA256:VM3dxY6ysPeE70IKwPJXE617IpGAad8Nggusqfra+r0  
- **ECDSA:** SHA256:Cpxg3v2HUEWceh4ooJ2jVLYoVYkbg8QCAB435R8i0m4

### Acesso:
```bash
pct enter 107
# ou
ssh root@192.168.0.200
```

### Alerta Thin Pool (monitorar):
⚠️ Thin pool próximo do limite (722GB alocados vs 687GB físicos)  
**Ação:** Monitorar uso de disco dos CTs

---

## 🎯 PRÓXIMOS PASSOS

### 1. Configurar DNS no Registro.br
- Acessar: https://registro.br
- Domínio: amigos4patas.com.br
- DNS: Apontar tipo A para 192.168.0.200

### 2. Abrir portas no roteador (192.168.0.1)
- Porta 80 → 192.168.0.200:80
- Porta 443 → 192.168.0.200:443
- Porta 22 → 192.168.0.200:22 (opcional)

### 3. Instalar stack no CT
- Nginx
- PostgreSQL
- Python 3 + Flask
- Certbot (SSL/HTTPS)

### 4. Subir site Amigos 4 Patas
- Deploy aplicação
- Configurar SSL
- Testar acesso: https://amigos4patas.com.br

---

## 🚀 STATUS ATUAL

- [x] CT criado
- [x] IP configurado (192.168.0.200)
- [x] SSH funcionando
- [ ] DNS configurado (pendente)
- [ ] Portas liberadas (pendente)
- [ ] Stack instalado (pendente)
- [ ] Site no ar (pendente)

---

## 🔗 RELACIONAMENTOS

- **Domínio:** amigos4patas.com.br (ativo, pago até 25/04/2028)
- **Projeto:** Amigos de 4 Patas - Parque Meia Lua
- **CT responsável:** Stark (CT 100) - este arquivo

---

**Criado em:** 26/04/2026 13:14  
**Por:** Acib ABBADE / Stark
