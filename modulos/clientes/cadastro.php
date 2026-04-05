<?php
// SGN - Cadastro de Clientes
require_once '../../includes/config.php';

$cliente = null;
if (isset($_GET['id'])) {
    // Buscar cliente para edição
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensagem = "Cliente cadastrado com sucesso!";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente - SGN</title>
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
        .form-section {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 30px;
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
        .form-group.full-width { grid-column: span 2; }
        .form-group label {
            color: #888;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 12px 15px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #fff;
            font-size: 15px;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #00d4ff;
        }
        .form-group textarea {
            min-height: 80px;
            resize: vertical;
        }
        .alert {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid rgba(40, 167, 69, 0.5);
            color: #28a745;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 15px;
        }
        .tab {
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: none;
            border-radius: 8px;
            color: #888;
            cursor: pointer;
        }
        .tab.active {
            background: rgba(0, 212, 255, 0.2);
            color: #00d4ff;
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
                    <div class="menu-title">Cadastros</div>
                    <a href="index.php" class="menu-item active">
                        <span class="icon">👥</span>Clientes
                    </a>
                    <a href="fornecedores.php" class="menu-item">
                        <span class="icon">🏭</span>Fornecedores
                    </a>
                    <a href="../config/usuarios.php" class="menu-item">
                        <span class="icon">👤</span>Usuários
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
                <h2>➕ Cadastro de Cliente</h2>
                <a href="index.php" class="btn">← Voltar</a>
            </div>

            <?php if (isset($mensagem)): ?>
            <div class="alert"><?php echo $mensagem; ?></div>
            <?php endif; ?>

            <div class="tabs">
                <button class="tab active">Dados Básicos</button>
                <button class="tab">Endereço</button>
                <button class="tab">Equipamentos</button>
                <button class="tab">Histórico</button>
            </div>

            <div class="form-section">
                <form method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nome Completo / Razão Social *</label>
                            <input type="text" name="nome" placeholder="Ex: João Silva" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Tipo *</label>
                            <select name="tipo" required>
                                <option value="">Selecione...</option>
                                <option value="PF">Pessoa Física</option>
                                <option value="PJ">Pessoa Jurídica</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>CPF / CNPJ *</label>
                            <input type="text" name="cpf_cnpj" placeholder="000.000.000-00" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Telefone *</label>
                            <input type="text" name="telefone" placeholder="(00) 00000-0000" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="cliente@email.com">
                        </div>
                        
                        <div class="form-group">
                            <label>Cidade</label>
                            <input type="text" name="cidade" placeholder="Ex: Curitiba">
                        </div>
                        
                        <div class="form-group full-width">
                            <label>Endereço Completo</label>
                            <input type="text" name="endereco" placeholder="Rua, número, bairro">
                        </div>
                        
                        <div class="form-group full-width">
                            <label>Observações</label>
                            <textarea name="observacoes" placeholder="Informações adicionais sobre o cliente..."></textarea>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn" style="margin-top: 25px;">Salvar Cliente</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>