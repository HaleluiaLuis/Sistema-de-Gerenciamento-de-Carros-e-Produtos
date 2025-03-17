<?php
session_start();
require_once '../controller/UserController.php';
require_once '../controller/EstatisticasController.php';

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

$estatisticasController = new EstatisticasController();
$estatisticas = $estatisticasController->obterEstatisticas();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estatísticas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <h2 class="text-2xl text-white font-bold mb-6">Estatísticas</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-gray-900 rounded-lg p-4">
                        <div class="text-white text-lg font-bold mb-4">Total de produtos</div>
                        <div class="text-4xl text-white font-bold"><?php echo isset($estatisticas['total_carros']) ? $estatisticas['total_carros'] : 'N/A'; ?></div>
                    </div>
                    <div class="bg-gray-900 rounded-lg p-4">
                        <div class="text-white text-lg font-bold mb-4">Total de Usuários</div>
                        <div class="text-4xl text-white font-bold"><?php echo isset($estatisticas['total_usuarios']) ? $estatisticas['total_usuarios'] : 'N/A'; ?></div>
                    </div>
                    <div class="bg-gray-900 rounded-lg p-4">
                        <div class="text-white text-lg font-bold mb-4">Total de Reservas</div>
                        <div class="text-4xl text-white font-bold"><?php echo isset($estatisticas['total_reservas']) ? $estatisticas['total_reservas'] : 'N/A'; ?></div>
                    </div>
                </div>
                <div class="mt-6">
                    <h3 class="text-xl text-white font-bold mb-4">Gráfico de Reservas, Usuários e Carros</h3>
                    <canvas id="graficoReservas" class="bg-gray-900 rounded-lg"></canvas>
                    <script>
                        var ctx = document.getElementById('graficoReservas').getContext('2d');
                        var graficoReservas = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Reservas', 'Usuários', 'bebidas'],
                                datasets: [{
                                    label: 'Estatísticas',
                                    data: [<?php echo isset($estatisticas['total_reservas']) ? $estatisticas['total_reservas'] : 0; ?>, <?php echo isset($estatisticas['total_usuarios']) ? $estatisticas['total_usuarios'] : 0; ?>, <?php echo isset($estatisticas['total_carros']) ? $estatisticas['total_carros'] : 0; ?>],
                                    backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>
</html>