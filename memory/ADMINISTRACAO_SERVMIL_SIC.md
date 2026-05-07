# 🔴 ADMINISTRAÇÃO SERVMIL - DOCUMENTO CRÍTICO
## SIC (Servidor SERVMIL) - Informações de Acesso e Configuração

**⚠️ PRIORIDADE MÁXIMA - NUNCA PERDER ESTE DOCUMENTO**

**Criado:** 24/04/2026 09:26  
**Local:** SERVMIL (Serve 1000)  
**Responsável:** Acib ABBADE  
**Administrador Técnico:** Stark (CT 100)

---

## 🖥️ SERVIDOR SIC - DADOS GERAIS

| Campo | Valor | Observação |
|-------|-------|------------|
| **Hostname** | DESKTOP-T022PKB | Nome do computador |
| **Sistema** | Windows 10 | Versão 10.0.19045.6456 |
| **Função** | Servidor Administrativo SERVMIL | Principal |
| **Localização** | SERVMIL (Serve 1000) | São Paulo/SP |

---

## 🌐 REDE E CONECTIVIDADE

### Rede Local (SERVMIL)
| Campo | Valor |
|-------|-------|
| **IP Local** | 192.168.1.101 |
| **MAC Address** | 10-C3-7B-C4-5B-59 |
| **Máscara** | 255.255.255.0 |
| **Gateway** | 192.168.1.1 |

### VPN ZeroTier (Acesso Remoto)
| Campo | Valor |
|-------|-------|
| **Network ID** | af415e486fe4483f |
| **IP ZeroTier** | 172.28.87.134 |
| **MAC ZeroTier** | 3C-6A-D2-CA-15-38 |
| **Status** | ✅ CONNECTED |
| **Versão** | v1.20 |

---

## 🔐 CREDENCIAIS DE ACESSO (⚠️ CONFIDENCIAL)

### Usuários Administradores
| Usuário | Senha | Privilégio | Finalidade | Criado/Atualizado |
|---------|-------|------------|------------|-------------------|
| **sic** | `Servmil@2026` | ✅ **ADMINISTRADOR** | USUÁRIO PRINCIPAL SERVMIL | 24/04/2026 09:25 |
| **stark** | `Rcmp814k@#` | ✅ **ADMINISTRADOR** | Acesso técnico/backup | 23/04/2026 |
| **acib** | `Rcmp814k@#` | ✅ **ADMINISTRADOR** | Administrador pessoal | 23/04/2026 |

### ⚠️ NOTAS DE SEGURANÇA:
- Senhas devem ser trocadas a cada 90 dias
- Usuário "sic" é o principal para operações SERVMIL
- Usuários "stark" e "acib" são para acesso técnico emergencial
- NUNCA compartilhar senhas em canais não seguros

---

## 🔌 SERVIÇOS E PORTAS

### Acesso Remoto Habilitado
| Serviço | Porta | Status | Inicialização |
|---------|-------|--------|---------------|
| **OpenSSH (sshd)** | 22 | ✅ Running | ✅ **Automático** |
| **Remote Desktop (RDP)** | 3389 | ✅ Running | ✅ **Automático** |
| **ZeroTier VPN** | 9993/UDP | ✅ Running | ✅ **Automático** |

### Configuração dos Serviços
- SSH configurado para aceitar senha
- RDP habilitado para múltiplos usuários
- Todos os serviços iniciam automaticamente no boot
- Firewall configurado para permitir conexões

---

## 📝 SCRIPTS E FERRAMENTAS

### Scripts Disponíveis no SIC
```
C:\Script_SIC_Completo.cmd      → Configuração completa dos serviços
C:\Config_SSH_RDP_Automatico.cmd → Reconfigurar SSH/RDP se necessário
```

### Localização de Backup
- **App restauração:** `recuperar_restaurar_Stark`
- **Backup documentação:** `\192.168.0.72\LAN\BACKUP_CRITICO\Backup-ct100-DOCUMENTACAO-COMPLETA\`

---

## 🛠️ PROCEDIMENTOS DE ACESSO

### Acesso Via ZeroTier (Recomendado)
```bash
# SSH (Linux/Mac/Git Bash)
ssh sic@172.28.87.134
# Senha: Servmil@2026

# RDP (Windows)
mstsc /v:172.28.87.134
# Usuário: sic
# Senha: Servmil@2026
```

### Acesso Via Rede Local (na SERVMIL)
```bash
# SSH
ssh sic@192.168.1.101
# Senha: Servmil@2026

