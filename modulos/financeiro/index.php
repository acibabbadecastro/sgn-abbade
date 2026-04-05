<?php
// SGN - Módulo Financeiro - Resumo das 4 Contas
require_once '../../includes/config.php';

$contas = getContas($pdo);
$resumo = getResumoMensal($pdo);
$saldo_total = getSaldoTotal($pdo);

// Calcular totais
$total_receitas = $resumo['receitas'] ?? 0;
$total_despesas = $resumo['despesas'] ?? 0;
$total_transferencias = $resumo['transferencias'] ?? 0;
$saldo_mes = $total_receitas - $total_despesas;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financeiro - Resumo - SGN</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #16213e 100%);
            min-height: 100vh;
            color: #e0e0e0;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .logo-area {
            padding: 30px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .logo-icon {
            font-size: 50px;
            margin-bottom: 10px;
        }

        .logo-area h1 {
            color: #00d4ff;
            font-size: 18px;
            font-weight: 600;
        }

        .menu {
            flex: 1;
            padding: 20px 0;
        }

        .menu-section {
            margin-bottom: 25px;
        }

        .menu-title {
            padding: 0 25px 10px;
            color: #666;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
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
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .menu-item.active {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2) 0%, rgba(0, 153, 204, 0.2) 100%);
            color: #00d4ff;
            border: 1px solid rgba(0, 212, 255, 0.3);
        }

        .menu-item .icon {
            width: 24px;
            margin-right: 15px;
            font-size: 18px;
            text-align: center;
        }

        .user-area {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logout-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background: rgba(255, 71, 87, 0.1);
            border: 1px solid rgba(255, 71, 87, 0.3);
            border-radius: 8px;
            color: #ff6b6b;
            text-align: center;
            text-decoration: none;
            font-size: 13px;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 30px;
        }

        .header {
            margin-bottom: 30px;
        }

        .header h2 {
            color: #fff;
            font-size: 28px;
        }

        .header p {
            color: #888;
        }

        /* Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .card-icon {
            font-size: 32px;
        }

        .card-value {
            font-size: 32px;
            font-weight: 700;
        }

        .card-value.positive {
            color: #00d4ff;
        }

        .card-value.negative {
            color: #ff6b6b;
        }

        .card-label {
            color: #888;
            font-size: 14px;
        }

        /* Contas Section */
        .section {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section h3 {
            color: #fff;
            font-size: 20px;
        }

        .btn {
            padding: 10px 20px;
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
        }

        /* Contas Grid */
        .contas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .conta-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 20px;
        }

        .conta-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .banco-tag {
            background: rgba(0, 212, 255, 0.1);
            color: #00d4ff;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
        }

        .tipo-tag {
            background: rgba(255, 255, 255, 0.05);
            color: #888;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
        }

        .conta-nome {
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .conta-numero {
            color: #666;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .conta-saldo {
            font-size: 28px;
            font-weight: 700;
            color: #00d4ff;
        }

        .conta-saldo-label {
            color: #666;
            font-size: 12px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px;
            color: #666;
        }

        .empty-state-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }

        .btn-primary {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="logo-area">
                <div class="logo-icon">🏢</div>
                <h1>ABBADE Technologies</h1>
            </div>

            <div class="menu">
                <div class="menu-section">
                    <div class="menu-title">Principal</div>
                    <a href="../../index.php" class="menu-item">
                        <span class="icon">📊</span>Dashboard
                    </a>
                </div>

                <div class="menu-section">
                    <div class="menu-title">Financeiro</div>
                    <a href="index.php" class="menu-item active">
                        <span class="icon">💰</span>Resumo
                    </a>
                    <a href="contas.php" class="menu-item">
                        <span class="icon">🏦</span>Contas
                    </a>
                    <a href="movimentacoes.php" class="menu-item">
                        <span class="icon">📈</span>Movimentações
                    </a>
                </div>
            </div>

            <div class="user-area">
                <a href="../../logout.php" class="logout-btn">Sair</a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h2>💰 Financeiro</h2>
                <p>Resumo das contas e movimentações</p>
            </div>

            <!-- Cards Resumo -->
            <div class="cards-grid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-icon">💰</span>
                    </div>
                    <div class="card-value positive"><?php echo formatMoney($saldo_total); ?></div>
                    <div class="card-label">Saldo Total em Contas</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-icon">📈</span>
                    </div>
                    <div class="card-value positive"><?php echo formatMoney($total_receitas); ?></div>
                    <div class="card-label">Receitas do Mês</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-icon">📉</span>
                    </div>
                    <div class="card-value negative"><?php echo formatMoney($total_despesas); ?></div>
                    <div class="card-label">Despesas do Mês</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-icon">📊</span>
                    </div>
                    <div class="card-value <?php echo $saldo_mes >= 0 ? 'positive' : 'negative'; ?>">
                        <?php echo formatMoney($saldo_mes); ?>
                    </div>
                    <div class="card-label">Saldo do Mês</div>
                </div>
            </div>

            <!-- Contas Bancárias -->
            <div class="section">
                <div class="section-header">
                    <h3>🏦 Contas Bancárias</h3>
                    <a href="contas.php" class="btn">Gerenciar Contas</a>
                </div>

                <?php if (count($contas) > 0): ?>
                    <div class="contas-grid">
                        <?php foreach ($contas as $conta): ?
                        <div class="conta-card">
                            <div class="conta-header">
                                <span class="banco-tag"><?php echo htmlspecialchars($conta['banco_nome'] ?? 'Banco'); ?></span>
                                <span class="tipo-tag"><?php echo $conta['tipo_pessoa']; ?></span>
                            </div>
                            
                            <div class="conta-nome"><?php echo htmlspecialchars($conta['apelido']); ?></div>
                            
                            <div class="conta-numero">Conta: <?php echo htmlspecialchars($conta['conta_numero']); ?></div>
                            
                            <div class="conta-saldo"><?php echo formatMoney($conta['saldo_atual']); ?></div>
                            
                            <div class="conta-saldo-label">Saldo Atual</div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?
                    <div class="empty-state">
                        <div class="empty-state-icon">🏦</div>
                        <p>Nenhuma conta cadastrada ainda.</p>
                        <a href="contas.php" class="btn-primary">Cadastrar Primeira Conta</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Resumo do Mês -->
            <div class="section">
                <h3>📊 Resumo do Mês (<?php echo date('m/Y'); ?>)</h3>
                
                <p style="color: #888; margin-top: 20px;">
                    Total de movimentações: <strong style="color: #00d4ff;"><?php echo $resumo['total'] ?? 0; ?></strong>
                </p>
                
                <p style="color: #888;">
                    Transferências: <strong style="color: #fff;"><?php echo formatMoney($total_transferencias); ?></strong>
                </p>
            </div>
        </main>
    </div>
</body>
</html>