<?php
// SGN - Movimentações por Conta Bancária
require_once '../../includes/config.php';

// Buscar contas
$contas = $pdo->query("SELECT * FROM financeiro.contas_bancarias WHERE ativa = true ORDER BY apelido")->fetchAll();

// Conta selecionada
$conta_id = $_GET['conta'] ?? null;
$movimentacoes = [];
$conta_selecionada = null;

if ($conta_id) {
    $stmt = $pdo->prepare("SELECT * FROM financeiro.contas_bancarias WHERE id = ?");
    $stmt->execute([$conta_id]);
    $conta_selecionada = $stmt->fetch();
    
    // Buscar movimentações
    $stmt = $pdo->prepare("
        SELECT m.*, c.nome as categoria_nome, fc.nome as pessoa_nome
        FROM financeiro.movimentacoes m
        LEFT JOIN financeiro.categorias c ON m.categoria_id = c.id
        LEFT JOIN financeiro.fornecedores_clientes fc ON m.fornecedor_cliente_id = fc.id
        WHERE m.conta_id = ?
        ORDER BY m.data DESC, m.id DESC
        LIMIT 100
    ");
    $stmt->execute([$conta_id]);
    $movimentacoes = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimentações por Conta - SGN</title>
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
        }
        .logo-area { padding: 30px 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); text-align: center; }
        .logo-icon { font-size: 50px; }
        .logo-area h1 { color: #00d4ff; font-size: 18px; }
        .menu { padding: 20px 0; }
        .menu-title { padding: 0 25px 10px; color: #666; font-size: 10px; text-transform: uppercase; }
        .menu-item {
            display: flex; align-items: center;
            padding: 14px 25px; margin: 2px 15px;
            border-radius: 10px;
            color: #a0a0a0; text-decoration: none; font-size: 14px;
        }
        .menu-item:hover { background: rgba(255, 255, 255, 0.05); color: #fff; }
        .menu-item.active { background: linear-gradient(135deg, rgba(0, 212, 255, 0.2) 0%, rgba(0, 153, 204, 0.2) 100%); color: #00d4ff; border: 1px solid rgba(0, 212, 255, 0.3); }
        .main-content { margin-left: 280px; flex: 1; padding: 30px; }
        .header { margin-bottom: 30px; }
        .header h2 { color: #fff; font-size: 28px; }
        
        /* Seletor de conta */
        .contas-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .conta-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .conta-card:hover { transform: translateY(-5px); border-color: rgba(0, 212, 255, 0.5); }
        .conta-card.selected { border-color: #00d4ff; background: rgba(0, 212, 255, 0.1); }
        .conta-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .conta-tipo { padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .conta-tipo.pj { background: rgba(0, 212, 255, 0.2); color: #00d4ff; }
        .conta-tipo.pf { background: rgba(0, 255, 100, 0.2); color: #00ff64; }
        .conta-nome { font-size: 20px; font-weight: 600; color: #fff; margin-bottom: 5px; }
        .conta-numero { color: #888; font-size: 14px; }
        
        /* Tabela */
        .table-container {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
            overflow-x: auto;
        }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #888; border-bottom: 1px solid rgba(255, 255, 255, 0.1); font-weight: 500; }
        td { padding: 15px; border-bottom: 1px solid rgba(255, 255, 255, 0.05); color: #e0e0e0; }
        tr:hover td { background: rgba(255, 255, 255, 0.02); }
        .valor-entrada { color: #00ff64; font-weight: 600; }
        .valor-saida { color: #ff6b6b; font-weight: 600; }
        .codigo { font-family: monospace; color: #00d4ff; background: rgba(0, 212, 255, 0.1); padding: 3px 8px; border-radius: 4px; font-size: 12px; }
        
        /* Botão opções */
        .btn-opcoes {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #fff;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
        }
        .btn-opcoes:hover { background: rgba(0, 212, 255, 0.3); }
        
        /* Popup */
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .popup-overlay.active { display: flex; }
        .popup-content {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border: 1px solid rgba(0, 212, 255, 0.3);
            border-radius: 20px;
            padding: 30px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }
        .popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .popup-header h3 { color: #00d4ff; font-size: 24px; }
        .btn-fechar {
            background: none;
            border: none;
            color: #888;
            font-size: 28px;
            cursor: pointer;
        }
        .btn-fechar:hover { color: #fff; }
        .popup-body { color: #e0e0e0; }
        .detail-row { display: flex; margin-bottom: 15px; }
        .detail-label { width: 150px; color: #888; font-size: 14px; }
        .detail-value { flex: 1; color: #fff; font-size: 14px; }
        .popup-actions { display: flex; gap: 10px; margin-top: 25px; padding-top: 20px; border-top: 1px solid rgba(255, 255, 255, 0.1); }
        .popup-btn {
            flex: 1;
            padding: 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            text-align: center;
        }
        .popup-btn.primary { background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%); color: #fff; }
        .popup-btn.secondary { background: rgba(255, 255, 255, 0.1); color: #fff; }
        .popup-btn:hover { opacity: 0.9; }
    </style>
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <div class="logo-area">
                <div class="logo-icon">🏢</div>
                <h1>ABBADE Technologies</h1>
            </div>
            <div class="menu">
                <div class="menu-title">Financeiro</div>
                <a href="../financeiro/index.php" class="menu-item"><span class="icon">💰</span>Resumo</a>
                <a href="../financeiro/contas.php" class="menu-item"><span class="icon">🏦</span>Contas</a>
                <a href="movimentacoes_conta.php" class="menu-item active"><span class="icon">📊</span>Movimentações</a>
            </div>
        </nav>

        <main class="main-content">
            <div class="header">
                <h2>📊 Movimentações por Conta</h2>
            </div>

            <!-- Seletor de Contas -->
            <div class="contas-grid">
                <?php foreach ($contas as $c): ?
                <a href="?conta=<?php echo $c['id']; ?>" class="conta-card <?php echo $conta_id == $c['id'] ? 'selected' : ''; ?>">
                    <div class="conta-header">
                        <div class="conta-tipo <?php echo $c['tipo_pessoa'] == 'PJ' ? 'pj' : 'pf'; ?>">
                            <?php echo $c['tipo_pessoa']; ?>
                        </div>
                        <div style="color: #888; font-size: 12px;">ID: <?php echo $c['id']; ?></div>
                    </div>
                    <div class="conta-nome"><?php echo htmlspecialchars($c['apelido']); ?></div>
                    <div class="conta-numero"><?php echo htmlspecialchars($c['numero_conta']); ?></div>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Movimentações -->
            <?php if ($conta_selecionada): ?
            <div class="table-container">
                <h3 style="color: #00d4ff; margin-bottom: 20px;">
                    <?php echo htmlspecialchars($conta_selecionada['apelido']); ?> - 
                    <?php echo count($movimentacoes); ?> movimentações
                </h3>
                
                <?php if (count($movimentacoes) > 0): ?
                <table>
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th>Categoria</th>
                            <th>Valor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movimentacoes as $m): ?
                        <tr>
                            <td><span class="codigo"><?php echo $m['codigo'] ?? 'N/A'; ?></span></td>
                            <td><?php echo date('d/m/Y', strtotime($m['data'])); ?></td>
                            <td><?php echo htmlspecialchars(substr($m['descricao'], 0, 50)); ?>...</td>
                            <td><?php echo htmlspecialchars($m['categoria_nome'] ?? 'N/A'); ?></td>
                            <td class="<?php echo $m['tipo'] == 'ENTRADA' ? 'valor-entrada' : 'valor-saida'; ?>">
                                R$ <?php echo number_format($m['valor'], 2, ',', '.'); ?>
                            </td>
                            <td>
                                <button class="btn-opcoes" onclick="abrirPopup(<?php echo htmlspecialchars(json_encode($m)); ?>)">
                                    ⚙️ Opções
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <?php else: ?
                <p style="color: #666; text-align: center; padding: 40px;">Nenhuma movimentação encontrada para esta conta.</p>
                <?php endif; ?>
            </div>
            <?php else: ?
            <p style="color: #888; text-align: center; padding: 60px; font-size: 18px;">
                👆 Selecione uma conta acima para ver as movimentações
            </p>
            <?php endif; ?>
        </main>
    </div>

    <!-- Popup de Detalhes -->
    <div class="popup-overlay" id="popup">
        <div class="popup-content">
            <div class="popup-header">
                <h3>📄 Detalhes da Movimentação</h3>
                <button class="btn-fechar" onclick="fecharPopup()">×</button>
            </div>
            
            <div class="popup-body" id="popup-body">
                <!-- Conteúdo dinâmico -->
            </div>
            
            <div class="popup-actions">
                <a href="#" class="popup-btn primary" id="btn-voltar" onclick="fecharPopup()">← Voltar</a>
                <a href="#" class="popup-btn secondary" id="btn-email">📧 Enviar por Email</a>
                <a href="#" class="popup-btn secondary" id="btn-imprimir" onclick="window.print()">🖨️ Imprimir</a>
                <a href="#" class="popup-btn secondary" id="btn-salvar">💾 Salvar PDF</a>
            </div>
        </div>
    </div>

    <script>
        function abrirPopup(dados) {
            const popup = document.getElementById('popup');
            const body = document.getElementById('popup-body');
            
            // Formatar dados
            let html = '';
            for (const [key, value] of Object.entries(dados)) {
                if (value) {
                    html += `
                        <div class="detail-row">
                            <div class="detail-label">${key.toUpperCase()}:</div>
                            <div class="detail-value">${value}</div>
                        </div>
                    `;
                }
            }
            
            body.innerHTML = html;
            popup.classList.add('active');
        }
        
        function fecharPopup() {
            document.getElementById('popup').classList.remove('active');
        }
        
        // Fechar ao clicar fora
        document.getElementById('popup').addEventListener('click', function(e) {
            if (e.target === this) fecharPopup();
        });
    </script>
</body>
</html>