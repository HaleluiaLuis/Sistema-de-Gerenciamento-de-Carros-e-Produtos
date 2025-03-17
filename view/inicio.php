<?php
session_start();
require_once '../controller/UserController.php';

// Verifique se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userController = new UserController();
$usuario = $userController->buscarUsuarioPorId($_SESSION['user_id']);

if (!$usuario) {
    echo 'Acesso negado.';
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
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
                    <?php if ($usuario->getRole() === 'admin') { ?>
                        <li class="flex items-center text-gray-400 hover:text-white cursor-pointer">
                            <i class="fas fa-car mr-3"></i>
                            <a href="lista_carros.php">Gerenciar Carros</a>
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
                            <i class="fas fa-file-alt mr-3"></i>
                            <a href="relatorios.php">Relatórios Financeiros</a>
                        </li>
                    <?php } ?>
                    <li class="flex items-center text-gray-400 hover:text-white cursor-pointer">
                        <i class="fas fa-user mr-3"></i>
                        <a href="perfil.php?id=<?php echo htmlspecialchars($usuario->getId()); ?>">Meu Perfil</a>
                    </li>
                    <li class="flex items-center text-gray-400 hover:text-white cursor-pointer">
                        <i class="fas fa-box mr-3"></i>
                        <a href="solicitar_produto.php">Solicitar Produto</a>
                    </li>
                </ul>
                <div class="mt-20 flex items-center text-white">
                    <img alt="User profile picture" class="rounded-full mr-3" height="40" src="https://storage.googleapis.com/a1aa/image/yO9jqoqkaGJSBNkP5mTAR48gPrA8ufjYLulLN6jLFgg7WoDKA.jpg" width="40"/>
                    <div>
                        <div class="font-bold">Welcome</div>
                        <div><?php echo htmlspecialchars($usuario->getNome()); ?></div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="w-full md:w-3/4 p-4">
                <div class="flex items-center justify-between mb-6">
                    <input class="w-2/3 p-2 rounded-lg bg-gray-700 text-white placeholder-gray-400" placeholder="Search car name, model" type="text"/>
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-filter text-white"></i>
                        <i class="fas fa-th-large text-white"></i>
                        <i class="fas fa-th-list text-white"></i>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Car Cards -->
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">2023</span>
                            <i class="far fa-heart text-white"></i>
                        </div>
                        <img alt="Audi Q7" class="w-full h-32 object-cover rounded-lg mb-4" height="150" src="https://storage.googleapis.com/a1aa/image/quMFE3ROsl4KGt3lNTaHPrwNBeoe9gMfFRewH7WNcFti3CdQB.jpg" width="300"/>
                        <div class="text-white text-lg font-bold mb-2">Audi Q7</div>
                        <div class="text-gray-400 text-sm mb-4">Premium Plus</div>
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">SUV</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">4</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">7</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">5</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Rent Now</button>
                            <div class="text-white text-lg font-bold">$250 / DAY</div>
                        </div>
                    </div>
                    <!-- Repeat similar blocks for other cars -->
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">2023</span>
                            <i class="far fa-heart text-white"></i>
                        </div>
                        <img alt="Mercedes-Benz S-Class" class="w-full h-32 object-cover rounded-lg mb-4" height="150" src="https://storage.googleapis.com/a1aa/image/FaBolm9JELZkExt101GlylZaAmuTHWIvZ5EWP8cr8HgbL0BF.jpg" width="300"/>
                        <div class="text-white text-lg font-bold mb-2">Mercedes-Benz S-Class</div>
                        <div class="text-gray-400 text-sm mb-4">S 500 4MATIC</div>
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">Sedan</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">4</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">5</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">5</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Rent Now</button>
                            <div class="text-white text-lg font-bold">$400 / DAY</div>
                        </div>
                    </div>
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">2023</span>
                            <i class="far fa-heart text-white"></i>
                        </div>
                        <img alt="Tesla Model 3" class="w-full h-32 object-cover rounded-lg mb-4" height="150" src="https://storage.googleapis.com/a1aa/image/fMD50vXN9erZiUYdbqkFuBlxEz726nOhQXxA2J2rqH4ztQHUA.jpg" width="300"/>
                        <div class="text-white text-lg font-bold mb-2">Tesla Model 3</div>
                        <div class="text-gray-400 text-sm mb-4">Standard Range Plus</div>
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">Sedan</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">4</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">5</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">2</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Rent Now</button>
                            <div class="text-white text-lg font-bold">$199 / DAY</div>
                        </div>
                    </div>
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">2023</span>
                            <i class="far fa-heart text-white"></i>
                        </div>
                        <img alt="BMW X5" class="w-full h-32 object-cover rounded-lg mb-4" height="150" src="https://storage.googleapis.com/a1aa/image/L3WFYQ0Tu4okLhmnhfym8wKWkM2WMcteaRJVNF6gc6ehbhOoA.jpg" width="300"/>
                        <div class="text-white text-lg font-bold mb-2">BMW X5</div>
                        <div class="text-gray-400 text-sm mb-4">xDrive40i</div>
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">SUV</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">4</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">5</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">2</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Rent Now</button>
                            <div class="text-white text-lg font-bold">$220 / DAY</div>
                        </div>
                    </div>
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">2023</span>
                            <i class="far fa-heart text-white"></i>
                        </div>
                        <img alt="Porsche Cayenne" class="w-full h-32 object-cover rounded-lg mb-4" height="150" src="https://storage.googleapis.com/a1aa/image/4Myz9pTBSnpZMdaLWZaf6DIfTWKh7SQ2jfxS3vFhVOrkbhOoA.jpg" width="300"/>
                        <div class="text-white text-lg font-bold mb-2">Porsche Cayenne</div>
                        <div class="text-gray-400 text-sm mb-4">Turbo GT</div>
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">SUV</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">4</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">5</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">2</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Rent Now</button>
                            <div class="text-white text-lg font-bold">$380 / DAY</div>
                        </div>
                    </div>
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">2023</span>
                            <i class="far fa-heart text-white"></i>
                        </div>
                        <img alt="Lamborghini Urus" class="w-full h-32 object-cover rounded-lg mb-4" height="150" src="https://storage.googleapis.com/a1aa/image/eSsQO8fR6Tu8uE1EckUeYGrG421NmzTZcmSQtWbyOtKrbhOoA.jpg" width="300"/>
                        <div class="text-white text-lg font-bold mb-2">Lamborghini Urus</div>
                        <div class="text-gray-400 text-sm mb-4">Urus</div>
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">SUV</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">4</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">5</span>
                            <span class="bg-gray-600 text-white text-xs px-2 py-1 rounded">2</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Rent Now</button>
                            <div class="text-white text-lg font-bold">$999 / DAY</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>