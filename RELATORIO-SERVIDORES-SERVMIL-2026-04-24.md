# 📊 RELATÓRIO COMPLETO - SERVIDORES SERVMIL

**Data:** 24/04/2026  
**Responsável:** Acib ABBADE  
**Análise:** Stark (CT 100)  
**Destinatário:** abbade@outlook.com

---

## 🖥️ **SERVIDOR 1: FILESERVER (DATASVR)**

### 📍 Identificação
| Campo | Valor |
|-------|-------|
| **Container** | CT 102 |
| **Hostname** | DATASVR |
| **IP Local** | 192.168.0.72 |
| **IP ZeroTier** | N/A (apenas rede local por segurança) |
| **Sistema** | Ubuntu Server |
| **Função** | Storage central compartilhado |

### 🔐 Credenciais
| Campo | Valor |
|-------|-------|
| **Usuário root** | root |
| **Senha root** | `Rcmp814k@#1982` (diferente dos outros CTs) |
| **Acesso** | SSH + Samba |

### 💾 Storage
```
Sistema de arquivos: /dev/mapper/pve-vm--102--disk--0
Tamanho: 99G
Usado: 4.6G
Disponível: 89G
Uso: 5%
```

### 📁 Estrutura de Pastas (Samba)
**Compartilhamento:** `\\192.168.0.72\LAN\`
**Path local:** `/home/master/LAN/`

**Pastas principais:**
1. Acib/ - Pasta pessoal
2. BACKUP_CRITICO/ - Backups essenciais
3. Configs_Agentes/ - Configurações dos agentes
4. Documentacao/ - Documentação técnica
5. Documentos/ - Documentos gerais
6. Emails/ - Arquivos de email
7. Inventario/ - Controle de inventário
8. LOGS/ - Logs do sistema
9. Logs/ - Logs adicionais
10. MD/ - Arquivos Markdown
11. MEMORIES/ - Memórias compartilhadas
12. Relatorios/ - Relatórios
13. Stark_Output/ - Saídas do Stark
14. carambola/ - Outros
15. pve1/ - Configurações Proxmox

### 🔧 Serviços
- **Samba:** Compartilhamento de arquivos
- **SSH:** Acesso remoto
- **Backup automático:** Sincronização de memórias a cada 4h

### ⚠️ Status Atual
✅ **ONLINE** - Funcionando normalmente
✅ **Espaço em disco:** Saudável (5% uso)
✅ **Acessível:** Via Samba e SSH

---

## 🖥️ **SERVIDOR 2: SIC (Servidor Windows)**

### 📍 Identificação
| Campo | Valor |
|-------|-------|
| **Hostname** | DESKTOP-T022PKB |
| **IP Local** | 192.168.1.101 (anteriormente 192.168.0.253) |
| **IP ZeroTier** | 172.28.87.134 |
| **Sistema** | Windows 10 Pro |
| **Função** | Servidor de aplicações SICNET |

### 🔐 Credenciais
| Campo | Valor |
|-------|-------|
| **Usuário local** | acib, stark, sic |
| **Senha** | `Rcmp814k@#` (padrão) |
| **Usuário SICNET** | 152097 |
| **Senha SICNET** | 53716820 |
| **Banco SICNET** | servmil / Rcmp814k |

### 🔌 Configuração de Rede
- **Localização:** SERVMIL, Switch porta 43
- **Conectividade:** ZeroTier VPN (172.28.0.0/16)
- **Acesso remoto:** SSH (porta 22), RDP (porta 3389) - com problemas técnicos

### 💾 Hardware
- **SSD:** Kingston 240GB (novo, instalado 24/04/2026)
- **Fonte:** Substituída (servidor anterior tinha fonte pifada)

### 📦 Software Instalado
- Windows 10 Pro
- SICNET (sistema de gestão SERVMIL)
- PostgreSQL (banco de dados local)
- ZeroTier VPN
- OpenSSH Server

### 🌐 SICNET Web
| Página | URL |
|--------|-----|
| Principal | http://192.168.0.99 (CT 104 - obsoleto) |
| Admin BD | http://192.168.1.101/admin_bd.php |
| Dashboard | http://192.168.1.101/ |

