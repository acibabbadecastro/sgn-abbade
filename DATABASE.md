# DATABASE.md - Sistema Financeiro - Schema PostgreSQL

**Data de criação:** 2026-04-05  
**Localização:** DATASVR (CT 102) - PostgreSQL 17.7  
**Acesso:** `http://192.168.0.109:8080/` (Adminer)  
**Banco:** `financas`  
**Usuário:** `acib`  
**Senha:** `Rcmp814k@#`

---

## 📋 Resumo da Arquitetura

O banco foi projetado para gerenciar **4 contas bancárias** do Acib com:
- Controle de saldos e limites
- Registro de movimentações (receitas, despesas, transferências)
- Categorização automática
- Cadastro de fornecedores/clientes
- Histórico de saldos
- Filtros avançados para consultas

---

## 🗄️ Schema: `financeiro`

### **1. TABELAS**

#### `bancos` - Instituições Financeiras
| Coluna | Tipo | Descrição |
|--------|------|-----------|
| id | SERIAL | PK auto-increment |
| codigo | VARCHAR(10) | Código Febraban (260=Nubank) |
| nome | VARCHAR(100) | Nome completo |
| nome_curto | VARCHAR(30) | Apelido (Nubank, BB) |

**Bancos cadastrados:** Nubank (260), Banco do Brasil (001), Itaú (341), Inter (077)

---

#### `contas_bancarias` - Contas do Acib
| Coluna | Tipo | Descrição |
|--------|------|-----------|
| id | SERIAL | PK |
| apelido | VARCHAR(50) | Como você chama (ex: "Nubank PJ65") |
| tipo_pessoa | VARCHAR(2) | PF ou PJ |
| banco_codigo | VARCHAR(10) | FK → bancos |
| agencia | VARCHAR(20) | Agência |
| conta_numero | VARCHAR(30) | Número da conta |
| conta_digito | VARCHAR(5) | Dígito |
| conta_tipo | VARCHAR(20) | corrente/poupanca/salario/pagamento |
| cpf_cnpj | VARCHAR(20) | CPF ou CNPJ do titular |
| titular_nome | VARCHAR(100) | Nome do titular |
| saldo_atual | DECIMAL(15,2) | Saldo em conta |
| data_saldo_atual | DATE | Data do saldo |
| limite | DECIMAL(15,2) | Limite/cheque especial |
| ativa | BOOLEAN | Conta ativa? |
| observacoes | TEXT | Notas |

---

#### `categorias` - Classificação de Transações
| Coluna | Tipo | Descrição |
|--------|------|-----------|
| id | SERIAL | PK |
| tipo | VARCHAR(15) | receita/despesa/transferencia |
| nome | VARCHAR(100) | Nome da categoria |
| descricao | TEXT | Explicação |
| cor | VARCHAR(7) | Cor HEX para dashboards |
| icone | VARCHAR(50) | Ícone sugerido |
| ativa | BOOLEAN | Ativa? |

**Categorias criadas (19):**

**Receitas:** Salário, Prestação de Serviços, Vendas, Investimentos, Reembolso, Outras Receitas  
**Despesas:** Alimentação, Transporte, Moradia, Saúde, Educação, Lazer, Vestuário, Comunicação, Impostos, Fornecedores, Investimentos, Outras Despesas  
**Transferências:** Transferência Entre Contas

---

#### `fornecedores_clientes` - Cadastro Geral
| Coluna | Tipo | Descrição |
|--------|------|-----------|
| id | SERIAL | PK |
| tipo | VARCHAR(15) | fornecedor/cliente/ambos |
| nome | VARCHAR(100) | Nome |
| cpf_cnpj | VARCHAR(20) | Documento |
| telefone | VARCHAR(20) | Contato |
| email | VARCHAR(100) | Email |
| endereco | TEXT | Endereço |
| observacoes | TEXT | Notas |
| ativo | BOOLEAN | Ativo? |

**Fornecedores pré-cadastrados (6):**
- ATUAL PECAS (Silvana/Rogerio)
- Aplicação RDB
- ALL PRO IMPORTS
- ROGERIO ESPEDITO
- ATACADAO
- HOUTER DO BRASIL

---

#### `movimentacoes` - Transações Financeiras (Tabela Principal)
| Coluna | Tipo | Descrição |
|--------|------|-----------|
| id | SERIAL | PK |
| conta_id | INTEGER | FK → contas_bancarias (origem) |
| data | DATE | Data da transação |
| data_competencia | DATE | Mês de competência (faturas) |
| valor | DECIMAL(15,2) | Valor (sempre positivo) |
| tipo | VARCHAR(15) | receita/despesa/transferencia |
| categoria_id | INTEGER | FK → categorias |
| fornecedor_cliente_id | INTEGER | FK → fornecedores_clientes |
| descricao | VARCHAR(255) | Descrição curta |
| detalhes | TEXT | Detalhes completos |
| numero_documento | VARCHAR(50) | NF, comprovante |
| codigo_transacao | VARCHAR(100) | ID único do banco |
| status | VARCHAR(20) | confirmada/pendente/cancelada/estornada |
| conciliada | BOOLEAN | Reconciliada com extrato? |
| conta_destino_id | INTEGER | FK → contas_bancarias (para transferências) |
| origem | VARCHAR(50) | manual/importado_csv/api_banco |
| arquivo_origem | VARCHAR(255) | Arquivo de origem |
| created_at | TIMESTAMP | Quando criou |
| updated_at | TIMESTAMP | Última alteração |

