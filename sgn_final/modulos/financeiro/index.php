<?php
// Dashboard Financeiro
require_once '../../includes/config.php';

$total_entradas = $pdo->query("SELECT COALESCE(SUM(valor), 0) FROM financeiro.movimentacoes WHERE tipo = 'ENTRADA'")->fetchColumn();
$total_saidas = $pdo->query("SELECT COALESCE(SUM(valor), 0) FROM financeiro.movimentacoes WHERE tipo = 'SAIDA'")->fetchColumn();
$saldo = $total_entradas - $total_saidas;
$contas = $pdo->query("SELECT COUNT(*) FROM financeiro.contas_bancarias WHERE ativa = true")->fetchColumn();
$movimentacoes = $pdo->query("SELECT COUNT(*) FROM financeiro.movimentacoes")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financeiro - SGN</title>
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
        .menu-parent:hover { background: rgba(100, 180, 255, 0.1); border-color: rgba(100, 180, 255, 0.3); color: #64b4ff; }
        .menu-parent.active { background: rgba(100, 200, 255, 0.15); border-color: rgba(100, 200, 255, 0.4); color: #64c8ff; }
        .menu-parent .icon { font-size: 22px; margin-right: 15px; }
        .menu-parent .arrow { margin-left: auto; font-size: 14px; }
        
        .submenu { display: none; padding: 10px 0 10px 30px; }
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
        .submenu-item:hover { background: rgba(100, 180, 255, 0.1); color: #64b4ff; transform: translateX(5px); }
        .submenu-item.active { background: rgba(100, 200, 255, 0.1); color: #64c8ff; }
        .submenu-item .icon { margin-right: 10px; font-size: 16px; }
        
        .main-content { margin-left: 320px; flex: 1; padding: 40px; }
        .header { margin-bottom: 40px; }
        .header h2 { color: #fff; font-size: 32px; margin-bottom: 10px; }
        .header p { color: #7a9cc4; font-size: 14px; }
        
        .cards-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; margin-bottom: 40px; }
        .card {
            background: rgba(100, 180, 255, 0.08);
            border: 1px solid rgba(100, 180, 255, 0.2);
            border-radius: 16px;
            padding: 30px;
            transition: all 0.3s ease;
        }
        .card:hover { transform: translateY(-5px); border-color: rgba(100, 180, 255, 0.4); }
        .card-icon { font-size: 40px; margin-bottom: 15px; }
        .card-value { font-size: 36px; font-weight: 700; color: #fff; margin-bottom: 8px; }
        .card-label { color: #7a9cc4; font-size: 14px; }
        .card.entradas .card-value { color: #00e676; }
        .card.saidas .card-value { color: #ff6b6b; }
        .card.saldo .card-value { color: #64b4ff; }
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
            
            <div class="menu-section">
                <div class="menu-parent financeiro" onclick="toggleSubmenu('financeiro')">
                    <span class="icon">💰</span>
                    <span>Financeiro</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="submenu open" id="submenu-financeiro">
                    <a href="index.php" class="submenu-item active"><span class="icon">📊</span> Resumo</a>
                    <a href="contas.php" class="submenu-item"><span class="icon">🏦</span> Contas Bancárias</a>
                    <a href="movimentacoes.php" class="submenu-item"><span class="icon">💵</span> Movimentações</a>
                    <a href="categorias.php" class="submenu-item"><span class="icon">🏷️</span> Categorias</a>
                    <a href="fornecedores.php" class="submenu-item"><span class="icon">🤝</span> Fornecedores</a>
                </div>
            </div>
            
            <div class="menu-section">
                <div class="menu-parent" onclick="location.href='../../index.php'">
                    <span class="icon">🏠</span>
                    <span>Voltar ao Início</span>
                </div>
            </div>
        </nav>

        <main class="main-content">
            <div class="header">
                <h2>💰 Resumo Financeiro</h2>
                <p>Visão geral das suas finanças</p>
            </div>

            <div class="cards-grid">
                <div class="card entradas">
                    <div class="card-icon">📈</div>
                    <div class="card-value">R$ <?php echo number_format($total_entradas, 2, ',', '.'); ?></div>
                    <div class="card-label">Total de Entradas</div>
                </div>
                
                <div class="card saidas">
                    <div class="card-icon">📉</div>
                    <div class="card-value">R$ <?php echo number_format($total_saidas, 2, ',', '.'); ?></div>
                    <div class="card-label">Total de Saídas</div>
                </div>
                
                <div class="card saldo">
                    <div class="card-icon">💵</div>
                    <div class="card-value">R$ <?php echo number_format($saldo, 2, ',', '.'); ?></div>
                    <div class="card-label">Saldo Geral</div>
                </div>
            </div>
            
            <div class="cards-grid">
                <div class="card">
                    <div class="card-icon">🏦</div>
                    <div class="card-value"><?php echo $contas; ?></div>
                    <div class="card-label">Contas Ativas</div>
                </div>
                
                <div class="card">
                    <div class="card-icon">📋</div>
                    <div class="card-value"><?php echo $movimentacoes; ?></div>
                    <div class="card-label">Movimentações Registradas</div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        function toggleSubmenu(id) {
            document.querySelectorAll('.submenu').forEach(el => el.classList.remove('open'));
            document.querySelectorAll('.menu-parent').forEach(el => el.classList.remove('active'));
            document.getElementById('submenu-' + id).classList.add('open');
            event.currentTarget.classList.add('active');
        }
    </script>
</body>
</html>
