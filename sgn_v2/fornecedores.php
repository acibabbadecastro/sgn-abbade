<?php
// SGN - Cadastro de Fornecedores com Busca por CNPJ
require_once '../../includes/config.php';

$mensagem = '';
$fornecedor = null;

// Buscar por CNPJ
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscar_cnpj'])) {
    $cnpj = preg_replace('/[^0-9]/', '', $_POST['cnpj_busca']);
    
    // Consulta na tabela
    $stmt = $pdo->prepare("SELECT * FROM financeiro.fornecedores_clientes WHERE cpf_cnpj = ? AND tipo IN ('fornecedor', 'ambos')");
    $stmt->execute([$cnpj]);
    $fornecedor = $stmt->fetch();
    
    if (!$fornecedor) {
        // Tentar consultar API da ReceitaWS (simulado)
        $mensagem = "CNPJ não encontrado. Deseja cadastrar manualmente?";
    }
}

// Salvar fornecedor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar'])) {
    $dados = [
        'tipo' => 'fornecedor',
        'nome' => $_POST['nome'],
        'nome_fantasia' => $_POST['nome_fantasia'] ?? null,
        'cpf_cnpj' => preg_replace('/[^0-9]/', '', $_POST['cpf_cnpj']),
        'telefone' => $_POST['telefone'] ?? null,
        'email' => $_POST['email'] ?? null,
        'endereco' => $_POST['endereco'] ?? null,
        'cidade' => $_POST['cidade'] ?? null,
        'observacoes' => $_POST['observacoes'] ?? null,
        'ativo' => true
    ];
    
    $sql = "INSERT INTO financeiro.fornecedores_clientes 
            (tipo, nome, nome_fantasia, cpf_cnpj, telefone, email, endereco, cidade, observacoes, ativo)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON CONFLICT (cpf_cnpj) DO UPDATE SET
            nome = EXCLUDED.nome, nome_fantasia = EXCLUDED.nome_fantasia,
            telefone = EXCLUDED.telefone, email = EXCLUDED.email,
            endereco = EXCLUDED.endereco, cidade = EXCLUDED.cidade,
            observacoes = EXCLUDED.observacoes, updated_at = NOW()";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_values($dados));
    $mensagem = "Fornecedor salvo com sucesso!";
}

