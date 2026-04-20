-- ============================================
-- SCHEMA: Contas Bancárias
-- Objetivo: Organizar 4 contas do Acib
-- Data: 2026-04-05
-- ============================================

-- Criar schema financeiro (se não existir)
CREATE SCHEMA IF NOT EXISTS financeiro;
SET search_path TO financeiro, public;

-- ============================================
-- TABELA: bancos
-- Lista de bancos para referência
-- ============================================
CREATE TABLE IF NOT EXISTS bancos (
    id SERIAL PRIMARY KEY,
    codigo VARCHAR(10) UNIQUE NOT NULL,  -- Código Febraban (ex: 260 para Nubank)
    nome VARCHAR(100) NOT NULL,
    nome_curto VARCHAR(30),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Popular bancos comuns
INSERT INTO bancos (codigo, nome, nome_curto) VALUES
('260', 'Nu Pagamentos S.A.', 'Nubank'),
('001', 'Banco do Brasil S.A.', 'Banco do Brasil'),
('104', 'Caixa Econômica Federal', 'Caixa'),
('341', 'Banco Itaú S.A.', 'Itaú'),
('033', 'Banco Santander (Brasil) S.A.', 'Santander'),
('237', 'Banco Bradesco S.A.', 'Bradesco'),
('077', 'Banco Inter S.A.', 'Banco Inter'),
('380', 'PicPay Serviços S.A.', 'PicPay'),
('290', 'PagSeguro Internet S.A.', 'PagBank')
ON CONFLICT (codigo) DO NOTHING;

-- ============================================
-- TABELA: contas_bancarias
-- As 4 contas do Acib
-- ============================================
CREATE TABLE IF NOT EXISTS contas_bancarias (
    id SERIAL PRIMARY KEY,
    
    -- Identificação
    apelido VARCHAR(50) NOT NULL,  -- Como você chama a conta (ex: "Nubank PJ65")
    tipo_pessoa VARCHAR(2) NOT NULL CHECK (tipo_pessoa IN ('PF', 'PJ')),  -- PF ou PJ
    
    -- Dados bancários
    banco_codigo VARCHAR(10) REFERENCES bancos(codigo),
    agencia VARCHAR(20),
    conta_numero VARCHAR(30) NOT NULL,
    conta_digito VARCHAR(5),
    conta_tipo VARCHAR(20) CHECK (conta_tipo IN ('corrente', 'poupanca', 'salario', 'pagamento')),
    
    -- Identificação fiscal
    cpf_cnpj VARCHAR(20),  -- CPF ou CNPJ do titular
    titular_nome VARCHAR(100),
    
    -- Informações financeiras
    saldo_atual DECIMAL(15, 2) DEFAULT 0.00,
    data_saldo_atual DATE,
    limite DECIMAL(15, 2) DEFAULT 0.00,  -- Limite de crédito/cheque especial
    
    -- Status
    ativa BOOLEAN DEFAULT TRUE,
    
    -- Controle
    observacoes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- TABELA: saldos_historico
-- Histórico de saldos para acompanhamento
-- ============================================
CREATE TABLE IF NOT EXISTS saldos_historico (
    id SERIAL PRIMARY KEY,
    conta_id INTEGER REFERENCES contas_bancarias(id) ON DELETE CASCADE,
    data DATE NOT NULL,
    saldo DECIMAL(15, 2) NOT NULL,
    saldo_disponivel DECIMAL(15, 2),  -- Considerando limite
    observacao VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE(conta_id, data)  -- Uma entrada por conta por dia
);

-- ============================================
-- TABELA: cartoes_credito
-- Cartões vinculados às contas
-- ============================================
CREATE TABLE IF NOT EXISTS cartoes_credito (
    id SERIAL PRIMARY KEY,
    conta_id INTEGER REFERENCES contas_bancarias(id) ON DELETE CASCADE,
    
    apelido VARCHAR(50),  -- Ex: "Nubank PJ - Principal"
    bandeira VARCHAR(30),  -- Visa, Mastercard, etc
    numero_final VARCHAR(4),  -- Últimos 4 dígitos
    limite_total DECIMAL(15, 2) DEFAULT 0.00,
    limite_utilizado DECIMAL(15, 2) DEFAULT 0.00,
    vencimento_fatura INTEGER CHECK (vencimento_fatura BETWEEN 1 AND 31),
    
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- ÍNDICES
-- ============================================
CREATE INDEX IF NOT EXISTS idx_contas_tipo ON contas_bancarias(tipo_pessoa);
CREATE INDEX IF NOT EXISTS idx_contas_banco ON contas_bancarias(banco_codigo);
CREATE INDEX IF NOT EXISTS idx_contas_ativa ON contas_bancarias(ativa);
CREATE INDEX IF NOT EXISTS idx_saldos_conta_data ON saldos_historico(conta_id, data);

-- ============================================
-- VIEW: resumo_contas
-- Resumo atual de todas as contas
-- ============================================
CREATE OR REPLACE VIEW resumo_contas AS
SELECT 
    cb.id,
    cb.apelido,
    cb.tipo_pessoa,
    cb.conta_numero,
    cb.cpf_cnpj,
    b.nome_curto AS banco,
    cb.saldo_atual,
    cb.limite,
    (cb.saldo_atual + cb.limite) AS saldo_disponivel_total,
    cb.ativa,
    cb.observacoes
FROM contas_bancarias cb
LEFT JOIN bancos b ON cb.banco_codigo = b.codigo
ORDER BY cb.tipo_pessoa, cb.apelido;

-- ============================================
-- COMENTÁRIOS
-- ============================================
COMMENT ON TABLE contas_bancarias IS 'Cadastro das contas bancárias do Acib';
COMMENT ON TABLE saldos_historico IS 'Histórico diário de saldos para acompanhamento';
COMMENT ON TABLE cartoes_credito IS 'Cartões de crédito vinculados às contas';

-- Mensagem de sucesso
SELECT 'Schema criado com sucesso! Pronto para cadastrar as 4 contas.' AS status;