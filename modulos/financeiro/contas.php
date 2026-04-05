<?php
// SGN - Gerenciamento de Contas Bancárias
require_once '../../includes/config.php';

$contas = getContas($pdo);
$bancos = getBancos($pdo);

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aqui seria o insert no banco
    $mensagem = "Conta cadastrada com sucesso!";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas Bancárias - SGN</title>
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
            border: none;
            cursor: pointer;
        }
        .btn-sm {
            padding: 8px 16px;
            font-size: 13px;
        }
        .contas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .conta-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
        }
        .conta-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .banco-tag {
            background: rgba(0, 212, 255, 0.1);
            color: #00d4ff;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
        }
        .tipo-tag {
            background: rgba(255, 255, 255, 0.05);
            color: #888;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
        }
        .conta-nome {
            color: #fff;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .conta-detalhes {
            color: #666;
            font-size: 13px;
            margin-bottom: 15px;
        }
        .conta-saldo {
            font-size: 32px;
            font-weight: 700;
            color: #00d4ff;
            margin-bottom: 5px;
        }
        .conta-acoes {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .form-section {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
            margin-top: 30px;
        }
        .form-section h3 {
            color: #fff;
            margin-bottom: 20px;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            color: #888;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .form-group input,
        .form-group select {
            padding: 12px 15px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #fff;
            font-size: 15px;
        }
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #00d4ff;
        }
        .alert {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid rgba(40, 167, 69, 0.5);
            color: #28a745;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
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
                    <a href="contas.php" class="menu-item active">
                        <span class="icon">🏦</span>Contas
                    </a>
                    <a href="movimentacoes.php" class="menu-item">
                        <span class="icon">📈</span>Movimentações
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
                <h2>🏦 Contas Bancárias</h2>
                <a href="#nova-conta" class="btn">+ Nova Conta</a>
            </div>

            <?php if (isset($mensagem)): ?>
            <div class="alert"><?php echo $mensagem; ?></div>
            <?php endif; ?>

            <!-- Contas Existentes -->
            <div class="contas-grid">
                <?php if (count($contas) > 0): ?
                    <?php foreach ($contas as $conta): ?
                    <div class="conta-card">
                        <div class="conta-header">
                            <span class="banco-tag"><?php echo $conta['banco_nome'] ?? 'Banco'; ?></span>
                            <span class="tipo-tag"><?php echo $conta['tipo_pessoa']; ?></span>
                        </div>
                        
                        <div class="conta-nome"><?php echo htmlspecialchars($conta['apelido']); ?></div>
                        <div class="conta-detalhes">
                            Conta: <?php echo htmlspecialchars($conta['conta_numero']); ?> | 
                            CPF/CNPJ: <?php echo htmlspecialchars($conta['cpf_cnpj']); ?>
                        </div>
                        
                        <div class="conta-saldo"><?php echo formatMoney($conta['saldo_atual']); ?></div>
                        <div style="color: #666; font-size: 13px;">Saldo Atual</div>
                        
                        <div class="conta-acoes">
                            <a href="editar_conta.php?id=<?php echo $conta['id']; ?>" class="btn btn-sm">Editar</a>
                            <a href="extrato.php?conta=<?php echo $conta['id']; ?>" class="btn btn-sm">Ver Extrato</a>
                        </div>
                    </div>
                    <?php endforeach; ?
                
                <?php else: ?>
                    <p style="color: #666; text-align: center; padding: 40px;">Nenhuma conta cadastrada. Use o formulário abaixo para cadastrar suas 4 contas.</p>
                <?php endif; ?>
            </div>

            <!-- Formulário Nova Conta -->
            <div class="form-section" id="nova-conta">
                <h3>➕ Cadastrar Nova Conta</h3>
                
                <form method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Apelido da Conta</label>
                            <input type="text" name="apelido" placeholder="Ex: Nubank PJ65" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Banco</label>
                            <select name="banco_codigo" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($bancos as $banco): ?>
                                <option value="<?php echo $banco['codigo']; ?>">
                                    <?php echo $banco['nome_curto']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Tipo</label>
                            <select name="tipo_pessoa" required>
                                <option value="PF">Pessoa Física</option>
                                <option value="PJ">Pessoa Jurídica</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Número da Conta</label>
                            <input type="text" name="conta_numero" placeholder="0000-0" required>
                        </div>
                        
                        <div class="form-group">
                            <label>CPF/CNPJ</label>
                            <input type="text" name="cpf_cnpj" placeholder="000.000.000-00" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Saldo Inicial</label>
                            <input type="number" name="saldo_inicial" step="0.01" placeholder="0,00" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn" style="margin-top: 20px;">Cadastrar Conta</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>