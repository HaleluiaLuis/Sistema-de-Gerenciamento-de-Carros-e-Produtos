<?php
session_start();
require_once '../controller/UserController.php';
require_once '../controller/CarroController.php';
require_once '../controller/SolicitacaoController.php';

if (!isset($_SESSION['user_id'])) {
    echo 'Acesso negado.';
    exit;
}

$userController = new UserController();
$usuario = $userController->buscarUsuarioPorId($_SESSION['user_id']);

if (!$usuario) {
    echo 'Usuário não encontrado.';
    exit;
}

$carroController = new CarroController();
$carro = $carroController->buscarCarroPorId($_GET['id']);

if (!$carro) {
    echo 'Carro não encontrado.';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $solicitacaoController = new SolicitacaoController();
    $carroId = $_POST['carro_id'];
    $usuarioId = $_POST['usuario_id'];
    $solicitacaoController->solicitarProduto($carroId, $usuarioId);
    header('Location: lista_carros.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Carro</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
    <header class="bg-blue-600 text-white p-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Solicitar Carro</h1>
        <a href="lista_carros.php" class="text-yellow-400 hover:text-yellow-300">Voltar</a>
    </header>
    <div class="container mx-auto p-6">
        <h1 class="text-xl font-bold mb-4">Solicitar Carro: <?php echo htmlspecialchars($carro->getMarca()) . ' ' . htmlspecialchars($carro->getModelo()); ?></h1>
        <form action="solicitar_produto.php?id=<?php echo htmlspecialchars($carro->getId()); ?>" method="post" class="bg-white p-6 rounded shadow-md">
            <input type="hidden" name="carro_id" value="<?php echo htmlspecialchars($carro->getId()); ?>">
            <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($usuario->getId()); ?>">
            <button type="submit" name="acao" value="solicitar" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Solicitar</button>
        </form>
    </div>
</body>
</html>
