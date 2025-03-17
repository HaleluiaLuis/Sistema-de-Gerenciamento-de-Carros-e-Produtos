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
    <title>Car Rentals - Criar Conta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
</head>
<body class="bg-gray-800 min-h-screen flex items-center justify-center">
    <div class="bg-gray-900 rounded-lg shadow-lg w-full max-w-md p-8">
        <h2 class="text-2xl text-white font-bold mb-6 text-center">Criar Conta</h2>
        <form action="../controller/UserController.php" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="acao" value="cadastrar">
            <div class="mb-4">
                <label class="block text-white text-sm font-bold mb-2" for="nome">Nome</label>
                <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="nome" name="nome" type="text" required>
            </div>
            <div class="mb-4">
                <label class="block text-white text-sm font-bold mb-2" for="email">Email</label>
                <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="email" name="email" type="email" required>
            </div>
            <div class="mb-4">
                <label class="block text-white text-sm font-bold mb-2" for="telefone">Telefone</label>
                <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="telefone" name="telefone" type="text" required>
            </div>
            <div class="mb-4">
                <label class="block text-white text-sm font-bold mb-2" for="endereco">Endereço</label>
                <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="endereco" name="endereco" type="text" required>
            </div>
            <div class="mb-4">
                <label class="block text-white text-sm font-bold mb-2" for="data_nascimento">Data de Nascimento</label>
                <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="data_nascimento" name="data_nascimento" type="date" required>
            </div>
            <div class="mb-4">
                <label class="block text-white text-sm font-bold mb-2" for="genero">Gênero</label>
                <select class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="genero" name="genero" required>
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                    <option value="Outro">Outro</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-white text-sm font-bold mb-2" for="role">Nível de Acesso</label>
                <select class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="role" name="role" required>
                    <option value="user">Usuário</option>
                    <option value="admin">Administrador</option>
                    <option value="manager">Gerente</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-white text-sm font-bold mb-2" for="password">Senha</label>
                <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="password" name="password" type="password" required>
            </div>
            <div class="mb-6">
                <label class="block text-white text-sm font-bold mb-2" for="confirm_password">Confirmar Senha</label>
                <input class="w-full px-3 py-2 text-gray-700 bg-gray-200 rounded-lg focus:outline-none" id="confirm_password" name="confirm_password" type="password" required>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg" type="submit" name="acao" value="cadastrar">Criar Conta</button>
            </div>
        </form>
        <div class="mt-6 text-center">
            <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="login.php">Já tem uma conta? Entrar</a>
        </div>
    </div>
</body>
</html>
