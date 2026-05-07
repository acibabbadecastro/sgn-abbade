-- 🏆 LIGA VIRTUAL DA COPA 2026 - BANCO DE DADOS
-- Criado: 2026-05-05
-- PostgreSQL 14+

-- ============================================
-- 1. USUÁRIOS
-- ============================================

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    nome_completo VARCHAR(100) NOT NULL,
    apelido VARCHAR(50) UNIQUE NOT NULL,  -- @acibabbade
    email VARCHAR(100) UNIQUE NOT NULL,
    senha_hash VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    
    -- Foto/Avatar
    avatar_url VARCHAR(255),
    avatar_tipo VARCHAR(20) DEFAULT 'avatar',  -- 'upload', 'avatar', 'gravatar'
    
    -- Consentimentos (OPCIONAIS)
    termos_aceitos BOOLEAN DEFAULT FALSE,
    termos_data TIMESTAMP,
    termos_versao VARCHAR(10) DEFAULT '1.0',
    
    imagem_autorizada BOOLEAN DEFAULT FALSE,
    imagem_data TIMESTAMP,
    
    privacidade_aceita BOOLEAN DEFAULT FALSE,
    privacidade_data TIMESTAMP,
    
    -- Visibilidade no Ranking
    ranking_visibilidade VARCHAR(20) DEFAULT 'top10',  -- 'publico', 'cadastrados', 'oculto'
    
    -- Estatísticas
    pontos_totais INTEGER DEFAULT 0,
    ranking_geral INTEGER DEFAULT 0,
    precisao_percent DECIMAL(5,2) DEFAULT 0,
    
    -- Time do Coração
    time_coracao VARCHAR(50),
    time_bandeira VARCHAR(10),  -- 🇧🇷, 🇦🇷, etc.
    
    -- Preferências da Camisa (prêmio especial)
    camisa_tamanho VARCHAR(5),  -- P, M, G, GG, XGG
    camisa_nome VARCHAR(50),
    camisa_numero INTEGER DEFAULT 10,
    
    -- Status
    ativo BOOLEAN DEFAULT TRUE,
    email_verificado BOOLEAN DEFAULT FALSE,
    verificado BOOLEAN DEFAULT FALSE,  -- para apostas em dinheiro
    
    -- Timestamps
    created_at TIMESTAMP DEFAULT NOW(),
    last_login TIMESTAMP,
    
    -- Índices
    INDEX idx_apelido (apelido),
    INDEX idx_email (email),
    INDEX idx_pontos (pontos_totais DESC)
);

-- ============================================
-- 2. TIMES VIRTUAIS
-- ============================================

CREATE TABLE times (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    descricao TEXT,
    
    -- WhatsApp
    whatsapp_grupo_nome VARCHAR(100),
    whatsapp_link_convite VARCHAR(255),
    whatsapp_grupo_id VARCHAR(100),
    
    -- Dono/Criador
    criador_id INTEGER REFERENCES users(id),
    criador_whatsapp VARCHAR(20),
    
    -- Configurações
    tipo VARCHAR(20) DEFAULT 'aberto',  -- 'aberto', 'fechado', 'privado'
    max_jogadores INTEGER DEFAULT 50,
    
    -- Apostas
    permite_apostas_internas BOOLEAN DEFAULT TRUE,
    permite_apostas_externas BOOLEAN DEFAULT TRUE,
    valor_padrao_aposta DECIMAL(10,2) DEFAULT 20.00,
    
    -- Visual
    escudo_url VARCHAR(255),
    cores_json JSONB,  -- {primary: '#0000FF', secondary: '#FFFFFF'}
    
    -- Estatísticas
    pontos_totais INTEGER DEFAULT 0,
    ranking_geral INTEGER DEFAULT 0,
    vitorias INTEGER DEFAULT 0,
    empates INTEGER DEFAULT 0,
    derrotas INTEGER DEFAULT 0,
    saldo_apostas DECIMAL(10,2) DEFAULT 0,
    
    -- Status
    ativo BOOLEAN DEFAULT TRUE,
    verificado BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT NOW(),
    
    -- Índices
    INDEX idx_slug (slug),
    INDEX idx_pontos (pontos_totais DESC)
);

-- Membros dos Times
CREATE TABLE time_membros (
    id SERIAL PRIMARY KEY,
    time_id INTEGER REFERENCES times(id) ON DELETE CASCADE,
    user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    
    -- WhatsApp
    whatsapp_numero VARCHAR(20),
    whatsapp_nome VARCHAR(100),
    
    -- Cargo
    cargo VARCHAR(20) DEFAULT 'jogador',  -- 'dono', 'capitao', 'jogador'
    
    -- Apostas
    apostas_feitas INTEGER DEFAULT 0,
    apostas_ganhas INTEGER DEFAULT 0,
    saldo_atual DECIMAL(10,2) DEFAULT 0,
    
    -- Status
    ativo BOOLEAN DEFAULT TRUE,
    entrou_em TIMESTAMP DEFAULT NOW(),
    
    UNIQUE(time_id, user_id),
    INDEX idx_user (user_id)
);

