<?php
// Fornecedores e Clientes
require_once '../../includes/config.php';

// Buscar fornecedores/clientes
$pessoas = $pdo->query("SELECT * FROM financeiro.fornecedores_clientes ORDER BY tipo, nome")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores/Clientes - SGN</title>
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
        .tipo-badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .tipo-fornecedor { background: rgba(0, 212, 255, 0.2); color: #00d4ff; }
        .tipo-cliente { background: rgba(0, 255, 100, 0.2); color: #00ff64; }
        .tipo-both { background: rgba(255, 193, 7, 0.2); color: #ffc107; }
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
                <div class="menu-title">Financeiro</div>
                <a href="index.php" class="menu-item"><span class="icon">📊</span>Resumo</a>
                <a href="contas.php" class="menu-item"><span class="icon">🏦</span>Contas Bancárias</a>
                <a href="movimentacoes.php" class="menu-item"><span class="icon">💵</span>Movimentações</a>
                <a href="categorias.php" class="menu-item"><span class="icon">🏷️</span>Categorias</a>
                <a href="fornecedores.php" class="menu-item active"><span class="icon">🤝</span>Fornecedores/Clientes</a>
                
                <div class="menu-title" style="margin-top: 20px;">Voltar</div>
                <a href="../../index.php" class="menu-item"><span class="icon">←</span>Dashboard Principal</a>
            </div>
        </nav>

        <main class="main-content">
            <div class="header">
                <h2>🤝 Fornecedores e Clientes</h2>
                <div style="color: #888;">Total: <?php echo count($pessoas); ?> registros</div>
            </div>

            <div class="table-container">
                <?php if (count($pessoas) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>CPF/CNPJ</th>
                            <th>Telefone</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pessoas as $p): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($p['nome']); ?></strong></td>
                            <td>
                                <span class="tipo-badge tipo-<?php echo $p['tipo']; ?>">
                                    <?php echo $p['tipo'] == 'fornecedor' ? 'FORNECEDOR' : ($p['tipo'] == 'cliente' ? 'CLIENTE' : 'AMBOS'); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($p['cpf_cnpj'] ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($p['telefone'] ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($p['email'] ?? '-'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p style="color: #666; text-align: center; padding: 40px;">Nenhum fornecedor ou cliente cadastrado.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
