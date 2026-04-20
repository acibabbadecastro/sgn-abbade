# 🗄️ BANCO DE DADOS - CONFIGURAÇÃO COMPLETA

**Documento:** 01_Configuracao.md  
**Data:** 09/04/2026 13:36  
**Autor:** Stark (CT 100)  
**Versão:** 1.0  
**Status:** ✅ Operacional

---

## 📋 IDENTIFICAÇÃO

| Campo | Informação |
|-------|------------|
| **Sistema** | Sistema Abbade |
| **Tipo** | PostgreSQL |
| **Versão** | 15+ (padrão Debian 12) |
| **Container** | CT 103 (Supervisor) |
| **Responsável** | Acib ABBADE |

---

## 🔌 CONEXÃO

### **PARÂMETROS DE ACESSO:**

```bash
# Conexão Básica
Host:     192.168.0.109
Porta:    5432
Banco:    financas (ou sgn)
Usuário:  acib
Senha:    Rcmp814k@#
```

### **STRING DE CONEXÃO (DSN):**

```
postgresql://acib:Rcmp814k@#@192.168.0.109:5432/financas
```

### **COMANDO PSQL:**

```bash
psql -h 192.168.0.109 -p 5432 -U acib -d financas
```

### **TESTE DE CONEXÃO:**

```bash
# Testar conectividade
pg_isready -h 192.168.0.109 -p 5432 -U acib

# Resultado esperado:
# 192.168.0.109:5432 - accepting connections
```

---

## 📂 SCHEMAS DO SISTEMA

### **SCHEMAS EXISTENTES (7):**

| Schema | Finalidade | Tabelas Principais | Status |
|--------|------------|-------------------|--------|
| **estoque** | Gestão de produtos e estoque | produtos, categorias, movimentacoes | ✅ Pronto |
| **clientes** | Cadastro de clientes e fornecedores | clientes, fornecedores | ✅ Pronto |
| **os** | Ordens de Serviço | ordens_servico, orcamentos, status_os | ✅ Pronto |
| **financeiro** | Controle financeiro | contas_bancarias, movimentacoes, categorias | ✅ Pronto |
| **fornecedores** | Gestão de fornecedores | fornecedores, produtos_fornecedor | ✅ Pronto |
| **garantia** | Controle de garantias | garantias, acompanhamentos | ⏳ Em desenvolvimento |
| **agenda** | Compromissos e visitas | compromissos, visitas, lembretes | ✅ Pronto |

---

## 📊 DETALHAMENTO POR SCHEMA

### **1️⃣ SCHEMA: estoque**

**Finalidade:** Gestão de produtos, categorias e movimentações de estoque

**Tabelas:**

```sql
-- Produtos
CREATE TABLE estoque.produtos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    categoria_id INTEGER REFERENCES estoque.categorias(id),
    preco_custo DECIMAL(10,2),
    preco_venda DECIMAL(10,2),
    quantidade INTEGER DEFAULT 0,
    estoque_minimo INTEGER DEFAULT 5,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categorias
CREATE TABLE estoque.categorias (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT
);

-- Movimentações
CREATE TABLE estoque.movimentacoes (
    id SERIAL PRIMARY KEY,
    produto_id INTEGER REFERENCES estoque.produtos(id),
    tipo VARCHAR(20) NOT NULL, -- 'entrada' ou 'saida'
    quantidade INTEGER NOT NULL,
    motivo VARCHAR(255),
    os_id INTEGER REFERENCES os.ordens_servico(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Consultas Úteis:**

```sql
-- Produtos com estoque baixo
SELECT p.nome, p.quantidade, p.estoque_minimo
FROM estoque.produtos p
WHERE p.quantidade <= p.estoque_minimo;

