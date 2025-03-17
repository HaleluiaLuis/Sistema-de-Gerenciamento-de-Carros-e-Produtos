<?php
require_once '../DAO/UsuarioDAO.php';
require_once '../DTO/UsuarioDTO.php';

class PerfilController {
    public function visualizarPerfil($id) {
        $usuarioDAO = new UsuarioDAO();
        return $usuarioDAO->buscarPorId($id);
    }

    public function editarPerfil($id, $nome, $email, $senha, $imagem, $role, $telefone, $endereco, $dataNascimento, $genero) {
        $usuarioDTO = new UsuarioDTO();
        $usuarioDTO->setId($id);
        $usuarioDTO->setNome($nome);
        $usuarioDTO->setEmail($email);
        if (!empty($senha)) {
            $usuarioDTO->setSenha(password_hash($senha, PASSWORD_BCRYPT));
        }
        $usuarioDTO->setImagem($imagem);
        $usuarioDTO->setRole($role);
        $usuarioDTO->setTelefone($telefone);
        $usuarioDTO->setEndereco($endereco);
        $usuarioDTO->setDataNascimento($dataNascimento);
        $usuarioDTO->setGenero($genero);

        $usuarioDAO = new UsuarioDAO();
        return $usuarioDAO->atualizar($usuarioDTO);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['acao'] === 'editar') {
    $perfilController = new PerfilController();
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $role = $_POST['role'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $dataNascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];

    // Verifica se uma nova imagem foi enviada
    if (!empty($_FILES['imagem']['name'])) {
        $imagem = $_FILES['imagem']['name'];
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadFile = $uploadDir . basename($imagem);
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFile)) {
            // Imagem movida com sucesso
        } else {
            echo 'Erro ao mover o arquivo de imagem.';
            exit;
        }
    } else {
        $usuarioAtual = $perfilController->visualizarPerfil($id);
        $imagem = $usuarioAtual->getImagem();
    }

    if ($perfilController->editarPerfil($id, $nome, $email, $senha, $imagem, $role, $telefone, $endereco, $dataNascimento, $genero)) {
        header('Location: ../view/perfil.php?id=' . $id);
    } else {
        echo 'Erro ao atualizar perfil.';
    }
}
?>