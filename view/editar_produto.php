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
    <title>Editar Produto</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php
    require_once '../controller/ProdutoController.php';
    $produtoController = new ProdutoController();
    $produto = $produtoController->buscarProdutoPorId($_GET['id']);

    if ($produto) {
        ?>
        <form action="../controller/ProdutoController.php" method="post">
            <input type="hidden" name="id" value="<?php echo $produto->getId(); ?>">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $produto->getNome(); ?>" required>
            <br>
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required><?php echo $produto->getDescricao(); ?></textarea>
            <br>
            <label for="preco">Preço:</label>
            <input type="text" id="preco" name="preco" value="<?php echo $produto->getPreco(); ?>" required>
            <br>
            <button type="submit" name="acao" value="atualizar">Atualizar</button>
        </form>
        <?php
    } else {
        echo '<p>Produto não encontrado.</p>';
    }
    ?>
    <a href="lista_produtos.php">Voltar</a>
</body>
</html>