**Índices criados (12):**
- idx_mov_data, idx_mov_conta, idx_mov_tipo
- idx_mov_categoria, idx_mov_fornecedor
- idx_mov_status, idx_mov_valor
- idx_mov_data_conta, idx_mov_data_tipo
- idx_mov_conciliada
- idx_mov_descricao (GIN - busca por texto)

---

#### `saldos_historico` - Acompanhamento Diário
| Coluna | Tipo | Descrição |
|--------|------|-----------|
| id | SERIAL | PK |
| conta_id | INTEGER | FK → contas_bancarias |
| data | DATE | Data do registro |
| saldo | DECIMAL(15,2) | Saldo na data |
| saldo_disponivel | DECIMAL(15,2) | Com limite |
| observacao | VARCHAR(255) | Nota |

---

#### `cartoes_credito` - Cartões Vinculados
| Coluna | Tipo | Descrição |
|--------|------|-----------|
| id | SERIAL | PK |
| conta_id | INTEGER | FK → contas_bancarias |
| apelido | VARCHAR(50) | Nome do cartão |
| bandeira | VARCHAR(30) | Visa, Mastercard |
| numero_final | VARCHAR(4) | Últimos 4 dígitos |
| limite_total | DECIMAL(15,2) | Limite do cartão |
| limite_utilizado | DECIMAL(15,2) | Quanto usou |
| vencimento_fatura | INTEGER | Dia do vencimento (1-31) |
| ativo | BOOLEAN | Ativo? |

---

### **2. VIEWS (Consultas Prontas)**

#### `resumo_contas`
Visão consolidada das contas com saldo disponível total (saldo + limite).

#### `vw_movimentacoes`
Movimentações completas com:
- Nome da conta
- Banco
- Categoria (com cor)
- Fornecedor/Cliente
- Conta destino (para transferências)

#### `vw_resumo_mensal`
Totais agrupados por:
- Mês
- Conta
- Tipo (receita/despesa)
- Categoria

#### `vw_saldo_por_conta`
Saldo calculado em tempo real baseado nas movimentações confirmadas.

---

### **3. FUNÇÕES**

#### `buscar_movimentacoes(...)`
Função com filtros avançados:

```sql
SELECT * FROM financeiro.buscar_movimentacoes(
    p_data_inicio := '2026-01-01',      -- Data inicial
    p_data_fim := '2026-12-31',         -- Data final
    p_conta_id := 1,                    -- ID da conta (NULL = todas)
    p_tipo := 'despesa',                 -- receita/despesa/transferencia
    p_categoria_id := NULL,            -- ID da categoria
    p_fornecedor_id := NULL,           -- ID do fornecedor
    p_valor_min := NULL,               -- Valor mínimo
    p_valor_max := NULL,               -- Valor máximo
    p_status := 'confirmada',           -- confirmada/pendente/cancelada
    p_busca_texto := 'mercado'         -- Busca na descrição
);
```

**Filtros disponíveis:**
- ✅ Por período (data_inicio até data_fim)
- ✅ Por conta específica
- ✅ Por tipo (receita/despesa/transferencia)
- ✅ Por categoria
- ✅ Por fornecedor/cliente
- ✅ Por faixa de valor (min/max)
- ✅ Por status
- ✅ Por texto na descrição (busca parcial)

---

## 🔐 Acesso

### Via Adminer (Web):
1. Acesse: `http://192.168.0.109:8080/`
2. Selecione: **PostgreSQL**
3. Servidor: `192.168.0.109`
4. Usuário: `acib`
5. Senha: `Rcmp814k@#`
6. Banco: `financas`

### Via SQL (linha de comando):
```bash
PGPASSWORD="Rcmp814k@#" psql -h 192.168.0.109 -U acib -d financas
```

---

## 📝 Fluxo de Uso

### Cadastrar uma nova conta:
```sql
INSERT INTO financeiro.contas_bancarias 
(apelido, tipo_pessoa, banco_codigo, conta_numero, cpf_cnpj, saldo_atual)
VALUES ('Nubank PJ65', 'PJ', '260', '986080174-7', '65.384.056/0001-32', 12.81);
```

### Registrar uma movimentação:
```sql
INSERT INTO financeiro.movimentacoes
(conta_id, data, valor, tipo, categoria_id, descricao, status)
VALUES (1, '2026-04-05', 150.00, 'despesa', 10, 'Compra no mercado', 'confirmada');
```

### Consultar resumo:
```sql
SELECT * FROM financeiro.resumo_contas;
SELECT * FROM financeiro.vw_movimentacoes WHERE data >= '2026-04-01';
```

---

## 🔄 Backup

**Local dos arquivos SQL:**
- Schema contas: `/root/schema_contas_bancarias.sql` (CT 100)
- Schema movimentações: `/root/schema_movimentacoes.sql` (CT 100)

---

## 📊 Status Atual

- ✅ **Tabelas:** 7/7 criadas
- ✅ **Views:** 4/4 criadas
- ✅ **Funções:** 1/1 criada
- ✅ **Categorias:** 19 pré-cadastradas
- ✅ **Fornecedores:** 6 pré-cadastrados
- ⏳ **Contas:** 0 (aguardando cadastro das 4 contas do Acib)
- ⏳ **Movimentações:** 0 (pronto para uso)

---

## 🎯 Próximos Passos

1. Cadastrar as 4 contas bancárias do Acib
2. Inserir saldo inicial de cada conta
3. Começar a registrar movimentações
4. Importar extratos CSV (se desejado)

---

**Última atualização:** 2026-04-05  
**Responsável:** Stark 🤖
