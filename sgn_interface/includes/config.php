<?php
// SGN - Configuração do Banco de Dados
// Conexão com PostgreSQL no DATASVR

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

// Configuração do schema
$schema = 'financeiro';

// Função para executar queries no schema financeiro
function query($pdo, $sql, $params = []) {
    global $schema;
    $sql = str_replace('financeiro.', "$schema.", $sql);
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

// Função para obter todas as contas
function getContas($pdo) {
    $sql = "SELECT cb.*, b.nome_curto as banco_nome 
            FROM financeiro.contas_bancarias cb 
            LEFT JOIN financeiro.bancos b ON cb.banco_codigo = b.codigo 
            WHERE cb.ativa = true 
            ORDER BY cb.tipo_pessoa, cb.apelido";
    return $pdo->query($sql)->fetchAll();
}

// Função para obter resumo financeiro
function getResumoFinanceiro($pdo) {
    $sql = "SELECT 
            COALESCE(SUM(CASE WHEN tipo = 'receita' AND status = 'confirmada' THEN valor ELSE 0 END), 0) as total_receitas,
            COALESCE(SUM(CASE WHEN tipo = 'despesa' AND status = 'confirmada' THEN valor ELSE 0 END), 0) as total_despesas,
            COALESCE(SUM(CASE WHEN tipo = 'transferencia' AND status = 'confirmada' THEN valor ELSE 0 END), 0) as total_transferencias,
            COUNT(*) as total_movimentacoes
            FROM financeiro.movimentacoes 
            WHERE DATE_TRUNC('month', data) = DATE_TRUNC('month', CURRENT_DATE)";
    return $pdo->query($sql)->fetch();
}

// Função para obter saldo total
function getSaldoTotal($pdo) {
    $sql = "SELECT COALESCE(SUM(saldo_atual), 0) as saldo_total FROM financeiro.contas_bancarias WHERE ativa = true";
    return $pdo->query($sql)->fetchColumn();
}
?