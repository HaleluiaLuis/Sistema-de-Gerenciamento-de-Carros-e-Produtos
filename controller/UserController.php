<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../DAO/UsuarioDAO.php';
require_once '../DTO/UsuarioDTO.php';
require_once '../DAO/SolicitacaoDAO.php'; // Adicione esta linha

/**
 * Classe UserController
 * Controla as operações relacionadas aos usuários.
 */
class UserController {
    private $userDAO;

    public function __construct() {
        $this->userDAO = new UsuarioDAO();
    }

    /**
     * Registra um novo usuário.
     * @param UsuarioDTO $userDTO
     * @return bool
     */
    public function register($userDTO) {
        return $this->userDAO->cadastrar($userDTO);
    }

    /**
     * Realiza o login de um usuário.
     * @param string $username
     * @param string $password
     * @return UsuarioDTO|null
     */
    public function login($email, $password) {
        $usuario = $this->userDAO->buscarPorEmail($email);
        if ($usuario && password_verify($password, $usuario->getSenha())) {
            return $usuario;
        }
        return null;
    }

    /**
     * Busca um usuário pelo ID.
     * @param int $id
     * @return UsuarioDTO|null
     */
    public function buscarUsuarioPorId($id) {
    return $this->userDAO->buscarPorId($id);
    }

    /**
     * Lista todos os usuários.
     * @return array
     */
    public function listarUsuarios() {
        return $this->userDAO->listar();
    }

    /**
     * Atualiza um usuário.
     * @param int $id
     * @param string $nome
     * @param string $email
     * @param string|null $senha
     * @param string $telefone
     * @param string $endereco
     * @param string $dataNascimento
     * @param string $genero
     * @return bool
     */
    public function atualizarUsuario($id, $nome, $email, $senha = null, $telefone, $endereco, $dataNascimento, $genero) {
        $usuarioDTO = new UsuarioDTO();
        $usuarioDTO->setId($id);
        $usuarioDTO->setNome($nome);
        $usuarioDTO->setEmail($email);
        $usuarioDTO->setTelefone($telefone);
        $usuarioDTO->setEndereco($endereco);
        $usuarioDTO->setDataNascimento($dataNascimento);
        $usuarioDTO->setGenero($genero);
        if ($senha) {
            $usuarioDTO->setSenha(password_hash($senha, PASSWORD_DEFAULT));
        }

        return $this->userDAO->atualizar($usuarioDTO);
    }

    /**
     * Exclui um usuário.
     * @param int $id
     * @return bool
     */
    public function excluirUsuario($id) {
        $solicitacaoDAO = new SolicitacaoDAO();
        $solicitacaoDAO->excluirPorUsuarioId($id); // Exclui as solicitações associadas ao usuário
        return $this->userDAO->excluir($id);
    }

    // ...outros métodos para gestão de usuários...
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error_message'] = 'CSRF token inválido.';
        header('Location: ../view/alguma_pagina.php');
        exit();
    }

    $userController = new UserController();

    if (isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') {
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
        $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
        $dataNascimento = filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_STRING);
        $genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING); // Captura o valor do role

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die('Email inválido.');
        }

        $usuarioDTO = new UsuarioDTO();
        $usuarioDTO->setNome($nome);
        $usuarioDTO->setEmail($email);
        $usuarioDTO->setTelefone($telefone);
        $usuarioDTO->setEndereco($endereco);
        $usuarioDTO->setDataNascimento($dataNascimento);
        $usuarioDTO->setGenero($genero);
        $usuarioDTO->setSenha(password_hash($password, PASSWORD_BCRYPT));
        $usuarioDTO->setRole($role); // Define o valor do role

        try {
            if ($userController->register($usuarioDTO)) {
                $_SESSION['success_message'] = 'Usuário cadastrado com sucesso.';
            } else {
                $_SESSION['error_message'] = 'Erro ao cadastrar usuário.';
            }
            header('Location: ../view/alguma_pagina.php');
            exit();
        } catch (Exception $e) {
            echo 'Erro: ' . $e->getMessage();
        }
    } elseif (isset($_POST['acao']) && $_POST['acao'] === 'login') {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die('Email inválido.');
        }

        $usuario = $userController->login($email, $password);
        if ($usuario) {
            $_SESSION['user_id'] = $usuario->getId();
            $_SESSION['success_message'] = 'Login realizado com sucesso.';
        } else {
            $_SESSION['error_message'] = 'Login ou senha inválidos.';
        }
        header('Location: ../view/alguma_pagina.php');
        exit();
    }
}
?>
