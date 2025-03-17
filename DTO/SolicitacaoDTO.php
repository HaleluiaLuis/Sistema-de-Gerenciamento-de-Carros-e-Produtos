<?php
class SolicitacaoDTO {
    private $id;
    private $carroId;
    private $usuarioId;
    private $status;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCarroId() {
        return $this->carroId;
    }

    public function setCarroId($carroId) {
        $this->carroId = $carroId;
    }

    public function getUsuarioId() {
        return $this->usuarioId;
    }

    public function setUsuarioId($usuarioId) {
        $this->usuarioId = $usuarioId;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
}
?>