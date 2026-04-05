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
            background: linear-gradient(135deg, #1a2a3a 0%, #0d1b2a 50%, #1b3a5c 100%);
            min-height: 100vh;
            color: #e0e0e0;
        }
        .container { display: flex; min-height: 100vh; }
        .sidebar {
            width: 320px;
            background: rgba(13, 27, 42, 0.95);
            border-right: 1px solid rgba(100, 180, 255, 0.15);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            padding: 30px 20px;
        }
        .logo-area {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid rgba(100, 180, 255, 0.15);
        }
        .logo-icon { font-size: 60px; margin-bottom: 15px; }
        .logo-area h1 { color: #64b4ff; font-size: 22px; font-weight: 600; }
        .logo-area p { color: #7a9cc4; font-size: 12px; margin-top: 5px; }
        
        .menu-section { margin-bottom: 10px; }
        
        .menu-parent {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 16px 20px;
            background: rgba(100, 180, 255, 0.05);
            border: 1px solid rgba(100, 180, 255, 0.1);
            border-radius: 12px;
            color: #a0b8d0;
            text-decoration: none;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .menu-parent:hover {
            background: rgba(100, 180, 255, 0.1);
            border-color: rgba(100, 180, 255, 0.3);
            color: #64b4ff;
        }
        .menu-parent .icon { font-size: 22px; margin-right: 15px; }
        .menu-parent .arrow { margin-left: auto; font-size: 14px; transition: transform 0.3s ease; }
        .menu-parent.active .arrow { transform: rotate(180deg); }
        
        .submenu {
            display: none;
            padding: 10px 0 10px 30px;
        }
        .submenu.open { display: block; }
        
        .submenu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            margin: 4px 0;
            background: rgba(100, 180, 255, 0.03);
            border-radius: 8px;
            color: #7a9cc4;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        .submenu-item:hover {
            background: rgba(100, 180, 255, 0.1);
            color: #64b4ff;
            transform: translateX(5px);
        }
        .submenu-item .icon { margin-right: 10px; font-size: 16px; }
        
        .menu-parent.financeiro:hover { border-color: rgba(100, 200, 255, 0.4); }
        .menu-parent.financeiro.active { background: rgba(100, 200, 255, 0.1); border-color: rgba(100, 200, 255, 0.4); color: #64c8ff; }
        
        .menu-parent.clientes:hover { border-color: rgba(100, 180, 255, 0.4); }
        .menu-parent.clientes.active { background: rgba(100, 180, 255, 0.1); border-color: rgba(100, 180, 255, 0.4); color: #64b4ff; }
        
        .menu-parent.os:hover { border-color: rgba(255, 200, 100, 0.4); }
        .menu-parent.os.active { background: rgba(255, 200, 100, 0.1); border-color: rgba(255, 200, 100, 0.4); color: #ffc864; }
        
        .menu-parent.estoque:hover { border-color: rgba(180, 130, 255, 0.4); }
        .menu-parent.estoque.active { background: rgba(180, 130, 255, 0.1); border-color: rgba(180, 130, 255, 0.4); color: #b482ff; }
        
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
        .welcome h2 { color: #fff; font-size: 32px; margin-bottom: 15px; }
        .welcome p { color: #7a9cc4; font-size: 16px; line-height: 1.6; }
        .welcome .emoji { font-size: 80px; margin-bottom: 20px; }
        
        .info-box {
            margin-top: 40px;
            background: rgba(100, 180, 255, 0.08);
            border: 1px solid rgba(100, 180, 255, 0.2);
            border-radius: 16px;
            padding: 25px 35px;
            text-align: center;
        }
        .info-box p { color: #7a9cc4; font-size: 13px; }
        .info-box .date { color: #64b4ff; font-size: 18px; font-weight: 600; margin-bottom: 5px; }
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
            
            <!-- FINANCEIRO -->
            <div class="menu-section">
                <div class="menu-parent financeiro" onclick="toggleSubmenu('financeiro')">
                    <span class="icon">💰</span>
                    <span>Financeiro</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="submenu" id="submenu-financeiro">
                    <a href="modulos/financeiro/index.php" class="submenu-item">
                        <span class="icon">📊</span> Resumo
                    </a>
                    <a href="modulos/financeiro/contas.php" class="submenu-item">
                        <span class="icon">🏦</span> Contas Bancárias
                    </a>
                    <a href="modulos/financeiro/movimentacoes.php" class="submenu-item">
                        <span class="icon">💵</span> Movimentações
                    </a>
                    <a href="modulos/financeiro/categorias.php" class="submenu-item">
                        <span class="icon">🏷️</span> Categorias
                    </a>
                    <a href="modulos/financeiro/fornecedores.php" class="submenu-item">
                        <span class="icon">🤝</span> Fornecedores
                    </a>
                </div>
            </div>
            
            <!-- CLIENTES -->
            <div class="menu-section">
                <div class="menu-parent clientes" onclick="toggleSubmenu('clientes')">
                    <span class="icon">👥</span>
                    <span>Clientes</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="submenu" id="submenu-clientes">
                    <a href="modulos/clientes/index.php" class="submenu-item">
                        <span class="icon">📋</span> Lista de Clientes
                    </a>
                </div>
            </div>
            
            <!-- ORDENS DE SERVIÇO -->
            <div class="menu-section">
                <div class="menu-parent os" onclick="toggleSubmenu('os')">
                    <span class="icon">🔧</span>
                    <span>Ordens de Serviço</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="submenu" id="submenu-os">
                    <a href="modulos/os/index.php" class="submenu-item">
                        <span class="icon">📋</span> Lista de OS
                    </a>
                </div>
            </div>
            
            <!-- ESTOQUE -->
            <div class="menu-section">
                <div class="menu-parent estoque" onclick="toggleSubmenu('estoque')">
                    <span class="icon">📦</span>
                    <span>Estoque</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="submenu" id="submenu-estoque">
                    <a href="modulos/estoque/index.php" class="submenu-item">
                        <span class="icon">📋</span> Lista de Produtos
                    </a>
                </div>
            </div>
        </nav>

        <main class="main-content">
            <div class="welcome">
                <div class="emoji">👋</div>
                <h2>Bem-vindo ao SGN</h2>
                <p>Selecione um módulo no menu à esquerda para começar.</p>
                
                <div class="info-box">
                    <div class="date"><?php echo date('d/m/Y'); ?></div>
                    <p>Clique nos módulos para ver as opções disponíveis</p>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        function toggleSubmenu(id) {
            // Fecha todos os submenus
            document.querySelectorAll('.submenu').forEach(el => el.classList.remove('open'));
            document.querySelectorAll('.menu-parent').forEach(el => el.classList.remove('active'));
            
            // Abre o clicado
            const submenu = document.getElementById('submenu-' + id);
            const parent = event.currentTarget;
            
            if (submenu) {
                submenu.classList.add('open');
                parent.classList.add('active');
            }
        }
    </script>
</body>
</html>
