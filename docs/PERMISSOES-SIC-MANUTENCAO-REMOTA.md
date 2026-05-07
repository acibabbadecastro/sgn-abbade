# 🔐 CONFIGURAÇÃO DE PERMISSÕES - MANUTENÇÃO REMOTA SIC

**Servidor:** SIC (Nº 2 da SERVMIL)  
**IP:** 192.168.0.253  
**Usuário:** acib  
**Data:** 23/04/2026

---

## 📋 **PERMISSÕES CONFIGURADAS**

### 1️⃣ **PERMISSÕES DE ADMINISTRADOR**

```powershell
# Verificar se acib é administrador
net localgroup administrators acib

# Se não estiver, adicionar:
net localgroup administrators acib /add
```

### 2️⃣ **ACESSO REMOTO (RDP)**

```powershell
# Habilitar RDP
Set-ItemProperty -Path 'HKLM:\System\CurrentControlSet\Control\Terminal Server' -Name 'fDenyTSConnections' -Value 0

# Permitir usuários remotos
Set-ItemProperty -Path 'HKLM:\System\CurrentControlSet\Control\Terminal Server\WinStations\RDP-Tcp' -Name 'UserAuthentication' -Value 1

# Adicionar usuário ao grupo de acesso remoto
net localgroup "Remote Desktop Users" acib /add

# Iniciar serviço
Start-Service TermService
Set-Service -Name TermService -StartupType Automatic
```

### 3️⃣ **FIREWALL**

```powershell
# Habilitar regras do RDP
Enable-NetFirewallRule -DisplayGroup "Remote Desktop"

# Liberar portas específicas (se necessário)
New-NetFirewallRule -DisplayName "SSH (TCP 22)" -Direction Inbound -Protocol TCP -LocalPort 22 -Action Allow
New-NetFirewallRule -DisplayName "RDP (TCP 3389)" -Direction Inbound -Protocol TCP -LocalPort 3389 -Action Allow
New-NetFirewallRule -DisplayName "ZeroTier" -Direction Inbound -Protocol UDP -LocalPort 9993 -Action Allow
```

### 4️⃣ **PERMISSÕES DE PASTAS**

```powershell
# Criar pasta de trabalho para administração
New-Item -ItemType Directory -Path "C:\Admin" -Force

# Dar permissões totais ao usuário acib
$path = "C:\Admin"
$acl = Get-Acl $path

# Usuário acib
$user = New-Object System.Security.Principal.NTAccount("acib")
$permission = $user, "FullControl", "ContainerInherit,ObjectInherit", "None", "Allow"
$accessRule = New-Object System.Security.AccessControl.FileSystemAccessRule $permission
$acl.SetAccessRule($accessRule)
Set-Acl $path $acl

# Logs
Write-Host "Permissões configuradas para C:\Admin"
```

### 5️⃣ **SERVIÇOS NECESSÁRIOS**

```powershell
# Garantir que estes serviços estejam em automático
$services = @(
    "TermService",      # Remote Desktop
    "sshd",             # OpenSSH
    "ZeroTierOneService" # ZeroTier
)

foreach ($service in $services) {
    try {
        Set-Service -Name $service -StartupType Automatic -ErrorAction SilentlyContinue
        Start-Service -Name $service -ErrorAction SilentlyContinue
        Write-Host "Serviço $service configurado"
    } catch {
        Write-Host "Serviço $service não encontrado ou erro"
    }
}
```

### 6️⃣ **POLÍTICAS DE SEGURANÇA (Opcional)**

```powershell
# Desabilitar bloqueio de conta por tentativas falhas (para não travar)
net accounts /lockoutthreshold:0

# Política de senha flexível
net accounts /minpwlen:6
net accounts /maxpwage:unlimited
```

---

## 🎯 **RESUMO DE ACESSOS**

| Serviço | Porta | Usuário | Permissão |
|---------|-------|---------|-----------|
| SSH | 22 | acib | ✅ Administrador |
| RDP | 3389 | acib | ✅ Acesso Remoto |
| ZeroTier | 9993 | - | ✅ Rede Privada |
| Pastas | - | acib | ✅ C:\Admin (Total) |

---

## ✅ **VERIFICAÇÃO FINAL**

```powershell
# Verificar tudo
Write-Host "=== VERIFICAÇÃO DE PERMISSÕES ==="
Write-Host "Usuário acib em grupos:"
net user acib | findstr "Local Group"

Write-Host "Serviços em execução:"
Get-Service TermService, sshd, ZeroTierOneService -ErrorAction SilentlyContinue | Select-Object Name, Status, StartType

Write-Host "Portas em escuta:"
netstat -an | findstr ":22\|:3389\|:9993"
```

---

*Configuração para manutenção remota completa*  
*Stark - Sistema de Gestão*
