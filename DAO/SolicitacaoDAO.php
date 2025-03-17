<?php
require_once '../conexao/Conexao.php';
require_once '../DTO/SolicitacaoDTO.php';

class SolicitacaoDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    public function cadastrar(SolicitacaoDTO $solicitacao) {
        $sql = 'INSERT INTO solicitacoes (carro_id, usuario_id, status) VALUES (:carro_id, :usuario_id, :status)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':carro_id', $solicitacao->getCarroId());
        $stmt->bindValue(':usuario_id', $solicitacao->getUsuarioId());
        $stmt->bindValue(':status', $solicitacao->getStatus());
        return $stmt->execute();
    }

    public function listar() {
        $sql = 'SELECT * FROM solicitacoes';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarPorUsuarioId($usuarioId) {
        $sql = 'SELECT * FROM solicitacoes WHERE usuario_id = :usuario_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuarioId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizarStatus($id, $status) {
        $sql = 'UPDATE solicitacoes SET status = :status WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function excluirPorUsuarioId($usuarioId) {
        $sql = 'DELETE FROM solicitacoes WHERE usuario_id = :usuario_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuarioId);
        return $stmt->execute();
    }
}
?>