<?php
// Contas Bancárias
require_once '../../includes/config.php';
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
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg, #1a2a3a 0%, #0d1b2a 50%, #1b3a5c 100%); min-height: 100vh; color: #e0e0e0; }
        .container { display: flex; min-height: 100vh; }
        .sidebar { width: 320px; background: rgba(13, 27, 42, 0.95); border-right: 1px solid rgba(100, 180, 255, 0.15); position: fixed; height: 100vh; overflow-y: auto; padding: 30px 20px; }
        .logo-area { text-align: center; margin-bottom: 40px; padding-bottom: 30px; border-bottom: 1px solid rgba(100, 180, 255, 0.15); }
        .logo-icon { font-size: 60px; margin-bottom: 15px; }
        .logo-area h1 { color: #64b4ff; font-size: 22px; font-weight: 600; }
        .logo-area p { color: #7a9cc4; font-size: 12px; margin-top: 5px; }
        .menu-section { margin-bottom: 10px; }
        .menu-parent { display: flex; align-items: center; width: 100%; padding: 16px 20px; background: rgba(100, 180, 255, 0.05); border: 1px solid rgba(100, 180, 255, 0.1); border-radius: 12px; color: #a0b8d0; text-decoration: none; font-size: 15px; cursor: pointer; transition: all 0.3s ease; }
        .menu-parent:hover, .menu-parent.active { background: rgba(100, 200, 255, 0.1); border-color: rgba(100, 200, 255, 0.3); color: #64b4ff; }
        .menu-parent .icon { font-size: 22px; margin-right: 15px; }
        .menu-parent .arrow { margin-left: auto; font-size: 14px; }
        .submenu { display: none; padding: 10px 0 10px 30px; }
        .submenu.open { display: block; }
        .submenu-item { display: flex; align-items: center; padding: 12px 20px; margin: 4px 0; background: rgba(100, 180, 255, 0.03); border-radius: 8px; color: #7a9cc4; text-decoration: none; font-size: 14px; transition: all 0.2s ease; }
        .submenu-item:hover, .submenu-item.active { background: rgba(100, 180, 255, 0.1); color: #64b4ff; transform: translateX(5px); }
        .submenu-item .icon { margin-right: 10px; font-size: 16px; }
        .main-content { margin-left: 320px; flex: 1; padding: 40px; }
        .header { margin-bottom: 40px; }
        .header h2 { color: #fff; font-size: 32px; margin-bottom: 10px; }
        .header p { color: #7a9cc4; font-size: 14px; }
        .contas-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 25px; }
        .conta-card { background: rgba(100, 180, 255, 0.08); border: 1px solid rgba(100, 180, 255, 0.2); border-radius: 16px; padding: 30px; transition: all 0.3s ease; }
        .conta-card:hover { transform: translateY(-5px); border-color: rgba(100, 180, 255, 0.4); }
        .conta-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .badge { padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-pj { background: rgba(100, 180, 255, 0.2); color: #64b4ff; }
        .badge-pf { background: rgba(0, 230, 118, 0.2); color: #00e676; }
        .badge-ativa { background: rgba(0, 230, 118, 0.2); color: #00e676; }
        .badge-inativa { background: rgba(255, 107, 107, 0.2); color: #ff6b6b; }
        .conta-nome { font-size: 24px; font-weight: 600; color: #fff; margin-bottom: 10px; }
        .conta-dado { color: #7a9cc4; font-size: 14px; margin-bottom: 8px; }
        .conta-dado strong { color: #a0b8d0; }
        .conta-saldo { margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(100, 180, 255, 0.15); }
        .conta-saldo-label { color: #7a9cc4; font-size: 12px; text-transform: uppercase; margin-bottom: 5px; }
        .conta-saldo-valor { font-size: 32px; font-weight: 700; color: #64b4ff; }
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
                <div class="menu-parent" onclick="toggleSubmenu('financeiro')">
                    <span class="icon">💰</span>
                    <span>Financeiro</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="submenu open" id="submenu-financeiro">
                    <a href="index.php" class="submenu-item"><span class="icon">📊</span> Resumo</a>
                    <a href="contas.php" class="submenu-item active"><span class="icon">🏦</span> Contas Bancárias</a>
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
                <h2>🏦 Contas Bancárias</h2>
                <p><?php echo count($contas); ?> contas cadastradas</p>
            </div>

            <div class="contas-grid">
                <?php foreach ($contas as $c): ?>
                <div class="conta-card">
                    <div class="conta-header">
                        <span class="badge <?php echo $c['tipo_pessoa'] == 'PJ' ? 'badge-pj' : 'badge-pf'; ?>">
                            <?php echo $c['tipo_pessoa']; ?>
                        </span>
                        <span class="badge <?php echo $c['ativa'] ? 'badge-ativa' : 'badge-inativa'; ?>">
                            <?php echo $c['ativa'] ? 'ATIVA' : 'INATIVA'; ?>
                        </span>
                    </div>
                    <div class="conta-nome"><?php echo htmlspecialchars($c['apelido']); ?></div>
                    <div class="conta-dado"><strong>Titular:</strong> <?php echo htmlspecialchars($c['titular']); ?></div>
                    <div class="conta-dado"><strong>CPF/CNPJ:</strong> <?php echo htmlspecialchars($c['cpf_cnpj']); ?></div>
                    <div class="conta-dado"><strong>Conta:</strong> <?php echo htmlspecialchars($c['numero_conta']); ?></div>
                    <div class="conta-dado"><strong>Banco:</strong> <?php echo htmlspecialchars($c['banco']); ?></div>
                    <div class="conta-saldo">
                        <div class="conta-saldo-label">Saldo Atual</div>
                        <div class="conta-saldo-valor">R$ <?php echo number_format($c['saldo_atual'] ?? 0, 2, ',', '.'); ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
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
