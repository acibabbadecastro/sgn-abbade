# 🏆 LIGA VIRTUAL DA COPA 2026 - DOCUMENTAÇÃO COMPLETA

**Data de Criação:** 2026-05-05  
**Criador:** Acib ABBADE  
**Desenvolvedor:** Stark 🤖  
**Status:** 🟢 Em Desenvolvimento  
**Prazo:** 11 de Junho de 2026 (Início da Copa)

---

## 📋 **VISÃO GERAL DO SISTEMA**

### **O Que É:**
Plataforma completa de bolão da Copa do Mundo 2026 com:
- Times virtuais via WhatsApp
- Ranking duplo (individual + equipes)
- Sistema de apostas com PIX
- Copa com eliminação (mata-mata)
- Prêmio especial (Camisa do Brasil)

### **Público-Alvo:**
- Famílias
- Grupos de amigos
- Empresas (team building)
- Torcedores em geral

---

## 🏗️ **ARQUITETURA DO SISTEMA**

### **Infraestrutura:**

```
┌─────────────────────────────────────────────────────────┐
│  CONTAINER 114 - LIGA VIRTUAL (Produção)               │
│  IP: 192.168.0.114                                     │
│  Hostname: liga-virtual                                │
│  Recursos: 4 CPU, 4GB RAM, 16GB Storage                │
│                                                         │
│  ┌─────────────────────────────────────────────────┐   │
│  │  Node.js v20.18.1 + Express                      │   │
│  │  PostgreSQL 17                                   │   │
│  │  React + Next.js (Frontend)                      │   │
│  │  API-Football (Dados em tempo real)             │   │
│  └─────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────┐
│  CONTAINER 114-CLONE (Failover/Backup)                 │
│  IP: 192.168.0.115 (a definir)                         │
│  Sincronização: Replicação em tempo real               │
│  Ativação: Automática ou manual em caso de falha       │
└─────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────┐
│  DATASVR (CT 102) - Backups                            │
│  Path: /mnt/data/LAN/Projetos/Liga-Virtual/            │
│  Backup: Diário (02:00) + Snapshots                    │
└─────────────────────────────────────────────────────────┘
```

---

## 🗄️ **ESTRUTURA DO BANCO DE DADOS**

### **Tabelas Principais (11 tabelas):**

| Tabela | Descrição | Campos Principais |
|--------|-----------|-------------------|
| **users** | Usuários do sistema | id, apelido, email, senha_hash, pontos_totais, ranking |
| **times** | Times virtuais | id, nome, whatsapp_link, criador_id, pontos_totais |
| **time_membros** | Membros dos times | time_id, user_id, cargo, saldo_apostas |
| **competicoes** | Competições (Liga/Copa) | id, nome, tipo, data_inicio, data_fim |
| **copa_chaves** | Chaves do mata-mata | competicao_id, rodada, time_a, time_b, vencedor |
| **games** | Jogos reais da Copa | time_a, time_b, placar, fase, estadio |
| **user_predictions** | Previsões dos usuários | user_id, game_id, escalacao, placar, pontos |
| **bolaos** | Bolões privados | criador_id, nome, valor_entrada, premio_total |
| **apostas_times** | Apostas entre times | time_a, time_b, valor, vencedor |
| **pagamentos** | Transações PIX | user_id, valor, tipo, pix_comprovante |
| **premios_especiais** | Prêmios especiais | nome, condicao_json, ganhador_id, camisa_tamanho |

### **Relacionamentos:**

```
users (1) ──< time_membros (>1) >── times (1)
users (1) ──< user_predictions (>1) >── games (1)
times (1) ──< copa_chaves (>1) >── competicoes (1)
users (1) ──< pagamentos (>1) >── bolaos (1)
```

---

## 🔧 **STACK TECNOLÓGICO**

### **Backend:**
| Tecnologia | Versão | Finalidade |
|------------|--------|------------|
| Node.js | 20.18.1 | Runtime |
| Express | 4.x | Framework web |
| PostgreSQL | 17 | Banco de dados |
| pg (node-postgres) | 8.x | Driver PostgreSQL |
| JWT | - | Autenticação |
| bcrypt | 5.x | Hash de senhas |

### **Frontend:**
| Tecnologia | Versão | Finalidade |
|------------|--------|------------|
| React | 18.x | Framework UI |
| Next.js | 14.x | SSR/SSG |
| TailwindCSS | 3.x | Estilização |
| Chart.js | 4.x | Gráficos/ranking |

