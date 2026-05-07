# 🖥️ DOCUMENTAÇÃO COMPLETA - SERVIDOR SIC (SERVMIL)

**Versão:** 1.0  
**Data:** 23/04/2026  
**Última Atualização:** 23/04/2026 16:57  
**Documentado por:** Stark - Sistema de Gestão

---

## 📋 **IDENTIFICAÇÃO DO SERVIDOR**

| Campo | Informação |
|-------|------------|
| **Nome** | SIC |
| **Número** | **2** (Servidor secundário da SERVMIL) |
| **Cliente** | SERVMIL |
| **Função** | Sistema SIC / Financeiro |
| **Localização** | Rede SERVMIL (192.168.0.0/24) |
| **Status** | 🟢 **Operacional** (reinstalado) |

---

## 🌐 **INFORMAÇÕES DE REDE**

| Interface | IP | Máscara | Gateway |
|-----------|-----|---------|---------|
| **Local (Ethernet)** | **192.168.0.253** | 255.255.255.0 | 192.168.0.1 |
| **ZeroTier** | ⏳ Aguardando atribuição | - | - |
| **Hostname** | DESKTOP-T022PKB | - | - |

---

## 💻 **ESPECIFICAÇÕES TÉCNICAS**

| Componente | Especificação |
|------------|---------------|
| **Sistema Operacional** | Windows 10 Pro |
| **Instalação** | 23/04/2026 (reinstalação) |
| **Arquitetura** | x64 |
| **Usuário Principal** | acib |
| **Domínio/Workgroup** | WORKGROUP |

---

## 🔐 **CREDENCIAIS DE ACESSO**

| Método | Usuário | Senha | Porta | Status |
|--------|---------|-------|-------|--------|
| **SSH** | acib | Rcmp814k@# | 22 | ✅ Funcionando |
| **RDP** | acib | Rcmp814k@# | 3389 | ⏳ Configurando |
| **Console** | (físico) | - | - | Disponível localmente |

### **Instruções de Acesso:**

**Via SSH (Terminal/Comandos):**
```bash
ssh acib@192.168.0.253
# Senha: Rcmp814k@#
```

**Via RDP (Área de Trabalho):**
```
mstsc  # ou cliente RDP
Host: 192.168.0.253
Usuário: acib
Senha: Rcmp814k@#
```

---

## 🔧 **SERVIÇOS CONFIGURADOS**

### **1. OpenSSH (Nativo Windows)**
| Configuração | Valor |
|--------------|-------|
| **Status** | ✅ Instalado e funcionando |
| **Porta** | 22 |
| **Autenticação** | Senha |
| **Inicialização** | ⏳ Manual (pendente configurar automático) |
| **Acesso** | Usuário acib |

**Comandos para gerenciar:**
```powershell
# Verificar status
Get-Service sshd

# Iniciar
Start-Service sshd

# Configurar automático
Set-Service -Name sshd -StartupType Automatic
```

---

### **2. ZeroTier (Rede Privada Mesh)**
| Configuração | Valor |
|--------------|-------|
| **Status** | ✅ Instalado |
| **Network ID** | af415e486fe4483f |
| **Status na Rede** | ⏳ Aguardando autorização |
| **MAC Address** | 3e:6b:f7:8e:53:bc |
| **IP Atribuído** | ⏳ Pendente |

**Comandos ZeroTier:**
```powershell
# Verificar status
zerotier-cli status
zerotier-cli listnetworks

# Receber IP após autorização
# Acesse: https://my.zerotier.com/ e autorize o dispositivo
```

**⚠️ PENDÊNCIA:** Autorizar dispositivo no painel ZeroTier (MAC: 3e:6b:f7:8e:53:bc)

---

### **3. RDP (Área de Trabalho Remota)**
| Configuração | Valor |
|--------------|-------|
| **Status** | ⏳ Configurando |
| **Porta** | 3389 |
| **Acesso** | ⏳ Aguardando permissões |

