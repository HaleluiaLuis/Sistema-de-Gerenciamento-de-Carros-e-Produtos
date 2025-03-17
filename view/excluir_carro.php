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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Carro</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
    <header class="bg-blue-600 text-white p-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Excluir Carro</h1>
        <a href="lista_carros.php" class="text-yellow-400 hover:text-yellow-300">Voltar</a>
    </header>
    <div class="container mx-auto p-6">
        <?php
        require_once '../controller/CarroController.php';
        $carroController = new CarroController();
        $carro = $carroController->buscarCarroPorId($_GET['id']);

        if ($carro) {
            ?>
            <h1 class="text-xl font-bold mb-4">Tem certeza que deseja excluir o carro "<?php echo htmlspecialchars($carro->getMarca()) . ' ' . htmlspecialchars($carro->getModelo()); ?>"?</h1>
            <form action="../controller/CarroController.php" method="post" class="bg-white p-6 rounded shadow-md">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($carro->getId()); ?>">
                <button type="submit" name="acao" value="excluir" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Excluir</button>
            </form>
            <?php
        } else {
            echo '<p>Carro não encontrado.</p>';
        }
        ?>
    </div>
</body>
</html>