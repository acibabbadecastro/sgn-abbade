<?php
// SGN - Configuração do Banco de Dados PostgreSQL
// ATENÇÃO: Preencha com seus dados antes de usar

$host = 'SEU_IP_POSTGRESQL';      // Ex: 192.168.1.100
$port = '5432';                   
$dbname = 'financas';             
$username = 'SEU_USUARIO';        
$password = 'SUA_SENHA';          // ⚠️ Nunca compartilhe!

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// Funções auxiliares
function getContas($pdo) {
    $sql = "SELECT cb.*, b.nome_curto as banco_nome 
            FROM financeiro.contas_bancarias cb 
            LEFT JOIN financeiro.bancos b ON cb.banco_codigo = b.codigo 
            WHERE cb.ativa = true 
            ORDER BY cb.apelido";
    return $pdo->query($sql)->fetchAll();
}

function getClientes($pdo) {
    $sql = "SELECT * FROM financeiro.fornecedores_clientes 
            WHERE ativo = true AND tipo IN ('cliente', 'ambos')
            ORDER BY nome";
    return $pdo->query($sql)->fetchAll();
}

function formatMoney($value) {
    return 'R$ ' . number_format($value, 2, ',', '.');
}

function formatDate($date) {
    if (!$date) return '-';
    return date('d/m/Y', strtotime($date));
}
?>