# 🔧 CONFIGURAÇÃO SERVIDOR SIC - WINDOWS 10

**Data:** 23/04/2026  
**Servidor:** SIC (SERVMIL)  
**Sistema:** Windows 10 recém-instalado

---

## 1️⃣ ZERO TIER (Rede Mesh Privada)

### **Instalação:**
```powershell
# Baixar instalador
# Site: https://www.zerotier.com/download/
# Ou via Winget:
winget install ZeroTier.ZeroTierOne
```

### **Configuração:**
```powershell
# Como administrador, execute:
zerotier-cli join <NETWORK_ID>

# Verificar status
zerotier-cli status
zerotier-cli listnetworks

# Exemplo de saída:
# 200 listnetworks <nwid> <name> <mac> <status> <type> <dev> <ZT assigned ips>
```

### **NETWORK ID da sua rede:**
*(Você precisa informar o ID da rede ZeroTier)*

---

## 2️⃣ OPENSSH (Nativo do Windows 10)

### **Instalação:**
```powershell
# Como administrador
Add-WindowsCapability -Online -Name OpenSSH.Server~~~~0.0.1.0

# Verificar instalação
Get-WindowsCapability -Online | Where-Object Name -like 'OpenSSH*'
```

### **Configuração:**
```powershell
# Iniciar serviço
Start-Service sshd

# Configurar para iniciar automaticamente
Set-Service -Name sshd -StartupType 'Automatic'

# Verificar se está rodando
Get-Service sshd
```

### **Configurar Autenticação:**
```powershell
# Abrir arquivo de configuração
notepad C:\ProgramData\ssh\sshd_config

# Alterar estas linhas:
# Port 22
# PermitRootLogin no
# PasswordAuthentication yes
# PubkeyAuthentication yes
```

### **Criar Usuário para Acesso:**
```powershell
# Criar usuário admin
net user admin_acib <SENHA_FORTE> /add
net localgroup administrators admin_acib /add
```

### **Firewall:**
```powershell
# Liberar porta SSH no firewall
New-NetFirewallRule -Name 'OpenSSH-Server-In-TCP' -DisplayName 'OpenSSH Server (sshd)' -Enabled True -Direction Inbound -Protocol TCP -Action Allow -LocalPort 22
```

---

## 3️⃣ FERRAMENTAS DE ADMINISTRAÇÃO REMOTA

### **OPÇÃO A: RustDesk (Recomendado)** ⭐
```
✅ Open Source
✅ Leve
✅ Seguro (criptografia)
✅ Sem limite de dispositivos
✅ Funciona atrás de NAT

Download: https://rustdesk.com/
ID do servidor: ____ (aparece após instalar)
Senha: ____ (definir fixa)
```

### **OPÇÃO B: AnyDesk**
```
✅ Muito popular
✅ Rápido
✅ Portátil (não precisa instalar)
⚠️ Limitações na versão gratuita

ID AnyDesk: ____
Senha: ____
```

### **OPÇÃO C: RDP (Área de Trabalho Remota - Nativo)**
```powershell
# Habilitar RDP
Set-ItemProperty -Path 'HKLM:\System\CurrentControlSet\Control\Terminal Server' -name "fDenyTSConnections" -value 0

# Habilitar no firewall
Enable-NetFirewallRule -DisplayGroup "Remote Desktop"

# Porta: 3389
```

### **OPÇÃO D: MeshCentral (Self-hosted)**
```
✅ Você hospeda (controle total)
✅ Web-based
✅ Múltiplos protocolos
⚠️ Requer servidor Node.js

URL: ____ (seu servidor)
```

---

## 📊 **RESUMO DE PORTAS E ACESSOS**

| Serviço | Porta | Protocolo | Uso |
|---------|-------|-----------|-----|
| **SSH** | 22 | TCP | Terminal/Comandos |
| **RDP** | 3389 | TCP | Área de trabalho |
| **RustDesk** | 21115-21119 | TCP | Desktop remoto |
| **ZeroTier** | 9993 | UDP | Rede privada mesh |

---

## 🔐 **CHECKLIST DE SEGURANÇA**

- [ ] **Mudar senha padrão** do Windows
- [ ] **Desabilitar SMB1** (antigo e inseguro)
- [ ] **Atualizar Windows** (Windows Update)
- [ ] **Instalar antivírus** (Windows Defender ou outro)
- [ ] **Configurar backup** automático
- [ ] **Documentar IPs ZeroTier** atribuídos

---

## 📝 **INFORMAÇÕES A ANOTAR**

```
Servidor: SIC (SERVMIL)
Sistema: Windows 10 Pro

ZeroTier:
  Network ID: ___________
  IP atribuído: ___________

SSH:
  Usuário: ___________
  Senha: ___________
  Porta: 22

RustDesk:
  ID: ___________
  Senha: ___________

RDP:
  Usuário: ___________
  Senha: ___________
  Porta: 3389
```

---

*Documento criado em: 23/04/2026 15:27*  
*Por: Stark - Sistema de Gestão*
