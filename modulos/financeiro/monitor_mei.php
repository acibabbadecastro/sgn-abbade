<?php
// SGN - Monitor MEI - Limite Mensal
// Limite MEI 2026: R$ 81.000,00 / ano = R$ 6.750,00 / mês (média)
// Alerta em 80% = R$ 5.400,00

require_once '../../includes/config.php';

$limite_mensal = 6750.00;
$alerta_80 = 5400.00;
$faturamento_atual = 0; // Simulado - virá do banco

$percentual = ($faturamento_atual / $limite_mensal) * 100;
$cor_barra = $percentual > 80 ? '#ff6b6b' : ($percentual > 50 ? '#ffc107' : '#28a745');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor MEI - SGN</title>
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
        .header { margin-bottom: 30px; }
        .header h2 { color: #fff; font-size: 28px; }
        .alert-mei {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.5);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
        }
        .alert-mei h3 {
            color: #ffc107;
            font-size: 20px;
            margin-bottom: 15px;
        }
        .progress-bar {
            width: 100%;
            height: 30px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            overflow: hidden;
            margin: 20px 0;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #28a745, #ffc107, #ff6b6b);
            border-radius: 15px;
            transition: width 0.5s ease;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 15px;
            font-weight: bold;
            color: #fff;
        }
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
            text-align: center;
        }
        .card-value {
            font-size: 36px;
            font-weight: 700;
            color: #fff;
            margin: 15px 0;
        }
        .card-value.warning { color: #ffc107; }
        .card-value.danger { color: #ff6b6b; }
        .card-label {
            color: #888;
            font-size: 14px;
        }
        .info-box {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
            margin-top: 30px;
        }
        .info-box h3 {
            color: #fff;
            margin-bottom: 15px;
        }
        .info-box ul {
            color: #888;
            line-height: 2;
            padding-left: 20px;
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
                    <div class="menu-title">Financeiro</div>
                    <a href="index.php" class="menu-item">
                        <span class="icon">💰</span>Resumo
                    </a>
                    <a href="monitor_mei.php" class="menu-item active">
                        <span class="icon">📊</span>Monitor MEI
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
                <h2>📊 Monitor MEI</h2>
            </div>

            <div class="alert-mei">
                <h3>⚠️ Limite Mensal MEI</h3>
                
                <p style="color: #ccc; margin-bottom: 10px;">
                    Mês atual: <strong><?php echo date('F/Y'); ?></strong>
                </p>
                
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php echo min($percentual, 100); ?>%;">
                        <?php echo round($percentual, 1); ?>%
                    </div>
                </div>
                
                <p style="color: #888; text-align: center;">
                    R$ <?php echo number_format($faturamento_atual, 2, ',', '.'); ?> 
                    de R$ <?php echo number_format($limite_mensal, 2, ',', '.'); ?> 
                    (limite mensal médio)
                </p>
            </div>

            <div class="cards-grid">
                <div class="card">
                    <div class="card-label">Faturamento Anual Permitido</div>
                    <div class="card-value">R$ 81.000</div>
                    <div style="color: #28a745; font-size: 13px;">Limite MEI 2026</div>
                </div>

                <div class="card">
                    <div class="card-label">Média Mensal</div>
                    <div class="card-value">R$ 6.750</div>
                    <div style="color: #888; font-size: 13px;">R$ 81.000 ÷ 12 meses</div>
                </div>

                <div class="card">
                    <div class="card-label">Alerta aos 80%</div>
                    <div class="card-value warning">R$ 5.400</div>
                    <div style="color: #ffc107; font-size: 13px;">Atenção!</div>
                </div>

                <div class="card">
                    <div class="card-label">Restante Este Mês</div>
                    <div class="card-value <?php echo ($limite_mensal - $faturamento_atual) < 1000 ? 'danger' : ''; ?>">
                        R$ <?php echo number_format($limite_mensal - $faturamento_atual, 2, ',', '.'); ?>
                    </div>
                    <div style="color: #888; font-size: 13px;">Disponível</div>
                </div>
            </div>

            <div class="info-box">
                <h3>ℹ️ Informações Importantes</h3>
                
                <ul>
                    <li>📌 O sistema calcula automaticamente o faturamento com base nas receitas registradas</li>
                    <li>⚠️ Alerta visual quando atingir 80% do limite mensal</li>
                    <li>🚨 Alerta crítico quando próximo de ultrapassar o limite</li>
                    <li>📊 Histórico mensal para acompanhamento anual</li>
                    <li>💡 Dica: O limite é de R$ 81.000/ano (média R$ 6.750/mês)</li>
                </ul>
            </div>
        </main>
    </div>
</body>
</html>