<?php
// SGN - Autenticação
session_start();

// Verifica se usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Função para verificar permissão
function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }
}

// Função de logout
function logout() {
    session_destroy();
    header('Location: index.php');
    exit;
}

// Processa logout
if (isset($_GET['logout'])) {
    logout();
}
?