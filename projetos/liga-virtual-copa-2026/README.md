# 🏆 LIGA VIRTUAL DA COPA 2026

**Descrição:** Plataforma de bolão da Copa com times virtuais, ranking duplo e premiação especial

**Criado:** 2026-05-05  
**Criador:** Acib ABBADE  
**Desenvolvedor:** Stark 🤖

---

## 📋 **FUNCIONALIDADES**

### **1. Sistema de Usuários**
- ✅ Cadastro com termos opcionais
- ✅ Login/Logout (JWT)
- ✅ Perfil com avatar/foto
- ✅ Configurações de privacidade

### **2. Times Virtuais**
- ✅ Criar time via WhatsApp
- ✅ Convites por link
- ✅ Ranking de times
- ✅ Apostas internas e externas

### **3. Competições**
- ✅ Liga Classificatória (todos vs todos)
- ✅ Copa (mata-mata, eliminação)
- ✅ Top 16 classificam para Copa
- ✅ Árvore de chaves visual

### **4. Previsões**
- ✅ Escalação (11 jogadores)
- ✅ Formação tática
- ✅ Placar exato
- ✅ Gols marcadores
- ✅ Pênaltis perdidos/defendidos
- ✅ Cartões amarelos/vermelhos
- ✅ MVP da partida

### **5. Ranking Híbrido**
- ✅ Top 10 público (visitantes)
- ✅ Completo só para cadastrados
- ✅ Individual + Times

### **6. Pagamentos**
- ✅ PIX integrado
- ✅ Pool de apostas
- ✅ Distribuição automática
- ✅ Taxa 10% plataforma

### **7. Prêmio Especial**
- ✅ Camisa do Brasil (se Brasil na final)
- ✅ Plataforma paga (~R$ 375)
- ✅ Personalização (nome + número)
- ✅ Frete por conta do ganhador

---

## 🗄️ **ESTRUTURA DO BANCO DE DADOS**

```sql
-- Ver arquivo: database/schema.sql
```

---

## 🛠️ **TECNOLOGIAS**

| Camada | Tecnologia |
|--------|------------|
| **Backend** | Node.js + Express |
| **Banco** | PostgreSQL |
| **Frontend** | React + Next.js |
| **Mobile** | Flutter (futuro) |
| **Pagamentos** | PIX API |
| **WhatsApp** | Links + API (opcional) |
| **Dados Futebol** | API-Football.com |

---

## 📅 **CRONOGRAMA**

| Semana | Entregável |
|--------|------------|
| 1 | Backend + Banco de Dados |
| 2 | Site (ranking, times, previsões) |
| 3 | WhatsApp + PIX |
| 4 | Testes Beta |
| 5 | Lançamento Oficial |

---

## 📁 **ESTRUTURA DE ARQUIVOS**

```
liga-virtual-copa-2026/
├── backend/
│   ├── src/
│   │   ├── controllers/
│   │   ├── models/
│   │   ├── routes/
│   │   └── middleware/
│   ├── database/
│   │   └── schema.sql
│   └── package.json
├── frontend/
│   ├── src/
│   │   ├── pages/
│   │   ├── components/
│   │   └── services/
│   └── package.json
├── mobile/ (futuro)
│   └── lib/
└── docs/
    └── TERMOS_DE_USO.md
```

---

## 🚀 **COMO RODAR (DESENVOLVIMENTO)**

```bash
# Backend
cd backend
npm install
npm run dev

# Frontend
cd frontend
npm install
npm run dev
```

---

**Status:** 🟢 Em Desenvolvimento  
**Próxima Atualização:** 2026-05-12
