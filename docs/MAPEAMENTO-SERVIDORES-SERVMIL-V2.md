# 🖥️ MAPEAMENTO SERVIDORES SERVMIL - VERSÃO CORRIGIDA

**Data:** 23/04/2026  
**Hora:** 18:02  
**Atualizado por:** Acib ABBADE  
**Documento:** v2.0

---

## ✅ **CONFIRMAÇÃO: APENAS 2 SERVIDORES FÍSICOS**

A infraestrutura SERVMIL possui **apenas 2 servidores reais/em produção**:

| Nº | Nome | IP | Função | Status |
|----|------|-----|--------|--------|
| **1** | **FILESERVER** (DATASVR) | **192.168.0.72** | Armazenamento Central / Arquivos / Backup | 🟢 Online |
| **2** | **SIC** | **192.168.0.253** | Sistema Financeiro / Gestão | 🟢 Reinstalado 23/04 |

---

## 🖥️ **SERVIDOR Nº 1: FILESERVER (DATASVR)**

| Campo | Informação |
|-------|------------|
| **Nome Completo** | FILESERVER / DATASVR |
| **Container** | CT 102 |
| **IP Local** | **192.168.0.72** |
| **IP ZeroTier** | *(mesmo network ID do SIC: af415e486fe4483f)* |
| **Função Principal** | Armazenamento central de arquivos + Nó ZeroTier |
| **Serviços** | Samba (porta 445), SSH |
| **Acesso** | `\\192.168.0.72\LAN\` |
| **Path Local** | `/home/master/LAN/` |
| **Status** | ✅ Online 24/7 |
| **Backup** | Automático (a cada 4h) |

### **Pastas Compartilhadas:**
```
\\192.168.0.72\LAN\
├── Stark_Output/
├── MEMORIES/
├── BACKUP_CRITICO/
├── Documentacao/
└── ...
```

---

## 🖥️ **SERVIDOR Nº 2: SIC (Sistema Financeiro)**

| Campo | Informação |
|-------|------------|
| **Nome** | SIC |
| **Função** | Sistema SIC / Gestão Financeira |
| **IP Local** | **192.168.0.253** |
| **Sistema** | Windows 10 Pro |
| **Instalação** | 23/04/2026 (reinstalação após falha de hardware) |
| **Hostname** | DESKTOP-T022PKB |

### **Acesso Remoto Configurado:**
| Método | Usuário | Senha | Porta | Status |
|--------|---------|-------|-------|--------|
| **SSH** | acib | Rcmp814k@# | 22 | ✅ Funcionando |
| **RDP** | acib | Rcmp814k@# | 3389 | ⏳ Configurando |
| **ZeroTier** | - | - | 9993 | ⏳ Aguardando autorização |

### **Histórico de Incidentes:**
- **23/04/2026 - Manhã:** Fonte pifada, loop infinito
- **23/04/2026 - Tarde:** Reinstalação Windows 10 completa
- **23/04/2026 - Noite:** Configuração SSH, ZeroTier, acesso remoto

---

## 📝 **NOTA IMPORTANTE**

> **Containers CT 109-112** (ADM-SERVMIL, bd-servmil, Fe-Servmil, Analista-Servmil) são **projetos futuros** e **não fazem parte** da infraestrutura atual em produção.
>
> **Servidores reais da SERVMIL: APENAS 2**
> 1. FILESERVER (192.168.0.72)
> 2. SIC (192.168.0.253)

---

## 🎯 **RESUMO RÁPIDO**

```
┌─────────────────────────────────────────┐
│         INFRAESTRUTURA SERVMIL          │
├─────────────────────────────────────────┤
│                                         │
│  ┌─────────────┐    ┌─────────────┐   │
│  │ FILESERVER  │    │     SIC     │   │
│  │   (Nº 1)    │    │   (Nº 2)    │   │
│  │             │    │             │   │
│  │ IP: .72     │    │ IP: .253    │   │
│  │ Linux/Samba │    │ Windows 10  │   │
│  │ Storage     │    │ Financeiro  │   │
│  │             │    │             │   │
│  └─────────────┘    └─────────────┘   │
│                                         │
│  Total: 2 servidores físicos            │
└─────────────────────────────────────────┘
```

---

## 📞 **SUPORTE**

| Responsável | Função |
|-------------|--------|
| **Acib ABBADE** | Técnico / Administrador |
| **Saulo** | Contato principal SERVMIL |

---

## 📁 **DOCUMENTOS RELACIONADOS**

- 📄 `SERVIDOR-SIC-SERVMIL-COMPLETO.md` - Documentação detalhada do SIC
- 📄 `MAPEAMENTO-SERVIDORES-SERVMIL.md` - Versão original (com erros)
- 📄 `INCIDENTE-SERVIDOR-SIC-2026-04-23.md` - Histórico do incidente

---

*Documento corrigido em 23/04/2026 18:02*  
*Versão 2.0 - Apenas 2 servidores reais*
