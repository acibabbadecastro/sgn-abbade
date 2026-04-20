<?php
// SGN - Dashboard sem valores (só no Financeiro)
require_once 'includes/config.php';

// Buscar apenas contagens, não valores
$total_contas = $pdo->query("SELECT COUNT(*) FROM financeiro.contas_bancarias WHERE ativa = true")->fetchColumn();
$total_clientes = $pdo->query("SELECT COUNT(*) FROM financeiro.fornecedores_clientes WHERE ativo = true")->fetchColumn();
$total_servicos = 0; // Contar da tabela de serviços
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SGN ABBADE Technologies</title>
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
            display: flex;
            flex-direction: column;
        }
        .logo-area {
            padding: 30px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        .logo-icon { font-size: 50px; margin-bottom: 10px; }
        .logo-area h1 { color: #00d4ff; font-size: 18px; font-weight: 600; }
        .logo-area p { color: #888; font-size: 11px; margin-top: 5px; }
        .menu { padding: 20px 0; flex: 1; }
        .menu-section { margin-bottom: 25px; }
        .menu-title { padding: 0 25px 10px; color: #666; font-size: 10px; text-transform: uppercase; letter-spacing: 2px; }
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
        .user-area { padding: 20px; border-top: 1px solid rgba(255, 255, 255, 0.1); }
        .user-info { display: flex; align-items: center; gap: 12px; margin-bottom: 15px; }
        .user-avatar { width: 40px; height: 40px; background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .user-details h4 { color: #fff; font-size: 14px; font-weight: 500; }
        .user-details p { color: #666; font-size: 11px; }
        .logout-btn {
            display: block; width: 100%; padding: 12px;
            background: rgba(255, 71, 87, 0.1); border: 1px solid rgba(255, 71, 87, 0.3);
            border-radius: 8px; color: #ff6b6b; text-align: center; text-decoration: none; font-size: 13px;
        }
        .main-content { margin-left: 280px; flex: 1; padding: 30px; min-height: 100vh; }
        .header { margin-bottom: 30px; }
        .header h2 { color: #fff; font-size: 28px; }
        .header p { color: #888; margin-top: 5px; }
        .welcome-card {
            background: rgba(0, 212, 255, 0.05);
            border: 1px solid rgba(0, 212, 255, 0.2);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
        }
        .welcome-card h3 { color: #00d4ff; font-size: 24px; margin-bottom: 10px; }
        .welcome-card p { color: #888; line-height: 1.6; }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
            text-align: center;
        }
        .stat-icon { font-size: 40px; margin-bottom: 15px; }
        .stat-value { font-size: 36px; font-weight: 700; color: #fff; }
        .stat-value.hidden { color: #333; font-size: 20px; }
        .stat-label { color: #888; font-size: 14px; margin-top: 10px; }
        .stat-hint { color: #666; font-size: 12px; margin-top: 5px; }
        .sections-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .section-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
        }
        .section-card h3 { color: #fff; font-size: 18px; margin-bottom: 15px; display: flex; align-items: center; gap: 10px; }
        .section-card p { color: #666; font-size: 14px; margin-bottom: 15px; }
        .btn-primary {
            display: inline-block; padding: 10px 20px;
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: #fff; text-decoration: none; border-radius: 8px; font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="logo-area">
                <div class="logo-icon">🏢</div>
                <h1>ABBADE Technologies</h1>
                <p>Sistema de Gerenciamento</p>
            </div>

            <div class="menu">
                <div class="menu-section">
                    <div class="menu-title">Principal</div>
                    <a href="index.php" class="menu-item active">
                        <span class="icon">📊</span>Dashboard
                    </a>
                </div>

                <div class="menu-section">
                    <div class="menu-title">Serviços</div>
                    <a href="modulos/servicos/agendados.php" class="menu-item">
                        <span class="icon">📅</span>Agendados
                    </a>
                    <a href="modulos/servicos/pendentes.php" class="menu-item">
                        <span class="icon">⏳</span>Pendentes
                    </a>
                    <a href="modulos/servicos/execucao.php" class="menu-item">
                        <span class="icon">⚙️</span>Em Execução
                    </a>
                </div>

                <div class="menu-section">
                    <div class="menu-title">Financeiro</div>
                    <a href="modulos/financeiro/index.php" class="menu-item">
                        <span class="icon">💰</span>Resumo
                    </a>
                    <a href="modulos/financeiro/contas.php" class="menu-item">
                        <span class="icon">🏦</span>Contas Bancárias
                    </a>
                    <a href="modulos/financeiro/extratos.php" class="menu-item">
                        <span class="icon">📄</span>Extratos
                    </a>
                </div>

                <div class="menu-section">
                    <div class="menu-title">Cadastros</div>
                    <a href="modulos/clientes/index.php" class="menu-item">
                        <span class="icon">👥</span>Clientes
                    </a>
                </div>
            </div>

            <div class="user-area">
                <div class="user-info">
                    <div class="user-avatar">👤</div>
                    <div class="user-details">
                        <h4>Administrador</h4>
                        <p>ABBADE Technologies</p>
                    </div>
                </div>
                <a href="logout.php" class="logout-btn">Sair do Sistema</a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h2>Dashboard</h2>
                <p>Visão geral do sistema - <?php echo date('d/m/Y'); ?></p>
            </div>

            <!-- Welcome Message -->
            <div class="welcome-card">
                <h3>👋 Bem-vindo ao SGN</h3>
                <p>
                    Sistema de Gerenciamento de Negócios ABBADE Technologies.
                    <br>Acesse o menu Financeiro > Resumo para visualizar valores e estatísticas financeiras.
                </p>
            </div>

            <!-- Stats sem valores -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">🏦</div>
                    <div class="stat-value"><?php echo $total_contas; ?></div>
                    <div class="stat-label">Contas Bancárias</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-value"><?php echo $total_clientes; ?></div>
                    <div class="stat-label">Clientes/Fornecedores</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <div class="stat-value hidden">***</div>
                    <div class="stat-label">Saldo Total</div>
                    <div class="stat-hint">Ver em Financeiro > Resumo</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">⚙️</div>
                    <div class="stat-value"><?php echo $total_servicos; ?></div>
                    <div class="stat-label">Serviços em Andamento</div>
                </div>
            </div>

            <!-- Quick Access -->
            <div class="sections-grid">
                <div class="section-card">
                    <h3>💰 Financeiro</h3>
                    <p>Acesse resumo financeiro, extratos e monitor MEI.</p>
                    <a href="modulos/financeiro/index.php" class="btn-primary">Ver Resumo Financeiro →</a>
                </div>

                <div class="section-card">
                    <h3>🔧 Serviços</h3>
                    <p>Gerencie serviços agendados e em execução.</p>
                    <a href="modulos/servicos/agendados.php" class="btn-primary">Ver Serviços →</a>
                </div>

                <div class="section-card">
                    <h3>👥 Cadastros</h3>
                    <p>Gerencie clientes e importe de extratos.</p>
                    <a href="modulos/clientes/index.php" class="btn-primary">Ver Clientes →</a>
                </div>

                <div class="section-card">
                    <h3>📄 Processar Extratos</h3>
                    <p>Importe extratos bancários do /home/lan.</p>
                    <a href="modulos/financeiro/processar_extratos.php" class="btn-primary">Processar Extratos →</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>