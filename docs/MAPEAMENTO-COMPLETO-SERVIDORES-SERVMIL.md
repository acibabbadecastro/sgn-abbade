# 🖥️ MAPEAMENTO COMPLETO - SERVIDORES SERVMIL

**Data:** 23/04/2026  
**Hora:** 17:58  
**Scan realizado por:** Stark
**Documento:** v1.0

---

## 📊 **RESUMO DA INFRAESTRUTURA**

| Total de Hosts Ativos | Servidores Identificados | Pendente de Verificação |
|----------------------|-------------------------|------------------------|
| 14+ | 6 confirmados | Alguns containers DHCP |

---

## 🖥️ **SERVIDORES FÍSICOS DA SERVMIL (APENAS 2)**

> ⚠️ **ATUALIZAÇÃO:** A infraestrutura SERVMIL possui apenas **2 servidores reais**:
> 1. **FILESERVER** (armazenamento central)
> 2. **SIC** (sistema financeiro)
> 
> Os demais containers (CT 109-112) são **projetos futuros/em desenvolvimento**.

---

### **1. FILESERVER (DATASVR / CT 102) - Servidor Nº 1**
| Campo | Informação |
|-------|------------|
| **Nome** | FILESERVER (DATASVR) |
| **Número** | **1** (Servidor principal) |
| **CT** | 102 |
| **IP** | **192.168.0.72** |
| **Função** | Armazenamento Central / Arquivos / Backup |
| **Serviços** | Samba (445), SSH, Storage |
| **Status** | ✅ Online |
| **Local** | `\\192.168.0.72\LAN\` |

### **2. SIC (Servidor Nº 2) - Financeiro** ⭐ RECÉM-REINSTALADO
| Campo | Informação |
|-------|------------|
| **Nome** | SIC |
| **Número** | **2** (Servidor secundário) |
| **IP** | **192.168.0.253** |
| **Função** | Sistema SIC / Financeiro |
| **Sistema** | Windows 10 Pro (reinstalado 23/04) |
| **Acesso** | SSH (acib/Rcmp814k@#), RDP (configurando) |
| **Status** | 🟢 Operacional |

### **4. ADM-SERVMIL (CT 109) - Administração**
| Campo | Informação |
|-------|------------|
| **Nome** | ADM-SERVMIL |
| **CT** | 109 |
| **IP** | DHCP (dinâmico) |
| **Função** | Administração SERVMIL |
| **Status** | ⏳ Verificar IP atual |

### **5. bd-servmil (CT 110) - Banco de Dados**
| Campo | Informação |
|-------|------------|
| **Nome** | bd-servmil |
| **CT** | 110 |
| **IP** | DHCP (dinâmico) |
| **Função** | Banco de Dados SERVMIL |
| **Status** | ⏳ Verificar IP atual |

### **6. Fe-Servmil (CT 111) - Frontend**
| Campo | Informação |
|-------|------------|
| **Nome** | Fe-Servmil |
| **CT** | 111 |
| **IP** | DHCP (dinâmico) |
| **Função** | Frontend / Interface |
| **Status** | ⏳ Verificar IP atual |

### **7. Analista-Servmil (CT 112) - Análise**
| Campo | Informação |
|-------|------------|
| **Nome** | Analista-Servmil |
| **CT** | 112 |
| **IP** | DHCP (dinâmico) |
| **Função** | Análise de Dados |
| **Status** | ⏳ Verificar IP atual |

---

## 🌐 **TOPOLOGIA DE REDE**

```
                    ┌─────────────────────┐
                    │   INTERNET/GATEWAY  │
                    │      192.168.0.1    │
                    └──────────┬──────────┘
                               │
              ┌────────────────┼────────────────┐
              │                │                │
    ┌─────────▼─────────┐     │     ┌──────────▼──────────┐
    │   PROXMOX HOST      │     │     │   OUTROS HOSTS      │
    │   192.168.0.192     │     │     │   (CTs 100-112)     │
    └─────────┬───────────┘     │     └─────────────────────┘
              │                 │
    ┌─────────┼─────────────────┼──────────────────────────┐
    │         │                 │                          │
    │         │                 │                          │
