<?php
require_once '../conexao/Conexao.php';
require_once '../DTO/ProdutoDTO.php';

class ProdutoDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    public function cadastrar(ProdutoDTO $produto) {
        $sql = 'INSERT INTO produtos (nome, descricao, preco) VALUES (:nome, :descricao, :preco)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nome', $produto->getNome());
        $stmt->bindValue(':descricao', $produto->getDescricao());
        $stmt->bindValue(':preco', $produto->getPreco());
        return $stmt->execute();
    }

    public function listar() {
        $sql = 'SELECT * FROM produtos';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $sql = 'SELECT * FROM produtos WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $produto = new ProdutoDTO();
            $produto->setId($result['id']);
            $produto->setNome($result['nome']);
            $produto->setDescricao($result['descricao']);
            $produto->setPreco($result['preco']);
            return $produto;
        }
        return null;
    }

    public function atualizar(ProdutoDTO $produto) {
        $sql = 'UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nome', $produto->getNome());
        $stmt->bindValue(':descricao', $produto->getDescricao());
        $stmt->bindValue(':preco', $produto->getPreco());
        $stmt->bindValue(':id', $produto->getId());
        return $stmt->execute();
    }

    public function excluir($id) {
        $sql = 'DELETE FROM produtos WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }
}
?>