### **Integrações:**
| Serviço | Finalidade | Custo |
|---------|------------|-------|
| API-Football | Dados dos jogos | R$ 50-150/mês |
| PIX API | Pagamentos | Grátis (banco) |
| WhatsApp | Links/Notificações | Grátis (links) |
| Telegram | Notificações | Grátis (bot) |

---

## 📁 **ESTRUTURA DE ARQUIVOS DO PROJETO**

```
/root/liga-virtual-copa-2026/
├── backend/
│   ├── src/
│   │   ├── controllers/
│   │   │   ├── auth.controller.js       # Login/Cadastro
│   │   │   ├── users.controller.js      # Usuários
│   │   │   ├── times.controller.js      # Times
│   │   │   ├── predictions.controller.js # Previsões
│   │   │   ├── ranking.controller.js    # Ranking
│   │   │   ├── bolao.controller.js      # Bolões
│   │   │   └── pagamentos.controller.js # PIX
│   │   ├── models/
│   │   │   ├── User.js
│   │   │   ├── Time.js
│   │   │   ├── Game.js
│   │   │   ├── Prediction.js
│   │   │   └── Bolao.js
│   │   ├── routes/
│   │   │   ├── auth.routes.js
│   │   │   ├── users.routes.js
│   │   │   ├── times.routes.js
│   │   │   ├── predictions.routes.js
│   │   │   ├── ranking.routes.js
│   │   │   └── bolao.routes.js
│   │   ├── middleware/
│   │   │   ├── auth.middleware.js       # JWT
│   │   │   ├── validation.middleware.js # Validações
│   │   │   └── rateLimit.middleware.js  # Rate limiting
│   │   └── app.js                       # App principal
│   ├── database/
│   │   ├── schema.sql                   # Schema completo
│   │   ├── seeds.sql                    # Dados iniciais
│   │   └── migrations/                  # Migrações
│   ├── tests/
│   │   └── *.test.js
│   ├── .env                             # Variáveis de ambiente
│   ├── .env.example                     # Exemplo
│   └── package.json
├── frontend/
│   ├── src/
│   │   ├── pages/
│   │   │   ├── index.jsx                # Homepage
│   │   │   ├── ranking.jsx              # Ranking
│   │   │   ├── login.jsx                # Login
│   │   │   ├── cadastro.jsx             # Cadastro
│   │   │   ├── time/[id].jsx            # Tela do time
│   │   │   ├── previsoes/[jogo].jsx     # Fazer previsões
│   │   │   ├── bolao/[id].jsx           # Bolão
│   │   │   └── perfil.jsx               # Perfil
│   │   ├── components/
│   │   │   ├── Header.jsx
│   │   │   ├── Footer.jsx
│   │   │   ├── RankingTable.jsx
│   │   │   ├── TimeCard.jsx
│   │   │   └── PredictionForm.jsx
│   │   ├── services/
│   │   │   └── api.js                   # API calls
│   │   └── styles/
│   │       └── globals.css
│   ├── public/
│   │   └── images/
│   ├── next.config.js
│   └── package.json
├── mobile/ (Futuro)
│   └── lib/
├── docs/
│   ├── API.md                           # Documentação da API
│   ├── TERMOS_DE_USO.md                 # Termos
│   ├── POLITICA_PRIVACIDADE.md          # LGPD
│   └── MANUAL_USUARIO.md                # Guia do usuário
├── scripts/
│   ├── backup.sh                        # Backup automático
│   ├── deploy.sh                        # Deploy
│   └── monitor.sh                       # Monitoramento
├── .gitignore
├── README.md
└── DOCUMENTACAO-COMPLETA.md             # ESTE ARQUIVO
```

---

## 🔐 **SEGURANÇA E LGPD**

### **Proteções Implementadas:**

| Proteção | Implementação | Status |
|----------|---------------|--------|
| **Senhas** | bcrypt + salt | ✅ |
| **JWT** | Tokens com expiração | ✅ |
| **HTTPS** | Certificado SSL | ⏳ |
| **Rate Limiting** | 100 req/min por IP | ⏳ |
| **SQL Injection** | Prepared statements | ✅ |
| **XSS** | Sanitização de input | ⏳ |
| **LGPD** | Consentimento registrado | ✅ |

### **Dados dos Usuários (LGPD):**

