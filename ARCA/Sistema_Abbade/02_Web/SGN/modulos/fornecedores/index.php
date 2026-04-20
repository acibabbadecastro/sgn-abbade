<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores - SGN</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #2d4a2d 0%, #1e3a1e 100%);
            min-height: 100vh;
            color: #d4e8d4;
        }
        .header {
            background: rgba(0, 0, 0, 0.3);
            padding: 20px 40px;
            border-bottom: 2px solid #4a7c4a;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 { color: #d4e8d4; font-size: 24px; }
        .back-btn {
            color: #8fbc8f;
            text-decoration: none;
            padding: 10px 20px;
            border: 1px solid #4a7c4a;
            border-radius: 6px;
            transition: all 0.3s;
        }
        .back-btn:hover {
            background: rgba(74, 124, 74, 0.3);
            color: #d4e8d4;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }
        .section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .section h2 {
            color: #d4e8d4;
            margin-bottom: 20px;
            font-size: 20px;
        }
        .btn {
            background: linear-gradient(145deg, #4a7c4a, #3d5a3d);
            color: #d4e8d4;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
        }
        .btn:hover {
            background: linear-gradient(145deg, #5a8c5a, #4a7c4a);
        }
        .btn.primary {
            background: linear-gradient(145deg, #5a9c5a, #4a8c4a);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        th {
            background: rgba(0, 0, 0, 0.2);
            color: #a8c8a8;
            font-weight: 600;
        }
        td {
            color: #d4e8d4;
        }
        tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #8fbc8f;
        }
        .search-box {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 12px 20px;
            border-radius: 8px;
            color: #d4e8d4;
            width: 100%;
            max-width: 400px;
            margin-bottom: 20px;
        }
        .search-box::placeholder {
            color: #6a8a6a;
        }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <a href="../index.php" class="back-btn">← Voltar ao Dashboard</a>
        </div>
        <h1>🏪 Fornecedores</h1>
        <div></div>
    </div>

    <div class="container">
        <!-- Ações -->
        <div class="section">
            <h2>⚡ Ações</h2>
            <a href="cadastro.php" class="btn primary">+ Novo Fornecedor</a>
            <a href="produtos.php" class="btn">📦 Produtos por Fornecedor</a>
        </div>

        <!-- Busca -->
        <div class="section">
            <h2>🔍 Buscar Fornecedor</h2>
            <input type="text" class="search-box" placeholder="Nome, CNPJ, telefone..." id="searchInput">
        </div>

        <!-- Lista de Fornecedores -->
        <div class="section">
            <h2>📋 Fornecedores Cadastrados</h2>
            <div id="fornecedoresList">
                <div class="empty-state">
                    <p>Nenhum fornecedor cadastrado.</p>
                    <p>Clique em "Novo Fornecedor" para começar.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // TODO: Implementar busca e carregamento via AJAX
    </script>
</body>
</html>
