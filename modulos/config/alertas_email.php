<?php
// SGN - Alertas de Email (Monitoramento)
$alerts_file = '../../alerts/email_alerts.json';
$alertas = [];

if (file_exists($alerts_file)) {
    $alertas = json_decode(file_get_contents($alerts_file), true) ?: [];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alertas de Email - SGN</title>
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
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
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
        .alert-card {
            background: rgba(255, 71, 87, 0.1);
            border: 1px solid rgba(255, 71, 87, 0.3);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 20px;
        }
        .alert-card h3 {
            color: #ff6b6b;
            margin-bottom: 10px;
        }
        .alert-card .meta {
            color: #888;
            font-size: 13px;
            margin-bottom: 15px;
        }
        .alert-card .keywords {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 15px;
        }
        .keyword {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
        }
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
                    <div class="menu-title">Sistema</div>
                    <a href="alertas_email.php" class="menu-item active">
                        <span class="icon">🚨</span>Alertas de Email
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
                <h2>🚨 Alertas de Email</h2>
                <button class="btn" onclick="location.reload()">🔄 Atualizar</button>
            </div>

            <?php if (count($alertas) > 0): ?
                <?php foreach (array_reverse($alertas) as $alerta): ?
                <div class="alert-card">
                    <h3>📧 <?php echo htmlspecialchars($alerta['assunto']); ?></h3>
                    
                    <div class="meta">
                        De: <?php echo htmlspecialchars($alerta['remetente']); ?> | 
                        Data: <?php echo date('d/m/Y H:i', strtotime($alerta['data'])); ?> | 
                        Prioridade: <?php echo $alerta['prioridade']; ?>
                    </div>
                    
                    <p style="color: #ccc;">
                        Palavras-chave detectadas:
                    </p>
                    
                    <div class="keywords">
                        <?php foreach ($alerta['palavras_chave'] as $palavra): ?
                        <span class="keyword"><?php echo htmlspecialchars($palavra); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?
            
            <?php else: ?
                <div class="empty">
                    <p>Nenhum alerta no momento.</p>
                    <p>O sistema verifica emails a cada 5 minutos.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>