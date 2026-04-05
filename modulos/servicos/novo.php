<?php
// SGN - Cadastrar Novo Serviço
require_once '../../includes/config.php';

// Buscar clientes para select
$clientes = getClientes($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensagem = "Serviço cadastrado com sucesso!";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Serviço - SGN</title>
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
        .form-group.full-width {
            grid-column: span 2;
        }
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
            min-height: 100px;
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
                    <a href="agendados.php" class="menu-item">
                        <span class="icon">📅</span>Agendados
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
                <h2>➕ Novo Serviço</h2>
                <a href="agendados.php" class="btn">← Voltar</a>
            </div>

            <?php if (isset($mensagem)): ?>
            <div class="alert"><?php echo $mensagem; ?></div>
            <?php endif; ?>

            <div class="form-section">
                <form method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Cliente</label>
                            <select name="cliente_id" required>
                                <option value="">Selecione o cliente...</option>
                                <?php foreach ($clientes as $c): ?>
                                <option value="<?php echo $c['id']; ?>">
                                    <?php echo htmlspecialchars($c['nome']); ?>
                                </option>
                                <?php endforeach; ?>
                                <option value="novo">+ Cadastrar novo cliente</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Equipamento</label>
                            <input type="text" name="equipamento" placeholder="Ex: Notebook Dell" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Marca/Modelo</label>
                            <input type="text" name="modelo" placeholder="Ex: Inspiron 15 3000" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Tipo de Serviço</label>
                            <select name="tipo_servico" required>
                                <option value="">Selecione...</option>
                                <option>Formatação</option>
                                <option>Limpeza</option>
                                <option>Troca de Peça</option>
                                <option>Reparo</option>
                                <option>Manutenção Preventiva</option>
                                <option>Outro</option>
                            </select>
                        </div>
                        
                        <div class="form-group full-width">
                            <label>Problema Relatado</label>
                            <textarea name="problema" placeholder="Descreva o problema relatado pelo cliente..." required></textarea>
                        </div>
                        
                        <div class="form-group full-width">
                            <label>Diagnóstico Técnico</label>
                            <textarea name="diagnostico" placeholder="Seu diagnóstico técnico..."></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Valor Estimado (R$)</label>
                            <input type="number" name="valor" step="0.01" placeholder="0,00">
                        </div>
                        
                        <div class="form-group">
                            <label>Data Prevista</label>
                            <input type="date" name="data_prevista" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Prioridade</label>
                            <select name="prioridade">
                                <option value="normal">Normal</option>
                                <option value="alta">Alta</option>
                                <option value="urgente">Urgente</option>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn" style="margin-top: 25px;">Cadastrar Serviço</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>