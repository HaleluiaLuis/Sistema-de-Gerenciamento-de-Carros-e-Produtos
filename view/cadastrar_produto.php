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
    <title>Cadastrar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
    <header class="bg-blue-600 text-white p-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Cadastrar Produto</h1>
        <a href="lista_produtos.php" class="text-yellow-400 hover:text-yellow-300">Voltar</a>
    </header>
    <div class="container mx-auto p-6">
        <form action="../controller/ProdutoController.php" method="post" class="bg-white p-6 rounded shadow-md">
            <div class="mb-4">
                <label for="nome" class="block text-sm font-medium text-gray-700">Nome:</label>
                <input type="text" id="nome" name="nome" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição:</label>
                <textarea id="descricao" name="descricao" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
            </div>
            <div class="mb-4">
                <label for="preco" class="block text-sm font-medium text-gray-700">Preço:</label>
                <input type="text" id="preco" name="preco" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <button type="submit" name="acao" value="cadastrar" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Cadastrar</button>
        </form>
    </div>
</body>
</html>