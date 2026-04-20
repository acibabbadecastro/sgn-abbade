<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGN - Sistema de Gestão Abbade</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #2d4a2d 0%, #1e3a1e 100%);
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: rgba(0, 0, 0, 0.3);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #4a7c4a;
        }

        .header h1 {
            color: #d4e8d4;
            font-size: 28px;
        }

        .header .user-info {
            color: #a8c8a8;
            font-size: 14px;
        }

        .header .date {
            color: #8fbc8f;
            font-size: 12px;
            margin-top: 4px;
        }

        /* Main Container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        /* Welcome Section */
        .welcome {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .welcome h2 {
            color: #d4e8d4;
            margin-bottom: 10px;
        }

        .welcome p {
            color: #a8c8a8;
        }

        /* Security Notice */
        .security-notice {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 25px;
            border-left: 4px solid #4a7c4a;
        }

        .security-notice p {
            color: #8fbc8f;
            font-size: 13px;
        }

        .security-notice strong {
            color: #d4e8d4;
        }

        /* Modules Grid */
        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .module-card {
            background: linear-gradient(145deg, #3d5a3d, #2d4a2d);
            border-radius: 12px;
            padding: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: block;
        }

        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border-color: #4a7c4a;
        }

        .module-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .module-title {
            color: #d4e8d4;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .module-description {
            color: #8fbc8f;
            font-size: 14px;
            line-height: 1.5;
        }

        /* Quick Stats - OPERACIONAIS APENAS */
        .stats-section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .stats-section h3 {
            color: #d4e8d4;
            margin-bottom: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
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

        .stat-info {
            color: #6a8a6a;
            font-size: 11px;
            margin-top: 8px;
        }

        /* Quick Actions */
        .quick-actions {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 25px;
        }

        .quick-actions h3 {
            color: #d4e8d4;
            margin-bottom: 20px;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .action-btn {
            background: linear-gradient(145deg, #4a7c4a, #3d5a3d);
            color: #d4e8d4;
            border: none;
            padding: 15px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .action-btn:hover {
            background: linear-gradient(145deg, #5a8c5a, #4a7c4a);
            transform: scale(1.05);
        }

        .action-btn.primary {
            background: linear-gradient(145deg, #5a9c5a, #4a8c4a);
        }

        .action-btn.primary:hover {
            background: linear-gradient(145deg, #6aac6a, #5a9c5a);
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            color: #6a8a6a;
            font-size: 12px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div>
            <h1>🖥️ SGN - Sistema de Gestão Abbade</h1>
            <div class="user-info">Usuário: <strong>Acib ABBADE</strong></div>
            <div class="date" id="currentDate"></div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container">
        <!-- Welcome -->
        <div class="welcome">
            <h2>Bem-vindo ao SGN!</h2>
            <p>Sistema centralizado para gestão da assistência técnica e loja.</p>
        </div>

        <!-- Security Notice -->
        <div class="security-notice">
            <p><strong>🔒 Aviso de Segurança:</strong> Dados financeiros e sensíveis são acessados apenas através da sessão "Financeiro" com filtros e controles adequados. Nunca são expostos na tela principal.</p>
        </div>

        <!-- Quick Stats - OPERACIONAIS APENAS -->
        <div class="stats-section">
            <h3>📊 Visão Operacional</h3>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value" id="osPendentes">0</div>
                    <div class="stat-label">OS Pendentes</div>
                    <div class="stat-info">🔒 Dados em Financeiro</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="osConcluidas">0</div>
                    <div class="stat-label">OS Concluídas (Mês)</div>
                    <div class="stat-info">🔒 Dados em Financeiro</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="clientesAtivos">0</div>
                    <div class="stat-label">Clientes Cadastrados</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="produtosEstoque">0</div>
                    <div class="stat-label">Produtos em Estoque</div>
                </div>
            </div>
        </div>

        <!-- Modules Grid -->
        <h3 style="color: #d4e8d4; margin-bottom: 15px;">📁 Módulos do Sistema</h3>
        <div class="modules-grid">
            <!-- Nova OS -->
            <a href="modulos/os/novo.php" class="module-card">
                <div class="module-icon">📋</div>
                <div class="module-title">Nova OS</div>
                <div class="module-description">Criar nova ordem de serviço com cadastro rápido de cliente</div>
            </a>

            <!-- OS Existentes -->
            <a href="modulos/os/index.php" class="module-card">
                <div class="module-icon">📂</div>
                <div class="module-title">Ordens de Serviço</div>
                <div class="module-description">Visualizar e gerenciar todas as OS</div>
            </a>

            <!-- Clientes -->
            <a href="modulos/clientes/index.php" class="module-card">
                <div class="module-icon">👥</div>
                <div class="module-title">Clientes</div>
                <div class="module-description">Cadastro e histórico de clientes</div>
            </a>

            <!-- Estoque -->
            <a href="modulos/estoque.php" class="module-card">
                <div class="module-icon">📦</div>
                <div class="module-title">Estoque</div>
                <div class="module-description">Controle de peças e produtos</div>
            </a>

            <!-- Financeiro (ACESSO CONTROLADO) -->
            <a href="modulos/financeiro/index.php" class="module-card">
                <div class="module-icon">💰</div>
                <div class="module-title">Financeiro</div>
                <div class="module-description">🔒 Dados financeiros com filtros e controles de acesso</div>
            </a>

            <!-- Fornecedores -->
            <a href="modulos/fornecedores.php" class="module-card">
                <div class="module-icon">🏪</div>
                <div class="module-title">Fornecedores</div>
                <div class="module-description">Cadastro e produtos por fornecedor</div>
            </a>

            <!-- Garantia -->
            <a href="modulos/garantia.php" class="module-card">
                <div class="module-icon">🛡️</div>
                <div class="module-title">Garantia</div>
                <div class="module-description">Controle de garantias de serviços</div>
            </a>

            <!-- Agenda -->
            <a href="modulos/agenda.php" class="module-card">
                <div class="module-icon">📅</div>
                <div class="module-title">Agenda</div>
                <div class="module-description">Compromissos e lembretes</div>
            </a>

            <!-- Admin BD -->
            <a href="admin_bd.php" class="module-card">
                <div class="module-icon">🗄️</div>
                <div class="module-title">Banco de Dados</div>
                <div class="module-description">Administração do PostgreSQL</div>
            </a>

            <!-- Relatórios -->
            <a href="modulos/relatorios.php" class="module-card">
                <div class="module-icon">📈</div>
                <div class="module-title">Relatórios</div>
                <div class="module-description">Relatórios gerenciais</div>
            </a>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h3>⚡ Ações Rápidas</h3>
            <div class="actions-grid">
                <a href="modulos/os/novo.php" class="action-btn primary">📋 Nova OS</a>
                <a href="modulos/clientes/index.php?action=novo" class="action-btn">👥 Novo Cliente</a>
                <a href="modulos/os/index.php?status=pendente" class="action-btn">📂 OS Pendentes</a>
                <a href="modulos/financeiro/index.php" class="action-btn">💰 Financeiro</a>
                <a href="modulos/estoque.php" class="action-btn">📦 Consultar Estoque</a>
                <a href="modulos/agenda.php" class="action-btn">📅 Minha Agenda</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        SGN - Sistema de Gestão Abbade © 2026 | Desenvolvido por Stark AI<br>
        <span style="color: #4a7c4a;">🔒 Dados financeiros protegidos - acesso restrito ao módulo apropriado</span>
    </div>

    <script>
        // Set current date
        const dateOptions = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        document.getElementById('currentDate').textContent = new Date().toLocaleDateString('pt-BR', dateOptions);

        // Load stats from database (placeholder)
        // NO FINANCIAL DATA - Only operational metrics
        function loadStats() {
            // TODO: Implement fetch to get real operational stats from database
        }

        // Load stats on page load
        loadStats();
    </script>
</body>
</html>
