<?php
// SGN - Extratos Bancários com Filtros
require_once '../../includes/config.php';

$contas = getContas($pdo);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extratos - SGN</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #16213e 100%);
            min-height: 100vh;
            color: #e0e0e0;
        }
        .container { display: flex; min-height: 100vh; }
        .sidebar {
            width: 280px;
            background: rgba(0, 0, 0, 0.4);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            position: fixed;
            height: 100vh;
        }
        .logo-area { padding: 30px 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); text-align: center; }
        .logo-area h1 { color: #00d4ff; font-size: 18px; }
        .menu { padding: 20px 0; }
        .menu-section { margin-bottom: 25px; }
        .menu-title { padding: 0 25px 10px; color: #666; font-size: 10px; text-transform: uppercase; }
        .menu-item {
            display: flex;
            align-items: center;
            padding: 14px 25px;
            margin: 2px 15px;
            border-radius: 10px;
            color: #a0a0a0;
            text-decoration: none;
            font-size: 14px;
        }
        .menu-item.active {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2) 0%, rgba(0, 153, 204, 0.2) 100%);
            color: #00d4ff;
            border: 1px solid rgba(0, 212, 255, 0.3);
        }
        .menu-item .icon { width: 24px; margin-right: 15px; }
        .main-content { margin-left: 280px; flex: 1; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h2 { color: #fff; font-size: 28px; }
        .btn {
            padding: 12px 24px;
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
        }
        .filtros-avancados {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
            padding: 25px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 16px;
        }
        .filtros-avancados select,
        .filtros-avancados input {
            padding: 12px 15px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #fff;
        }
        .section {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
        }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #888; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        td { padding: 15px; border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .entrada { color: #28a745; }
        .saida { color: #ff6b6b; }
    </style>
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <div class="logo-area">
                <h1>🏢 ABBADE Technologies</h1>
            </div>
            <div class="menu">
                <div class="menu-section">
                    <div class="menu-title">Financeiro</div>
                    <a href="index.php" class="menu-item">
                        <span class="icon">💰</span>Resumo
                    </a>
                    <a href="contas.php" class="menu-item">
                        <span class="icon">🏦</span>Contas Bancárias
                    </a>
                    <a href="extratos.php" class="menu-item active">
                        <span class="icon">📄</span>Extratos
                    </a>
                    <a href="movimentacoes.php" class="menu-item">
                        <span class="icon">📈</span>Movimentações
                    </a>
                </div>
                <div class="menu-section">
                    <a href="../../index.php" class="menu-item">
                        <span class="icon">⬅️</span>Dashboard
                    </a>
                </div>
            </div>
        </nav>

        <main class="main-content">
            <div class="header">
                <h2>📄 Extratos Bancários</h2>
                <a href="movimentacoes.php" class="btn">+ Nova Movimentação</a>
            </div>

            <div class="filtros-avancados">
                <select>
                    <option>Todas as Contas</option>
                    <?php foreach ($contas as $c): ?>
                    <option><?php echo $c['apelido']; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <select>
                    <option>Todos os Tipos</option>
                    <option>Entrada</option>
                    <option>Saída</option>
                    <option>Transferência</option>
                </select>
                
                <select>
                    <option>Período: Este Mês</option>
                    <option>Últimos 7 dias</option>
                    <option>Últimos 30 dias</option>
                    <option>Este Ano</option>
                    <option>Personalizado...</option>
                </select>
                
                <select>
                    <option>Valor: Qualquer</option>
                    <option>Até R$ 100</option>
                    <option>R$ 100 a R$ 500</option>
                    <option>R$ 500 a R$ 1.000</option>
                    <option>Acima de R$ 1.000</option>
                </select>
                
                <input type="text" placeholder="Buscar descrição...">
                
                <button class="btn">🔍 Filtrar</button>
                <button class="btn">📥 Exportar</button>
            </div>

            <div class="section">
                <p style="color: #666; text-align: center; padding: 40px;">
                    Use os filtros acima para visualizar extratos.
                    <br>Os dados serão carregados do PostgreSQL.
                </p>
            </div>
        </main>
    </div>
</body>
</html>