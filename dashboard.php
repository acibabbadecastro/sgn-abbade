<?php
// SGN - Dashboard LIMPO (sem valores financeiros visíveis)
require_once 'includes/config.php';

// Contagens APENAS (sem valores)
try {
    $total_contas = $pdo->query("SELECT COUNT(*) FROM financeiro.contas_bancarias WHERE ativa = true")->fetchColumn() ?: 0;
    $total_clientes = $pdo->query("SELECT COUNT(*) FROM financeiro.fornecedores_clientes WHERE ativo = true")->fetchColumn() ?: 0;
} catch (Exception $e) {
    $total_contas = 0;
    $total_clientes = 0;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SGN</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #16213e 100%); min-height: 100vh; color: #e0e0e0; }
        .container { display: flex; min-height: 100vh; }
        .sidebar { width: 280px; background: rgba(0, 0, 0, 0.4); backdrop-filter: blur(20px); border-right: 1px solid rgba(255, 255, 255, 0.1); position: fixed; height: 100vh; overflow-y: auto; }
        .logo-area { padding: 30px 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); text-align: center; }
        .logo-icon { font-size: 50px; margin-bottom: 10px; }
        .logo-area h1 { color: #00d4ff; font-size: 18px; font-weight: 600; }
        .logo-area p { color: #888; font-size: 11px; margin-top: 5px; }
        .menu { padding: 20px 0; flex: 1; }
        .menu-section { margin-bottom: 25px; }
        .menu-title { padding: 0 25px 10px; color: #666; font-size: 10px; text-transform: uppercase; letter-spacing: 2px; }
        .menu-item { display: flex; align-items: center; padding: 14px 25px; margin: 2px 15px; border-radius: 10px; color: #a0a0a0; text-decoration: none; font-size: 14px; transition: all 0.3s ease; }
        .menu-item:hover { background: rgba(255, 255, 255, 0.05); color: #fff; }
        .menu-item.active { background: linear-gradient(135deg, rgba(0, 212, 255, 0.2) 0%, rgba(0, 153, 204, 0.2) 100%); color: #00d4ff; border: 1px solid rgba(0, 212, 255, 0.3); }
        .menu-item .icon { width: 24px; margin-right: 15px; font-size: 18px; text-align: center; }
        .main-content { margin-left: 280px; flex: 1; padding: 30px; min-height: 100vh; }
        .header { margin-bottom: 30px; }
        .header h2 { color: #fff; font-size: 28px; }
        .header p { color: #888; margin-top: 5px; }
        .alert-box { background: rgba(0, 212, 255, 0.1); border: 1px solid rgba(0, 212, 255, 0.3); border-radius: 12px; padding: 20px; margin-bottom: 30px; color: #00d4ff; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 25px; text-align: center; }
        .stat-icon { font-size: 40px; margin-bottom: 15px; }
        .stat-value { font-size: 36px; font-weight: 700; color: #fff; }
        .stat-value.hidden { color: #444; background: #222; padding: 5px 15px; border-radius: 8px; font-size: 24px; }
        .stat-label { color: #888; font-size: 14px; margin-top: 10px; }
        .stat-hint { color: #666; font-size: 12px; margin-top: 5px; }
        .sections-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .section-card { background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 25px; }
        .section-card h3 { color: #fff; font-size: 18px; margin-bottom: 15px; display: flex; align-items: center; gap: 10px; }
        .section-card p { color: #666; font-size: 14px; margin-bottom: 15px; }
        .btn-primary { display: inline-block; padding: 10px 20px; background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%); color: #fff; text-decoration: none; border-radius: 8px; font-weight: 500; }
    </style>
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <div class="logo-area">
                <div class="logo-icon">🏢</div>
                <h1>ABBADE Technologies</h1>
                <p>Sistema de Gerenciamento</p>
            </div>
            <div class="menu">
                <div class="menu-section">
                    <div class="menu-title">Principal</div>
                    <a href="dashboard.php" class="menu-item active"><span class="icon">📊</span>Dashboard</a>
                </div>
                <div class="menu-section">
                    <div class="menu-title">Financeiro</div>
                    <a href="modulos/financeiro/index.php" class="menu-item"><span class="icon">💰</span>Resumo (com valores)</a>
                    <a href="modulos/financeiro/contas.php" class="menu-item"><span class="icon">🏦</span>Contas</a>
                </div>
                <div class="menu-section">
                    <div class="menu-title">Cadastros</div>
                    <a href="modulos/clientes/index.php" class="menu-item"><span class="icon">👥</span>Clientes</a>
                </div>
            </div>
        </nav>

        <main class="main-content">
            <div class="header">
                <h2>Dashboard</h2>
                <p>Visão geral - <?php echo date('d/m/Y'); ?></p>
            </div>

            <div class="alert-box">
                🔒 <strong>Valores ocultos:</strong> Para ver saldos e valores financeiros, acesse o menu <strong>Financeiro → Resumo</strong>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">🏦</div>
                    <div class="stat-value"><?php echo $total_contas; ?></div>
                    <div class="stat-label">Contas Bancárias</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-value"><?php echo $total_clientes; ?></div>
                    <div class="stat-label">Clientes/Fornecedores</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <div class="stat-value hidden">🔒</div>
                    <div class="stat-label">Saldo Total</div>
                    <div class="stat-hint">Acesse Financeiro → Resumo</div>
                </div>
            </div>

            <div class="sections-grid">
                <div class="section-card">
                    <h3>💰 Ver Financeiro</h3>
                    <p>Acesse resumo completo com saldos e movimentações.</p>
                    <a href="modulos/financeiro/index.php" class="btn-primary">Ir para Financeiro →</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
