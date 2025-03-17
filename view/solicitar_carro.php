<?php
session_start();
require_once '../controller/UserController.php';
require_once '../controller/CarroController.php';
require_once '../controller/SolicitacaoController.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

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

// Verifica se o parâmetro 'id' está presente na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $carroController = new CarroController();
    $carro = $carroController->buscarCarroPorId($id);

    if (!$carro) {
        echo 'Carro não encontrado.';
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('CSRF token inválido.');
        }
        $solicitacaoController = new SolicitacaoController();
        $carroId = $_POST['carro_id'];
        $usuarioId = $_POST['usuario_id'];
        $solicitacaoController->solicitarProduto($carroId, $usuarioId);
        header('Location: lista_carros.php');
        exit;
    }
} else {
    echo "ID do carro não fornecido.";
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
<body class="bg-gray-800 min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 rounded-lg shadow-lg w-full max-w-6xl p-4">
        <div class="flex flex-wrap">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4 bg-gray-900 rounded-lg p-4 mb-4 md:mb-0">
                <div class="text-white text-2xl font-bold mb-6">
                    Car Rentals
                </div>
                <ul class="space-y-4">
                    <li class="flex items-center text-gray-400 hover:text-white cursor-pointer">
                        <i class="fas fa-car mr-3"></i>
                        <a href="lista_carros.php">Listar Carros</a>
                    </li>
                    <li class="flex items-center text-gray-400 hover:text-white cursor-pointer">
                        <i class="fas fa-user mr-3"></i>
                        <a href="perfil.php?id=<?php echo htmlspecialchars($usuario->getId()); ?>">Meu Perfil</a>
                    </li>
                    <li class="flex items-center text-gray-400 hover:text-white cursor-pointer">
                        <i class="fas fa-box mr-3"></i>
                        <a href="minhas_solicitacoes.php">Minhas Solicitações</a>
                    </li>
                </ul>
                <div class="mt-20 flex items-center text-white">
                    <img alt="User profile picture" class="rounded-full mr-3" height="40" src="../uploads/<?php echo htmlspecialchars($usuario->getImagem()); ?>" width="40"/>
                    <div>
                        <div class="font-bold">Welcome</div>
                        <div><?php echo htmlspecialchars($usuario->getNome()); ?></div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="editar_perfil.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg" style="display: block; margin-bottom: 10px;">Editar Perfil</a>
                    <a href="../controller/logout.php" class="bg-red-600 text-white px-4 py-2 rounded-lg" style="display: block;">Logout</a>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="w-full md:w-3/4 p-4">
                <h2 class="text-2xl text-white font-bold mb-6">Solicitar Carro</h2>
                <div class="bg-gray-700 rounded-lg p-4">
                    <h1 class="text-xl font-bold mb-4 text-white">Solicitar Carro: <?php echo htmlspecialchars($carro->getMarca()) . ' ' . htmlspecialchars($carro->getModelo()); ?></h1>
                    <form action="solicitar_carro.php?id=<?php echo htmlspecialchars($carro->getId()); ?>" method="post" class="bg-gray-800 p-6 rounded shadow-md">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="carro_id" value="<?php echo htmlspecialchars($carro->getId()); ?>">
                        <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($usuario->getId()); ?>">
                        <button type="submit" name="acao" value="solicitar" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Solicitar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>