-- Histórico de movimentações de um produto
SELECT m.*, p.nome as produto
FROM estoque.movimentacoes m
JOIN estoque.produtos p ON m.produto_id = p.id
WHERE p.id = 1
ORDER BY m.created_at DESC;
```

---

### **2️⃣ SCHEMA: clientes**

**Finalidade:** Cadastro de clientes e fornecedores

**Tabelas:**

```sql
-- Clientes
CREATE TABLE clientes.clientes (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cpf_cnpj VARCHAR(20),
    email VARCHAR(255),
    telefone VARCHAR(20),
    endereco TEXT,
    tipo VARCHAR(20) DEFAULT 'PF', -- PF ou PJ
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Fornecedores
CREATE TABLE clientes.fornecedores (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cnpj VARCHAR(20),
    email VARCHAR(255),
    telefone VARCHAR(20),
    endereco TEXT,
    contato VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Clientes Cadastrados (Exemplos):**

| ID | Nome | Tipo | Contato |
|----|------|------|---------|
| 1 | Servmil | PJ | Anderson |
| 2 | Ana | PF | - |
| 3 | Herbert | PF | Herbertcastro08@hotmail.com |
| 4 | Fernando (Mercadinho) | PJ | - |
| 5 | Juninho (PRIME) | PJ | - |

---

### **3️⃣ SCHEMA: os**

**Finalidade:** Gestão de Ordens de Serviço

**Tabelas:**

```sql
-- Ordens de Serviço
CREATE TABLE os.ordens_servico (
    id SERIAL PRIMARY KEY,
    cliente_id INTEGER REFERENCES clientes.clientes(id),
    numero_os VARCHAR(20) UNIQUE NOT NULL,
    status VARCHAR(50) DEFAULT 'aberta',
    equipamento VARCHAR(255),
    defeito_relatado TEXT,
    servico_realizado TEXT,
    valor_pecas DECIMAL(10,2),
    valor_mao_obra DECIMAL(10,2),
    valor_total DECIMAL(10,2),
    data_entrada TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_saida TIMESTAMP,
    tecnico_responsavel VARCHAR(255),
    observacoes TEXT
);

-- Orçamentos
CREATE TABLE os.orcamentos (
    id SERIAL PRIMARY KEY,
    os_id INTEGER REFERENCES os.ordens_servico(id),
    descricao TEXT NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) DEFAULT 'pendente', -- pendente, aprovado, reprovado
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_aprovacao TIMESTAMP
);

-- Status OS
CREATE TABLE os.status_os (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    ordem INTEGER DEFAULT 0,
    cor VARCHAR(20) -- ex: 'verde', 'amarelo', 'vermelho'
);
```

**Status Padrão:**

| ID | Status | Ordem | Cor |
|----|--------|-------|-----|
| 1 | Aberta | 1 | Verde |
| 2 | Em Análise | 2 | Amarelo |
| 3 | Aguardando Peça | 3 | Laranja |
| 4 | Aguardando Aprovação | 4 | Azul |
| 5 | Em Andamento | 5 | Roxo |
| 6 | Concluída | 6 | Verde |
| 7 | Entregue | 7 | Azul |
| 8 | Cancelada | 8 | Vermelho |

---

### **4️⃣ SCHEMA: financeiro**

**Finalidade:** Controle financeiro completo

**Tabelas:**

```sql
-- Contas Bancárias
CREATE TABLE financeiro.contas_bancarias (
    id SERIAL PRIMARY KEY,
    banco VARCHAR(100),
    agencia VARCHAR(20),
    conta VARCHAR(20),
    tipo VARCHAR(20), -- Corrente, Poupança, PJ, PF
    saldo_atual DECIMAL(10,2) DEFAULT 0,
    ativa BOOLEAN DEFAULT true
);

-- Movimentações
CREATE TABLE financeiro.movimentacoes (
    id SERIAL PRIMARY KEY,
    conta_id INTEGER REFERENCES financeiro.contas_bancarias(id),
    tipo VARCHAR(20) NOT NULL, -- 'receita' ou 'despesa'
    categoria_id INTEGER REFERENCES financeiro.categorias(id),
    descricao TEXT NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    data_movimento DATE NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    os_id INTEGER REFERENCES os.ordens_servico(id),
    comprovante VARCHAR(255)
);

-- Categorias
CREATE TABLE financeiro.categorias (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    tipo VARCHAR(20) NOT NULL, -- 'receita' ou 'despesa'
    descricao TEXT
);
```

**Contas Cadastradas:**

| ID | Banco | Tipo | Saldo |
|----|-------|------|-------|
| 1 | Nubank | PJ65 | R$ 12,81 |
| 2 | Nubank | PJ20 | -R$ 185,31 |
| 3 | Nubank | PF | R$ 20,81 |

**Categorias de Receita:**

| ID | Categoria |
|----|-----------|
| 1 | Venda de Produto |
| 2 | Serviço - Mão de Obra |
| 3 | Peça de Reposição |
| 4 | Garantia Estendida |

**Categorias de Despesa:**

| ID | Categoria |
|----|-----------|
| 1 | Compra de Peças |
| 2 | Impostos |
| 3 | Aluguel |
| 4 | Energia |
| 5 | Internet |
| 6 | Software/Assinaturas |

---

### **5️⃣ SCHEMA: fornecedores**

**Finalidade:** Gestão de fornecedores e produtos por fornecedor

**Tabelas:**

```sql
-- Fornecedores (espelho de clientes.fornecedores)
CREATE TABLE fornecedores.fornecedores (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cnpj VARCHAR(20),
    email VARCHAR(255),
    telefone VARCHAR(20),
    site VARCHAR(255),
    prazo_entrega_dias INTEGER DEFAULT 7,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Produtos por Fornecedor
CREATE TABLE fornecedores.produtos_fornecedor (
    id SERIAL PRIMARY KEY,
    fornecedor_id INTEGER REFERENCES fornecedores.fornecedores(id),
    produto_id INTEGER REFERENCES estoque.produtos(id),
    codigo_fornecedor VARCHAR(50),
    preco_custo DECIMAL(10,2),
    lead_time_dias INTEGER DEFAULT 7,
    ultimo_pedido DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Fornecedores Identificados:**

| Fornecedor | Qtd Pedidos | Valor Total |
|------------|-------------|-------------|
| Aplicação RDB | 11x | R$ 8.014,81 |
| ALL PRO IMPORTS | 4x | R$ 2.758,80 |
| ROGERIO ESPEDITO | 13x | R$ 2.268,28 |
| ATACADAO | 10x | R$ 1.529,73 |
| ATUAL PECAS | 14x | R$ 1.124,50 |
| HOUTER DO BRASIL | 2x | R$ 1.222,12 |

---

### **6️⃣ SCHEMA: garantia**

**Finalidade:** Controle de garantias de serviços

**Tabelas:**

```sql
-- Garantias
CREATE TABLE garantia.garantias (
    id SERIAL PRIMARY KEY,
    os_id INTEGER REFERENCES os.ordens_servico(id),
    data_inicio DATE NOT NULL,
    data_fim DATE NOT NULL,
    dias_garantia INTEGER DEFAULT 90,
    status VARCHAR(50) DEFAULT 'ativa', -- ativa, vencida, acionada
    observacoes TEXT
);

-- Acompanhamentos
CREATE TABLE garantia.acompanhamentos (
    id SERIAL PRIMARY KEY,
    garantia_id INTEGER REFERENCES garantia.garantias(id),
    data_acompanhamento DATE NOT NULL,
    tipo VARCHAR(50), -- ligacao, email, whatsapp
    resultado TEXT,
    proximo_contato DATE
);
```

**Política de Garantia:**

| Serviço | Dias de Garantia |
|---------|------------------|
| Formatação | 30 dias |
| Troca de Tela | 90 dias |
| Reparo de Placa | 90 dias |
| Instalação de SSD | 90 dias |

---

### **7️⃣ SCHEMA: agenda**

**Finalidade:** Gestão de compromissos e visitas

**Tabelas:**

```sql
-- Compromissos
CREATE TABLE agenda.compromissos (
    id SERIAL PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    data_hora TIMESTAMP NOT NULL,
    duracao_minutos INTEGER DEFAULT 60,
    tipo VARCHAR(50), -- visita, ligacao, prazo, reuniao
    cliente_id INTEGER REFERENCES clientes.clientes(id),
    os_id INTEGER REFERENCES os.ordens_servico(id),
    status VARCHAR(50) DEFAULT 'pendente', -- pendente, concluido, cancelado
    prioridade VARCHAR(20) DEFAULT 'media', -- baixa, media, alta, urgente
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Visitas
CREATE TABLE agenda.visitas (
    id SERIAL PRIMARY KEY,
    compromisso_id INTEGER REFERENCES agenda.compromissos(id),
    endereco TEXT NOT NULL,
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),
    confirmado BOOLEAN DEFAULT false,
    data_confirmação TIMESTAMP
);

-- Lembretes
CREATE TABLE agenda.lembretes (
    id SERIAL PRIMARY KEY,
    compromisso_id INTEGER REFERENCES agenda.compromissos(id),
    minutos_antes INTEGER DEFAULT 30,
    enviado BOOLEAN DEFAULT false,
    canal VARCHAR(50), -- telegram, whatsapp, email
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 🔧 MANUTENÇÃO DO BANCO

### **BACKUP MANUAL:**

```bash
# Backup completo (todos os schemas)
pg_dump -h 192.168.0.109 -U acib -d financas > backup_$(date +%Y%m%d_%H%M%S).sql

# Backup de um schema específico
pg_dump -h 192.168.0.109 -U acib -d financas -n estoque > backup_estoque_$(date +%Y%m%d).sql

# Backup comprimido
pg_dump -h 192.168.0.109 -U acib -d financas | gzip > backup_$(date +%Y%m%d_%H%M%S).sql.gz
```

### **RESTORE:**

```bash
# Restore de backup
gunzip backup_20260409_020000.sql.gz
psql -h 192.168.0.109 -U acib -d financas < backup_20260409_020000.sql
```

### **LIMPEZA (VACUUM):**

```sql
-- Vacuum em todo o banco
VACUUM ANALYZE;

-- Vacuum em tabela específica
VACUUM ANALYZE os.ordens_servico;
```

### **CONSULTAS DE MANUTENÇÃO:**

```sql
-- Tamanho do banco
SELECT pg_size_pretty(pg_database_size('financas'));

-- Tamanho por tabela
SELECT 
    schemaname,
    tablename,
    pg_size_pretty(pg_total_relation_size(schemaname||'.'||tablename)) AS size
FROM pg_tables
WHERE schemaname IN ('estoque', 'clientes', 'os', 'financeiro', 'fornecedores', 'garantia', 'agenda')
ORDER BY pg_total_relation_size(schemaname||'.'||tablename) DESC;

-- Últimos backups (se houver tabela de log)
SELECT * FROM backup_log ORDER BY data_backup DESC LIMIT 10;
```

---

## 📈 MONITORAMENTO

### **CONEXÕES ATIVAS:**

```sql
SELECT 
    datname,
    numbackends,
    xact_commit,
    xact_rollback,
    blks_read,
    blks_hit
FROM pg_stat_database
WHERE datname = 'financas';
```

### **TABELAS MAIS ACESSADAS:**

```sql
SELECT 
    schemaname,
    relname,
    seq_scan,
    idx_scan,
    n_tup_ins,
    n_tup_upd,
    n_tup_del
FROM pg_stat_user_tables
WHERE schemaname IN ('estoque', 'clientes', 'os', 'financeiro')
ORDER BY (seq_scan + idx_scan) DESC;
```

---

## 🔐 SEGURANÇA

### **USUÁRIOS DO BANCO:**

```sql
-- Listar usuários
SELECT usename, usecreatedb, usesuper FROM pg_user;

-- Permissões do usuário 'acib'
\du acib
```

### **RECOMENDAÇÕES:**

1. ✅ Senha forte (já implementado: `Rcmp814k@#`)
2. ✅ Acesso apenas na rede local (192.168.0.x)
3. ✅ Backup diário automatizado (pendente)
4. ⏳ Implementar SSL (pendente)
5. ⏳ Criar usuário de leitura para relatórios (pendente)

---

## 📞 SUPORTE

| Problema | Solução |
|----------|---------|
| Conexão recusada | Verificar se CT 103 está ONLINE |
| Senha inválida | Confirmar senha: `Rcmp814k@#` |
| Banco não existe | Usar `financas` ou `sgn` |
| Schema não encontrado | Especificar schema: `estoque.produtos` |

---

## 📝 HISTÓRICO DE REVISÕES

| Versão | Data | Autor | Alterações |
|--------|------|-------|------------|
| 1.0 | 09/04/2026 | Stark | Criação inicial |

---

**Última atualização:** 09/04/2026 13:36  
**Próxima revisão:** 16/04/2026 (7 dias)  
**Responsável:** Stark (CT 100)
