<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGN - ABBADE Technologies</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #16213e 100%);
            min-height: 100vh;
            color: #e0e0e0;
        }

        /* Container Principal */
        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar - Menu Lateral */
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

        /* Logo Area */
        .logo-area {
            padding: 30px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .logo-icon {
            font-size: 50px;
            margin-bottom: 10px;
        }

        .logo-area h1 {
            color: #00d4ff;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .logo-area p {
            color: #888;
            font-size: 11px;
            margin-top: 5px;
        }

        /* Menu */
        .menu {
            flex: 1;
            padding: 20px 0;
        }

        .menu-section {
            margin-bottom: 25px;
        }

        .menu-title {
            padding: 0 25px 10px;
            color: #666;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
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
            cursor: pointer;
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

        .menu-item .icon {
            width: 24px;
            margin-right: 15px;
            font-size: 18px;
            text-align: center;
        }

        .menu-item .arrow {
            margin-left: auto;
            font-size: 12px;
            opacity: 0.5;
        }

        /* Submenu */
        .submenu {
            display: none;
            padding-left: 20px;
        }

        .submenu.active {
            display: block;
        }

        .submenu .menu-item {
            padding: 10px 25px;
            font-size: 13px;
            margin: 2px 15px 2px 30px;
        }

        /* User Area */
        .user-area {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .user-details h4 {
            color: #fff;
            font-size: 14px;
            font-weight: 500;
        }

        .user-details p {
            color: #666;
            font-size: 11px;
        }

        .logout-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background: rgba(255, 71, 87, 0.1);
            border: 1px solid rgba(255, 71, 87, 0.3);
            border-radius: 8px;
            color: #ff6b6b;
            text-align: center;
            text-decoration: none;
            font-size: 13px;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 71, 87, 0.2);
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 30px;
            min-height: 100vh;
        }

        .header {
            margin-bottom: 30px;
        }

        .header h2 {
            color: #fff;
            font-size: 28px;
            font-weight: 600;
        }

        .header p {
            color: #888;
            margin-top: 5px;
        }

        /* Cards */
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
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-color: rgba(0, 212, 255, 0.2);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .card-icon {
            font-size: 32px;
        }

        .card-value {
            font-size: 36px;
            font-weight: 700;
            color: #fff;
        }

        .card-value.positive {
            color: #00d4ff;
        }

        .card-value.negative {
            color: #ff6b6b;
        }

        .card-label {
            color: #888;
            font-size: 14px;
        }

        /* Content Sections */
        .content-section {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .content-section h3 {
            color: #fff;
            font-size: 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state-icon {
            font-size: 60px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .btn-primary {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 212, 255, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar - Menu Lateral -->
        <nav class="sidebar">
            <div class="logo-area">
                <div class="logo-icon">🏢</div>
                <h1>ABBADE Technologies</h1>
                <p>Sistema de Gerenciamento</p>
            </div>

            <div class="menu">
                <!-- Dashboard -->
                <div class="menu-section">
                    <div class="menu-title">Principal</div>
                    <a href="index.php" class="menu-item active">
                        <span class="icon">📊</span>
                        Dashboard
                    </a>
                </div>

                <!-- Serviços -->
                <div class="menu-section">
                    <div class="menu-title">Serviços</div>
                    <a href="modulos/servicos/agendados.php" class="menu-item">
                        <span class="icon">📅</span>
                        Agendados
                    </a>
                    <a href="modulos/servicos/pendentes.php" class="menu-item">
                        <span class="icon">⏳</span>
                        Pendentes
                    </a>
                    <a href="modulos/servicos/execucao.php" class="menu-item">
                        <span class="icon">⚙️</span>
                        Em Execução
                    </a>
                </div>

                <!-- Financeiro -->
                <div class="menu-section">
                    <div class="menu-title">Financeiro</div>
                    <a href="modulos/financeiro/index.php" class="menu-item">
                        <span class="icon">💰</span>
                        Resumo
                        <span class="arrow">›</span>
                    </a>
                    <a href="modulos/financeiro/contas.php" class="menu-item">
                        <span class="icon">🏦</span>
                        Contas Bancárias
                    </a>
                    <a href="modulos/financeiro/movimentacoes.php" class="menu-item">
                        <span class="icon">📈</span>
                        Movimentações
                    </a>
                    <a href="modulos/financeiro/relatorios.php" class="menu-item">
                        <span class="icon">📋</span>
                        Relatórios
                    </a>
                </div>

                <!-- Clientes -->
                <div class="menu-section">
                    <div class="menu-title">Cadastros</div>
                    <a href="modulos/clientes/index.php" class="menu-item">
                        <span class="icon">👥</span>
                        Clientes
                    </a>
                    <a href="modulos/clientes/fornecedores.php" class="menu-item">
                        <span class="icon">🏭</span>
                        Fornecedores
                    </a>
                </div>

                <!-- Configurações -->
                <div class="menu-section">
                    <div class="menu-title">Sistema</div>
                    <a href="modulos/config/usuarios.php" class="menu-item">
                        <span class="icon">👤</span>
                        Usuários
                    </a>
                    <a href="modulos/config/impressoras.php" class="menu-item">
                        <span class="icon">🖨️</span>
                        Impressoras
                    </a>
                    <a href="modulos/config/bancos.php" class="menu-item">
                        <span class="icon">🗄️</span>
                        Bancos de Dados
                    </a>
                    <a href="modulos/config/importar.php" class="menu-item">
                        <span class="icon">📥</span>
                        Importar Dados
                    </a>
                    <a href="modulos/config/exportar.php" class="menu-item">
                        <span class="icon">📤</span>
                        Exportar / PDF
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

            <!-- Cards de Resumo -->
            <div class="cards-grid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-icon">💰</span>
                    </div>
                    <div class="card-value positive">R$ 0,00</div>
                    <div class="card-label">Saldo Total</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-icon">📈</span>
                    </div>
                    <div class="card-value positive">R$ 0,00</div>
                    <div class="card-label">Receitas (Mês)</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-icon">📉</span>
                    </div>
                    <div class="card-value negative">R$ 0,00</div>
                    <div class="card-label">Despesas (Mês)</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-icon">⚙️</span>
                    </div>
                    <div class="card-value">0</div>
                    <div class="card-label">Serviços em Andamento</div>
                </div>
            </div>

            <!-- Contas Bancárias -->
            <div class="content-section">
                <h3>🏦 Contas Bancárias</h3>
                <div class="empty-state">
                    <div class="empty-state-icon">🏦</div>
                    <p>Nenhuma conta cadastrada ainda.</p>
                    <p>Clique no menu Financeiro > Contas Bancárias para cadastrar.</p>
                    <a href="modulos/financeiro/contas.php" class="btn-primary">Cadastrar Contas</a>
                </div>
            </div>

            <!-- Serviços -->
            <div class="content-section">
                <h3>🔧 Serviços Recentes</h3>
                <div class="empty-state">
                    <div class="empty-state-icon">🔧</div>
                    <p>Nenhum serviço registrado.</p>
                    <p>Use o menu Serviços para agendar novos atendimentos.</p>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Toggle submenu (se precisar no futuro)
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function(e) {
                // Remove active de todos
                document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
                // Adiciona ao clicado
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>