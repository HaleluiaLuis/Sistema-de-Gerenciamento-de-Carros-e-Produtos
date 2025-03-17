<?php
session_start();
require_once '../controller/UserController.php';
require_once '../controller/CarroController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userController = new UserController();
$usuario = $userController->buscarUsuarioPorId($_SESSION['user_id']);
$carroController = new CarroController();
$carros = $carroController->listarCarros();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rentals - Lista de Carros</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        .hover-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
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
        <a href="lista_carros.php">Listar carros</a>
    </li>
    <li class="flex items-center text-gray-400 hover:text-white cursor-pointer">
        <i class="fas fa-plus mr-3"></i>
        <a href="cadastrar_carro.php">Cadastrar Carro</a>
    </li>
    <li class="flex items-center text-gray-400 hover:text-white cursor-pointer">
        <i class="fas fa-tasks mr-3"></i>
        <a href="lista_solicitacoes.php">Gerenciar Solicitações</a>
    </li>
    <li class="flex items-center text-gray-400 hover:text-white cursor-pointer">
        <i class="fas fa-chart-line mr-3"></i>
        <a href="estatisticas.php">Ver Estatísticas</a>
    </li>
    <li class="flex items-center text-gray-400 hover:text-white cursor-pointer">
        <i class="fas fa-user mr-3"></i>
        <a href="perfil.php?id=<?php echo htmlspecialchars($usuario->getId()); ?>">Meu Perfil</a>
    </li>
    <li class="flex items-center text-gray-400 hover:text-white cursor-pointer">
        <i class="fas fa-box mr-3"></i>
        <a href="minhas_solicitacoes.php">Minhas Solicitações</a>
    </li>
    <?php if ($usuario->getRole() === 'admin') { ?>
    <li class="flex items-center text-gray-400 hover:text-white cursor-pointer">
        <i class="fas fa-users mr-3"></i>
        <a href="lista_usuarios.php">Listar Usuários</a>
    </li>
    <li class="flex items-center text-gray-400 hover:text-white cursor-pointer">
        <i class="fas fa-user-shield mr-3"></i>
        <a href="gerenciar_permissoes.php">Gerenciar Permissões</a>
    </li>
    <?php } ?>
</ul>
                <div class="mt-20 flex items-center text-white">
                    <img alt="User profile picture" class="rounded-full mr-3" height="40" src="../uploads/<?php echo htmlspecialchars($usuario->getImagem()); ?>" width="40"/>
                    <div>
                        <div class="font-bold">
                            Welcome
                        </div>
                        <div>
                            <?php echo htmlspecialchars($usuario->getNome()); ?>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="editar_perfil.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg" style="display: block; margin-bottom: 10px;">Editar Perfil</a>
                    <a href="../controller/logout.php" class="bg-red-600 text-white px-4 py-2 rounded-lg" style="display: block;">Logout</a>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="w-full md:w-3/4 p-4">
                <h2 class="text-2xl text-white font-bold mb-6">Lista de Carros</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php
                    foreach ($carros as $carro) {
                        echo '<div class="bg-gray-700 rounded-lg p-4 hover-card">';
                        echo '<div class="flex justify-between items-center mb-4">';
                        echo '<span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">' . htmlspecialchars($carro['ano']) . '</span>';
                        echo '<i class="far fa-heart text-white"></i>';
                        echo '</div>';
                        echo '<img alt="' . htmlspecialchars($carro['modelo']) . '" class="w-full h-32 object-cover rounded-lg mb-4" height="150" src="../uploads/' . htmlspecialchars($carro['imagem_url']) . '" width="300"/>';
                        echo '<div class="text-white text-lg font-bold mb-2">' . htmlspecialchars($carro['modelo']) . '</div>';
                        echo '<div class="text-gray-400 text-sm mb-4">' . htmlspecialchars($carro['descricao']) . '</div>';
                        echo '<div class="flex items-center space-x-2 mb-4">';
                        echo '<span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">' . htmlspecialchars($carro['tipo']) . '</span>';
                        echo '<span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">' . htmlspecialchars($carro['portas']) . '</span>';
                        echo '<span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">' . htmlspecialchars($carro['lugares']) . '</span>';
                        echo '<span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">' . htmlspecialchars($carro['malas']) . '</span>';
                        echo '</div>';
                        echo '<div class="flex items-center justify-between">';
                        if ($usuario->getRole() === 'admin') {
                            echo '<a href="editar_carro.php?id=' . htmlspecialchars($carro['id']) . '" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Editar Carro</a>';
                        } else {
                            echo '<a href="solicitar_carro.php?id=' . htmlspecialchars($carro['id']) . '" class="bg-green-600 text-white px-4 py-2 rounded-lg">Solicitar</a>';
                        }
                        echo '<div class="text-white text-lg font-bold">' . htmlspecialchars($carro['preco']) . ' AOA / DAY</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>