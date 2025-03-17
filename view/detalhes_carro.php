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
    <title>Detalhes do Carro</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
    <header class="bg-blue-600 text-white p-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Detalhes do Carro</h1>
        <a href="lista_carros.php" class="text-yellow-400 hover:text-yellow-300">Voltar</a>
    </header>
    <div class="container mx-auto p-6">
        <?php
        require_once '../controller/CarroController.php';
        $carroController = new CarroController();
        $carro = $carroController->buscarCarroPorId($_GET['id']);

        if ($carro) {
            echo '<img src="../uploads/' . htmlspecialchars($carro->getImagem()) . '" alt="Imagem do Carro" class="w-full h-40 object-cover rounded mb-4">';
            echo '<h2 class="text-xl font-semibold mb-4">' . htmlspecialchars($carro->getMarca()) . ' ' . htmlspecialchars($carro->getModelo()) . '</h2>';
            echo '<p><strong>Ano:</strong> ' . htmlspecialchars($carro->getAno()) . '</p>';
            echo '<p><strong>Placa:</strong> ' . htmlspecialchars($carro->getPlaca()) . '</p>';
            echo '<p><strong>Cor:</strong> ' . htmlspecialchars($carro->getCor()) . '</p>';
            echo '<p><strong>Quilometragem:</strong> ' . htmlspecialchars($carro->getQuilometragem()) . ' km</p>';
            echo '<p><strong>Combustível:</strong> ' . htmlspecialchars($carro->getCombustivel()) . '</p>';
            echo '<p><strong>Preço por Dia:</strong>  ' . htmlspecialchars($carro->getPreco()) . ' AOA </p>';
        } else {
            echo '<p>Carro não encontrado.</p>';
        }
        ?>
    </div>
</body>
</html>