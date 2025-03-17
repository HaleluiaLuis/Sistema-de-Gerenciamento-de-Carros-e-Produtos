<?php
require_once '../conexao/Conexao.php';

class EstatisticasDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    public function obterEstatisticas() {
        $estatisticas = [];

        // Total de reservas
        $sql = 'SELECT COUNT(*) as total FROM solicitacoes';
        $stmt = $this->pdo->query($sql);
        $estatisticas['total_reservas'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Total de usuários
        $sql = 'SELECT COUNT(*) as total FROM usuarios';
        $stmt = $this->pdo->query($sql);
        $estatisticas['total_usuarios'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Total de carros
        $sql = 'SELECT COUNT(*) as total FROM carros';
        $stmt = $this->pdo->query($sql);
        $estatisticas['total_carros'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        return $estatisticas;
    }
}
?>