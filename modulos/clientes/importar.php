<?php
// SGN - Importar Clientes de Extratos
require_once '../../includes/config.php';

$mensagem = '';
$preview = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['arquivo'])) {
    // Simulação de processamento
    $mensagem = "Arquivo recebido! Analise de preview gerada.";
    $preview = [
        ['nome' => 'ATUAL PECAS', 'valor' => '150,00', 'data' => '05/04/2026', 'tipo' => 'fornecedor'],
        ['nome' => 'JOÃO SILVA', 'valor' => '300,00', 'data' => '04/04/2026', 'tipo' => 'cliente'],
    ];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar Clientes - SGN</title>
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
        .upload-area {
            background: rgba(255, 255, 255, 0.02);
            border: 2px dashed rgba(0, 212, 255, 0.3);
            border-radius: 16px;
            padding: 60px;
            text-align: center;
            margin-bottom: 30px;
        }
        .upload-area:hover { border-color: #00d4ff; }
        .upload-icon { font-size: 60px; margin-bottom: 20px; }
        .alert {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid rgba(40, 167, 69, 0.5);
            color: #28a745;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .section {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
        }
        .section h3 { color: #fff; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #888; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        td { padding: 15px; border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .tipo-cliente { color: #28a745; }
        .tipo-fornecedor { color: #ffc107; }
        .acoes { display: flex; gap: 10px; }
        .acoes select { padding: 5px 10px; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); color: #fff; border-radius: 6px; }
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
                    <a href="index.php" class="menu-item">
                        <span class="icon">👥</span>Clientes
                    </a>
                    <a href="fornecedores.php" class="menu-item">
                        <span class="icon">🏭</span>Fornecedores
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
                <h2>📥 Importar Clientes de Extratos</h2>
                <a href="index.php" class="btn">← Voltar</a>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <div class="upload-area">
                    <div class="upload-icon">📄</div>
                    <p>Arraste o arquivo CSV ou extrato bancário aqui</p>
                    <p style="color: #666; margin-top: 10px;">ou clique para selecionar</p>
                    <input type="file" name="arquivo" accept=".csv,.ofx,.txt" style="display: none;">
                    <button type="button" class="btn" style="margin-top: 20px;" onclick="document.querySelector('input[type=file]').click()">
                        Selecionar Arquivo
                    </button>
                </div>

                <?php if ($mensagem): ?>
                <div class="alert"><?php echo $mensagem; ?></div>
                <?php endif; ?>

                <?php if ($preview): ?>
                <div class="section">
                    <h3>👁️ Preview dos Dados</h3>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Nome Detectado</th>
                                <th>Valor</th>
                                <th>Data</th>
                                <th>Tipo Sugerido</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($preview as $p): ?>
                            <tr>
                                <td><?php echo $p['nome']; ?></td>
                                <td>R$ <?php echo $p['valor']; ?></td>
                                <td><?php echo $p['data']; ?></td>
                                <td class="tipo-<?php echo $p['tipo']; ?>"><?php echo ucfirst($p['tipo']); ?></td>
                                <td class="acoes">
                                    <select>
                                        <option>Criar novo</option>
                                        <option>Mesclar com existente</option>
                                        <option>Ignorar</option>
                                    </select>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <button type="submit" class="btn" style="margin-top: 20px;">✓ Confirmar Importação</button>
                </div>
                <?php endif; ?>
            </form>

            <div class="section">
                <h3>ℹ️ Como funciona</h3>
                
                <ul style="color: #888; line-height: 2;">
                    <li>📤 Faça upload do extrato bancário (CSV, OFX)</li>
                    <li>🔍 O sistema identifica automaticamente nomes de clientes e fornecedores</li>
                    <li>📊 Preview para confirmar antes de importar</li>
                    <li>✅ Evita duplicados sugerindo mesclagem</li>
                    <li>💾 Salva no banco de dados PostgreSQL</li>
                </ul>
            </div>
        </main>
    </div>
</body>
</html>