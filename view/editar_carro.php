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
    <title>Editar Carro</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
    <header class="bg-blue-600 text-white p-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Editar Carro</h1>
        <a href="lista_carros.php" class="text-yellow-400 hover:text-yellow-300">Voltar</a>
    </header>
    <div class="container mx-auto p-6">
        <?php
        require_once '../controller/CarroController.php';
        $carroController = new CarroController();
        $carro = $carroController->buscarCarroPorId($_GET['id']);

        if ($carro) {
            ?>
            <form action="../controller/CarroController.php" method="post" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($carro->getId()); ?>">
                <div class="mb-4">
                    <label for="marca" class="block text-sm font-medium text-gray-700">Marca:</label>
                    <input type="text" id="marca" name="marca" value="<?php echo htmlspecialchars($carro->getMarca()); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="modelo" class="block text-sm font-medium text-gray-700">Modelo:</label>
                    <input type="text" id="modelo" name="modelo" value="<?php echo htmlspecialchars($carro->getModelo()); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="ano" class="block text-sm font-medium text-gray-700">Ano:</label>
                    <input type="number" id="ano" name="ano" value="<?php echo htmlspecialchars($carro->getAno()); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="placa" class="block text-sm font-medium text-gray-700">Placa:</label>
                    <input type="text" id="placa" name="placa" value="<?php echo htmlspecialchars($carro->getPlaca()); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="cor" class="block text-sm font-medium text-gray-700">Cor:</label>
                    <input type="text" id="cor" name="cor" value="<?php echo htmlspecialchars($carro->getCor()); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="quilometragem" class="block text-sm font-medium text-gray-700">Quilometragem:</label>
                    <input type="number" id="quilometragem" name="quilometragem" value="<?php echo htmlspecialchars($carro->getQuilometragem()); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="combustivel" class="block text-sm font-medium text-gray-700">Combustível:</label>
                    <input type="text" id="combustivel" name="combustivel" value="<?php echo htmlspecialchars($carro->getCombustivel()); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="preco" class="block text-sm font-medium text-gray-700">Preço por Dia:</label>
                    <input type="number" id="preco" name="preco" value="<?php echo htmlspecialchars($carro->getPreco()); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="imagem" class="block text-sm font-medium text-gray-700">Imagem:</label>
                    <input type="file" id="imagem" name="imagem" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <button type="submit" name="acao" value="atualizar" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Atualizar</button>
            </form>
            <?php
        } else {
            echo '<p>Carro não encontrado.</p>';
        }
        ?>
    </div>
</body>
</html>