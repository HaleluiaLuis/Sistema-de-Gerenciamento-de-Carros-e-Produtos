<?php
session_start();
require_once '../controller/UserController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userController = new UserController();
$usuario = $userController->buscarUsuarioPorId($_GET['id']);

if (!$usuario) {
    echo 'Usuário não encontrado.';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $dataNascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];
    $senha = $_POST['senha'];

    $userController->atualizarUsuario($id, $nome, $email, $senha, $telefone, $endereco, $dataNascimento, $genero);
    header('Location: lista_usuarios.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-800 min-h-screen flex items-center justify-center">
    <div class="bg-gray-900 rounded-lg shadow-lg w-full max-w-md p-8">
        <h2 class="text-2xl text-white font-bold mb-6 text-center">Editar Usuário</h2>
        <form action="editar_usuario.php?id=<?php echo htmlspecialchars($usuario->getId()); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario->getId()); ?>">
            <div class="mb-4">
                <label class="block text-white text-sm font-bold mb-2" for="nome">Nome</label>
                <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="nome" name="nome" type="text" value="<?php echo htmlspecialchars($usuario->getNome()); ?>" required>
            </div>
            <div class="mb-4">
                <label class="block text-white text-sm font-bold mb-2" for="email">Email</label>
                <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="email" name="email" type="email" value="<?php echo htmlspecialchars($usuario->getEmail()); ?>" required>
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
                <label class="block text-white text-sm font-bold mb-2" for="senha">Senha</label>
                <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="senha" name="senha" type="password">
            </div>
            <div class="flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg" type="submit">Salvar Alterações</button>
            </div>
        </form>
    </div>
</body>
</html>
