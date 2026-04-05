<?php
// SGN - Serviços Agendados
require_once '../../includes/config.php';

// Simular dados (depois vem do banco)
$servicos = [
    ['id' => 1, 'cliente' => 'João Silva', 'equipamento' => 'Notebook Dell', 'servico' => 'Formatação', 'data' => '2026-04-06', 'hora' => '09:00', 'status' => 'confirmado'],
    ['id' => 2, 'cliente' => 'Maria Santos', 'equipamento' => 'Impressora HP', 'servico' => 'Limpeza', 'data' => '2026-04-06', 'hora' => '14:00', 'status' => 'confirmado'],
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços Agendados - SGN</title>
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
        .menu-item:hover { background: rgba(255, 255, 255, 0.05); color: #fff; }
        .menu-item.active {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2) 0%, rgba(0, 153, 204, 0.2) 100%);
            color: #00d4ff;
            border: 1px solid rgba(0, 212, 255, 0.3);
        }
        .menu-item .icon { width: 24px; margin-right: 15px; font-size: 18px; text-align: center; }
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
            border: none;
            cursor: pointer;
        }
        .btn-success { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); }
        .btn-warning { background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); }
        .btn-danger { background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); }
        .section {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
        }
        .section h3 { color: #fff; font-size: 20px; margin-bottom: 20px; }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            text-align: left;
            padding: 15px;
            color: #888;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: #e0e0e0;
        }
        tr:hover { background: rgba(255, 255, 255, 0.02); }
        .status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .status-confirmado {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }
        .acoes { display: flex; gap: 8px; }
        .acoes a {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            color: #fff;
        }
        .filtros {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        .filtros input, .filtros select {
            padding: 10px 15px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #fff;
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
                    <a href="agendados.php" class="menu-item active">
                        <span class="icon">📅</span>Agendados
                    </a>
                    <a href="pendentes.php" class="menu-item">
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
                <h2>📅 Serviços Agendados</h2>
                <a href="novo.php" class="btn">+ Novo Serviço</a>
            </div>

            <div class="filtros">
                <input type="date" placeholder="Data">
                <select>
                    <option>Todos os Status</option>
                    <option>Confirmado</option>
                    <option>Pendente</option>
                    <option>Cancelado</option>
                </select>
                <input type="text" placeholder="Buscar cliente...">
            </div>

            <div class="section">
                <table>
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Equipamento</th>
                            <th>Serviço</th>
                            <th>Data/Hora</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($servicos as $s): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($s['cliente']); ?></td>
                            <td><?php echo htmlspecialchars($s['equipamento']); ?></td>
                            <td><?php echo htmlspecialchars($s['servico']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($s['data'])) . ' ' . $s['hora']; ?></td>
                            <td><span class="status status-confirmado">Confirmado</span></td>
                            <td class="acoes">
                                <a href="execucao.php?iniciar=<?php echo $s['id']; ?>" class="btn-success">Iniciar</a>
                                <a href="editar.php?id=<?php echo $s['id']; ?>" class="btn-warning">Editar</a>
                                <a href="cancelar.php?id=<?php echo $s['id']; ?>" class="btn-danger">Cancelar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>