┌───▼───┐ ┌───▼───┐ ┌─────────▼──────────┐ ┌──────────────▼──────────────┐
│DATASVR│ │  SGN  │ │   CONTAINERS       │ │         SERVIDORES          │
│ .72   │ │  .99  │ │   SERVMIL (DHCP)   │ │         FÍSICOS             │
└───────┘ └───────┘ │                    │ │                             │
                    │  • ADM (CT 109)    │ │  • SIC (.253) - Windows 10  │
                    │  • BD (CT 110)     │ │    (Servidor Nº 2)          │
                    │  • Fe (CT 111)     │ │                             │
                    │  • Analista (112)  │ └─────────────────────────────┘
                    └────────────────────┘
```

---

## 📋 **INVENTÁRIO DE IPs**

### **IPs Fixos (Estáticos):**
| IP | Host | Função |
|----|------|--------|
| 192.168.0.1 | Gateway/Roteador | Acesso internet |
| 192.168.0.72 | DATASVR (CT 102) | Storage |
| 192.168.0.99 | SGN (CT 104) | Web Server |
| 192.168.0.192 | Proxmox Host | Virtualização |
| 192.168.0.253 | **SIC** | **Servidor Nº 2 - Windows** |

### **Outros Hosts Ativos (scan):**
| IP | Status |
|----|--------|
| 192.168.0.21 | Stark (CT 100) |
| 192.168.0.118 | ? (verificar) |
| 192.168.0.193 | ? (verificar) |
| 192.168.0.231 | ? (verificar) |
| 192.168.0.124 | ? (verificar) |
| 192.168.0.183 | ? (verificar) |
| 192.168.0.222 | ? (verificar) |
| 192.168.0.229 | ? (verificar) |
| 192.168.0.122 | ? (verificar) |
| 192.168.0.27 | ? (verificar) |

---

## ⚠️ **PENDÊNCIAS - VERIFICAÇÃO COMPLETA**

### **Containers SERVMIL com DHCP:**
- [ ] **CT 109 ADM-SERVMIL** → Descobrir IP atual
- [ ] **CT 110 bd-servmil** → Descobrir IP atual
- [ ] **CT 111 Fe-Servmil** → Descobrir IP atual
- [ ] **CT 112 Analista-Servmil** → Descobrir IP atual

### **Servidor Nº 1:**
- [ ] Identificar qual é o servidor principal da SERVMIL
- [ ] Verificar IP e função

---

## 🎯 **PRÓXIMOS PASSOS SUGERIDOS**

1. **Verificar IPs dos containers DHCP**
2. **Identificar o Servidor Nº 1**
3. **Mapear todos os serviços em cada servidor**
4. **Criar documentação de failover/backup**
5. **Testar conectividade entre servidores**

---

## 📞 **INFORMAÇÕES DE CONTATO**

| Responsável | Função |
|-------------|--------|
| **Saulo** | Contato principal SERVMIL |
| **Bryan** | Técnico/Operacional |
| **Daniela** | Administrativa |
| **Gabriele** | RH |
| **Juliana** | Operações |
| **Ana** | Suporte |

---

## 📝 **DOCUMENTOS RELACIONADOS**

- 📁 `/root/.openclaw/workspace/memory/MAPEAMENTO-SERVIDORES-SERVMIL.md`
- 📁 `/root/.openclaw/workspace/docs/SERVIDOR-SIC-SERVMIL-COMPLETO.md`
- 📁 `/root/.openclaw/workspace/memory/INCIDENTE-SERVIDOR-SIC-2026-04-23.md`
- 📁 `/root/.openclaw/workspace/memory/servicos-servmil-2026-04.md`

---

*Mapeamento realizado em 23/04/2026 17:58*  
*Por: Stark - Sistema de Gestão*
