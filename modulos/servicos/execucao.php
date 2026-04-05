<?php
// SGN - Serviços em Execução
require_once '../../includes/config.php';

$servicos = [
    ['id' => 1, 'cliente' => 'Carlos Mendes', 'equipamento' => 'Notebook Lenovo', 'inicio' => '14:30', 'status' => 'em_andamento'],
    ['id' => 2, 'cliente' => 'Fernanda Lima', 'equipamento' => 'Impressora Epson', 'inicio' => '15:00', 'status' => 'em_andamento'],
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços em Execução - SGN</title>
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
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
        }
        .card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
            position: relative;
            overflow: hidden;
        }
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, #00d4ff, #0099cc);
        }
        .timer {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(0, 212, 255, 0.1);
            border: 1px solid rgba(0, 212, 255, 0.3);
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 20px;
            font-weight: 700;
            color: #00d4ff;
            font-family: monospace;
        }
        .card-title {
            color: #fff;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 5px;
            margin-top: 10px;
        }
        .card-subtitle {
            color: #888;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .card-info {
            color: #666;
            font-size: 13px;
            margin-bottom: 5px;
        }
        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: #fff;
        }
        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: #fff;
        }
        .acoes {
            display: flex;
            gap: 10px;
            margin-top: 20px;
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
                    <a href="pendentes.php" class="menu-item">
                        <span class="icon">⏳</span>Pendentes
                    </a>
                    <a href="execucao.php" class="menu-item active">
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
                <h2>⚙️ Serviços em Execução</h2>
            </div>

            <div class="cards-grid">
                <?php foreach ($servicos as $s): ?
                <div class="card">
                    <div class="timer" data-inicio="<?php echo $s['inicio']; ?>">
                        00:45:12
                    </div>
                    
                    <div class="card-title"><?php echo $s['cliente']; ?></div>
                    
                    <div class="card-subtitle"><?php echo $s['equipamento']; ?></div>
                    
                    <div class="card-info">🕐 Início: <?php echo $s['inicio']; ?></div>
                    
                    <div class="card-info">👤 Técnico: Admin</div>
                    
                    <div class="acoes">
                        <a href="finalizar.php?id=<?php echo $s['id']; ?>" class="btn btn-success">✓ Finalizar</a>
                        <a href="pausar.php?id=<?php echo $s['id']; ?>" class="btn btn-danger">⏸ Pausar</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <script>
        // Timer simples
        setInterval(() => {
            document.querySelectorAll('.timer').forEach(timer => {
                // Simulação de timer
            });
        }, 1000);
    </script>
</body>
</html>