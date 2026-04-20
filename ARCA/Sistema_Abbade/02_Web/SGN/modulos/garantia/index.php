<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garantia - SGN</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #2d4a2d 0%, #1e3a1e 100%);
            min-height: 100vh;
            color: #d4e8d4;
        }
        .header {
            background: rgba(0, 0, 0, 0.3);
            padding: 20px 40px;
            border-bottom: 2px solid #4a7c4a;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 { color: #d4e8d4; font-size: 24px; }
        .back-btn {
            color: #8fbc8f;
            text-decoration: none;
            padding: 10px 20px;
            border: 1px solid #4a7c4a;
            border-radius: 6px;
            transition: all 0.3s;
        }
        .back-btn:hover {
            background: rgba(74, 124, 74, 0.3);
            color: #d4e8d4;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }
        .section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .section h2 {
            color: #d4e8d4;
            margin-bottom: 20px;
            font-size: 20px;
        }
        .btn {
            background: linear-gradient(145deg, #4a7c4a, #3d5a3d);
            color: #d4e8d4;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
        }
        .btn:hover {
            background: linear-gradient(145deg, #5a8c5a, #4a7c4a);
        }
        .btn.primary {
            background: linear-gradient(145deg, #5a9c5a, #4a8c4a);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }
        .stat-card {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }
        .stat-value {
            font-size: 32px;
            font-weight: bold;
            color: #d4e8d4;
        }
        .stat-label {
            color: #8fbc8f;
            font-size: 13px;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        th {
            background: rgba(0, 0, 0, 0.2);
            color: #a8c8a8;
            font-weight: 600;
        }
        td {
            color: #d4e8d4;
        }
        tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #8fbc8f;
        }
        .status-ativa { color: #5a9c5a; }
        .status-vencida { color: #9c5a5a; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <a href="../index.php" class="back-btn">← Voltar ao Dashboard</a>
        </div>
        <h1>🛡️ Garantia</h1>
        <div></div>
    </div>

    <div class="container">
        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value" id="garantiasAtivas">0</div>
                <div class="stat-label">Garantias Ativas</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" id="vencendo30">0</div>
                <div class="stat-label">Vencendo em 30 dias</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" id="vencidas">0</div>
                <div class="stat-label">Garantias Vencidas</div>
            </div>
        </div>

        <!-- Ações -->
        <div class="section">
            <h2>⚡ Ações</h2>
            <a href="registrar.php" class="btn primary">+ Registrar Garantia</a>
            <a href="consultar.php" class="btn">🔍 Consultar Garantia</a>
        </div>

        <!-- Lista de Garantias -->
        <div class="section">
            <h2>📋 Garantias Registradas</h2>
            <div id="garantiasList">
                <div class="empty-state">
                    <p>Nenhuma garantia registrada.</p>
                    <p>Clique em "Registrar Garantia" para começar.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // TODO: Implementar carregamento de garantias via AJAX
    </script>
</body>
</html>