**Nota:** Sistema migrado do CT 104 (obsoleto) para servidor físico SIC em 24/04/2026.

### ⚠️ Status Atual
⚠️ **PARCIAL** - Entregue e configurado, mas com pendências:

#### ✅ Concluído:
- Windows 10 instalado e configurado
- ZeroTier conectado (172.28.87.134)
- SICNET instalado e funcionando
- Banco de dados restaurado
- SSD Kingston 240GB instalado

#### 🔧 Pendências:
- Acesso remoto SSH via ZeroTier (problemas de firewall/antivírus)
- Configuração RDP para usuário "sic"
- Redundância de mapeamento de rede (Serviço #6)
- Mapeamento padronizado para todos os usuários

---

## 📊 **RESUMO COMPARATIVO**

| Aspecto | FILESERVER (CT 102) | SIC (Windows) |
|---------|---------------------|---------------|
| **Tipo** | Container LXC Ubuntu | Servidor físico Windows |
| **IP Local** | 192.168.0.72 | 192.168.1.101 |
| **VPN ZeroTier** | ❌ Não tem | ✅ 172.28.87.134 |
| **Acesso externo** | ❌ Apenas local | ✅ Via VPN |
| **Função** | Storage de arquivos | Aplicações SICNET |
| **Status** | ✅ 100% operacional | ⚠️ 80% operacional |

---

## 🔐 **SEGURANÇA**

### FILESERVER
✅ Senha diferente dos outros CTs (`Rcmp814k@#1982`)
✅ Apenas rede local (sem VPN)
✅ Samba configurado com autenticação
⚠️ Backup automático configurado para DATASVR

### SIC
⚠️ Múltiplos usuários locais (acib, stark, sic)
⚠️ Acesso remoto ainda com problemas (SSH/RDP)
⚠️ Windows Defender ativo (pode bloquear conexões)
⚠️ Necessita hardening de segurança

---

## 📋 **TAREFAS PENDENTES - INFRA SERVMIL**

### 🔴 Prioridade Alta
1. **Configurar acesso remoto SIC** - Resolver SSH/RDP via ZeroTier
2. **Padronizar mapeamentos de rede** - Serviço #6 (redundância)
3. **Revisar permissões de usuários** - Gabriele, Maria, Pamela (Serviço #2)

### 🟡 Prioridade Média
4. **Comprar 2 monitores 19"** - Para Pamela (novo setor)
5. **Comprar 2 CPU** - Reserva SERVMIL
6. **Cabo de energia** - Monitor do Marcel

### 🟢 Prioridade Baixa
7. **Documentar acesso SIC** - Criar manual para usuários
8. **Testar backup automático** - Verificar se DATASVR está recebendo backups

---

## 💡 **RECOMENDAÇÕES**

### Melhorias Imediatas:
1. **Resolver acesso remoto SIC** - Prioridade máxima
2. **Implementar Nginx Proxy Manager** - Gateway central para acesso web
3. **Configurar monitoramento** - Grafana/Prometheus para ambos servidores
4. **Automatizar backups SIC** - Replicar dados críticos para DATASVR

### Boas Práticas:
1. **Isolamento:** Manter FILESERVER apenas em rede local (já está correto)
2. **VPN:** SIC já tem ZeroTier (resolver problemas de conectividade)
3. **Documentação:** Manter registros atualizados (como este relatório)
4. **Backup:** Implementar backup automatizado do SIC para DATASVR

---

## 📞 **CONTEXTO DE SUPORTE**

**CT 109 (ADM-SERVMIL):** Gerencia FILESERVER
**CT 110 (BD-SERVMIL):** Banco de dados SERVMIL
**CT 111 (Fe-Servmil):** Frontend/aplicações
**CT 112 (Analista-Seg):** Monitora segurança (alerta: abbade@outlook.com)

---

*Relatório gerado em: 24/04/2026 17:22*  
*Por: Stark - Orquestrador OpenClaw CT 100*
