<?php
// Movimentações Financeiras - Lista Completa
require_once '../../includes/config.php';

// Buscar todas as movimentações
$movimentacoes = $pdo->query("
    SELECT m.*, c.nome as categoria_nome, cb.apelido as conta_nome, fc.nome as pessoa_nome
    FROM financeiro.movimentacoes m
    LEFT JOIN financeiro.categorias c ON m.categoria_id = c.id
    LEFT JOIN financeiro.contas_bancarias cb ON m.conta_id = cb.id
    LEFT JOIN financeiro.fornecedores_clientes fc ON m.fornecedor_cliente_id = fc.id
    ORDER BY m.data DESC, m.id DESC
")->fetchAll();

// Contas para filtro
$contas = $pdo->query("SELECT * FROM financeiro.contas_bancarias WHERE ativa = true ORDER BY apelido")->fetchAll();
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
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th { text-align: left; padding: 15px; color: #888; border-bottom: 1px solid rgba(255, 255, 255, 0.1); font-weight: 500; white-space: nowrap; }
        td { padding: 12px 15px; border-bottom: 1px solid rgba(255, 255, 255, 0.05); color: #e0e0e0; }
        tr:hover td { background: rgba(255, 255, 255, 0.02); }
        .valor-entrada { color: #00ff64; font-weight: 600; }
        .valor-saida { color: #ff6b6b; font-weight: 600; }
        .codigo { font-family: monospace; color: #00d4ff; background: rgba(0, 212, 255, 0.1); padding: 3px 8px; border-radius: 4px; font-size: 12px; }
        .tipo-badge { padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; }
        .tipo-entrada { background: rgba(0, 255, 100, 0.2); color: #00ff64; }
        .tipo-saida { background: rgba(255, 107, 107, 0.2); color: #ff6b6b; }
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
                <a href="movimentacoes.php" class="menu-item active"><span class="icon">💵</span>Movimentações</a>
                <a href="categorias.php" class="menu-item"><span class="icon">🏷️</span>Categorias</a>
                <a href="fornecedores.php" class="menu-item"><span class="icon">🤝</span>Fornecedores/Clientes</a>
                
                <div class="menu-title" style="margin-top: 20px;">Voltar</div>
                <a href="../../index.php" class="menu-item"><span class="icon">←</span>Dashboard Principal</a>
            </div>
        </nav>

        <main class="main-content">
            <div class="header">
                <h2>💵 Todas as Movimentações</h2>
                <div style="color: #888;">Total: <?php echo count($movimentacoes); ?> registros</div>
            </div>

            <div class="table-container">
                <?php if (count($movimentacoes) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Data</th>
                            <th>Conta</th>
                            <th>Descrição</th>
                            <th>Categoria</th>
                            <th>>Fornecedor/Cliente</th>
                            <th>Tipo</th>
                            <th style="text-align: right;">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movimentacoes as $m): ?>
                        <tr>
                            <td><span class="codigo"><?php echo $m['codigo'] ?? 'N/A'; ?></span></td>
                            <td><?php echo formatarData($m['data']); ?></td>
                            <td><?php echo htmlspecialchars($m['conta_nome'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($m['descricao']); ?></td>
                            <td><?php echo htmlspecialchars($m['categoria_nome'] ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($m['pessoa_nome'] ?? '-'); ?></td>
                            <td><span class="tipo-badge tipo-<?php echo strtolower($m['tipo']); ?>"><?php echo $m['tipo']; ?></span></td>
                            <td style="text-align: right;" class="<?php echo $m['tipo'] == 'ENTRADA' ? 'valor-entrada' : 'valor-saida'; ?>">
                                <?php echo formatarMoeda($m['valor']); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p style="color: #666; text-align: center; padding: 40px;">Nenhuma movimentação registrada.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
