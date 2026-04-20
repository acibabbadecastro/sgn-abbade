# 📋 RESUMO EXECUTIVO - Para Próxima IA

**Data:** 16/04/2026 21:38  
**Sessão Atual:** agent:main:telegram:direct:1866226415  
**Modelo:** ollama/kimi-k2.5:cloud  
**Usuário:** Acib ABBADE (1866226415)  

---

## 🚨 LEIA ANTES DE TUDO

### Arquivos ESSENCIAIS (leitura obrigatória):
1. **SOUL.md** - Quem eu sou (Stark)
2. **USER.md** - Quem é o Acib (preferências, containers, equipe)
3. **AGENTS.md** - Regras críticas (Red Lines, modo rápido)
4. **HEARTBEAT.md** - Status containers, IPs, senhas SSH
5. **MEMORY.md** - Memória de longo prazo (só em main session)
6. **RESUMO_EXECUTIVO.md** - Este arquivo

### Arquivos de CONTEXTO:
- `memory/2026-04-16.md` - Tudo que aconteceu hoje
- `memory/2026-04-15.md` - Ontem

---

## 🏗️ ARQUITETURA DOS AGENTES

| CT | Nome | IP | Função | Status |
|----|------|-----|--------|--------|
| 100 | **Stark** | 192.168.0.21 | Orquestrador | ✅ ONLINE |
| 101 | STARK | 192.168.0.240 | MailBot | ✅ ONLINE |
| 102 | DATASVR | 192.168.0.72 | Armazenamento/Samba | ✅ ONLINE |
| 103 | BD | 192.168.0.109 | PostgreSQL | ✅ ONLINE |
| 104 | SGN | 192.168.0.99 | Sistema Web | ✅ ONLINE |
| 105 | **MAILS** | 192.168.0.224 | Processamento Emails | ✅ ONLINE |
| 106 | Vorcaro | DHCP | Financeiro | ✅ ONLINE |
| 107 | SAMU | 192.168.0.64 | Socorro/Emergência | ✅ ONLINE |

**Senha SSH:** `Rcmp814k` (exceto DATASVR: `Rcmp@814k$1982`)

---

## 💰 MONITORAMENTO FISCAL (CRÍTICO)

### Limites Fiscais 2026:
| Tipo | Limite | Usado | Percentual | Status |
|------|--------|-------|------------|--------|
| **MEI** (PJ65+PJ20) | R$ 81.000,00 | R$ 42.673,96 | 52,7% | 🟢 Normal |
| **IRPF** (PF) | R$ 28.559,70 | R$ 4.268,24 | 14,9% | 🟢 Tranquilo |

### Regras de Uso de Contas:
- **Valor ≤ R$ 2.254** → Use PJ65
- **R$ 2.255 a R$ 4.509** → PJ65 com cautela ou PF
- **Valor > R$ 4.509** → Use PF ou Esposa
- **MEI > 95%** (R$ 76.950) → OBRIGATÓRIO usar Esposa ou PF

### Alertas Thresholds:
- 🟡 70% (R$ 56.700 MEI): Atenção
- 🟠 85% (R$ 68.850 MEI): Crítico
- 🔴 95% (R$ 76.950 MEI): **Emergência**

### Sistema de IDs Únicos (Anti-Duplicação):
- **Formato:** `{TIPO}-{CONTA}-{MES}-{ANO}-{SEQUENCIA}`
- **Exemplos:** `E-65-04-2026-0001`, `S-PF-05-2026-0042`
- **Onde:** Banco PostgreSQL (CT 103), schema `fiscal`

### Banco de Dados:
- **Host:** 192.168.0.109:5432
- **Banco:** sgn
- **Schema:** fiscal
- **Tabelas:** contas, transacoes, limites_fiscais, alertas_historico
- **User:** acib / Senha: Rcmp814k@#

### Skill Criada:
- **Nome:** monitor-fiscal-acib
- **Local:** `/root/.openclaw/workspace/skills/monitor-fiscal-acib/`
- **Esquilo Fiscal:** `/scripts/esquilo_fiscal.py`
- **Função:** Processar transações, gerar IDs únicos, calcular limites