-- Convites para Times
CREATE TABLE time_convites (
    id SERIAL PRIMARY KEY,
    time_id INTEGER REFERENCES times(id) ON DELETE CASCADE,
    convidado_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    convidado_por INTEGER REFERENCES users(id),
    
    status VARCHAR(20) DEFAULT 'pendente',  -- 'pendente', 'aceito', 'recusado'
    expires_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT NOW()
);

-- ============================================
-- 3. COMPETIÇÕES (LIGA + COPA)
-- ============================================

CREATE TABLE competicoes (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    tipo VARCHAR(20) NOT NULL,  -- 'liga' ou 'copa'
    
    -- Período
    data_inicio DATE,
    data_fim DATE,
    
    -- Configurações
    max_times INTEGER,
    formato VARCHAR(20),  -- 'mata_mata', 'pontos_corridos', 'misto'
    
    -- Status
    status VARCHAR(20) DEFAULT 'inscritoes',  -- 'inscricoes', 'em_andamento', 'finalizada'
    campeao_id INTEGER REFERENCES times(id),
    
    created_at TIMESTAMP DEFAULT NOW()
);

-- Chaves da Copa (Mata-Mata)
CREATE TABLE copa_chaves (
    id SERIAL PRIMARY KEY,
    competicao_id INTEGER REFERENCES competicoes(id) ON DELETE CASCADE,
    
    -- Rodada
    rodada VARCHAR(50),  -- 'oitavas', 'quartas', 'semi', 'final'
    ordem INTEGER,
    
    -- Times
    time_a_id INTEGER REFERENCES times(id),
    time_b_id INTEGER REFERENCES times(id),
    
    -- Pontuação
    pontos_time_a INTEGER DEFAULT 0,
    pontos_time_b INTEGER DEFAULT 0,
    
    -- Vencedor
    vencedor_id INTEGER REFERENCES times(id),
    proximo_jogo_id INTEGER REFERENCES copa_chaves(id),
    
    -- Status
    status VARCHAR(20) DEFAULT 'pendente',
    finalizado_em TIMESTAMP,
    
    INDEX idx_competicao (competicao_id)
);

-- ============================================
-- 4. JOGOS E PREVISÕES
-- ============================================

-- Jogos Reais da Copa
CREATE TABLE games (
    id SERIAL PRIMARY KEY,
    competicao_id INTEGER REFERENCES competicoes(id),
    
    -- Times Reais
    time_a VARCHAR(50),  -- 'Brasil'
    time_b VARCHAR(50),  -- 'Argentina'
    
    -- Data
    data_jogo TIMESTAMP,
    estadio VARCHAR(100),
    fase VARCHAR(50),  -- 'Grupo A', 'Oitavas', etc.
    
    -- Resultado Real
    placar_a INTEGER,
    placar_b INTEGER,
    status VARCHAR(20) DEFAULT 'agendado',  -- 'agendado', 'em_andamento', 'finalizado'
    
    -- Eventos (gols, cartões, etc.)
    eventos_json JSONB,
    
    created_at TIMESTAMP DEFAULT NOW(),
    
    INDEX idx_fase (fase),
    INDEX idx_data (data_jogo)
);

-- Previsões dos Usuários
CREATE TABLE user_predictions (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    game_id INTEGER REFERENCES games(id) ON DELETE CASCADE,
    time_id INTEGER REFERENCES times(id) ON DELETE CASCADE,
    bolao_id INTEGER REFERENCES bolaos(id),
    
    -- Previsões
    escalacao JSONB,  -- [11 jogador_ids]
    formacao VARCHAR(10),  -- '4-3-3', '4-4-2'
    placar_a INTEGER,
    placar_b INTEGER,
    gols_marcadores JSONB,  -- [jogador_ids]
    assistencias JSONB,
    cartoes_amarelos JSONB,
    cartoes_vermelhos JSONB,
    penalts_perdidos JSONB,
    penalts_defendidos JSONB,
    mvp INTEGER,
    
    -- Pontuação
    pontos_rodada INTEGER DEFAULT 0,
    
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW(),
    
    UNIQUE(user_id, game_id),
    INDEX idx_game (game_id),
    INDEX idx_pontos (pontos_rodada DESC)
);

-- ============================================
-- 5. APOSTAS E PAGAMENTOS
-- ============================================

