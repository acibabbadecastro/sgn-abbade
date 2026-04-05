<?php
// SGN - Configuração do Banco de Dados PostgreSQL
// Conexão com DATASVR (CT 102)

$host = '192.168.0.109';
$port = '5432';
$dbname = 'financas';
$username = 'acib';
$password = 'Rcmp814k@#';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    die("Erro de conexão com o banco de dados: " . $e->getMessage());
}

// Funções auxiliares

function getContas($pdo) {
    $sql = "SELECT cb.*, b.nome_curto as banco_nome, b.nome as banco_nome_completo 
            FROM financeiro.contas_bancarias cb 
            LEFT JOIN financeiro.bancos b ON cb.banco_codigo = b.codigo 
            WHERE cb.ativa = true 
            ORDER BY cb.tipo_pessoa, cb.apelido";
    return $pdo->query($sql)->fetchAll();
}

function getContaById($pdo, $id) {
    $sql = "SELECT cb.*, b.nome_curto as banco_nome 
            FROM financeiro.contas_bancarias cb 
            LEFT JOIN financeiro.bancos b ON cb.banco_codigo = b.codigo 
            WHERE cb.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getBancos($pdo) {
    $sql = "SELECT * FROM financeiro.bancos ORDER BY nome_curto";
    return $pdo->query($sql)->fetchAll();
}

function getCategorias($pdo) {
    $sql = "SELECT * FROM financeiro.categorias WHERE ativa = true ORDER BY tipo, nome";
    return $pdo->query($sql)->fetchAll();
}

function getFornecedores($pdo) {
    $sql = "SELECT * FROM financeiro.fornecedores_clientes 
            WHERE ativo = true AND tipo IN ('fornecedor', 'ambos')
            ORDER BY nome";
    return $pdo->query($sql)->fetchAll();
}

function getClientes($pdo) {
    $sql = "SELECT * FROM financeiro.fornecedores_clientes 
            WHERE ativo = true AND tipo IN ('cliente', 'ambos')
            ORDER BY nome";
    return $pdo-
>query($sql)->fetchAll();
}

function getMovimentacoes($pdo, $limit = 50) {
    $sql = "SELECT m.*, c.nome as categoria_nome, c.cor as categoria_cor,
                   fc.nome as fornecedor_nome, cb.apelido as conta_apelido
            FROM financeiro.movimentacoes m
            LEFT JOIN financeiro.categorias c ON m.categoria_id = c.id
            LEFT JOIN financeiro.fornecedores_clientes fc ON m.fornecedor_cliente_id = fc.id
            LEFT JOIN financeiro.contas_bancarias cb ON m.conta_id = cb.id
            ORDER BY m.data DESC, m.id DESC
            LIMIT ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

function getResumoMensal($pdo, $mes = null, $ano = null) {
    if (!$mes) $mes = date('m');
    if (!$ano) $ano = date('Y');
    
    $sql = "SELECT 
            COALESCE(SUM(CASE WHEN tipo = 'receita' AND status = 'confirmada' THEN valor ELSE 0 END), 0) as receitas,
            COALESCE(SUM(CASE WHEN tipo = 'despesa' AND status = 'confirmada' THEN valor ELSE 0 END), 0) as despesas,
            COALESCE(SUM(CASE WHEN tipo = 'transferencia' AND status = 'confirmada' THEN valor ELSE 0 END), 0) as transferencias,
            COUNT(*) as total
            FROM financeiro.movimentacoes 
            WHERE EXTRACT(MONTH FROM data) = ? AND EXTRACT(YEAR FROM data) = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$mes, $ano]);
    return $stmt->fetch();
}

function getSaldoTotal($pdo) {
    $sql = "SELECT COALESCE(SUM(saldo_atual), 0) as saldo 
            FROM financeiro.contas_bancarias 
            WHERE ativa = true";
    return $pdo->query($sql)->fetchColumn();
}

function formatMoney($value) {
    return 'R$ ' . number_format($value, 2, ',', '.');
}

function formatDate($date) {
    if (!$date) return '-';
    return date('d/m/Y', strtotime($date));
}
?