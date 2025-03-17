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
    <title>Lista de Produtos</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Produtos</h1>
    <br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once '../controller/ProdutoController.php';
            $produtoController = new ProdutoController();
            $produtos = $produtoController->listarProdutos();

            foreach ($produtos as $produto) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($produto['id']) . '</td>';
                echo '<td>' . htmlspecialchars($produto['nome']) . '</td>';
                echo '<td>' . htmlspecialchars($produto['descricao']) . '</td>';
                echo '<td>' . htmlspecialchars($produto['preco']) . '</td>';
                echo '<td><a href="detalhes_produto.php?id=' . htmlspecialchars($produto['id']) . '">Detalhes</a> | <a href="editar_produto.php?id=' . htmlspecialchars($produto['id']) . '">Editar</a> | <a href="excluir_produto.php?id=' . htmlspecialchars($produto['id']) . '">Excluir</a></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <br>
    <a href="index.php">Voltar</a>
</body>
</html>