-- Bolões
CREATE TABLE bolaos (
    id SERIAL PRIMARY KEY,
    criador_id INTEGER REFERENCES users(id),
    nome VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    
    valor_entrada DECIMAL(10,2),
    vagas_totais INTEGER,
    vagas_ocupadas INTEGER,
    premio_total DECIMAL(10,2),
    distribuicao_premio JSONB,  -- {1: 50%, 2: 30%, 3: 20%}
    
    status VARCHAR(20) DEFAULT 'aberto',
    codigo_convite VARCHAR(50),
    
    created_at TIMESTAMP DEFAULT NOW()
);

-- Apostas entre Times
CREATE TABLE apostas_times (
    id SERIAL PRIMARY KEY,
    time_a_id INTEGER REFERENCES times(id),
    time_b_id INTEGER REFERENCES times(id),
    
    valor_aposta DECIMAL(10,2) NOT NULL,
    valor_total DECIMAL(10,2),
    
    game_id INTEGER REFERENCES games(id),
    data_inicio TIMESTAMP,
    data_fim TIMESTAMP,
    
    pontos_time_a INTEGER DEFAULT 0,
    pontos_time_b INTEGER DEFAULT 0,
    vencedor_id INTEGER REFERENCES times(id),
    
    status_pagamento VARCHAR(20) DEFAULT 'pendente',
    pix_comprovante VARCHAR(255),
    
    status VARCHAR(20) DEFAULT 'ativa',
    created_at TIMESTAMP DEFAULT NOW()
);

-- Pagamentos
CREATE TABLE pagamentos (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id),
    bolao_id INTEGER REFERENCES bolaos(id),
    valor DECIMAL(10,2),
    tipo VARCHAR(20),  -- 'entrada', 'premio', 'taxa'
    status VARCHAR(20) DEFAULT 'pendente',
    pix_key VARCHAR(255),
    pix_comprovante VARCHAR(255),
    created_at TIMESTAMP DEFAULT NOW()
);

-- ============================================
-- 6. PRÊMIOS ESPECIAIS
-- ============================================

CREATE TABLE premios_especiais (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    
    -- Condições
    condicao_json JSONB,  -- {brasil_final: true}
    
    -- Status
    ativo BOOLEAN DEFAULT TRUE,
    reclamado BOOLEAN DEFAULT FALSE,
    
    -- Ganhador
    ganhador_id INTEGER REFERENCES users(id),
    data_ganho TIMESTAMP,
    
    -- Entrega
    camisa_tamanho VARCHAR(5),
    camisa_nome VARCHAR(50),
    camisa_numero INTEGER DEFAULT 10,
    endereco_entrega JSONB,
    frete_pago BOOLEAN DEFAULT FALSE,
    
    created_at TIMESTAMP DEFAULT NOW()
);

-- Condições de Prêmios
CREATE TABLE premio_condicoes (
    id SERIAL PRIMARY KEY,
    premio_id INTEGER REFERENCES premios_especiais(id) ON DELETE CASCADE,
    evento VARCHAR(100),  -- 'brasil_chega_final'
    valor_esperado BOOLEAN,
    valor_real BOOLEAN DEFAULT FALSE,
    verificado_em TIMESTAMP
);

-- ============================================
-- 7. LOGS E AUDITORIA
-- ============================================

-- Logs de Consentimento (LGPD)
CREATE TABLE consentimento_logs (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    tipo VARCHAR(50),  -- 'termos', 'imagem', 'privacidade'
    acao VARCHAR(20),  -- 'aceitou', 'revogou'
    versao VARCHAR(10),
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT NOW()
);

-- Logs de Notificações WhatsApp
CREATE TABLE whatsapp_logs (
    id SERIAL PRIMARY KEY,
    time_id INTEGER REFERENCES times(id),
    tipo VARCHAR(50),
    mensagem TEXT,
    destinatarios JSONB,
    enviado_em TIMESTAMP DEFAULT NOW(),
    status VARCHAR(20)
);

-- ============================================
-- 8. SESSÕES E AUTENTICAÇÃO
-- ============================================

CREATE TABLE user_sessions (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    token VARCHAR(255) UNIQUE NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT NOW(),
    
    INDEX idx_token (token)
);

-- ============================================
-- DADOS INICIAIS
-- ============================================

-- Prêmio Especial da Camisa do Brasil
INSERT INTO premios_especiais (nome, descricao, condicao_json, ativo)
VALUES (
    'Camisa Oficial da Seleção Brasileira',
    'Camisa oficial Nike 2026 - Personalizada com nome e número',
    '{"brasil_final": true, "ranking_minimo": 1}',
    TRUE
);

-- Condição do Prêmio
INSERT INTO premio_condicoes (premio_id, evento, valor_esperado)
VALUES (1, 'brasil_chega_final', TRUE);
