<?php
require_once '../DAO/EstatisticasDAO.php';

class EstatisticasController {
    public function obterEstatisticas() {
        $estatisticasDAO = new EstatisticasDAO();
        return $estatisticasDAO->obterEstatisticas();
    }
}
?>