// Listar fornecedores
$fornecedores = $pdo->query("SELECT * FROM financeiro.fornecedores_clientes 
                                WHERE tipo IN ('fornecedor', 'ambos') AND ativo = true 
                                ORDER BY nome")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores - SGN</title>
    <style>
        /* Reset e Base */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #16213e 100%);
            min-height: 100vh;
            color: #e0e0e0;
        }
        
        /* Layout */
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
        .logo-area {
            padding: 30px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        .logo-icon { font-size: 50px; margin-bottom: 10px; }
        .logo-area h1 { color: #00d4ff; font-size: 18px; }
        .menu { padding: 20px 0; }
        .menu-title { padding: 0 25px 10px; color: #666; font-size: 10px; text-transform: uppercase; letter-spacing: 2px; }
        .menu-item {
            display: flex; align-items: center;
            padding: 14px 25px; margin: 2px 15px;
            border-radius: 10px;
            color: #a0a0a0; text-decoration: none; font-size: 14px;
            transition: all 0.3s ease;
        }
        .menu-item:hover { background: rgba(255, 255, 255, 0.05); color: #fff; }
        .menu-item.active {
            background: linear-gradient(135deg, rgba(0, 212, 255, 0.2) 0%, rgba(0, 153, 204, 0.2) 100%);
            color: #00d4ff; border: 1px solid rgba(0, 212, 255, 0.3);
        }
        .menu-item .icon { width: 24px; margin-right: 15px; font-size: 18px; }
        
        /* Main Content */
        .main-content { margin-left: 280px; flex: 1; padding: 30px; }
        .header { margin-bottom: 30px; }
        .header h2 { color: #fff; font-size: 28px; }
        
        /* Busca CNPJ */
        .busca-box {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(0, 212, 255, 0.3);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
        }
        .busca-box h3 { color: #00d4ff; margin-bottom: 20px; }
        .busca-row { display: flex; gap: 15px; }
        .busca-row input {
            flex: 1; padding: 15px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #fff; font-size: 16px;
        }
        .busca-row input::placeholder { color: #666; }
        .btn-buscar {
            padding: 15px 30px;
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            border: none; border-radius: 10px;
            color: #fff; font-size: 16px; font-weight: 600;
            cursor: pointer;
        }
        
        /* Formulário */
        .form-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
        }
        .form-card h3 { color: #fff; margin-bottom: 25px; }
        .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 20px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { color: #888; margin-bottom: 8px; font-size: 14px; }
        .form-group input, .form-group textarea {
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #fff; font-size: 14px;
        }
        .form-group textarea { min-height: 100px; resize: vertical; }
        
        .btn-salvar {
            padding: 15px 40px;
            background: linear-gradient(135deg, #00d4ff 0%, #0099cc 100%);
            border: none; border-radius: 10px;
            color: #fff; font-size: 16px; font-weight: 600;
            cursor: pointer;
        }
        
        /* Lista */
        .lista-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 25px;
        }
        .lista-card h3 { color: #fff; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #888; font-weight: 500; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        td { padding: 15px; border-bottom: 1px solid rgba(255, 255, 255, 0.05); color: #e0e0e0; }
        tr:hover td { background: rgba(255, 255, 255, 0.02); }
        
        .cnpj-format { font-family: monospace; color: #00d4ff; }
        
        /* Mensagem */
        .mensagem {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .mensagem.success { background: rgba(0, 255, 100, 0.1); border: 1px solid rgba(0, 255, 100, 0.3); color: #00ff64; }
        .mensagem.info { background: rgba(0, 212, 255, 0.1); border: 1px solid rgba(0, 212, 255, 0.3); color: #00d4ff; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="logo-area">
                <div class="logo-icon">🏢</div>
                <h1>ABBADE Technologies</h1>
            </div>
            <div class="menu">
                <div class="menu-title">Principal</div>
                <a href="../../dashboard.php" class="menu-item"><span class="icon">📊</span>Dashboard</a>
                
                <div class="menu-title">Cadastros</div>
                <a href="../clientes/index.php" class="menu-item"><span class="icon">👥</span>Clientes</a>
                <a href="fornecedores.php" class="menu-item active"><span class="icon">🏭</span>Fornecedores</a>
                <a href="usuarios.php" class="menu-item"><span class="icon">👤</span>Usuários</a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h2>🏭 Cadastro de Fornecedores</h2>
            </div>

            <?php if ($mensagem): ?>
            <div class="mensagem <?php echo strpos($mensagem, 'sucesso') !== false ? 'success' : 'info'; ?>">
                <?php echo $mensagem; ?>
            </div>
            <?php endif; ?>

            <!-- Busca por CNPJ -->
            <div class="busca-box">
                <h3>🔍 Buscar por CNPJ</h3>
                <form method="POST">
                    <div class="busca-row">
                        <input type="text" name="cnpj_busca" placeholder="Digite o CNPJ (00.000.000/0000-00)" 
                               value="<?php echo $fornecedor['cpf_cnpj'] ?? ''; ?>" 
                               maxlength="18" >
                        <button type="submit" name="buscar_cnpj" class="btn-buscar">Buscar</button>
                    </div>
                </form>
            </div>

            <!-- Formulário -->
            <div class="form-card">
                <h3>📝 Dados do Fornecedor</h3>
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Razão Social *</label>
                            <input type="text" name="nome" required 
                                   value="<?php echo $fornecedor['nome'] ?? ''; ?>" 
                                   placeholder="Nome completo da empresa">
                        </div>
                        
                        <div class="form-group">
                            <label>Nome Fantasia</label>
                            <input type="text" name="nome_fantasia" 
                                   value="<?php echo $fornecedor['nome_fantasia'] ?? ''; ?>"
                                   placeholder="Nome comercial">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>CNPJ *</label>
                            <input type="text" name="cpf_cnpj" required 
                                   value="<?php echo $fornecedor['cpf_cnpj'] ?? ''; ?>"
                                   placeholder="00.000.000/0000-00">
                        </div>
                        
                        <div class="form-group">
                            <label>Telefone</label>
                            <input type="text" name="telefone" 
                                   value="<?php echo $fornecedor['telefone'] ?? ''; ?>"
                                   placeholder="(00) 00000-0000">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="email" name="email" 
                                   value="<?php echo $fornecedor['email'] ?? ''; ?>"
                                   placeholder="email@empresa.com.br">
                        </div>
                        
                        <div class="form-group">
                            <label>Cidade</label>
                            <input type="text" name="cidade" 
                                   value="<?php echo $fornecedor['cidade'] ?? ''; ?>"
                                   placeholder="Curitiba - PR">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Endereço Completo</label>
                            <input type="text" name="endereco" 
                                   value="<?php echo $fornecedor['endereco'] ?? ''; ?>"
                                   placeholder="Rua, número, bairro, CEP">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Observações</label>
                            <textarea name="observacoes" placeholder="Informações adicionais sobre o fornecedor..."><?php echo $fornecedor['observacoes'] ?? ''; ?></textarea>
                        </div>
                    </div>

                    <button type="submit" name="salvar" class="btn-salvar">💾 Salvar Fornecedor</button>
                </form>
            </div>

            <!-- Lista -->
            <div class="lista-card">
                <h3>📋 Fornecedores Cadastrados (<?php echo count($fornecedores); ?>)</h3>
                
                <?php if (count($fornecedores) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nome/Razão Social</th>
                            <th>CNPJ</th>
                            <th>Cidade</th>
                            <th>Telefone</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fornecedores as $f): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($f['nome']); ?></strong><br>
                                <small style="color: #666;"><?php echo htmlspecialchars($f['nome_fantasia'] ?? ''); ?></small></td>
                            <td class="cnpj-format"><?php echo $f['cpf_cnpj']; ?></td>
                            <td><?php echo htmlspecialchars($f['cidade'] ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($f['telefone'] ?? '-'); ?></td>
                            <td>
                                <a href="?editar=<?php echo $f['id']; ?>" style="color: #00d4ff; text-decoration: none;">✏️ Editar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p style="color: #666; text-align: center; padding: 40px;">
                    Nenhum fornecedor cadastrado.
                </p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script>
        // Máscara CNPJ
        document.querySelector('input[name="cnpj_busca"]').addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '');
            v = v.replace(/^(\d{2})(\d)/, '$1.$2');
            v = v.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
            v = v.replace(/\.(\d{3})(\d)/, '.$1/$2');
            v = v.replace(/(\d{4})(\d)/, '$1-$2');
            e.target.value = v.substring(0, 18);
        });
    </script>
</body>
</html>