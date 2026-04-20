-- ============================================
-- SCHEMA: Movimentações Financeiras
-- Filtros avançados para consultas
-- ============================================

SET search_path TO financeiro, public;

-- ============================================
-- TABELA: categorias
-- Categorização de receitas e despesas
-- ============================================
CREATE TABLE IF NOT EXISTS categorias (
    id SERIAL PRIMARY KEY,
    tipo VARCHAR(10) NOT NULL CHECK (tipo IN ('receita', 'despesa', 'transferencia')),
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    cor VARCHAR(7),  -- Hex color para dashboards
    icone VARCHAR(50),  -- Nome do ícone
    ativa BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categorias padrão
INSERT INTO categorias (tipo, nome, descricao, cor) VALUES
-- Receitas
('receita', 'Salário', 'Recebimento de salário e rendimentos', '#28a745'),
('receita', 'Prestação de Serviços', 'Trabalhos técnicos (manutenção PCs, impressoras, etc)', '#20c997'),
('receita', 'Vendas', 'Venda de equipamentos e produtos', '#17a2b8'),
('receita', 'Investimentos', 'Rendimentos e dividendos', '#6f42c1'),
('receita', 'Reembolso', 'Devoluções e reembolsos', '#6c757d'),
('receita', 'Outras Receitas', 'Receitas diversas', '#007bff'),
-- Despesas
('despesa', 'Alimentação', 'Restaurantes, mercado, lanches', '#dc3545'),
('despesa', 'Transporte', 'Combustível, transporte público, manutenção veículos', '#fd7e14'),
('despesa', 'Moradia', 'Aluguel, condomínio, energia, água, internet', '#e83e8c'),
('despesa', 'Saúde', 'Médicos, medicamentos, plano de saúde', '#17a2b8'),
('despesa', 'Educação', 'Cursos, livros, materiais', '#6f42c1'),
('despesa', 'Lazer', 'Entretenimento, viagens, hobbies', '#ffc107'),
('despesa', 'Vestuário', 'Roupas e acessórios', '#6610f2'),
('despesa', 'Comunicação', 'Celular, internet, TV', '#20c997'),
('despesa', 'Impostos', 'Impostos e taxas', '#6c757d'),
('despesa', 'Fornecedores', 'Peças, equipamentos para loja (ATUAL PECAS, etc)', '#fd7e14'),
('despesa', 'Investimentos', 'Aplicações e investimentos', '#28a745'),
('despesa', 'Outras Despesas', 'Despesas diversas', '#dc3545'),
-- Transferências
('transferencia', 'Transferência Entre Contas', 'Movimentação entre suas contas', '#6c757d')
ON CONFLICT DO NOTHING;

-- ============================================
-- TABELA: fornecedores_clientes
-- Cadastro de fornecedores e clientes
-- ============================================
CREATE TABLE IF NOT EXISTS fornecedores_clientes (
    id SERIAL PRIMARY KEY,
    tipo VARCHAR(15) NOT NULL CHECK (tipo IN ('fornecedor', 'cliente', 'ambos')),
    nome VARCHAR(100) NOT NULL,
    cpf_cnpj VARCHAR(20),
    telefone VARCHAR(20),
    email VARCHAR(100),
    endereco TEXT,
    observacoes TEXT,
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Fornecedores conhecidos
INSERT INTO fornecedores_clientes (tipo, nome, cpf_cnpj, observacoes) VALUES
('fornecedor', 'ATUAL PECAS', NULL, 'Proprietários: Silvana Barbosa, Rogerio Espedito'),
('fornecedor', 'Aplicação RDB', NULL, 'Investimentos'),
('fornecedor', 'ALL PRO IMPORTS', NULL, 'Importação'),
('fornecedor', 'ROGERIO ESPEDITO', NULL, 'Peças'),
('fornecedor', 'ATACADAO', NULL, 'Compras diversas'),
('fornecedor', 'HOUTER DO BRASIL', NULL, 'Equipamentos')
ON CONFLICT DO NOTHING;

-- ============================================
-- TABELA: movimentacoes
-- Registro de todas as transações financeiras
-- ============================================
CREATE TABLE IF NOT EXISTS movimentacoes (
    id SERIAL PRIMARY KEY,
    
    -- Conta
    conta_id INTEGER NOT NULL REFERENCES contas_bancarias(id),
    
    -- Dados da transação
    data DATE NOT NULL,
    data_competencia DATE,  -- Mês/ano de competência (útil para faturas)
    
    -- Valores
    valor DECIMAL(15, 2) NOT NULL,
    tipo VARCHAR(10) NOT NULL CHECK (tipo IN ('receita', 'despesa', 'transferencia')),
    
    -- Classificação
    categoria_id INTEGER REFERENCES categorias(id),
    fornecedor_cliente_id INTEGER REFERENCES fornecedores_clientes(id),
    
    -- Descrição
    descricao VARCHAR(255) NOT NULL,
    detalhes TEXT,
    
    -- Identificação bancária
    numero_documento VARCHAR(50),  -- Número do comprovante, NF, etc
    codigo_transacao VARCHAR(100),  -- ID único do banco
    
    -- Status
    status VARCHAR(20) DEFAULT 'confirmada' CHECK (status IN ('confirmada', 'pendente', 'cancelada', 'estornada')),
    conciliada BOOLEAN DEFAULT FALSE,  -- Reconciliado com extrato
    
    -- Transferência (se aplicável)
    conta_destino_id INTEGER REFERENCES contas_bancarias(id),
    
    -- Metadados
    origem VARCHAR(50),  -- 'manual', 'importado_csv', 'api_banco'
    arquivo_origem VARCHAR(255),  -- Arquivo de origem (CSV, OFX, etc)
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- ÍNDICES para performance em filtros
-- ============================================
CREATE INDEX IF NOT EXISTS idx_mov_data ON movimentacoes(data);
CREATE INDEX IF NOT EXISTS idx_mov_conta ON movimentacoes(conta_id);
CREATE INDEX IF NOT EXISTS idx_mov_tipo ON movimentacoes(tipo);
CREATE INDEX IF NOT EXISTS idx_mov_categoria ON movimentacoes(categoria_id);
CREATE INDEX IF NOT EXISTS idx_mov_fornecedor ON movimentacoes(fornecedor_cliente_id);
CREATE INDEX IF NOT EXISTS idx_mov_status ON movimentacoes(status);
CREATE INDEX IF NOT EXISTS idx_mov_valor ON movimentacoes(valor);
CREATE INDEX IF NOT EXISTS idx_mov_data_conta ON movimentacoes(data, conta_id);
CREATE INDEX IF NOT EXISTS idx_mov_data_tipo ON movimentacoes(data, tipo);
CREATE INDEX IF NOT EXISTS idx_mov_conciliada ON movimentacoes(conciliada);

-- Índice para busca por texto na descrição
CREATE INDEX IF NOT EXISTS idx_mov_descricao ON movimentacoes USING gin(to_tsvector('portuguese', descricao));

-- ============================================
-- VIEWS para consultas comuns
-- ============================================

-- View: movimentacoes completas (com joins)
CREATE OR REPLACE VIEW vw_movimentacoes AS
SELECT 
    m.id,
    m.data,
    m.data_competencia,
    m.valor,
    m.tipo,
    m.descricao,
    m.detalhes,
    m.numero_documento,
    m.status,
    m.conciliada,
    
    -- Conta origem
    cb.apelido AS conta_apelido,
    cb.cpf_cnpj AS conta_cnpj_cpf,
    b.nome_curto AS banco,
    
    -- Categoria
    c.nome AS categoria,
    c.cor AS categoria_cor,
    
    -- Fornecedor/Cliente
    fc.nome AS fornecedor_cliente,
    fc.tipo AS fornecedor_cliente_tipo,
    
    -- Conta destino (para transferências)
    cb2.apelido AS conta_destino_apelido,
    
    m.origem,
    m.created_at
FROM movimentacoes m
LEFT JOIN contas_bancarias cb ON m.conta_id = cb.id
LEFT JOIN bancos b ON cb.banco_codigo = b.codigo
LEFT JOIN categorias c ON m.categoria_id = c.id
LEFT JOIN fornecedores_clientes fc ON m.fornecedor_cliente_id = fc.id
LEFT JOIN contas_bancarias cb2 ON m.conta_destino_id = cb2.id;

-- View: resumo mensal
CREATE OR REPLACE VIEW vw_resumo_mensal AS
SELECT 
    DATE_TRUNC('month', data) AS mes,
    conta_id,
    tipo,
    categoria_id,
    COUNT(*) AS quantidade,
    SUM(valor) AS total
FROM movimentacoes
WHERE status = 'confirmada'
GROUP BY DATE_TRUNC('month', data), conta_id, tipo, categoria_id
ORDER BY mes DESC;

-- View: saldo por conta (em tempo real)
CREATE OR REPLACE VIEW vw_saldo_por_conta AS
SELECT 
    cb.id AS conta_id,
    cb.apelido,
    cb.tipo_pessoa,
    b.nome_curto AS banco,
    COALESCE(SUM(CASE WHEN m.tipo = 'receita' THEN m.valor ELSE 0 END), 0) -
    COALESCE(SUM(CASE WHEN m.tipo = 'despesa' THEN m.valor ELSE 0 END), 0) +
    COALESCE(SUM(CASE WHEN m.tipo = 'transferencia' AND m.conta_destino_id IS NOT NULL THEN -m.valor 
                      WHEN m.tipo = 'transferencia' AND m.conta_destino_id IS NULL THEN m.valor 
                      ELSE 0 END), 0) AS saldo_calculado
FROM contas_bancarias cb
LEFT JOIN bancos b ON cb.banco_codigo = b.codigo
LEFT JOIN movimentacoes m ON cb.id = m.conta_id AND m.status = 'confirmada'
GROUP BY cb.id, cb.apelido, cb.tipo_pessoa, b.nome_curto;

-- ============================================
-- FUNÇÕES para consultas avançadas
-- ============================================

-- Função: Buscar movimentações com filtros
CREATE OR REPLACE FUNCTION buscar_movimentacoes(
    p_data_inicio DATE DEFAULT NULL,
    p_data_fim DATE DEFAULT NULL,
    p_conta_id INTEGER DEFAULT NULL,
    p_tipo VARCHAR DEFAULT NULL,  -- 'receita', 'despesa', 'transferencia' ou NULL para todos
    p_categoria_id INTEGER DEFAULT NULL,
    p_fornecedor_id INTEGER DEFAULT NULL,
    p_valor_min DECIMAL DEFAULT NULL,
    p_valor_max DECIMAL DEFAULT NULL,
    p_status VARCHAR DEFAULT 'confirmada',  -- NULL para todos
    p_busca_texto VARCHAR DEFAULT NULL  -- Busca na descrição
)
RETURNS TABLE (
    id INTEGER,
    data DATE,
    valor DECIMAL,
    tipo VARCHAR,
    descricao VARCHAR,
    categoria VARCHAR,
    fornecedor VARCHAR,
    conta VARCHAR
) AS $$
BEGIN
    RETURN QUERY
    SELECT 
        m.id,
        m.data,
        m.valor,
        m.tipo,
        m.descricao,
        c.nome AS categoria,
        fc.nome AS fornecedor,
        cb.apelido AS conta
    FROM movimentacoes m
    LEFT JOIN categorias c ON m.categoria_id = c.id
    LEFT JOIN fornecedores_clientes fc ON m.fornecedor_cliente_id = fc.id
    LEFT JOIN contas_bancarias cb ON m.conta_id = cb.id
    WHERE 
        (p_data_inicio IS NULL OR m.data >= p_data_inicio)
        AND (p_data_fim IS NULL OR m.data <= p_data_fim)
        AND (p_conta_id IS NULL OR m.conta_id = p_conta_id)
        AND (p_tipo IS NULL OR m.tipo = p_tipo)
        AND (p_categoria_id IS NULL OR m.categoria_id = p_categoria_id)
        AND (p_fornecedor_id IS NULL OR m.fornecedor_cliente_id = p_fornecedor_id)
        AND (p_valor_min IS NULL OR m.valor >= p_valor_min)
        AND (p_valor_max IS NULL OR m.valor <= p_valor_max)
        AND (p_status IS NULL OR m.status = p_status)
        AND (p_busca_texto IS NULL OR m.descricao ILIKE '%' || p_busca_texto || '%')
    ORDER BY m.data DESC, m.id DESC;
END;
$$ LANGUAGE plpgsql;

-- ============================================
-- COMENTÁRIOS
-- ============================================
COMMENT ON TABLE movimentacoes IS 'Registro de todas as transações financeiras com suporte a filtros avançados';
COMMENT ON TABLE categorias IS 'Categorias para classificação de receitas e despesas';
COMMENT ON TABLE fornecedores_clientes IS 'Cadastro de fornecedores e clientes';
COMMENT ON FUNCTION buscar_movimentacoes IS 'Função para buscar movimentações com múltiplos filtros';

-- Mensagem
SELECT 'Schema de movimentações criado com sucesso! Pronto para cadastrar transações.' AS status;