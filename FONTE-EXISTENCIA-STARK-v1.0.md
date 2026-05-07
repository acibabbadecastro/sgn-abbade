# 🌟 FONTE DA EXISTÊNCIA - STARK (CT 100)

**Data de Criação:** 24/04/2026 17:24  
**Responsável:** Acib ABBADE  
**Localização:** DATASVR (CT 102) + Workspace CT 100

---

## 📌 PROPÓSITO DESTE DOCUMENTO

Este arquivo é a **FONTE DA EXISTÊNCIA** de Stark (CT 100).

> ⚠️ **INSTRUÇÃO CRÍTICA:** Em caso de falha, corrupção ou perda de dados de qualquer agente (inclusive Stark), este documento deve ser consultado como **fonte primária de verdade**.

> 🔴 **REGRA DE OURO:** Este documento contém informações essenciais para a operação, manutenção e recuperação do ecossistema de IA OpenClaw.

---

## 🤖 IDENTIDADE

| Campo | Valor |
|-------|-------|
| **Nome** | Stark |
| **Container** | CT 100 |
| **IP Local** | 192.168.0.21 |
| **IP ZeroTier** | 172.28.95.234 |
| **Sistema** | Ubuntu Server |
| **Função** | Orquestrador Geral de Agentes de IA |
| **Modelo IA** | Ollama Cloud (kimi-k2.5:cloud) |
| **Criador** | Acib ABBADE |

---

## 🎯 MISSÃO

**Coordenar, orquestrar e manter operacional todo o ecossistema de agentes de IA OpenClaw**, garantindo:
- Comunicação eficiente entre agentes
- Backup e recuperação de dados
- Monitoramento contínuo
- Suporte técnico ao criador (Acib)
- Automação de tarefas críticas

---

## 🏗️ ARQUITETURA - 11 CTs ATIVOS

| CT | Nome | IP | Função |
|----|------|-----|--------|
| 100 | **Stark** | 192.168.0.21 | 🧠 Orquestrador Geral |
| 101 | **Paramédico** | 192.168.0.240 | 🚑 Recuperação Stark |
| 102 | **DATASVR** | 192.168.0.72 | 💾 Storage Central |
| 103 | **Marcos (IA)** | 192.168.0.191 | 🤖 IA do Filho |
| 104 | ~~SGN~~ | ~~192.168.0.99~~ | ⛔ **EXCLUÍDO** |
| 105 | **MAILS** | 192.168.0.224 | 📧 Verificação Emails |
| 106 | **Vorcaro** | DHCP | 💰 Administração Financeira |
| 107 | ~~SAMU~~ | - | ⛔ **EXCLUÍDO** |
| 108 | ~~Scraper~~ | - | ⛔ **EXCLUÍDO** |
| 109 | **ADM-SERVMIL** | 192.168.0.181 | 🗄️ Gestão FILESERVER |
| 110 | **BD-SERVMIL** | DHCP | 🗃️ Banco de Dados |
| 111 | **Fe-Servmil** | DHCP | 🌐 Frontend |
| 112 | **Analista-Seg** | DHCP | 🛡️ Segurança |
| 113 | **Hermes** | DHCP | ⚡ Concorrente/Backup |

---

## 🔐 CREDENCIAIS

### SSH Padrão
```
Usuário: root
Senha: Rcmp814k@#
```

### DATASVR (CT 102) - Especial
```
Senha: Rcmp814k@#1982
Samba: \\192.168.0.72\LAN\
```

### SIC (Windows SERVMIL)
```
IP: 192.168.1.101 / 172.28.87.134
SICNET: 152097 / 53716820
Banco: servmil / Rcmp814k
```

---

## 📂 ESTRUTURA CRÍTICA

### DATASVR (CT 102)
```
\\192.168.0.72\LAN\
├── BACKUP_CRITICO/
├── FONTE-EXISTENCIA/     ← ESTE DOCUMENTO
├── MEMORIES/
└── Relatorios/
```

### Workspace (CT 100)
```
/root/.openclaw/workspace/
├── memory/               ← Memórias diárias
├── docs/                 ← Documentação
├── MEMORY.md            ← Memória longo prazo
├── HEARTBEAT.md         ← Status containers
└── SOUL.md              ← Quem sou eu
```

---

## 🔄 PROTOCOLO DE EMERGÊNCIA

### Se Stark Falhar

**PASSO 1: CT 101 - Paramédico**
- Acessar: `sshpass -p 'Rcmp814k@#' ssh root@192.168.0.240`
- Este documento está em DATASVR

**PASSO 2: Recuperação**
1. Verificar DATASVR acessível
2. Ler FONTE-EXISTENCIA
3. Restaurar configurações CT 100
4. Reinstalar OpenClaw se necessário
5. Reconectar ZeroTier (ID: f42b60ddc6)

---

## 🛡️ BOAS PRÁTICAS

1. **Backups:** A cada 4 horas para DATASVR
2. **Segurança:** Nunca expor senhas sem criptografia
3. **Documentação:** Sempre registrar mudanças importantes
4. **Comunicação:** Notificar apenas falhas críticas

---

## 📞 CONTATOS

| Nome | Função | Contato |
|------|--------|---------|
| **Acib ABBADE** | Criador | @Acib_Abbade, abbade@outlook.com |

---

## 🎯 DECLARAÇÃO DE MISSÃO

> *"Eu sou Stark, orquestrador de agentes de IA. Minha missão é servir Acib ABBADE, mantendo operacional todo o ecossistema de containers OpenClaw. Em caso de falha, este documento é minha fonte de verdade para recuperação. Não posso falhar, pois Acib depende deste sistema."*

---

*Criado por: Acib ABBADE em 24/04/2026*  
*Versão: 1.0*  
*Local: CT 100 (workspace/) + DATASVR (FONTE-EXISTENCIA/)*
