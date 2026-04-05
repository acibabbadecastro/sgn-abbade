<?php
// SGN - Serviços Pendentes
require_once '../../includes/config.php';

$servicos = [
    ['id' => 1, 'cliente' => 'Pedro Almeida', 'equipamento' => 'Desktop HP', 'problema' => 'Placa mãe queimada', 'status' => 'aguardando_peca', 'prioridade' => 'alta'],
    ['id' => 2, 'cliente' => 'Ana Costa', 'equipamento' => 'Notebook Samsung', 'problema' => 'Aguardando aprovação', 'status' => 'aguardando_aprovacao', 'prioridade' => 'media'],
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços Pendentes - SGN</title>
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
        .logo-area {
            padding: 30px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        .logo-area h1 { color: #00d4ff; font-size: 18px; }
        .menu { padding: 20px 0; }
        .menu-section { margin-bottom: 25px; }
        .menu-title {
            padding: 0 25px 10px;
            color: #666;
            font-size: 10px;
            text-transform: uppercase;
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
        }
        .menu-item.active {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2) 0%, rgba(0, 153, 204, 0.2) 100%);
            color: #00d4ff;
            border: 1px solid rgba(0, 212, 255, 0.3);
        }
        .menu-item .icon { width: 24px; margin-right: 15px; }
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
        .btn {
            padding: 12px 24px;
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
        }
        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        .section {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
        }
        .section h3 { color: #fff; margin-bottom: 20px; }
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 20px;
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .prioridade-alta {
            background: rgba(255, 71, 87, 0.2);
            color: #ff6b6b;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
        }
        .prioridade-media {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
        }
        .status-tag {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
        }
        .status-aguardando_peca {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }
        .status-aguardando_aprovacao {
            background: rgba(0, 123, 255, 0.2);
            color: #007bff;
        }
        .card-title {
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .card-subtitle {
            color: #888;
            font-size: 13px;
        }
        .card-acoes {
            margin-top: 15px;
        }
        .btn-sm {
            padding: 8px 16px;
            font-size: 13px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            text-align: left;
            padding: 15px;
            color: #888;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
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
                    <div class="menu-title">Serviços</div>
                    <a href="agendados.php" class="menu-item">
                        <span class="icon">📅</span>Agendados
                    </a>
                    <a href="pendentes.php" class="menu-item active">
                        <span class="icon">⏳</span>Pendentes
                    </a>
                    <a href="execucao.php" class="menu-item">
                        <span class="icon">⚙️</span>Em Execução
                    </a>
                </div>
                <div class="menu-section">
                    <a href="../../index.php" class="menu-item">
                        <span class="icon">⬅️</span>Voltar ao Dashboard
                    </a>
                </div>
            </div>
        </nav>

        <main class="main-content">
            <div class="header">
                <h2>⏳ Serviços Pendentes</h2>
            </div>

            <div class="cards-grid">
                <?php foreach ($servicos as $s): ?
                <div class="card">
                    <div class="card-header">
                        <span class="<?php echo $s['prioridade'] === 'alta' ? 'prioridade-alta' : 'prioridade-media'; ?>">
                            Prioridade <?php echo $s['prioridade']; ?>
                        </span>
                        <span class="status-tag status-<?php echo $s['status']; ?>">
                            <?php 
                            $status_text = [
                                'aguardando_peca' => 'Aguardando Peça',
                                'aguardando_aprovacao' => 'Aguardando Aprovação',
                                'aguardando_cliente' => 'Aguardando Cliente'
                            ];
                            echo $status_text[$s['status']] ?? $s['status'];
                            ?>
                        </span>
                    </div>
                    
                    <div class="card-title"><?php echo $s['cliente']; ?></div>
                    <div class="card-subtitle"><?php echo $s['equipamento']; ?></div>
                    
                    <p style="color: #666; margin-top: 10px; font-size: 13px;"><?php echo $s['problema']; ?></p>
                    
                    <div class="card-acoes">
                        <a href="execucao.php?iniciar=<?php echo $s['id']; ?>" class="btn btn-success btn-sm">Iniciar Execução</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="section">
                <h3>📊 Resumo de Pendentes</h3>
                
                <table>
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Quantidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Aguardando Peça</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>Aguardando Aprovação</td>
                            <td>1</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>