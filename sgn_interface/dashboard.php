<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

// Obtém dados do banco
$contas = getContas($pdo);
$resumo = getResumoFinanceiro($pdo);
$saldo_total = getSaldoTotal($pdo);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SGN ABBADE Technologies</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            color: #e0e0e0;
        }
        
        /* Layout */
        .container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 280px;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            padding: 30px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .logo-area {
            text-align: center;
            padding: 0 20px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }
        
        .logo-area .icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
        
        .logo-area h2 {
            color: #00d4ff;
            font-size: 20px;
            font-weight: 600;
        }
        
        .logo-area p {
            color: #888;
            font-size: 12px;
            margin-top: 5px;
        }
        
        .menu {
            padding: 0 15px;
        }
        
        .menu-item {
            display: block;
            padding: 15px 20px;
            margin-bottom: 5px;
            border-radius: 12px;
            color: #b0b0b0;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
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
            margin-right: 12px;
            font-size: 18px;
        }
        
        .menu-section {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .menu-title {
            padding: 0 20px 10px;
            color: #666;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* Main Content */
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
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .header h1 {
            color: #fff;
            font-size: 28px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-info span {
            color: #888;
            font-size: 14px;
        }
        
        .btn-logout {
            background: rgba(255, 71, 87, 0.2);
            border: 1px solid rgba(255, 71, 87, 0.5);
            color: #ff6b6b;
            padding: 8px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            transition: all 0.3s ease;
        }
        
        .btn-logout:hover {
            background: rgba(255, 71, 87, 0.4);
        }
        
        /* Cards */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 25px;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-color: rgba(0, 212, 255, 0.3);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .card-title {
            color: #888;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .card-icon {
            font-size: 30px;
        }
        
        .card-value {
            font-size: 32px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 5px;
        }
        
        .card-value.positive {
            color: #00d4ff;
        }
        
        .card-value.negative {
            color: #ff6b6b;
        }
        
        .card-subtitle {
            color: #666;
            font-size: 13px;
        }
        
        /* Contas */
        .contas-section {
            margin-top: 30px;
        }
        
        .section-title {
            color: #fff;
            font-size: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .contas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .conta-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 20px;
            transition: all 0.3s ease;
        }
        
        .conta-card:hover {
            border-color: rgba(0, 212, 255, 0.3);
        }
        
        .conta-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .conta-banco {
            font-size: 12px;
            color: #00d4ff;
            background: rgba(0, 212, 255, 0.1);
            padding: 4px 12px;
            border-radius: 20px;
        }
        
        .conta-tipo {
            font-size: 11px;
            color: #888;
            background: rgba(255, 255, 255, 0.05);
            padding: 4px 10px;
            border-radius: 20px;
        }
        
        .conta-nome {
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .conta-numero {
            color: #666;
            font-size: 13px;
            margin-bottom: 15px;
        }
        
        .conta-saldo {
            font-size: 28px;
            font-weight: 700;
            color: #00d4ff;
        }
        
        .conta-saldo-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        
        /* Mensagem sem contas */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            border: 1px dashed rgba(255, 255, 255, 0.2);
        }
        
        .empty-state-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }
        
        .empty-state h3 {
            color: #fff;
            font-size: 20px;
            margin-bottom: 10px;
        }
        
        .empty-state p {
            color: #666;
            margin-bottom: 25px;
        }
        
        .btn-primary {
            display: inline-block;
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            color: #fff;
            padding: 12px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 212, 255, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="logo-area">
                <div class="icon">🏢</div>
                <h2>ABBADE Technologies</h2>
                <p>Sistema de Gerenciamento</p>
            </div>
            
            <div class="menu">
                <a href="dashboard.php" class="menu-item active">
                    <span class="icon">📊</span>Dashboard
                </a>
                
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
                        <span class="icon">🏦</span>Contas
                    </a>
                    <a href="modulos/financeiro/movimentacoes.php" class="menu-item">
                        <span class="icon">📈</span>Movimentações
                    </a>
                    <a href="modulos/financeiro/relatorios.php" class="menu-item">
                        <span class="icon">📋</span>Relatórios
                    </a>
                </div>
                
                <div class="menu-section">
                    <div class="menu-title">Cadastros</div>
                    <a href="modulos/clientes/index.php" class="menu-item">
                        <span class="icon">👥</span>Clientes
                    </a>
                    <a href="modulos/clientes/fornecedores.php" class="menu-item">
                        <span class="icon">🏭</span>Fornecedores
                    </a>
                </div>
                
                <div class="menu-section">
                    <div class="menu-title">Configurações</div>
                    <a href="modulos/config/usuarios.php" class="menu-item">
                        <span class="icon">👤</span>Usuários
                    </a>
                    <a href="modulos/config/impressoras.php" class="menu-item">
                        <span class="icon">🖨️</span>Impressoras
                    </a>
                    <a href="modulos/config/index.php" class="menu-item">
                        <span class="icon">⚙️</span>Geral
                    </a>
                </div>
            </div>
        </nav>
        
        <!-- Main Content -->
        <div class="main-content">
            <header class="header">
                <h1>Dashboard</h1>
                <div class="user-info">
                    <span>👤 <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></span>
                    <a href="?logout=1" class="btn-logout">Sair</a>
                </div>
            </header>
            
            <!-- Cards de Resumo -->
            <div class="cards-grid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Saldo Total</span>
                        <span class="card-icon">💰</span>
                    </div>
                    <div class="card-value positive">R$ <?php echo number_format($saldo_total, 2, ',', '.'); ?></div>
                    <div class="card-subtitle">Todas as contas</div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Receitas (Mês)</span>
                        <span class="card-icon">📈</span>
                    </div>
                    <div class="card-value positive">R$ <?php echo number_format($resumo['total_receitas'] ?? 0, 2, ',', '.'); ?></div>
                    <div class="card-subtitle">Entradas confirmadas</div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Despesas (Mês)</span>
                        <span class="card-icon">📉</span>
                    </div>
                    <div class="card-value negative">R$ <?php echo number_format($resumo['total_despesas'] ?? 0, 2, ',', '.'); ?></div>
                    <div class="card-subtitle">Saídas confirmadas</div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Movimentações</span>
                        <span class="card-icon">📊</span>
                    </div>
                    <div class="card-value"><?php echo $resumo['total_movimentacoes'] ?? 0; ?></div>
                    <div class="card-subtitle">No mês atual</div>
                </div>
            </div>
            
            <!-- Contas Bancárias -->
            <div class="contas-section">
                <h2 class="section-title">🏦 Contas Bancárias</h2>
                
                <?php if (count($contas) > 0): ?>
                    <div class="contas-grid">
                        <?php foreach ($contas as $conta): ?>
                        <div class="conta-card">
                            <div class="conta-header">
                                <span class="conta-banco"><?php echo htmlspecialchars($conta['banco_nome'] ?? 'Banco'); ?></span>
                                <span class="conta-tipo"><?php echo $conta['tipo_pessoa']; ?></span>
                            </div>
                            
                            <div class="conta-nome"><?php echo htmlspecialchars($conta['apelido']); ?></div>
                            <div class="conta-numero">Conta: <?php echo htmlspecialchars($conta['conta_numero']); ?></div>
                            
                            <div class="conta-saldo">R$ <?php echo number_format($conta['saldo_atual'], 2, ',', '.'); ?></div>
                            <div class="conta-saldo-label">Saldo Atual</div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">🏦</div>
                        <h3>Nenhuma conta cadastrada</h3>
                        <p>Cadastre suas contas bancárias para começar a gerenciar suas finanças.</p>
                        <a href="modulos/financeiro/contas.php" class="btn-primary">Cadastrar Conta</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>