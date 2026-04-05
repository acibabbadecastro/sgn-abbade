<?php
// Módulo Financeiro - Dashboard
require_once '../../includes/config.php';

// Estatísticas
$total_entradas = $pdo->query("SELECT COALESCE(SUM(valor), 0) FROM financeiro.movimentacoes WHERE tipo = 'ENTRADA'")->fetchColumn();
$total_saidas = $pdo->query("SELECT COALESCE(SUM(valor), 0) FROM financeiro.movimentacoes WHERE tipo = 'SAIDA'")->fetchColumn();
$caixa = $total_entradas - $total_saidas;

// Contas bancárias
$contas = $pdo->query("SELECT * FROM financeiro.contas_bancarias WHERE ativa = true ORDER BY apelido")->fetchAll();

// Movimentações recentes
$movimentacoes = $pdo->query("
    SELECT m.*, c.nome as categoria_nome, cb.apelido as conta_nome
    FROM financeiro.movimentacoes m
    LEFT JOIN financeiro.categorias c ON m.categoria_id = c.id
    LEFT JOIN financeiro.contas_bancarias cb ON m.conta_id = cb.id
    ORDER BY m.data DESC, m.id DESC
    LIMIT 10
")->fetchAll();
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
        .cards-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;
        }
        .card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 25px;
            transition: transform 0.3s ease;
        }
        .card:hover { transform: translateY(-5px); }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .card-icon { font-size: 35px; }
        .card-value { font-size: 32px; font-weight: 700; color: #fff; }
        .card-label { color: #888; font-size: 14px; }
        .card-entrada .card-value { color: #00ff64; }
        .card-saida .card-value { color: #ff6b6b; }
        .card-caixa .card-value { color: #00d4ff; }
        .section {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
        }
        .section h3 { color: #00d4ff; margin-bottom: 20px; font-size: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #888; border-bottom: 1px solid rgba(255, 255, 255, 0.1); font-weight: 500; }
        td { padding: 15px; border-bottom: 1px solid rgba(255, 255, 255, 0.05); color: #e0e0e0; }
        tr:hover td { background: rgba(255, 255, 255, 0.02); }
        .valor-entrada { color: #00ff64; font-weight: 600; }
        .valor-saida { color: #ff6b6b; font-weight: 600; }
        .contas-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .conta-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 25px;
            text-decoration: none;
            color: inherit;
            display: block;
            transition: all 0.3s ease;
        }
        .conta-card:hover { transform: translateY(-5px); border-color: rgba(0, 212, 255, 0.5); }
        .conta-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .conta-tipo { padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .conta-tipo.pj { background: rgba(0, 212, 255, 0.2); color: #00d4ff; }
        .conta-tipo.pf { background: rgba(0, 255, 100, 0.2); color: #00ff64; }
        .conta-nome { font-size: 20px; font-weight: 600; color: #fff; margin-bottom: 5px; }
        .conta-numero { color: #888; font-size: 14px; }
        .conta-saldo { margin-top: 15px; padding-top: 15px; border-top: 1px solid rgba(255, 255, 255, 0.1); }
        .conta-saldo-label { color: #888; font-size: 12px; }
        .conta-saldo-valor { font-size: 24px; font-weight: 700; color: #00ff64; }
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
                <a href="index.php" class="menu-item active"><span class="icon">📊</span>Resumo</a>
                <a href="contas.php" class="menu-item"><span class="icon">🏦</span>Contas Bancárias</a>
                <a href="movimentacoes.php" class="menu-item"><span class="icon">💵</span>Movimentações</a>
                <a href="categorias.php" class="menu-item"><span class="icon">🏷️</span>Categorias</a>
                <a href="fornecedores.php" class="menu-item"><span class="icon">🤝</span>Fornecedores/Clientes</a>
                
                <div class="menu-title" style="margin-top: 20px;">Voltar</div>
                <a href="../../index.php" class="menu-item"><span class="icon">←</span>Dashboard Principal</a>
            </div>
        </nav>

        <main class="main-content">
            <div class="header">
                <h2>💰 Financeiro</h2>
                <div>
                    <span style="color: #888;"><?php echo date('d/m/Y'); ?></span>
                </div>
            </div>

            <div class="cards-grid">
                <div class="card card-entrada">
                    <div class="card-header">
                        <span class="card-icon">📥</span>
                    </div>
                    <div class="card-value"><?php echo formatarMoeda($total_entradas); ?></div>
                    <div class="card-label">Total Entradas</div>
                </div>
                
                <div class="card card-saida">
                    <div class="card-header">
                        <span class="card-icon">📤</span>
                    </div>
                    <div class="card-value"><?php echo formatarMoeda($total_saidas); ?></div>
                    <div class="card-label">Total Saídas</div>
                </div>
                
                <div class="card card-caixa">
                    <div class="card-header">
                        <span class="card-icon">💰</span>
                    </div>
                    <div class="card-value"><?php echo formatarMoeda($caixa); ?></div>
                    <div class="card-label">Saldo em Caixa</div>
                </div>
            </div>

            <div class="section">
                <h3>🏦 Contas Bancárias</h3>
                <div class="contas-grid">
                    <?php foreach ($contas as $c): ?>
                    <div class="conta-card">
                        <div class="conta-header">
                            <div class="conta-tipo <?php echo $c['tipo_pessoa'] == 'PJ' ? 'pj' : 'pf'; ?>">
                                <?php echo $c['tipo_pessoa']; ?>
                            </div>
                            <div style="color: #888; font-size: 12px;">ID: <?php echo $c['id']; ?></div>
                        </div>
                        <div class="conta-nome"><?php echo htmlspecialchars($c['apelido']); ?></div>
                        <div class="conta-numero"><?php echo htmlspecialchars($c['numero_conta']); ?></div>
                        
                        <div class="conta-saldo">
                            <div class="conta-saldo-label">Saldo</div>
                            <div class="conta-saldo-valor"><?php echo formatarMoeda($c['saldo_atual'] ?? 0); ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="section">
                <h3>📝 Movimentações Recentes</h3>
                <?php if (count($movimentacoes) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Conta</th>
                            <th>Descrição</th>
                            <th>Categoria</th>
                            <th>Tipo</th>
                            <th style="text-align: right;">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movimentacoes as $m): ?>
                        <tr>
                            <td><?php echo formatarData($m['data']); ?></td>
                            <td><?php echo htmlspecialchars($m['conta_nome'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($m['descricao']); ?></td>
                            <td><?php echo htmlspecialchars($m['categoria_nome'] ?? 'N/A'); ?></td>
                            <td><?php echo $m['tipo']; ?></td>
                            <td style="text-align: right;" class="<?php echo $m['tipo'] == 'ENTRADA' ? 'valor-entrada' : 'valor-saida'; ?>">
                                <?php echo formatarMoeda($m['valor']); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p style="color: #666; text-align: center; padding: 20px;">Nenhuma movimentação registrada.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
