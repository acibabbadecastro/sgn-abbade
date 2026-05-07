# 📊 RELATÓRIO DE VARREDURA PVE
## Proxmox VE - Reconhecimento e Atualização

**Data/Hora:** 27/04/2026 14:21  
**Servidor:** pve1 (192.168.0.192)  
**Executor:** Stark (CT 100)

---

## 1. INFORMAÇÕES GERAIS DO SISTEMA

| Campo | Valor |
|-------|-------|
| **Proxmox VE** | 9.1.0 |
| **Kernel** | 6.17.2-1-pve |
| **pve-manager** | 9.1.1 |
| **Versão Ceph** | 19.2.3-pve2 |
| **ZFS** | 2.3.4-pve1 |

---

## 2. RECURSOS DO HOST

### CPU
- **Modelo:** AMD (BOGOMIPS: 86239.56)
- **Performance:** 5523550 regex/second
- **Seek Time Médio:** 0.10 ms

### Memória
| Tipo | Total | Usado | Disponível |
|------|-------|-------|------------|
| RAM | 30 GB | 5.9 GB | 24 GB |
| Swap | 8.0 GB | 0 B | 8.0 GB |

### Armazenamento
| Dispositivo | Tamanho | Usado | Disponível | % Uso |
|-------------|---------|-------|------------|-------|
| /dev/mapper/pve-root | 65 GB | 28 GB | 34 GB | 45% |
| /dev/fuse (PVE config) | 128 MB | 20 KB | 128 MB | 1% |

### Performance de Disco
- **Buffered Reads:** 498.13 MB/sec
- **Seek Time:** 0.10 ms

---

## 3. CONTAINERS LXC - STATUS GERAL

### ✅ RUNNING (9 CTs)

| VMID | Nome | Status | IP | Função |
|------|------|--------|-----|--------|
| 100 | Stark | ✅ Running | 192.168.0.21 | Orquestrador Principal |
| 101 | STARK | ✅ Running | 192.168.0.240 | MailBot |
| 102 | DATASVR | ✅ Running | 192.168.0.72 | Armazenamento/Samba |
| 103 | Marcos | ✅ Running | 192.168.0.109 | Banco de Dados |
| 104 | SGN | ✅ Running | 192.168.0.99 | Sistema Web |
| 105 | MAILS | ✅ Running | 192.168.0.224 | Processamento Emails |
| 106 | gerente-fin | ✅ Running | DHCP | Financeiro |
| 107 | 4pets | ✅ Running | 192.168.0.200 | Site Amigos de 4 Patas |
| 109 | ADM-SERVMIL | ✅ Running | DHCP | Administração SERVMIL |

### ⏹️ STOPPED (4 CTs)

| VMID | Nome | Status | Último Uso |
|------|------|--------|------------|
| 110 | bd-servmil | ⏹️ Stopped | Banco SERVMIL |
| 111 | Fe-Servmil | ⏹️ Stopped | Frontend SERVMIL |
| 112 | Analista-Servmil | ⏹️ Stopped | Análise Dados |
| 113 | Hermes1 | ⏹️ Stopped | Outro |

---

## 4. REDE E INFRAESTRUTURA

### Interfaces Principais
- **vmbr0:** 192.168.0.192/24 (rede principal)
- **zt44xluacq:** 172.28.43.237/16 (ZeroTier - VPN)
- **MAC Address:** 00:e0:4c:be:03:cb

### Container Bridges
Múltiplas interfaces veth detectadas (containers isolados via bridge)

---

## 5. ATUALIZAÇÕES PENDENTES

### ⚠️ CRÍTICO: 114 pacotes com updates disponíveis

**Principais atualizações de segurança:**

| Pacote | Versão Atual | Nova Versão | Tipo |
|--------|--------------|-------------|------|
| amd64-microcode | 3.20250311.1 | 3.20251202.1 | CPU/Microcode |
| bind9-dnsutils | 9.20.15 | 9.20.21 | DNS (Security) |
| bind9-host | 9.20.15 | 9.20.21 | DNS (Security) |
| gnutls-bin | 3.8.9-3 | 3.8.9-3+deb13u2 | TLS/SSL (Security) |
| inetutils-telnet | 2.6-3 | 2.6-3+deb13u3 | Telnet (Security) |
| libcares2 | 1.34.5 | 1.34.5-1+deb13u1 | DNS Resolver (Security) |
| chrony | 4.6.1-3 | 4.6.1-3+deb13u1 | NTP (Time Sync) |
| corosync | 3.1.9 | 3.1.10 | Cluster Communication |
| frr | 10.3.1 | 10.4.1 | Routing (BGP/OSPF) |

### Recomendação de Atualização:
```bash
# Atualizar lista de pacotes
apt update

# Verificar atualizações disponíveis
apt list --upgradable

# Aplicar atualizações (com cuidado)
apt upgrade -s  # Simular primeiro

# Se tudo OK, aplicar
apt upgrade

# Reiniciar se necessário
reboot
```

---

## 6. ANÁLISE DE SAÚDE

### ✅ Pontos Positivos
- 9 containers running (alta disponibilidade)
- Memória suficiente (24GB livres de 30GB)
- Disco OK (45% usado, 34GB livres)
- Performance de I/O excelente (498 MB/s)
- Versão Proxmox atualizada (9.1.0)

### ⚠️ Pontos de Atenção
- **114 pacotes pendentes** (incluindo security updates)
- **4 containers parados** (CT 110-113) - revisar necessidade
- **CT 107 (4Pets)** - confirmar se site está acessível
- **ZeroTier ativo** - verificar se VPN está sendo usada

### 🔴 Ações Recomendadas Imediatas
1. **Aplicar security updates** (especialmente bind9, gnutls)
2. **Revisar CTs parados** - iniciar ou remover se desnecessários
3. **Backup antes de atualizações**
4. **Verificar logs de erro** em CTs running

---

## 7. MAPEAMENTO DE SERVIÇOS

```
192.168.0.192:8006  → PVE Web Interface
192.168.0.21        → Stark (Orquestrador)
192.168.0.240       → STARK (MailBot)
192.168.0.72        → DATASVR (Samba)
192.168.0.109       → Marcos (PostgreSQL)
192.168.0.99        → SGN (Sistema Web)
192.168.0.224       → MAILS (Email Processing)
192.168.0.200       → 4Pets (Site)
DHCP                → gerente-fin, ADM-SERVMIL
```

---

## 8. PRÓXIMAS AÇÕES SUGERIDAS

| Prioridade | Ação | Responsável | Prazo |
|------------|------|-------------|-------|
| 🔴 Alta | Aplicar security updates | root | 48h |
| 🟡 Média | Revisar CTs parados (110-113) | Acib | 1 semana |
| 🟢 Baixa | Documentar configuração ZeroTier | Stark | Contínuo |

---

**Gerado por:** Stark - Assistente de Acib ABBADE  
**Data:** 27/04/2026 14:21  
**Próxima varredura:** Agendada automaticamente