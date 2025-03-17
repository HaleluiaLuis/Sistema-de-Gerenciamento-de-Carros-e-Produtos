<?php
session_start();
require_once '../controller/UserController.php';

if (!isset($_SESSION['user_id'])) {
    echo 'Acesso negado.';
    exit;
}

$userController = new UserController();
$usuario = $userController->buscarUsuarioPorId($_SESSION['user_id']);

if ($usuario->getRole() !== 'admin') {
    echo 'Acesso negado.';
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detalhes do Produto</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php
    require_once '../controller/ProdutoController.php';
    $produtoController = new ProdutoController();
    $produto = $produtoController->buscarProdutoPorId($_GET['id']);

    if ($produto) {
        echo '<h1>' . htmlspecialchars($produto->getNome()) . '</h1>';
        echo '<p>' . htmlspecialchars($produto->getDescricao()) . '</p>';
        echo '<p>Preço: ' . htmlspecialchars($produto->getPreco()) . '</p>';
        echo '<br>';
    } else {
        echo '<p>Produto não encontrado.</p>';
    }
    ?>
    <a href="lista_produtos.php">Voltar</a>
</body>
</html>