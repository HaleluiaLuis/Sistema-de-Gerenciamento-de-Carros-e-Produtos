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

if ($usuario->getRole() !== 'admin') {
    echo 'Acesso negado.';
    exit;
}

if (isset($_GET['search'])) {
    $termo = $_GET['search'];
    $carros = $carroController->pesquisarCarros($termo);
} else {
    $carros = $carroController->listarCarros();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Solicitações</title>
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
                        <div class="font-bold">Welcome</div>
                        <div><?php echo htmlspecialchars($usuario->getNome()); ?></div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="w-full md:w-3/4 p-4">
                <h2 class="text-2xl text-white font-bold mb-6">Lista de Solicitações</h2>

                <?php
                require_once '../controller/SolicitacaoController.php';
                require_once '../controller/CarroController.php';
                require_once '../controller/UserController.php';

                $solicitacaoController = new SolicitacaoController();
                $carroController = new CarroController();
                $usuarioController = new UserController();
                $solicitacoes = $solicitacaoController->listarSolicitacoes();

                echo '<div class="grid grid-cols-1 md:grid-cols-2 gap-4">';
                foreach ($solicitacoes as $solicitacao) {
                    $carro = $carroController->buscarCarroPorId($solicitacao['carro_id']);
                    $usuario = $usuarioController->buscarUsuarioPorId($solicitacao['usuario_id']);
                    
                    if ($carro && $usuario) {
                        echo '<div class="bg-gray-900 rounded-lg shadow-lg p-6 mb-6 hover-card">';
                        echo '<div class="flex justify-between items-center mb-4">';
                        echo '<div class="text-white text-xl font-bold">Solicitação #' . htmlspecialchars($solicitacao['id']) . '</div>';
                        echo '<div class="text-gray-400 text-sm">Status: <span class="text-green-500 font-medium">' . htmlspecialchars($solicitacao['status']) . '</span></div>';
                        echo '</div>';
                        echo '<div class="text-gray-300 text-sm">';
                        echo '<p><strong>Carro:</strong> ' . htmlspecialchars($carro->getMarca()) . ' ' . htmlspecialchars($carro->getModelo()) . '</p>';
                        echo '<p><strong>Usuário:</strong> ' . htmlspecialchars($usuario->getNome()) . '</p>';
                        echo '<p><strong>Data de Solicitação:</strong> ' . (isset($solicitacao['data_solicitacao']) ? htmlspecialchars($solicitacao['data_solicitacao']) : 'N/A') . '</p>';
                        echo '</div>';
                        echo '<div class="mt-4 flex space-x-2">';
                        echo '<a href="atualizar_solicitacao.php?id=' . htmlspecialchars($solicitacao['id']) . '&status=Aceitar" class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded-lg focus:outline-none">Aceitar</a>';
                        echo '<a href="atualizar_solicitacao.php?id=' . htmlspecialchars($solicitacao['id']) . '&status=Rejeitar" class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded-lg focus:outline-none">Rejeitar</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                echo '</div>';
                ?>
            </div>
        </div>
    </div>
</body>
</html>
