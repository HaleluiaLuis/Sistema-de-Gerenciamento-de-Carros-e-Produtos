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
    <title>Excluir Produto</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php
    require_once '../controller/ProdutoController.php';
    $produtoController = new ProdutoController();
    $produto = $produtoController->buscarProdutoPorId($_GET['id']);

    if ($produto) {
        ?>
        <h1>Tem certeza que deseja excluir o produto "<?php echo $produto->getNome(); ?>"?</h1>
        <form action="../controller/ProdutoController.php" method="post">
            <input type="hidden" name="id" value="<?php echo $produto->getId(); ?>">
            <button type="submit" name="acao" value="excluir">Excluir</button>
        </form>
        <?php
    } else {
        echo '<p>Produto não encontrado.</p>';
    }
    ?>
    <a href="lista_produtos.php">Voltar</a>
</body>
</html>