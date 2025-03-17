<?php
session_start();
require_once '../controller/UserController.php';

if (!isset($_SESSION['user_id'])) {
    echo 'Acesso negado.';
    exit;
}

$userController = new UserController();
$usuario = $userController->buscarUsuarioPorId($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rentals - Editar Perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
</head>
<body class="bg-gray-800 min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 rounded-lg shadow-lg w-full max-w-4xl p-4">
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
                    <img alt="User profile picture" class="rounded-full mr-3" height="40" src="https://storage.googleapis.com/a1aa/image/D5fVDDxdTiWFf0jWmW7bFR2EJVvokAFm5qyLhYfm0aZSfxegC.jpg" width="40"/>
                    <div>
                        <div class="font-bold">
                            Welcome
                        </div>
                        <div>
                            Leslie Alexander
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="w-full md:w-3/4 p-4">
                <h2 class="text-2xl text-white font-bold mb-6">Editar Perfil</h2>
                <div class="bg-gray-700 rounded-lg p-4">
                    <form action="../controller/PerfilController.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>">
                        <input type="hidden" name="role" value="<?php echo $usuario->getRole(); ?>">
                        <input type="hidden" name="acao" value="editar">
                        <div class="mb-4">
                            <label class="block text-white text-sm font-bold mb-2" for="nome">Nome</label>
                            <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="nome" name="nome" type="text" value="<?php echo htmlspecialchars($usuario->getNome()); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-white text-sm font-bold mb-2" for="email">Email</label>
                            <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="email" name="email" type="email" value="<?php echo htmlspecialchars($usuario->getEmail()); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-white text-sm font-bold mb-2" for="senha">Senha</label>
                            <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="senha" name="senha" type="password">
                        </div>
                        <div class="mb-4">
                            <label class="block text-white text-sm font-bold mb-2" for="telefone">Telefone</label>
                            <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="telefone" name="telefone" type="text" value="<?php echo htmlspecialchars($usuario->getTelefone()); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-white text-sm font-bold mb-2" for="endereco">Endereço</label>
                            <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="endereco" name="endereco" type="text" value="<?php echo htmlspecialchars($usuario->getEndereco()); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-white text-sm font-bold mb-2" for="data_nascimento">Data de Nascimento</label>
                            <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="data_nascimento" name="data_nascimento" type="date" value="<?php echo htmlspecialchars($usuario->getDataNascimento()); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-white text-sm font-bold mb-2" for="genero">Gênero</label>
                            <select class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="genero" name="genero" required>
                                <option value="Masculino" <?php echo $usuario->getGenero() == 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
                                <option value="Feminino" <?php echo $usuario->getGenero() == 'Feminino' ? 'selected' : ''; ?>>Feminino</option>
                                <option value="Outro" <?php echo $usuario->getGenero() == 'Outro' ? 'selected' : ''; ?>>Outro</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-white text-sm font-bold mb-2" for="imagem">Imagem de Perfil</label>
                            <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="imagem" name="imagem" type="file">
                        </div>
                        <div class="flex justify-end">
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg" type="submit" name="acao" value="editar">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>