| Dado | Retenção | Acesso |
|------|----------|--------|
| Nome/Apelido | Enquanto ativo | Público (ranking) |
| Email | 5 anos após inatividade | Só admins |
| Senha | Enquanto ativo | Nunca (hash) |
| Previsões | 2 anos | Público (após jogo) |
| Pagamentos | 5 anos | Só admins |
| WhatsApp | Enquanto ativo | Time members |

---

## 📊 **SISTEMA DE RANKING**

### **Ranking Híbrido:**

| Tipo de Acesso | Visibilidade |
|----------------|--------------|
| **Visitante** | Top 10 (público) |
| **Cadastrado** | Top 100 (completo) |
| **Admin** | Completo + filtros |

### **Cálculo de Pontos:**

| Categoria | Pontos |
|-----------|--------|
| Placar Exato | +15 |
| Gols Marcados (cada) | +5 |
| Assistência Prevista | +3 |
| Escalação Correta (cada) | +1 |
| Formação Correta | +5 |
| MVP Correto | +10 |
| Pênalti Perdido Previsto | +10 |
| Pênalti Defendido Previsto | +15 |
| Cartão Amarelo | -2 |
| Cartão Vermelho | -5 |

---

## 💰 **SISTEMA DE PAGAMENTOS (PIX)**

### **Fluxo de Aposta:**

```
1. Criador define bolão (R$ 20/jogador)
         ↓
2. Participantes pagam via PIX
         ↓
3. Sistema confirma automaticamente
         ↓
4. Pool formado (ex: 20 x R$ 20 = R$ 400)
         ↓
5. Plataforma retém 10% (R$ 40)
         ↓
6. Vencedor recebe 70% (R$ 280)
7. Segundo lugar 20% (R$ 80)
```

### **Chaves PIX Suportadas:**
- [ ] CPF
- [ ] Email
- [ ] Telefone
- [ ] Aleatória

---

## 🏆 **PREMIAÇÃO ESPECIAL**

### **Camisa do Brasil:**

| Campo | Valor |
|-------|-------|
| **Condição** | Brasil chega à final |
| **Prêmio** | Camisa Nike 2026 oficial |
| **Personalização** | Nome + número |
| **Custo** | ~R$ 375 (plataforma paga) |
| **Frete** | Ganhador paga |
| **Ganhador** | #1 do ranking na data da final |

---

## 📅 **CRONOGRAMA DE DESENVOLVIMENTO**

| Semana | Data | Entregáveis | Status |
|--------|------|-------------|--------|
| **1** | 05-11 Mai | Backend + Banco de Dados | 🟢 Em andamento |
| **2** | 12-18 Mai | Frontend básico | ⏳ Pendente |
| **3** | 19-25 Mai | Integrações (PIX, WhatsApp) | ⏳ Pendente |
| **4** | 26 Mai-01 Jun | Testes Beta | ⏳ Pendente |
| **5** | 02-08 Jun | Lançamento Oficial | ⏳ Pendente |
| **Copa** | 11 Jun | **PRAZO FINAL** | ⏳ |

---

## 🔄 **SISTEMA DE BACKUP**

### **Backups Automáticos:**

| Tipo | Frequência | Local | Retenção |
|------|------------|-------|----------|
| **Banco de Dados** | Diário (02:00) | DATASVR | 30 dias |
| **Código** | Por commit | GitHub | Permanente |
| **Arquivos** | Diário (03:00) | DATASVR | 7 dias |
| **Snapshot CT** | Semanal (Domingo) | Proxmox | 4 semanas |

### **Comandos de Backup:**

```bash
# Backup do banco
pg_dump -U ligavirtual liga_virtual > /mnt/data/LAN/Projetos/Liga-Virtual/backup-$(date +%Y%m%d).sql

# Backup de arquivos
rsync -avz /root/liga-virtual-copa-2026/ /mnt/data/LAN/Projetos/Liga-Virtual/code/

# Snapshot Proxmox
pct snapshot 114 backup-daily
```

---

## 🚨 **SISTEMA DE FAILOVER (CLONE CT 114)**

### **Container Clone (CT 115):**

| Item | Configuração |
|------|--------------|
| **CT ID** | 115 (a criar) |
| **Nome** | liga-virtual-backup |
| **IP** | 192.168.0.115 |
| **Recursos** | 4 CPU, 4GB RAM, 16GB Storage |
| **Sincronização** | Replicação PostgreSQL em tempo real |
| **Ativação** | Manual ou automática (health check) |

### **Procedimento de Failover:**

