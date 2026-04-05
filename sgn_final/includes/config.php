<?php
// SGN - Sistema de Gestão de Negócios
// Configuração do Banco de Dados

$host = 'localhost';
$dbname = 'sgn_db';
$user = 'sgn_user';
$pass = 'sgn_pass';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

// Funções úteis
function formatarMoeda($valor) {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

function formatarData($data) {
    return date('d/m/Y', strtotime($data));
}

function formatarDataHora($data) {
    return date('d/m/Y H:i', strtotime($data));
}
