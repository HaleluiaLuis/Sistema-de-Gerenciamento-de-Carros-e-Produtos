<?php
session_start();
require_once '../controller/UserController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userController = new UserController();
$usuario = $userController->buscarUsuarioPorId($_SESSION['user_id']);

if ($usuario->getRole() !== 'admin') {
    echo 'Acesso negado.';
    exit();
}

$usuarios = $userController->listarUsuarios();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rentals - Listar Usuários</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
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
                <h2 class="text-2xl text-white font-bold mb-6">Lista de Usuários</h2>
                <div class="bg-gray-700 rounded-lg p-4">
                    <table class="min-w-full bg-gray-700">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left text-white">Nome</th>
                                <th class="py-2 px-4 text-left text-white">Email</th>
                                <th class="py-2 px-4 text-left text-white">Telefone</th>
                                <th class="py-2 px-4 text-left text-white">Endereço</th>
                                <th class="py-2 px-4 text-left text-white">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($usuarios as $usuario) {
                                echo '<tr class="border-b border-gray-600">';
                                echo '<td class="py-2 px-4 text-white">' . htmlspecialchars($usuario['nome']) . '</td>';
                                echo '<td class="py-2 px-4 text-white">' . htmlspecialchars($usuario['email']) . '</td>';
                                echo '<td class="py-2 px-4 text-white">' . htmlspecialchars($usuario['telefone']) . '</td>';
                                echo '<td class="py-2 px-4 text-white">' . htmlspecialchars($usuario['endereco']) . '</td>';
                                echo '<td class="py-2 px-4 text-white">';
                                echo '<a href="editar_usuario.php?id=' . htmlspecialchars($usuario['id']) . '" class="bg-blue-600 text-white px-4 py-2 rounded-lg mr-2">Editar</a>';
                                echo '<a href="deletar_usuario.php?id=' . htmlspecialchars($usuario['id']) . '" class="bg-red-600 text-white px-4 py-2 rounded-lg">Deletar</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>