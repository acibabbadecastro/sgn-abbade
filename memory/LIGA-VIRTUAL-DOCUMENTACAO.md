# 🏆 LIGA VIRTUAL DA COPA 2026 - MEMÓRIA DO SISTEMA

**Criado:** 2026-05-05  
**Status:** 🟢 Em Desenvolvimento  
**Prazo:** 11 de Junho de 2026 (37 dias)

---

## 📋 **RESUMO DO PROJETO**

Plataforma de bolão da Copa com:
- ✅ Times via WhatsApp
- ✅ Ranking duplo (individual + times)
- ✅ Ranking híbrido (Top 10 público + completo privado)
- ✅ Copa com eliminação (mata-mata)
- ✅ Apostas com PIX
- ✅ Prêmio: Camisa do Brasil (se Brasil na final)

---

## 🏗️ **INFRAESTRUTURA**

### **Container Principal:**
- **CT:** 114
- **Nome:** liga-virtual
- **IP:** 192.168.0.114
- **Recursos:** 4 CPU, 4GB RAM, 16GB Storage
- **OS:** Ubuntu 25.04
- **Stack:** Node.js 20 + PostgreSQL 17 + React

### **Container Clone (Failover):**
- **CT:** 115 (a criar)
- **Nome:** liga-virtual-backup
- **IP:** 192.168.0.115
- **Sincronização:** PostgreSQL replication

### **Backups:**
- **Local:** DATASVR (CT 102)
- **Path:** `/mnt/data/LAN/Projetos/Liga-Virtual/`
- **Frequência:** Diário (02:00) + Snapshots

---

## 🗄️ **BANCO DE DADOS (11 Tabelas)**

1. **users** - Usuários
2. **times** - Times virtuais
3. **time_membros** - Membros dos times
4. **competicoes** - Competições (Liga/Copa)
5. **copa_chaves** - Chaves do mata-mata
6. **games** - Jogos reais
7. **user_predictions** - Previsões
8. **bolaos** - Bolões privados
9. **apostas_times** - Apostas entre times
10. **pagamentos** - Transações PIX
11. **premios_especiais** - Prêmios especiais

**Schema completo:** `/root/.openclaw/workspace/projetos/liga-virtual-copa-2026/backend/database/schema.sql`

---

## 💰 **MODELO DE NEGÓCIOS**

| Receita | Valor | Descrição |
|---------|-------|-----------|
| **Taxa Plataforma** | 10% | Sobre prêmios |
| **API Futebol** | R$ 50-150/mês | Dados em tempo real |
| **Patrocínios** | Variável | Marcas parceiras |

**Custo Camisa Brasil:** ~R$ 375 (plataforma paga)

---

## 📅 **CRONOGRAMA**

| Semana | Data | Entregável |
|--------|------|------------|
| 1 | 05-11 Mai | Backend + DB |
| 2 | 12-18 Mai | Frontend |
| 3 | 19-25 Mai | Integrações |
| 4 | 26 Mai-01 Jun | Testes Beta |
| 5 | 02-08 Jun | Lançamento |
| **COPA** | **11 Jun** | **PRAZO** |

---

## 📁 **ARQUIVOS DO PROJETO**

| Arquivo | Local |
|---------|-------|
| **Código** | `/root/liga-virtual-copa-2026/` (CT 107 temporário) |
| **Documentação** | `/root/.openclaw/workspace/projetos/liga-virtual-copa-2026/DOCUMENTACAO-COMPLETA.md` |
| **Schema DB** | `/root/.openclaw/workspace/projetos/liga-virtual-copa-2026/backend/database/schema.sql` |
| **Backups** | `/mnt/data/LAN/Projetos/Liga-Virtual/` |
| **Memória** | `/root/.openclaw/workspace/memory/LIGA-VIRTUAL-DOCUMENTACAO.md` |

---

## 🔐 **SEGURANÇA**

- ✅ Senhas com bcrypt
- ✅ JWT para autenticação
- ✅ LGPD compliance (termos opcionais)
- ✅ Backups automáticos
- ✅ Failover com CT 115

---

## 📊 **RANKING HÍBRIDO**

| Acesso | Visibilidade |
|--------|--------------|
| Visitante | Top 10 |
| Cadastrado | Top 100 |
| Admin | Completo |

---

## 🏆 **PREMIAÇÃO ESPECIAL**

**Camisa do Brasil:**
- Condição: Brasil na final
- Ganhador: #1 ranking na data da final
- Custo: R$ 375 (plataforma)
- Personalização: Nome + número

---

## 📞 **CONTATOS**

- **Suporte:** suporte@ligavirtual.com.br
- **WhatsApp:** (12) 98801-3359
- **Telegram:** @acib_abbade_bot

---

**Última atualização:** 2026-05-05 11:30  
**Próxima revisão:** 2026-05-12