# RDP
mstsc /v:192.168.1.101
```

---

## ⚠️ PROCEDIMENTOS DE EMERGÊNCIA

### Se Serviços Não Iniciarem
1. Acessar SIC localmente
2. Executar como Administrador:
   ```cmd
   C:\Script_SIC_Completo.cmd
   ```
3. Verificar serviços:
   ```cmd
   sc query sshd
   sc query termservice
   sc query ZeroTierOneService
   ```

### Se Perder Acesso ZeroTier
1. Verificar status no painel: https://my.zerotier.com
2. Network ID: af415e486fe4483f
3. Verificar se dispositivo está autorizado
4. Reiniciar serviço ZeroTier no SIC:
   ```cmd
   net stop ZeroTierOneService
   net start ZeroTierOneService
   ```

### Recuperação de Senha
Se esquecer senha do usuário "sic":
1. Acessar com usuário "stark" ou "acib"
2. Executar:
   ```cmd
   net user sic NovaSenhaAqui
   ```
3. Atualizar este documento imediatamente

---

## 📞 CONTATOS E SUPORTE

| Função | Contato |
|--------|---------|
| **Administrador SERVMIL** | Acib ABBADE (@Acib_Abbade) |
| **Suporte Técnico IA** | Stark (CT 100 - 192.168.0.21) |
| **Infraestrutura** | PVE1 (Proxmox - 192.168.0.192) |
| **Backup/Dados** | DATASVR (192.168.0.72) |

---

## 🔄 ATUALIZAÇÕES E MANUTENÇÃO

### Histórico de Alterações
| Data | Alteração | Responsável |
|------|-----------|-------------|
| 23/04/2026 | Configuração inicial completa | Stark |
| 23/04/2026 | Instalação SSH, RDP, ZeroTier | Stark |
| 23/04/2026 | Criação usuários stark/acib | Stark |
| 24/04/2026 | **Criação usuário sic** | Acib |
| 24/04/2026 | **Definição senha Servmil@2026** | Acib |
| 24/04/2026 | **Documentação ADMINISTRAÇÃO SERVMIL** | Stark |

### Próximas Ações Recomendadas
- [ ] Trocar senhas (próxima: 90 dias)
- [ ] Verificar backups automáticos
- [ ] Testar recuperação de desastre
- [ ] Atualizar este documento se houver mudanças

---

## 🚨 ALERTAS DE SEGURANÇA

### ⚠️ NUNCA FAZER:
- ❌ Compartilhar senhas por email/WhatsApp não seguro
- ❌ Desativar antivirus permanentemente
- ❌ Abrir portas não necessárias no firewall
- ❌ Conectar dispositivos USB não confiáveis
- ❌ Desligar serviços críticos (SSH, RDP, ZeroTier)

### ✅ SEMPRE FAZER:
- ✅ Manter Windows atualizado
- ✅ Verificar logs de acesso periodicamente
- ✅ Fazer backup antes de alterações
- ✅ Usar conexão ZeroTier para acesso remoto
- ✅ Desconectar sessões RDP quando terminar

---

## 📌 NOTAS FINAIS

> **Este documento é CRÍTICO para a operação da SERVMIL.**
> 
> **Manter atualizado e em local seguro.**
> 
> **Backup em múltiplos locais recomendado.**

**Documento Versionado:** ADMINISTRACAO_SERVMIL_SIC.md  
**Versão:** 1.0  
**Classificação:** 🔴 **CONFIDENCIAL - ADMINISTRAÇÃO**  
**Próxima revisão:** Após qualquer alteração no SIC

---

*Documento criado por Stark em 24/04/2026 - 09:26*  
*Última atualização: 24/04/2026 - 09:26*

---

## 🔧 COMANDO PARA LIBERAR RDP AO USUÁRIO SIC

Execute no SIC como Administrador:

```cmd
net localgroup "Remote Desktop Users" sic /add
```

**Após executar:** Faça logoff/logon ou reinicie


---

## 🔧 COMANDOS CORRETOS PARA RDP (WINDOWS PT-BR)

### Opção 1 - Nome em Português:
```cmd
net localgroup "Usuários de Área de Trabalho Remota" sic /add
```

### Opção 2 - SID (Universal - recomendado):
```powershell
Add-LocalGroupMember -SID "S-1-5-32-555" -Member "sic"
```

### Opção 3 - Script Completo (PowerShell):
```powershell
$rdpGroup = Get-LocalGroup | Where-Object {$_.SID -eq "S-1-5-32-555"}
Add-LocalGroupMember -Group $rdpGroup -Member "sic"
Write-Host "✅ Usuario sic adicionado ao grupo RDP!"
```


---

## 🔐 SICNET - ACESSO AO SISTEMA

**Sistema:** SICNET (Software ERP SERVMIL)

| Campo | Valor |
|-------|-------|
| **Site** | https://www.sicnet.com.br/acesso |
| **Usuário** | 152097 |
| **Senha** | 53716820 |
| **Data cadastro** | 24/04/2026 |

**Funções disponíveis:**
- Código para instalação do software
- Suporte técnico
- Pagamentos e boletos
- Compra de módulos adicionais
- Alteração de cadastro


---

## 🗄️ BANCO DE DADOS SIC

**Sistema:** SICNET - Banco de Dados

| Campo | Valor |
|-------|-------|
| **Usuário BD** | servmil |
| **Senha BD** | Rcmp814k@# |
| **Requisitos senha** | Mínimo 8 caracteres, maiúscula, minúscula e número |
| **Data registro** | 24/04/2026 10:59 |


---

## 🗄️ BANCO DE DADOS SIC - ATUALIZADO

**Sistema:** SICNET - Banco de Dados

| Campo | Valor |
|-------|-------|
| **Usuário BD** | servmil |
| **Senha BD (ATUALIZADA)** | Rcmp814k |
| **Senha anterior** | Rcmp814k@# (com @#) |
| **Requisitos senha** | Mínimo 8 caracteres, maiúscula, minúscula e número |
| **Data atualização** | 24/04/2026 11:00 |

