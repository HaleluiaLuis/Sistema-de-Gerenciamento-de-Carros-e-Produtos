<?php
session_start();
require_once '../controller/UserController.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$userController = new UserController();
$usuario = $userController->buscarUsuarioPorId($_GET['id']);

if (!$usuario) {
    echo 'Usuário não encontrado.';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token inválido.');
    }

    $id = $_POST['id'];
    $userController->excluirUsuario($id);
    header('Location: lista_usuarios.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-800 min-h-screen flex items-center justify-center">
    <div class="bg-gray-900 rounded-lg shadow-lg w-full max-w-md p-8">
        <h2 class="text-2xl text-white font-bold mb-6 text-center">Deletar Usuário</h2>
        <form action="deletar_usuario.php?id=<?php echo htmlspecialchars($usuario->getId()); ?>" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="acao" value="excluir">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario->getId()); ?>">
            <p class="text-white mb-4">Tem certeza que deseja deletar o usuário "<?php echo htmlspecialchars($usuario->getNome()); ?>"?</p>
            <div class="flex justify-end">
                <button class="bg-red-600 text-white px-4 py-2 rounded-lg mr-2" type="submit">Deletar</button>
                <a href="lista_usuarios.php" class="bg-gray-600 text-white px-4 py-2 rounded-lg">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
