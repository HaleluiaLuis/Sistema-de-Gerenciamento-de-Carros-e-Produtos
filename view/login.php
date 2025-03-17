<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rentals - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
</head>
<body class="bg-gray-800 min-h-screen flex items-center justify-center">
    <div class="bg-gray-900 rounded-lg shadow-lg w-full max-w-md p-8">
        <h2 class="text-2xl text-white font-bold mb-6 text-center">Login</h2>
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sucesso!</strong>
                <span class="block sm:inline"><?php echo $_SESSION['success_message']; ?></span>
                <?php unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>
        <form action="../controller/UserController.php" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="mb-4">
                <label class="block text-white text-sm font-bold mb-2" for="email">Email</label>
                <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="email" name="email" type="email" required>
            </div>
            <div class="mb-6">
                <label class="block text-white text-sm font-bold mb-2" for="password">Senha</label>
                <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="password" name="password" type="password" required>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg" type="submit" name="acao" value="login">Entrar</button>
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="esqueci_senha.php">Esqueceu a senha?</a>
            </div>
        </form>
        <div class="mt-6 text-center">
            <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="register.php">Criar uma conta</a>
        </div>
    </div>
</body>
</html>