```
1. Detectar falha no CT 114
         ↓
2. Parar replicação
         ↓
3. Promover CT 115 para primário
         ↓
4. Atualizar DNS/load balancer
         ↓
5. Notificar usuários (manutenção)
         ↓
6. Reparar CT 114
         ↓
7. Reverter replicação (114 → 115)
```

---

## 📱 **INTEGRAÇÃO WHATSAPP**

### **Tipos de Notificação:**

| Evento | Mensagem | Gatilho |
|--------|----------|---------|
| **Novo Jogo** | "Jogo disponível! Faça suas previsões" | 2h antes do jogo |
| **Resultado** | "Seu time fez X pontos!" | Após jogo |
| **Convite Time** | "Você foi convidado para o time X" | Convite enviado |
| **Pagamento** | "Pagamento confirmado!" | PIX confirmado |
| **Lembrete** | "Faltam 30min para o jogo!" | 30min antes |

### **Links de Convite:**

```
Formato: https://ligavirtual.com.br/time/{slug}/entrar
Exemplo: https://ligavirtual.com.br/time/fc-familia-silva/entrar
```

---

## 🎯 **REGRAS DE NEGÓCIO**

### **Classificação para Copa:**

1. Top 16 da Liga → Copa
2. Critérios de desempate:
   - Maior número de vitórias
   - Maior saldo de pontos
   - Maior número de acertos no placar
   - Sorteio

### **Mata-Mata:**

1. 1º vs 16º, 2º vs 15º, etc.
2. Vencedor avança, perdedor eliminado
3. Critérios de desempate (ver acima)

---

## 📞 **SUPORTE E CONTATO**

| Canal | Contato | Uso |
|-------|---------|-----|
| **Email** | suporte@ligavirtual.com.br | Geral |
| **WhatsApp** | (12) 98801-3359 | Urgente |
| **Telegram** | @acib_abbade_bot | Suporte técnico |
| **GitHub** | github.com/acibabbadecastro/liga-virtual | Bugs/Features |

---

## 📝 **HISTÓRICO DE VERSÕES**

| Versão | Data | Mudanças | Status |
|--------|------|----------|--------|
| **0.1** | 05/05/2026 | Criação do projeto, schema DB | ✅ Concluído |
| **0.2** | 12/05/2026 | Backend API | ⏳ Pendente |
| **0.3** | 19/05/2026 | Frontend básico | ⏳ Pendente |
| **0.4** | 26/05/2026 | Integrações | ⏳ Pendente |
| **1.0** | 08/06/2026 | Lançamento oficial | ⏳ Pendente |

---

## 🔑 **VARIÁVEIS DE AMBIENTE (.env)**

```bash
# Servidor
NODE_ENV=development
PORT=3000
HOST=192.168.0.114

# Banco de Dados
DB_HOST=localhost
DB_PORT=5432
DB_NAME=liga_virtual
DB_USER=ligavirtual
DB_PASSWORD=SEGREDO

# JWT
JWT_SECRET=SEGREDO
JWT_EXPIRES_IN=7d

# API Futebol
API_FOOTBALL_KEY=SEGREDO
API_FOOTBALL_URL=https://v3.football.api-sports.io

# PIX
PIX_KEY=SEGREDO
PIX_SECRET=SEGREDO

# WhatsApp
WHATSAPP_TOKEN=SEGREDO

# Email
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USER=SEGREDO
SMTP_PASS=SEGREDO
```

---

## ✅ **CHECKLIST DE LANÇAMENTO**

### **Pré-Lançamento:**
- [ ] Backend API completa
- [ ] Frontend responsivo
- [ ] Banco de dados configurado
- [ ] SSL/HTTPS ativo
- [ ] Backups automáticos
- [ ] Monitoramento ativo
- [ ] Termos de uso
- [ ] Política de privacidade

### **Pós-Lançamento:**
- [ ] Beta testers (10-20 pessoas)
- [ ] Coletar feedback
- [ ] Ajustar bugs
- [ ] Marketing (WhatsApp, redes)
- [ ] Suporte 24/7 (durante Copa)

---

**Documentação criada em:** 2026-05-05 11:30  
**Última atualização:** 2026-05-05 11:30  
**Próxima revisão:** 2026-05-12

**Backups em:**
- `/root/.openclaw/workspace/projetos/liga-virtual-copa-2026/DOCUMENTACAO-COMPLETA.md`
- `/mnt/data/LAN/Projetos/Liga-Virtual/Docs/DOCUMENTACAO-COMPLETA.md`
- `/root/.openclaw/workspace/memory/LIGA-VIRTUAL-DOCUMENTACAO.md`
