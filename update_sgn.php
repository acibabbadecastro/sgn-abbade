<?php
// Script para atualizar SGN direto do GitHub
$repo = 'acibabbadecastro/sgn-abbade';
$branch = 'master';
$dir = __DIR__;

// Baixa arquivos do GitHub
$files = [
    'index.php',
    'includes/config.php',
    'modulos/clientes/index.php',
    'modulos/estoque/index.php',
    'modulos/os/index.php',
    'modulos/financeiro/index.php',
    'modulos/financeiro/contas.php',
    'modulos/financeiro/movimentacoes.php',
    'modulos/financeiro/categorias.php',
    'modulos/financeiro/fornecedores.php',
];

echo "Atualizando SGN...\n<br>";

foreach ($files as $file) {
    $url = "https://raw.githubusercontent.com/{$repo}/{$branch}/{$file}";
    $content = @file_get_contents($url);
    
    if ($content !== false) {
        $path = $dir . '/' . $file;
        if (file_put_contents($path, $content)) {
            echo "✓ {$file}\n<br>";
        } else {
            echo "✗ Erro ao salvar: {$file}\n<br>";
        }
    } else {
        echo "✗ Erro ao baixar: {$file}\n<br>";
    }
}

echo "\n<br>Atualização concluída!";
?>
