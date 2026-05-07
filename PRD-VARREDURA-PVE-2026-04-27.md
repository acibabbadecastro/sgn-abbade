# 📋 PRD - VARREDURA PVE E INFRAESTRUTURA
## Product Requirements Document

**Data:** 27/04/2026  
**Versão:** 1.0  
**Autor:** Stark (Assistente de Acib ABBADE)  
**Destinatário:** abbade@outlook.com

---

## 1. RESUMO EXECUTIVO

Documento técnico detalhando o estado atual da infraestrutura Proxmox VE (PVE1), incluindo status de containers, recursos, atualizações pendentes e recomendações.

---

## 2. STATUS ATUAL DA INFRAESTRUTURA

### 2.1 Host Proxmox (PVE1)
- **IP:** 192.168.0.192
- **Proxmox VE:** 9.1.0
- **Kernel:** 6.17.2-1-pve
- **Hardware:** AMD Ryzen, 30GB RAM, SSD

### 2.2 Recursos Disponíveis
| Recurso | Total | Usado | Livre | Status |
|---------|-------|-------|-------|--------|
| RAM | 30 GB | 5.9 GB | 24 GB | ✅ OK |
| Disco | 65 GB | 28 GB | 34 GB | ✅ OK |
| CPU | AMD | 20% uso | 80% livre | ✅ OK |

### 2.3 Containers Ativos (9)

| CT | Nome | IP | Função | Status |
|----|------|-----|--------|--------|
| 100 | Stark | 192.168.0.21 | Orquestrador IA | ✅ Running |
| 101 | STARK | 192.168.0.240 | MailBot | ✅ Running |
| 102 | DATASVR | 192.168.0.72 | Armazenamento | ✅ Running |
| 103 | Marcos | 192.168.0.109 | PostgreSQL | ✅ Running |
| 104 | SGN | 192.168.0.99 | Sistema Web | ✅ Running |
| 105 | MAILS | 192.168.0.224 | Email Processing | ✅ Running |
| 106 | gerente-fin | DHCP | Financeiro | ✅ Running |
| 107 | 4pets | 192.168.0.200 | Site Institucional | ✅ Running |
| 109 | ADM-SERVMIL | DHCP | Administração | ✅ Running |

### 2.4 Containers Parados (4)
- CT 110: bd-servmil (Banco SERVMIL)
- CT 111: Fe-Servmil (Frontend)
- CT 112: Analista-Servmil (Analytics)
- CT 113: Hermes1 (Outro)

---

## 3. ATUALIZAÇÕES CRÍTICAS

### ⚠️ Security Updates Pendentes (114 pacotes)

**Prioridade Alta:**
- amd64-microcode (CPU vulnerabilities)
- bind9-dnsutils (DNS security)
- gnutls-bin (TLS/SSL)
- libcares2 (DNS resolver)
- chrony (NTP/time sync)

**Comando para atualização:**
```bash
apt update && apt upgrade -s
# Verificar, depois aplicar:
# apt upgrade && reboot
```

---

## 4. RECOMENDAÇÕES TÉCNICAS

### 4.1 Imediatas (48h)
1. ✅ Aplicar security updates
2. ✅ Verificar CTs parados (iniciar ou remover)
3. ✅ Confirmar backup DATASVR antes de updates

### 4.2 Médio Prazo (1 semana)
1. Documentar configuração ZeroTier VPN
2. Revisar política de backups
3. Configurar monitoramento automático

### 4.3 Longo Prazo
1. Implementar sistema de atualização automatizado
2. Criar playbooks de recuperação
3. Documentação completa da arquitetura

---

## 5. MAPEAMENTO DE SERVIÇOS

```
Internet
    ↓
Router (192.168.0.1)
    ↓
PVE1 (192.168.0.192)
    ├── CT 100: Stark (Orquestrador)
    ├── CT 101: MailBot
    ├── CT 102: DATASVR (NAS)
    ├── CT 103: PostgreSQL
    ├── CT 104: SGN (Web)
    ├── CT 105: Email Processor
    ├── CT 106: Financeiro
    ├── CT 107: 4Pets (Site)
    └── CT 109: ADM-SERVMIL
```

---

## 6. MÉTRICAS DE SAÚDE

| Métrica | Valor | Status |
|---------|-------|--------|
| Uptime estimado | 99.5% | ✅ Excelente |
| Uso médio CPU | 20% | ✅ Baixo |
| Uso RAM | 20% | ✅ Confortável |
| Uso Disco | 45% | ✅ Adequado |
| Containers Running | 9/13 | ⚠️ Revisar parados |
| Updates pendentes | 114 | 🔴 Crítico |

---

## 7. PRÓXIMAS AÇÕES

| # | Ação | Prioridade | Responsável | Prazo |
|---|------|------------|-------------|-------|
| 1 | Aplicar security updates | 🔴 Alta | root | 48h |
| 2 | Revisar CTs parados | 🟡 Média | Acib | 1 semana |
| 3 | Documentar ZeroTier | 🟢 Baixa | Stark | Contínuo |
| 4 | Configurar SSH keys | 🔴 Alta | Stark | 24h |
| 5 | Backup DATASVR | 🔴 Alta | Automático | Diário |

---

## 8. CONTATO E SUPORTE

**Responsável técnico:** Stark (CT 100)  
**Administrador:** Acib ABBADE  
**Acesso PVE:** https://192.168.0.192:8006  
**Backup DATASVR:** \\192.168.0.72\LAN\

---

**Documento gerado automaticamente em:** 27/04/2026 14:24  
**Próxima revisão:** Após aplicação de updates