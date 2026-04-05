<?php
// Página inicial do SGN - Dashboard
require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGN - Sistema de Gestão de Negócios</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #16213e 100%);
            min-height: 100vh;
            color: #e0e0e0;
        }
        .container { display: flex; min-height: 100vh; }
        .sidebar {
            width: 320px;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            padding: 30px 20px;
        }
        .logo-area {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .logo-icon { font-size: 60px; margin-bottom: 15px; }
        .logo-area h1 { color: #00d4ff; font-size: 22px; font-weight: 600; }
        .logo-area p { color: #666; font-size: 12px; margin-top: 5px; }
        
        .section-title {
            color: #666;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
            padding-left: 10px;
        }
        
        .modulo-btn {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 18px 20px;
            margin-bottom: 10px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            color: #a0a0a0;
            text-decoration: none;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        .modulo-btn:hover {
            background: rgba(0, 212, 255, 0.1);
            border-color: rgba(0, 212, 255, 0.3);
            color: #00d4ff;
            transform: translateX(5px);
        }
        .modulo-btn .icon { font-size: 24px; margin-right: 15px; }
        .modulo-btn .arrow { margin-left: auto; font-size: 18px; opacity: 0.5; }
        
        .modulo-btn.financeiro:hover { background: rgba(0, 255, 100, 0.1); border-color: rgba(0, 255, 100, 0.3); color: #00ff64; }
        .modulo-btn.clientes:hover { background: rgba(0, 212, 255, 0.1); border-color: rgba(0, 212, 255, 0.3); color: #00d4ff; }
        .modulo-btn.os:hover { background: rgba(255, 193, 7, 0.1); border-color: rgba(255, 193, 7, 0.3); color: #ffc107; }
        .modulo-btn.estoque:hover { background: rgba(255, 107, 107, 0.1); border-color: rgba(255, 107, 107, 0.3); color: #ff6b6b; }
        
        .main-content {
            margin-left: 320px;
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .welcome {
            text-align: center;
            max-width: 600px;
        }
        .welcome h2 {
            color: #fff;
            font-size: 32px;
            margin-bottom: 15px;
        }
        .welcome p {
            color: #888;
            font-size: 16px;
            line-height: 1.6;
        }
        .welcome .emoji { font-size: 80px; margin-bottom: 20px; }
        
        .info-box {
            margin-top: 40px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px 35px;
            text-align: center;
        }
        .info-box p { color: #666; font-size: 13px; }
        .info-box .date { color: #00d4ff; font-size: 18px; font-weight: 600; margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <div class="logo-area">
                <div class="logo-icon">🏢</div>
                <h1>ABBADE Technologies</h1>
                <p>Sistema de Gestão de Negócios</p>
            </div>
            
            <div class="section-title">Módulos</div>
            
            <a href="modulos/financeiro/index.php" class="modulo-btn financeiro">
                <span class="icon">💰</span>
                <span>Financeiro</span>
                <span class="arrow">→</span>
            </a>
            
            <a href="modulos/clientes/index.php" class="modulo-btn clientes">
                <span class="icon">👥</span>
                <span>Clientes</span>
                <span class="arrow">→</span>
            </a>
            
            <a href="modulos/os/index.php" class="modulo-btn os">
                <span class="icon">🔧</span>
                <span>Ordens de Serviço</span>
                <span class="arrow">→</span>
            </a>
            
            <a href="modulos/estoque/index.php" class="modulo-btn estoque">
                <span class="icon">📦</span>
                <span>Estoque</span>
                <span class="arrow">→</span>
            </a>
        </nav>

        <main class="main-content">
            <div class="welcome">
                <div class="emoji">👋</div>
                <h2>Bem-vindo ao SGN</h2>
                <p>Selecione um módulo no menu à esquerda para começar.</p>
                
                <div class="info-box">
                    <div class="date"><?php echo date('d/m/Y'); ?></div>
                    <p>Escolha uma das opções acima para gerenciar seu negócio</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
