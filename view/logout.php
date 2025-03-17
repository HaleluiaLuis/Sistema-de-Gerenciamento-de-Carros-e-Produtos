<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
    <header class="bg-blue-600 text-white p-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Sessão Terminada</h1>
    </header>
    <div class="container mx-auto p-6">
        <p class="text-green-500">Sua sessão foi terminada com sucesso.</p>
        <p>Você será redirecionado para a página de login em 3 segundos...</p>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = 'login.php';
        }, 3000);
    </script>
</body>
</html>