**Comandos para habilitar:**
```powershell
# Habilitar RDP
Set-ItemProperty -Path 'HKLM:\System\CurrentControlSet\Control\Terminal Server' -Name 'fDenyTSConnections' -Value 0

# Liberar firewall
Enable-NetFirewallRule -DisplayGroup "Remote Desktop"

# Iniciar serviço
Start-Service TermService
Set-Service -Name TermService -StartupType Automatic
```

---

## ⚠️ **HISTÓRICO DE INCIDENTES**

### **Incidente #1 - Fonte Pifada (23/04/2026)**
| Campo | Informação |
|-------|------------|
| **Data/Hora** | 23/04/2026 - manhã |
| **Problema** | Fonte do servidor falhou |
| **Sintomas** | Loop infinito de reinicialização |
| **Diagnóstico** | Hardware - fonte de alimentação com defeito |
| **Ação Tomada** | Reinstalação completa do Windows 10 |
| **Status** | ✅ Resolvido (substituição/reparo) |

---

## 📊 **ESTRUTURA DE PASTAS**

```
C:\
├── Admin\                    # ⏳ Criar (para manutenção)
├── ProgramData\ssh\           # Configuração SSH
├── Program Files (x86)\ZeroTier\One\  # ZeroTier
└── Windows\System32\OpenSSH\  # OpenSSH nativo
```

---

## 🔥 **FIREWALL E PORTAS**

| Porta | Protocolo | Serviço | Status |
|-------|-----------|---------|--------|
| 22 | TCP | SSH | ✅ Liberada |
| 3389 | TCP | RDP | ⏳ Liberando |
| 9993 | UDP | ZeroTier | ✅ Liberada |

---

## 🎯 **PENDÊNCIAS E PRÓXIMOS PASSOS**

### **Prioridade Alta:**
- [ ] ⚠️ **Autorizar ZeroTier** no painel my.zerotier.com
- [ ] ⚠️ **Configurar RDP** (executar script de permissões como admin)
- [ ] ⚠️ **Tornar SSH automático** (iniciar com Windows)
- [ ] ⚠️ **Criar pasta C:\Admin** para arquivos de manutenção

### **Prioridade Média:**
- [ ] Instalar ferramentas de administração
- [ ] Configurar backup automático
- [ ] Documentar senhas de serviços
- [ ] Testar acesso remoto via ZeroTier

---

## 📝 **INFORMAÇÕES DO CLIENTE**

| Campo | Informação |
|-------|------------|
| **Cliente** | SERVMIL |
| **Contato Principal** | Saulo |
| **Outros Contatos** | Bryan, Daniela, Gabriele, Juliana, Ana |
| **Prioridade** | 🔴 Alta |
| **Histórico** | Cliente desde 2026, múltiplos serviços |

---

## 💰 **CONTROLE DE SERVIÇOS**

| Chamado | Data | Serviço | Valor | Status |
|---------|------|---------|-------|--------|
| SERV-202604-23-152600 | 23/04 | Fonte SIC + Reinstalação | R$ 380-780 | 🟢 Concluído |

---

## 🔗 **LINKS ÚTEIS**

- 📁 Documentação completa: `/root/.openclaw/workspace/memory/INCIDENTE-SERVIDOR-SIC-2026-04-23.md`
- 📁 Mapeamento servidores: `/root/.openclaw/workspace/memory/MAPEAMENTO-SERVIDORES-SERVMIL.md`
- 📁 Serviços SERVMIL: `/root/.openclaw/workspace/memory/servicos-servmil-2026-04.md`

---

## 📞 **SUPORTE**

| Responsável | Contato |
|-------------|---------|
| **Técnico** | Acib ABBADE |
| **Sistema** | Stark (IA) |
| **Acesso** | 24/7 via SSH/ZeroTier (após configuração) |

---

## ✅ **CHECKLIST DE VERIFICAÇÃO**

**Ao acessar o servidor, verificar:**
- [ ] Conectividade de rede (ping 192.168.0.253)
- [ ] Serviço SSH rodando
- [ ] Espaço em disco
- [ ] Logs de eventos
- [ ] Conectividade ZeroTier (quando autorizado)

---

*Documentação criada em 23/04/2026 16:57*  
*Atualizada automaticamente pelo sistema*  
*Stark - Sistema de Gestão SERVMIL*
