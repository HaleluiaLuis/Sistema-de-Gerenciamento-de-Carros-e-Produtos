<?php
class CarroDTO {
    private $id;
    private $marca;
    private $modelo;
    private $ano;
    private $placa;
    private $cor;
    private $quilometragem;
    private $combustivel;
    private $preco;
    private $imagem; // Novo campo

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function getAno() {
        return $this->ano;
    }

    public function setAno($ano) {
        $this->ano = $ano;
    }

    public function getPlaca() {
        return $this->placa;
    }

    public function setPlaca($placa) {
        $this->placa = $placa;
    }

    public function getCor() {
        return $this->cor;
    }

    public function setCor($cor) {
        $this->cor = $cor;
    }

    public function getQuilometragem() {
        return $this->quilometragem;
    }

    public function setQuilometragem($quilometragem) {
        $this->quilometragem = $quilometragem;
    }

    public function getCombustivel() {
        return $this->combustivel;
    }

    public function setCombustivel($combustivel) {
        $this->combustivel = $combustivel;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function setPreco($preco) {
        $this->preco = $preco;
    }

    public function getImagem() {
        return $this->imagem;
    }

    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }
}
?>