<?php
// Módulo Estoque
require_once '../../includes/config.php';

// Buscar produtos
$produtos = $pdo->query("
    SELECT p.*, c.nome as categoria_nome
    FROM estoque.produtos p
    LEFT JOIN estoque.categorias c ON p.categoria_id = c.id
    ORDER BY p.nome
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque - SGN</title>
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
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        .logo-area { padding: 30px 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); text-align: center; }
        .logo-icon { font-size: 50px; margin-bottom: 10px; }
        .logo-area h1 { color: #00d4ff; font-size: 18px; }
        .menu { padding: 20px 0; }
        .menu-title { padding: 0 25px 10px; color: #666; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; }
        .menu-item {
            display: flex; align-items: center;
            padding: 14px 25px; margin: 2px 15px;
            border-radius: 10px;
            color: #a0a0a0; text-decoration: none; font-size: 14px;
        }
        .menu-item:hover { background: rgba(255, 255, 255, 0.05); color: #fff; }
        .menu-item.active { background: linear-gradient(135deg, rgba(0, 212, 255, 0.2) 0%, rgba(0, 153, 204, 0.2) 100%); color: #00d4ff; border: 1px solid rgba(0, 212, 255, 0.3); }
        .menu-item .icon { margin-right: 12px; font-size: 18px; }
        .main-content { margin-left: 280px; flex: 1; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h2 { color: #fff; font-size: 28px; }
        .table-container {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
            overflow-x: auto;
        }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #888; border-bottom: 1px solid rgba(255, 255, 255, 0.1); font-weight: 500; }
        td { padding: 15px; border-bottom: 1px solid rgba(255, 255, 255, 0.05); color: #e0e0e0; }
        tr:hover td { background: rgba(255, 255, 255, 0.02); }
        .estoque-baixo { color: #ff6b6b; font-weight: 600; }
        .estoque-ok { color: #00ff64; }
        .codigo-produto { font-family: monospace; color: #00d4ff; background: rgba(0, 212, 255, 0.1); padding: 3px 8px; border-radius: 4px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <div class="logo-area">
                <div class="logo-icon">🏢</div>
                <h1>ABBADE Technologies</h1>
            </div>
            <div class="menu">
                <div class="menu-title">Estoque</div>
                <a href="index.php" class="menu-item active"><span class="icon">📦</span>Produtos</a>
                
                <div class="menu-title" style="margin-top: 20px;">Voltar</div>
                <a href="../../index.php" class="menu-item"><span class="icon">←</span>Dashboard Principal</a>
            </div>
        </nav>

        <main class="main-content">
            <div class="header">
                <h2>📦 Estoque</h2>
                <div style="color: #888;">Total: <?php echo count($produtos); ?> produtos</div>
            </div>

            <div class="table-container">
                <?php if (count($produtos) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th style="text-align: center;">Estoque</th>
                            <th style="text-align: right;">Preço Custo</th>
                            <th style="text-align: right;">Preço Venda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $p): ?>
                        <tr>
                            <td><span class="codigo-produto"><?php echo htmlspecialchars($p['codigo'] ?? 'N/A'); ?></span></td>
                            <td><strong><?php echo htmlspecialchars($p['nome']); ?></strong></td>
                            <td><?php echo htmlspecialchars($p['categoria_nome'] ?? 'N/A'); ?></td>
                            <td style="text-align: center;">
                                <span class="<?php echo $p['quantidade'] <= $p['estoque_minimo'] ? 'estoque-baixo' : 'estoque-ok'; ?>">
                                    <?php echo $p['quantidade']; ?>
                                </span>
                            </td>
                            <td style="text-align: right;"><?php echo formatarMoeda($p['preco_custo'] ?? 0); ?></td>
                            <td style="text-align: right;"><?php echo formatarMoeda($p['preco_venda'] ?? 0); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p style="color: #666; text-align: center; padding: 40px;">Nenhum produto cadastrado.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
