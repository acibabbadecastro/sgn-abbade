<?php
// SGN - Movimentações Financeiras
require_once '../../includes/config.php';

$movimentacoes = getMovimentacoes($pdo, 50);
$contas = getContas($pdo);
$categorias = getCategorias($pdo);

// Filtros
$filtro_conta = $_GET['conta'] ?? null;
$filtro_tipo = $_GET['tipo'] ?? null;
$filtro_data_inicio = $_GET['data_inicio'] ?? null;
$filtro_data_fim = $_GET['data_fim'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimentações - SGN</title>
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
        .logo-area {
            padding: 30px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        .logo-area h1 { color: #00d4ff; font-size: 18px; }
        .menu { padding: 20px 0; }
        .menu-section { margin-bottom: 25px; }
        .menu-title {
            padding: 0 25px 10px;
            color: #666;
            font-size: 10px;
            text-transform: uppercase;
        }
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
        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .header h2 { color: #fff; font-size: 28px; }
        .btn {
            padding: 12px 24px;
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
        }
        .filtros {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 12px;
        }
        .filtros select,
        .filtros input {
            padding: 10px 15px;
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            text-align: left;
            padding: 15px;
            color: #888;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        tr:hover { background: rgba(255, 255, 255, 0.02); }
        .tipo-receita { color: #28a745; }
        .tipo-despesa { color: #ff6b6b; }
        .valor-receita { color: #28a745; font-weight: 600; }
        .valor-despesa { color: #ff6b6b; font-weight: 600; }
        .categoria-tag {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
        }
        .paginacao {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 25px;
        }
        .paginacao a {
            padding: 10px 15px;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
        }
        .paginacao a.active {
            background: #00d4ff;
        }
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
                        <span class="icon">🏦</span>Contas
                    </a>
                    <a href="movimentacoes.php" class="menu-item active">
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
                <h2>📈 Movimentações</h2>
                <a href="nova_movimentacao.php" class="btn">+ Nova Movimentação</a>
            </div>

            <div class="filtros">
                <select>
                    <option>Todas as Contas</option>
                    <?php foreach ($contas as $c): ?>
                    <option value="<?php echo $c['id']; ?>"><?php echo $c['apelido']; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <select>
                    <option>Todos os Tipos</option>
                    <option>Receita</option>
                    <option>Despesa</option>
                    <option>Transferência</option>
                </select>
                
                <select>
                    <option>Todas Categorias</option>
                    <?php foreach ($categorias as $cat): ?>
                    <option><?php echo $cat['nome']; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <input type="date" placeholder="Data início">
                <input type="date" placeholder="Data fim">
                <button class="btn">Filtrar</button>
            </div>

            <div class="section">
                <table>
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th>Categoria</th>
                            <th>Tipo</th>
                            <th>Conta</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" style="text-align: center; color: #666; padding: 40px;">
                                Nenhuma movimentação registrada.
                                <br><br>
                                <a href="nova_movimentacao.php" class="btn">Registrar Movimentação</a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="paginacao">
                    <a href="#">← Anterior</a>
                    <a href="#" class="active">1</a>
                    <a href="#">Próximo →</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>