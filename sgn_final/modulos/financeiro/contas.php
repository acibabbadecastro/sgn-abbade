<?php
// Contas Bancárias
require_once '../../includes/config.php';

// Buscar contas
$contas = $pdo->query("SELECT * FROM financeiro.contas_bancarias ORDER BY apelido")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas Bancárias - SGN</title>
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
        .contas-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 20px; }
        .conta-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 25px;
            transition: all 0.3s ease;
        }
        .conta-card:hover { transform: translateY(-5px); border-color: rgba(0, 212, 255, 0.5); }
        .conta-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .conta-tipo { padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .conta-tipo.pj { background: rgba(0, 212, 255, 0.2); color: #00d4ff; }
        .conta-tipo.pf { background: rgba(0, 255, 100, 0.2); color: #00ff64; }
        .status-ativa { padding: 4px 10px; border-radius: 4px; font-size: 11px; background: rgba(0, 255, 100, 0.2); color: #00ff64; }
        .status-inativa { padding: 4px 10px; border-radius: 4px; font-size: 11px; background: rgba(255, 107, 107, 0.2); color: #ff6b6b; }
        .conta-nome { font-size: 22px; font-weight: 600; color: #fff; margin-bottom: 5px; }
        .conta-dados { color: #888; font-size: 14px; margin-bottom: 5px; }
        .conta-saldo { margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(255, 255, 255, 0.1); }
        .conta-saldo-label { color: #888; font-size: 12px; margin-bottom: 5px; }
        .conta-saldo-valor { font-size: 28px; font-weight: 700; color: #00ff64; }
        .conta-banco { color: #00d4ff; font-size: 14px; margin-top: 10px; }
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
                <a href="contas.php" class="menu-item active"><span class="icon">🏦</span>Contas Bancárias</a>
                <a href="movimentacoes.php" class="menu-item"><span class="icon">💵</span>Movimentações</a>
                <a href="categorias.php" class="menu-item"><span class="icon">🏷️</span>Categorias</a>
                <a href="fornecedores.php" class="menu-item"><span class="icon">🤝</span>Fornecedores/Clientes</a>
                
                <div class="menu-title" style="margin-top: 20px;">Voltar</div>
                <a href="../../index.php" class="menu-item"><span class="icon">←</span>Dashboard Principal</a>
            </div>
        </nav>

        <main class="main-content">
            <div class="header">
                <h2>🏦 Contas Bancárias</h2>
                <div style="color: #888;">Total: <?php echo count($contas); ?> contas</div>
            </div>

            <div class="contas-grid">
                <?php foreach ($contas as $c): ?>
                <div class="conta-card">
                    <div class="conta-header">
                        <div class="conta-tipo <?php echo $c['tipo_pessoa'] == 'PJ' ? 'pj' : 'pf'; ?>">
                            <?php echo $c['tipo_pessoa']; ?>
                        </div>
                        <div class="<?php echo $c['ativa'] ? 'status-ativa' : 'status-inativa'; ?>">
                            <?php echo $c['ativa'] ? 'ATIVA' : 'INATIVA'; ?>
                        </div>
                    </div>
                    
                    <div class="conta-nome"><?php echo htmlspecialchars($c['apelido']); ?></div>
                    <div class="conta-dados"><strong>Titular:</strong> <?php echo htmlspecialchars($c['titular']); ?></div>
                    <div class="conta-dados"><strong>CPF/CNPJ:</strong> <?php echo htmlspecialchars($c['cpf_cnpj']); ?></div>
                    <div class="conta-dados"><strong>Conta:</strong> <?php echo htmlspecialchars($c['numero_conta']); ?></div>
                    
                    <div class="conta-banco"><?php echo htmlspecialchars($c['banco']); ?></div>
                    
                    <div class="conta-saldo">
                        <div class="conta-saldo-label">Saldo Atual</div>
                        <div class="conta-saldo-valor"><?php echo formatarMoeda($c['saldo_atual'] ?? 0); ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</body>
</html>
