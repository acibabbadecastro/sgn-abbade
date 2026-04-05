<?php
// Categorias Financeiras
require_once '../../includes/config.php';

// Buscar categorias
$categorias = $pdo->query("SELECT * FROM financeiro.categorias ORDER BY tipo, nome")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias - SGN</title>
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
        .categorias-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
        .categoria-section { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 25px; }
        .categoria-section h3 { color: #00d4ff; margin-bottom: 20px; font-size: 20px; }
        .categoria-list { list-style: none; }
        .categoria-item {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .categoria-item:last-child { border-bottom: none; }
        .categoria-nome { font-size: 16px; color: #fff; }
        .categoria-desc { font-size: 12px; color: #666; margin-top: 3px; }
        .tipo-entrada { color: #00ff64; }
        .tipo-saida { color: #ff6b6b; }
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
                <a href="categorias.php" class="menu-item active"><span class="icon">🏷️</span>Categorias</a>
                <a href="fornecedores.php" class="menu-item"><span class="icon">🤝</span>Fornecedores/Clientes</a>
                
                <div class="menu-title" style="margin-top: 20px;">Voltar</div>
                <a href="../../index.php" class="menu-item"><span class="icon">←</span>Dashboard Principal</a>
            </div>
        </nav>

        <main class="main-content">
            <div class="header">
                <h2>🏷️ Categorias Financeiras</h2>
            </div>

            <div class="categorias-grid">
                <div class="categoria-section">
                    <h3 class="tipo-entrada">📥 Entradas</h3>
                    <ul class="categoria-list">
                        <?php 
                        $entradas = array_filter($categorias, function($c) { return $c['tipo'] == 'ENTRADA'; });
                        if (count($entradas) > 0):
                            foreach ($entradas as $cat): 
                        ?>
                        <li class="categoria-item">
                            <div>
                                <div class="categoria-nome"><?php echo htmlspecialchars($cat['nome']); ?></div>
                                <?php if ($cat['descricao']): ?>
                                <div class="categoria-desc"><?php echo htmlspecialchars($cat['descricao']); ?></div>
                                <?php endif; ?>
                            </div>
                        </li>
                        <?php endforeach; else: ?>
                        <li class="categoria-item"><span style="color: #666;">Nenhuma categoria de entrada</span></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="categoria-section">
                    <h3 class="tipo-saida">📤 Saídas</h3>
                    <ul class="categoria-list">
                        <?php 
                        $saidas = array_filter($categorias, function($c) { return $c['tipo'] == 'SAIDA'; });
                        if (count($saidas) > 0):
                            foreach ($saidas as $cat): 
                        ?>
                        <li class="categoria-item">
                            <div>
                                <div class="categoria-nome"><?php echo htmlspecialchars($cat['nome']); ?></div>
                                <?php if ($cat['descricao']): ?>
                                <div class="categoria-desc"><?php echo htmlspecialchars($cat['descricao']); ?></div>
                                <?php endif; ?>
                            </div>
                        </li>
                        <?php endforeach; else: ?>
                        <li class="categoria-item"><span style="color: #666;">Nenhuma categoria de saída</span></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
