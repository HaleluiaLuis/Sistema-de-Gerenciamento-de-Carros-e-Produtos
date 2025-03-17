<?php
require_once '../DAO/SolicitacaoDAO.php';
require_once '../DTO/SolicitacaoDTO.php';

class SolicitacaoController {
    public function solicitarProduto($carroId, $usuarioId) {
        $solicitacaoDTO = new SolicitacaoDTO();
        $solicitacaoDTO->setCarroId($carroId);
        $solicitacaoDTO->setUsuarioId($usuarioId);
        $solicitacaoDTO->setStatus('Pendente');

        $solicitacaoDAO = new SolicitacaoDAO();
        return $solicitacaoDAO->cadastrar($solicitacaoDTO);
    }

    public function listarSolicitacoes() {
        $solicitacaoDAO = new SolicitacaoDAO();
        return $solicitacaoDAO->listar();
    }

    public function atualizarStatus($id, $status) {
        $solicitacaoDAO = new SolicitacaoDAO();
        return $solicitacaoDAO->atualizarStatus($id, $status);
    }

    public function listarSolicitacoesPorUsuario($usuarioId) {
        $solicitacaoDAO = new SolicitacaoDAO();
        return $solicitacaoDAO->listarPorUsuarioId($usuarioId);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $solicitacaoController = new SolicitacaoController();

    if ($_POST['acao'] === 'solicitar') {
        $carroId = $_POST['carro_id'];
        $usuarioId = $_POST['usuario_id'];
        $solicitacaoController->solicitarProduto($carroId, $usuarioId);
        header('Location: ../view/lista_carros.php');
    }
}
?>