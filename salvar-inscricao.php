<?php
/**
 * Salvar Inscrição Newsletter - Amigos de 4 Patas
 * Recebe dados do formulário e salva em arquivo JSON
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

// Função para resposta JSON
function responder($success, $message) {
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

// Verifica método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responder(false, 'Método não permitido');
}

// Recebe dados
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$whatsapp = isset($_POST['whatsapp']) ? preg_replace('/\D/', '', $_POST['whatsapp']) : '';

// Validação básica
if (empty($nome)) {
    responder(false, 'Informe seu nome');
}

if (empty($email) && empty($whatsapp)) {
    responder(false, 'Informe email ou WhatsApp');
}

if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    responder(false, 'Email inválido');
}

if (!empty($whatsapp) && strlen($whatsapp) !== 11) {
    responder(false, 'WhatsApp deve ter 11 dígitos (DDD + número)');
}

// Prepara dados
$inscricao = [
    'id' => uniqid('a4p_', true),
    'nome' => $nome,
    'email' => $email,
    'whatsapp' => $whatsapp,
    'data' => date('Y-m-d H:i:s'),
    'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
    'origem' => $_SERVER['HTTP_REFERER'] ?? 'direct'
];

// Diretório para salvar
$dataDir = __DIR__ . '/data';
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0755, true);
}

$arquivo = $dataDir . '/newsletter.json';

// Carrega inscrições existentes
$inscricoes = [];
if (file_exists($arquivo)) {
    $conteudo = file_get_contents($arquivo);
    $inscricoes = json_decode($conteudo, true) ?: [];
}

// Verifica duplicados (email ou whatsapp)
foreach ($inscricoes as $existente) {
    if (!empty($email) && $existente['email'] === $email) {
        responder(false, 'Este email já está cadastrado');
    }
    if (!empty($whatsapp) && $existente['whatsapp'] === $whatsapp) {
        responder(false, 'Este WhatsApp já está cadastrado');
    }
}

// Adiciona nova inscrição
$inscricoes[] = $inscricao;

// Salva arquivo
if (file_put_contents($arquivo, json_encode($inscricoes, JSON_PRETTY_PRINT))) {
    responder(true, 'Cadastro realizado com sucesso! Você receberá nossas atualizações.');
} else {
    responder(false, 'Erro ao salvar. Tente novamente.');
}
