<?php
// SGN - Sistema de Gerenciamento de Negócios ABBADE Technologies
// Tela de Login

session_start();

// Se já está logado, vai para dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

// Processa login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Login padrão (temporário - depois vem do banco)
    if ($username === 'admin' && $password === 'Rcmp814k@#') {
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = 'admin';
        $_SESSION['empresa'] = 'ABBADE Technologies';
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Usuário ou senha incorretos!';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGN - Sistema de Gerenciamento de Negócios</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 50px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }
        
        .logo {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .logo-icon {
            font-size: 60px;
            margin-bottom: 15px;
        }
        
        .logo h1 {
            color: #fff;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        .logo p {
            color: #a0a0a0;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            color: #e0e0e0;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            background: rgba(0, 0, 0, 0.2);
            color: #fff;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #00d4ff;
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);
        }
        
        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 212, 255, 0.4);
        }
        
        .error-message {
            background: rgba(255, 71, 87, 0.2);
            border: 1px solid rgba(255, 71, 87, 0.5);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
            color: #ff6b6b;
            text-align: center;
            font-size: 14px;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 12px;
        }
        
        .info-box {
            background: rgba(0, 212, 255, 0.1);
            border-left: 4px solid #00d4ff;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 0 8px 8px 0;
            color: #b0b0b0;
            font-size: 13px;
        }
        
        .info-box strong {
            color: #00d4ff;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <div class="logo-icon">🏢</div>
            <h1>ABBADE Technologies</h1>
            <p>Sistema de Gerenciamento de Negócios</p>
        </div>
        
        <?php if ($error): ?>
        <div class="error-message">
            ⚠️ <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>
        
        <div class="info-box">
            <strong>Login Padrão:</strong><br>
            Usuário: <code>admin</code><br>
            Senha: <code>Rcmp814k@#</code>
        </div>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">👤 Usuário</label>
                <input type="text" id="username" name="username" placeholder="Digite seu usuário" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">🔒 Senha</label>
                <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
            </div>
            
            <button type="submit" class="btn-login">Entrar no Sistema</button>
        </form>
        
        <div class="footer">
            <p>© 2026 ABBADE Technologies - Todos os direitos reservados</p>
            <p>Servidor: SGN (CT 104) | Banco: PostgreSQL (DATASVR)</p>
        </div>
    </div>
</body>
</html>