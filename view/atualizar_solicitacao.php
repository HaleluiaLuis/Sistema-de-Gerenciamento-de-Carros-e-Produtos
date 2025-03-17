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
    <title>Atualizar Solicitação</title>
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
                <h2 class="text-2xl text-white font-bold mb-6">Atualizar Solicitação</h2>
                <div class="bg-gray-700 rounded-lg p-4">
                    <?php
                    require_once '../controller/SolicitacaoController.php';

                    $solicitacaoController = new SolicitacaoController();
                    $id = $_GET['id'];
                    $status = $_GET['status'];

                    if ($solicitacaoController->atualizarStatus($id, $status)) {
                        echo '<p class="text-green-500">Solicitação atualizada com sucesso.</p>';
                    } else {
                        echo '<p class="text-red-500">Erro ao atualizar solicitação.</p>';
                    }
                    ?>
                    <a href="lista_solicitacoes.php" class="text-blue-500 hover:text-blue-700">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>