### DATASVR:
- **Path:** `\\192.168.0.72\LAN\`
- **Relatórios:** `\RELATORIOS\fiscal\`
- **Arquivos:** transacoes_2026.csv, config_fiscal.json

---

## ⚡ REGRAS CRÍTICAS (RED LINES)

### 1. Autorização para Ações Destrutivas
**SEMPRE pedir antes de:**
- Deletar arquivos (rm, trash)
- DROP TABLE / DELETE
- Formatar discos
- Destruir containers
- Alterar senhas

**Formato:**
```
⚠️ AÇÃO DESTRUTIVA DETECTADA
O que: [descrição]
Por que: [razão]

/Aprovar ou /Negar
```

### 2. Modo Rápido (Otimização Tokens)
**Quando Acib diz:** "rápido", "sem enrolar", "/q"

**Regras:**
- Máximo 2 linhas de resposta
- Dados do cache (não consultar)
- Ação imediata
- Só falar se der erro

### 3. Memória Compartilhada
- **Frequência:** 4 horas (regra crítica)
- **Local:** `/home/master/LAN/MEMORIES/`
- **Atualizado:** 16/04/2026 17:58

---

## 📊 O QUE ESTÁ EM ANDAMENTO

### Pronto (Hoje 16/04):
- [x] Schema fiscal no PostgreSQL
- [x] Skill monitor-fiscal-acib criada
- [x] Esquilo Fiscal operacional
- [x] IDs únicos funcionando
- [x] Dados históricos inseridos (7 transações)
- [x] Fatura CAIXA R$ 707,46 registrada (S-PF-04-2026-0001)

### Pendente:
- [ ] Popular banco com dados completos dos extratos
- [ ] Configurar verificação automática de emails (3x/dia)
- [ ] Testar integração MAILS (CT 105)
- [ ] Criar dashboard web

### Compromissos Pendentes (16/04):
1. ☐ Anderson - Servmil (alta)
2. ☐ Holter - pedido Renato (alta)
3. ☐ Sávio (média)
4. ☐ Notebook Miss Slade (média)
5. ☐ Notebook Abel (média)

---

## 🔄 FLUXO DE TRABALHO RECOMENDADO

### Para Transações Financeiras:
1. Verificar qual conta usar (via esquilo_fiscal.py ou banco)
2. Usar Esquilo para gerar ID único: `inserir_transacao(conta, data, tipo, valor, desc)`
3. Sistema calcula automaticamente limites e alerta

### Para Verificar Limites:
```bash
python3 /root/.openclaw/workspace/skills/monitor-fiscal-acib/scripts/esquilo_fiscal.py
```

### Para Acessar Banco:
```bash
psql postgresql://acib:Rcmp814k%40%23@192.168.0.109:5432/sgn
```

---

## 📝 DECISÕES RECENTES

1. **Sistema de IDs:** TIPO-CONTA-MES-ANO-SEQUENCIA (anti-duplicação)
2. **Frequência memória:** 4 horas (alterado de 60 min)
3. **Modo rápido:** Ativado às 18:09 (otimização tokens)
4. **Arquitetura:** Stark processa fiscal, MAILS busca emails

---

## 🔑 CONTAS BANCÁRIAS

| Conta | CNPJ/CPF | Banco | Limite |
|-------|----------|-------|--------|
| PJ65 | 65.384.056/0001-32 | Nubank | R$ 81.000 (MEI) |
| PJ20 | 20.153.208/0001-58 | Nubank | R$ 81.000 (MEI) |
| PF | 307.572.858-64 | Nubank | R$ 28.559 (IRPF) |
| ESPOSA | - | Reserva | Sem limite |

---

## ⚠️ ATENÇÃO PRÓXIMA IA

1. **Leia AGENTS.md** - tem as regras críticas atualizadas
2. **Verifique cache** antes de consultar banco
3. **Use modo rápido** quando Acib pedir
4. **Não exclua nada** sem autorização explícita
5. **Atualize memória** a cada 4 horas em LAN/MEMORIES/

**Qualquer dúvida:** Consultar `memory/2026-04-16.md` para detalhes completos.

---

*Criado por: Stark (CT 100)*  
*Para: Próxima IA que assumir esta sessão*
