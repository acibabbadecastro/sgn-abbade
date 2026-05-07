# 🖥️ MAPEAMENTO SERVIDORES SERVMIL - VERSÃO FINAL

**Data:** 23/04/2026  
**Hora:** 18:02  
**Atualizado por:** Acib ABBADE  
**Documento:** v3.0 (FINAL)

---

## ✅ **CONFIRMAÇÃO FINAL: 2 SERVIDORES + TOPOLOGIA**

```
┌─────────────────────────────────────────────────────────────┐
│                    TOPOLOGIA SERVMIL                        │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│   ┌──────────────┐         ┌─────────────────────────────┐  │
│   │   INTERNET   │         │      REDE LOCAL 192.168.0   │  │
│   │              │         │                             │  │
│   │              │◄────────┤  ┌───────────────────────┐   │  │
│   │              │  ZeroTier  │   FILESERVER (Nº 1)   │   │  │
│   │              │   (VPN)   │   IP: 192.168.0.72    │   │  │
│   │              │           │   Storage / Samba     │   │  │
│   │              │           └───────────────────────┘   │  │
│   │              │                     │                  │  │
│   │   NUVEM      │◄────────────────────┤                  │  │
│   │              │      ZeroTier Mesh  │                  │  │
│   │              │    (af415e486f...)  │                  │  │
│   │              │◄────────────────────┘                  │  │
│   │              │           │                           │  │
│   └──────────────┘           │                           │  │
│                              │                           │  │
│   ┌──────────────┐          │                           │  │
│   │   VOCÊ       │◄─────────┘                           │  │
│   │  (Remoto)    │    Acesso via ZeroTier              │  │
│   │              │                                     │  │
│   └──────────────┘           ┌────────────────────────┐│  │
│                              │   SIC (Nº 2)           ││  │
│                              │   IP Local: .253       ││  │
│                              │   IP ZT: 172.x.x.x     ││  │
│                              │   Windows 10 / Finance ││  │
│                              │   ★ NÓ ZEROTIER ★      ││  │
│                              └────────────────────────┘│  │
│                                                          │  │
└──────────────────────────────────────────────────────────┘  │
```

---

## 🖥️ **SERVIDOR Nº 1: FILESERVER (DATASVR/CT 102)**

| Campo | Informação |
|-------|------------|
| **Nome** | FILESERVER / DATASVR |
| **Número** | **1** |
| **Container** | CT 102 |
| **IP Local** | **192.168.0.72** |
| **ZeroTier** | ❌ Não participa (apenas local) |
| **Função** | Armazenamento Central / Backup |
| **Acesso** | `\\192.168.0.72\LAN\` |
| **Serviços** | Samba (445), SSH |
| **Status** | 🟢 Online 24/7 |

---

## 🖥️ **SERVIDOR Nº 2: SIC (NÓ ZERO TIER)** ⭐

| Campo | Informação |
|-------|------------|
| **Nome** | SIC |
| **Número** | **2** |
| **IP Local** | **192.168.0.253** |
| **IP ZeroTier** | ⏳ *Aguardando atribuição* |
| **Network ID** | `af415e486fe4483f` |
| **Função** | Sistema Financeiro / **NÓ ZERO TIER** |
| **Sistema** | Windows 10 Pro (reinstalado 23/04) |
| **Acesso Local** | SSH: acib / Rcmp814k@# |
| **Acesso Remoto** | ZeroTier (quando autorizado) |
| **Status** | 🟢 Operacional |

### **Responsabilidade do SIC:**
- ✅ Sistema Financeiro da SERVMIL
- ✅ **Ponto de entrada ZeroTier** para acesso remoto
- ✅ Gateway para FILESERVER via ZeroTier

---

## 🌐 **COMO FUNCIONA O ACESSO REMOTO**

### **Cenário: Você fora da SERVMIL**

```
┌─────────┐      ZeroTier VPN      ┌─────────┐      Local      ┌──────────┐
│   VOCÊ  │  ═══════════════════►  │   SIC   │  ─────────────► │ FILESV   │
│ (Remoto)│      (encriptado)       │  (.253) │   (192.168.0)   │  (.72)   │
│         │                          │  ★ NÓ ★ │                 │          │
└─────────┘                          └─────────┘                 └──────────┘
                                                                         
IP ZeroTier: 172.x.x.x                IP Local: .253                   IP: .72
```

**Passo a passo:**
1. Você conecta via ZeroTier (rede `af415e486fe4483f`)
2. Entra no SIC pelo IP ZeroTier (ex: `172.16.x.x`)
3. Do SIC, acessa FILESERVER normalmente (`192.168.0.72`)

---

## 📝 **RESUMO FINAL**

| Servidor | IP Local | ZeroTier | Função |
|----------|----------|----------|--------|
| **FILESERVER** | 192.168.0.72 | ❌ Apenas local | Storage |
| **SIC** | 192.168.0.253 | ✅ **NÓ ZEROTIER** | Financeiro + Gateway |

**Total: 2 servidores**  
**Nós ZeroTier: 1 (SIC)**  
**Acesso remoto: Via SIC → FILESERVER**

---

## 🎯 **PRÓXIMOS PASSOS**

1. ⏳ **Autorizar SIC** no painel ZeroTier (my.zerotier.com)
2. ⏳ **Anotar IP ZeroTier** atribuído ao SIC
3. ⏳ **Testar acesso:** Você → ZeroTier → SIC → FILESERVER

---

*Documento finalizado em 23/04/2026 18:02*  
*Topologia corrigida: SIC = Nó ZeroTier, FILESERVER = Apenas local*
