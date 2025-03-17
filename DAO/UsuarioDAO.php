<?php
require_once '../conexao/Conexao.php';
require_once '../DTO/UsuarioDTO.php';

class UsuarioDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    public function cadastrar(UsuarioDTO $usuario) {
        if ($this->buscarPorEmail($usuario->getEmail())) {
            throw new Exception('Email já cadastrado.');
        }

        $sql = 'INSERT INTO usuarios (nome, email, senha, role, imagem, telefone, endereco, data_nascimento, genero) VALUES (:nome, :email, :senha, :role, :imagem, :telefone, :endereco, :data_nascimento, :genero)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nome', $usuario->getNome());
        $stmt->bindValue(':email', $usuario->getEmail());
        $stmt->bindValue(':senha', $usuario->getSenha());
        $stmt->bindValue(':role', $usuario->getRole());
        $stmt->bindValue(':imagem', $usuario->getImagem());
        $stmt->bindValue(':telefone', $usuario->getTelefone());
        $stmt->bindValue(':endereco', $usuario->getEndereco());
        $stmt->bindValue(':data_nascimento', $usuario->getDataNascimento());
        $stmt->bindValue(':genero', $usuario->getGenero());
        return $stmt->execute();
    }

    public function buscarPorEmail($email) {
        $sql = 'SELECT * FROM usuarios WHERE email = :email';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $usuario = new UsuarioDTO();
            $usuario->setId($result['id']);
            $usuario->setNome($result['nome']);
            $usuario->setEmail($result['email']);
            $usuario->setSenha($result['senha']);
            $usuario->setRole($result['role']);
            $usuario->setImagem($result['imagem']);
            $usuario->setTelefone($result['telefone']);
            $usuario->setEndereco($result['endereco']);
            $usuario->setDataNascimento($result['data_nascimento']);
            $usuario->setGenero($result['genero']);
            return $usuario;
        }
        return null;
    }

    public function buscarPorId($id) {
        $sql = 'SELECT * FROM usuarios WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $usuario = new UsuarioDTO();
            $usuario->setId($row['id']);
            $usuario->setNome($row['nome']);
            $usuario->setEmail($row['email']);
            $usuario->setSenha($row['senha']);
            $usuario->setImagem($row['imagem']);
            $usuario->setRole($row['role']);
            $usuario->setTelefone($row['telefone']);
            $usuario->setEndereco($row['endereco']);
            $usuario->setDataNascimento($row['data_nascimento']);
            $usuario->setGenero($row['genero']);
            return $usuario;
        }
        return null;
    }

    public function listar() {
        $sql = 'SELECT * FROM usuarios';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizar(UsuarioDTO $usuario) {
        $sql = 'UPDATE usuarios SET nome = :nome, email = :email, role = :role, imagem = :imagem, telefone = :telefone, endereco = :endereco, data_nascimento = :data_nascimento, genero = :genero';
        if ($usuario->getSenha()) {
            $sql .= ', senha = :senha';
        }
        $sql .= ' WHERE id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nome', $usuario->getNome());
        $stmt->bindValue(':email', $usuario->getEmail());
        $stmt->bindValue(':role', $usuario->getRole());
        $stmt->bindValue(':imagem', $usuario->getImagem());
        $stmt->bindValue(':telefone', $usuario->getTelefone());
        $stmt->bindValue(':endereco', $usuario->getEndereco());
        $stmt->bindValue(':data_nascimento', $usuario->getDataNascimento());
        $stmt->bindValue(':genero', $usuario->getGenero());
        if ($usuario->getSenha()) {
            $stmt->bindValue(':senha', $usuario->getSenha());
        }
        $stmt->bindValue(':id', $usuario->getId());

        try {
            return $stmt->execute();
        } catch (Exception $e) {
            echo 'Erro ao atualizar o perfil: ' . $e->getMessage();
            return false;
        }
    }

    public function excluir($id) {
        $sql = 'DELETE FROM usuarios WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}
?>