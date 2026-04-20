#!/bin/bash
# Script de instalação do SGN - Sistema de Gerenciamento de Negócios
# Execute no SGN (CT 104) como root

echo "🚀 Instalando SGN - ABBADE Technologies..."

# Criar diretórios
mkdir -p /var/www/html/includes
mkdir -p /var/www/html/modulos/servicos
mkdir -p /var/www/html/modulos/financeiro
mkdir -p /var/www/html/modulos/clientes
mkdir -p /var/www/html/modulos/config
mkdir -p /var/www/html/css
mkdir -p /var/www/html/js

echo "✅ Diretórios criados"

# Criar config.php
cat > /var/www/html/includes/config.php << 'CONFIGEOF'
<?php
// SGN - Configuração do Banco de Dados PostgreSQL
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
    die("Erro de conexão: " . $e->getMessage());
}

function getContas($pdo) {
    $sql = "SELECT cb.*, b.nome_curto as banco_nome 
            FROM financeiro.contas_bancarias cb 
            LEFT JOIN financeiro.bancos b ON cb.banco_codigo = b.codigo 
            WHERE cb.ativa = true ORDER BY cb.tipo_pessoa, cb.apelido";
    return $pdo->query($sql)->fetchAll();
}

function getSaldoTotal($pdo) {
    $sql = "SELECT COALESCE(SUM(saldo_atual), 0) FROM financeiro.contas_bancarias WHERE ativa = true";
    return $pdo->query($sql)->fetchColumn();
}
?>
CONFIGEOF

echo "✅ config.php criado"

# Criar auth.php
cat > /var/www/html/includes/auth.php << 'AUTHEOF'
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
AUTHEOF

echo "✅ auth.php criado"

# Criar login.php
cat > /var/www/html/login.php << 'LOGINPHP'
<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'Rcmp814k@#') {
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = 'admin';
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Credenciais inválidas!';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>SGN - Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 50px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .logo { font-size: 50px; margin-bottom: 10px; }
        h1 { color: #fff; margin-bottom: 5px; }
        p { color: #888; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; text-align: left; }
        label { color: #ccc; display: block; margin-bottom: 8px; }
        input {
            width: 100%;
            padding: 15px;
            border: 2px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            background: rgba(0,0,0,0.2);
            color: #fff;
            font-size: 16px;
        }
        input:focus { outline: none; border-color: #00d4ff; }
        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,212,255,0.4); }
        .error {
            background: rgba(255,71,87,0.2);
            border: 1px solid rgba(255,71,87,0.5);
            color: #ff6b6b;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .info {
            background: rgba(0,212,255,0.1);
            border-left: 3px solid #00d4ff;
            color: #ccc;
            padding: 15px;
            margin-bottom: 20px;
            text-align: left;
            font-size: 13px;
        }
        .info strong { color: #00d4ff; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">🏢</div>
        <h1>ABBADE Technologies</h1>
        <p>Sistema de Gerenciamento de Negócios</p>
        
        <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="info">
            <strong>Login Padrão:</strong><br>
            Usuário: <code>admin</code><br>
            Senha: <code>Rcmp814k@#</code>
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label>👤 Usuário</label>
                <input type="text" name="username" placeholder="admin" required>
            </div>
            <div class="form-group">
                <label>🔒 Senha</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit">Entrar no Sistema</button>
        </form>
    </div>
</body>
</html>
LOGINPHP

echo "✅ login.php criado"

# Backup do index.html e criar novo index.php
mv /var/www/html/index.html /var/www/html/index.html.bak 2>/dev/null || true

echo "🎉 Instalação concluída!"
echo ""
echo "Acesse: http://192.168.0.99/login.php"
echo "Usuário: admin"
echo "Senha: Rcmp814k@#"
