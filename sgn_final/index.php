<?php
// Página inicial do SGN - Dashboard
require_once 'includes/config.php';

// Buscar estatísticas
$clientes = $pdo->query("SELECT COUNT(*) FROM clientes.clientes")->fetchColumn();
$os_abertas = $pdo->query("SELECT COUNT(*) FROM os.ordens_servico WHERE status = 'ABERTA'")->fetchColumn();
$os_andamento = $pdo->query("SELECT COUNT(*) FROM os.ordens_servico WHERE status = 'EM_ANDAMENTO'")->fetchColumn();
$os_concluidas = $pdo->query("SELECT COUNT(*) FROM os.ordens_servico WHERE status = 'CONCLUIDA'")->fetchColumn();

// Total em caixa
$total_entradas = $pdo->query("SELECT COALESCE(SUM(valor), 0) FROM financeiro.movimentacoes WHERE tipo = 'ENTRADA'")->fetchColumn();
$total_saidas = $pdo->query("SELECT COALESCE(SUM(valor), 0) FROM financeiro.movimentacoes WHERE tipo = 'SAIDA'")->fetchColumn();
$caixa = $total_entradas - $total_saidas;

// Últimas movimentações
$movimentacoes = $pdo->query("
    SELECT m.*, c.nome as categoria_nome 
    FROM financeiro.movimentacoes m 
    LEFT JOIN financeiro.categorias c ON m.categoria_id = c.id 
    ORDER BY m.data DESC, m.id DESC 
    LIMIT 5
")->fetchAll();

// Últimas OS
$ultimas_os = $pdo->query("
    SELECT os.*, c.nome as cliente_nome 
    FROM os.ordens_servico os 
    LEFT JOIN clientes.clientes c ON os.cliente_id = c.id 
    ORDER BY os.id DESC 
    LIMIT 5
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGN - Sistema de Gestão de Negócios</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
        .logo-area {
            padding: 30px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        .logo-icon { font-size: 50px; margin-bottom: 10px; }
        .logo-area h1 { color: #00d4ff; font-size: 18px; }
        .menu { padding: 20px 0; }
        .menu-title {
            padding: 0 25px 10px;
            color: #666;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
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
        .menu-item .icon { margin-right: 12px; font-size: 18px; }
        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .header h2 { color: #fff; font-size: 28px; }
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 25px;
            transition: transform 0.3s ease;
        }
        .card:hover { transform: translateY(-5px); }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .card-icon { font-size: 35px; }
        .card-value { font-size: 32px; font-weight: 700; color: #fff; }
        .card-label { color: #888; font-size: 14px; }
        .card-clientes .card-value { color: #00d4ff; }
        .card-os .card-value { color: #ff6b6b; }
        .card-caixa .card-value { color: #00ff64; }
        .section {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
        }
        .section h3 {
            color: #00d4ff;
            margin-bottom: 20px;
            font-size: 20px;
        }
        table { width: 100%; border-collapse: collapse; }
        th {
            text-align: left;
            padding: 15px;
            color: #888;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-weight: 500;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: #e0e0e0;
        }
        tr:hover td { background: rgba(255, 255, 255, 0.02); }
        .status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .status-aberta { background: rgba(255, 107, 107, 0.2); color: #ff6b6b; }
        .status-andamento { background: rgba(255, 193, 7, 0.2); color: #ffc107; }
        .status-concluida { background: rgba(0, 255, 100, 0.2); color: #00ff64; }
        .valor-entrada { color: #00ff64; }
        .valor-saida { color: #ff6b6b; }
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
                <div class="menu-title">Principal</div>
                <a href="index.php" class="menu-item active">
                    <span class="icon">📊</span>Dashboard
                </a>
                
                <div class="menu-title" style="margin-top: 20px;">Módulos</div>
                <a href="modulos/clientes/index.php" class="menu-item">
                    <span class="icon">👥</span>Clientes
                </a>
                <a href="modulos/os/index.php" class="menu-item">
                    <span class="icon">🔧</span>Ordens de Serviço
                </a>
                <a href="modulos/financeiro/index.php" class="menu-item">
                    <span class="icon">💰</span>Financeiro
                </a>
                <a href="modulos/estoque/index.php" class="menu-item">
                    <span class="icon">📦</span>Estoque
                </a>
            </div>
        </nav>

        <main class="main-content">
            <div class="header">
                <h2>📊 Dashboard</h2>
                <div style="color: #888;"><?php echo date('d/m/Y H:i'); ?></div>
            </div>

            <div class="cards-grid">
                <div class="card card-clientes">
                    <div class="card-header">
                        <span class="card-icon">👥</span>
                    </div>
                    <div class="card-value"><?php echo $clientes; ?></div>
                    <div class="card-label">Clientes Cadastrados</div>
                </div>
                
                <div class="card card-os">
                    <div class="card-header">
                        <span class="card-icon">🔧</span>
                    </div>
                    <div class="card-value"><?php echo $os_abertas + $os_andamento; ?></div>
                    <div class="card-label">OS em Aberto</div>
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
                <h3>💰 Últimas Movimentações Financeiras</h3>
                <?php if (count($movimentacoes) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Data</th>
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

            <div class="section">
                <h3>🔧 Últimas Ordens de Serviço</h3>
                <?php if (count($ultimas_os) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>OS #</th>
                            <th>Cliente</th>
                            <th>Equipamento</th>
                            <th>Status</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ultimas_os as $os): ?>
                        <tr>
                            <td>#<?php echo $os['id']; ?></td>
                            <td><?php echo htmlspecialchars($os['cliente_nome'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($os['equipamento']); ?></td>
                            <td>
                                <span class="status status-<?php echo strtolower($os['status']); ?>">
                                    <?php echo str_replace('_', ' ', $os['status']); ?>
                                </span>
                            </td>
                            <td><?php echo formatarData($os['data_abertura']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p style="color: #666; text-align: center; padding: 20px;">Nenhuma ordem de serviço registrada.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
