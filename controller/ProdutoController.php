<?php
require_once '../DAO/ProdutoDAO.php';
require_once '../DTO/ProdutoDTO.php';

class ProdutoController {
    public function cadastrarProduto($nome, $descricao, $preco) {
        $produtoDTO = new ProdutoDTO();
        $produtoDTO->setNome($nome);
        $produtoDTO->setDescricao($descricao);
        $produtoDTO->setPreco($preco);

        $produtoDAO = new ProdutoDAO();
        return $produtoDAO->cadastrar($produtoDTO);
    }

    public function listarProdutos() {
        $produtoDAO = new ProdutoDAO();
        return $produtoDAO->listar();
    }

    public function buscarProdutoPorId($id) {
        $produtoDAO = new ProdutoDAO();
        return $produtoDAO->buscarPorId($id);
    }

    public function atualizarProduto($id, $nome, $descricao, $preco) {
        $produtoDTO = new ProdutoDTO();
        $produtoDTO->setId($id);
        $produtoDTO->setNome($nome);
        $produtoDTO->setDescricao($descricao);
        $produtoDTO->setPreco($preco);

        $produtoDAO = new ProdutoDAO();
        return $produtoDAO->atualizar($produtoDTO);
    }

    public function excluirProduto($id) {
        $produtoDAO = new ProdutoDAO();
        return $produtoDAO->excluir($id);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produtoController = new ProdutoController();

    if ($_POST['acao'] === 'cadastrar') {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $produtoController->cadastrarProduto($nome, $descricao, $preco);
        header('Location: ../view/lista_produtos.php');
    } elseif ($_POST['acao'] === 'atualizar') {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $produtoController->atualizarProduto($id, $nome, $descricao, $preco);
        header('Location: ../view/lista_produtos.php');
    } elseif ($_POST['acao'] === 'excluir') {
        $id = $_POST['id'];
        $produtoController->excluirProduto($id);
        header('Location: ../view/lista_produtos.php');
    }
}
?>