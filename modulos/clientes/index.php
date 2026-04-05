<?php
// SGN - Clientes
require_once '../../includes/config.php';

$clientes = getClientes($pdo);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - SGN</title>
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
        .logo-area { padding: 30px 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); text-align: center; }
        .logo-area h1 { color: #00d4ff; font-size: 18px; }
        .menu { padding: 20px 0; }
        .menu-section { margin-bottom: 25px; }
        .menu-title { padding: 0 25px 10px; color: #666; font-size: 10px; text-transform: uppercase; }
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
        .main-content { margin-left: 280px; flex: 1; padding: 30px; }
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
        .busca {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }
        .busca input {
            flex: 1;
            padding: 12px 15px;
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
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #888; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        td { padding: 15px; border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .acoes { display: flex; gap: 8px; }
        .acoes a {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            color: #fff;
        }
        .btn-edit { background: rgba(0, 212, 255, 0.3); }
        .btn-view { background: rgba(40, 167, 69, 0.3); }
        .empty { text-align: center; padding: 60px; color: #666; }
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
                    <div class="menu-title">Cadastros</div>
                    <a href="index.php" class="menu-item active">
                        <span class="icon">👥</span>Clientes
                    </a>
                    <a href="fornecedores.php" class="menu-item">
                        <span class="icon">🏭</span>Fornecedores
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
                <h2>👥 Clientes</h2>
                <div>
                    <a href="importar.php" class="btn" style="margin-right: 10px;">📥 Importar</a>
                    <a href="cadastro.php" class="btn">+ Novo Cliente</a>
                </div>
            </div>

            <div class="busca">
                <input type="text" placeholder="Buscar por nome, CPF/CNPJ ou telefone...">
                <button class="btn">Buscar</button>
            </div>

            <div class="section">
                <?php if (count($clientes) > 0): ?
                    <table>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Contato</th>
                                <th>CPF/CNPJ</th>
                                <th>Cidade</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $c): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($c['nome']); ?></td>
                                <td><?php echo htmlspecialchars($c['telefone']); ?></td>
                                <td><?php echo htmlspecialchars($c['cpf_cnpj']); ?></td>
                                <td><?php echo htmlspecialchars($c['cidade'] ?? '-'); ?></td>
                                <td class="acoes">
                                    <a href="ver.php?id=<?php echo $c['id']; ?>" class="btn-view">Ver</a>
                                    <a href="cadastro.php?id=<?php echo $c['id']; ?>" class="btn-edit">Editar</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                
                <?php else: ?>
                    <div class="empty">
                        <p>Nenhum cliente cadastrado.</p>
                        <p>Importe de extratos bancários ou cadastre manualmente.</p>
                        <a href="cadastro.php" class="btn" style="margin-top: 20px;">Cadastrar Cliente</a>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>