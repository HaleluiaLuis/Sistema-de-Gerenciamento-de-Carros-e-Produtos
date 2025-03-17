<?php
require_once '../conexao/Conexao.php';
require_once '../DTO/CarroDTO.php';

class CarroDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    public function cadastrar(CarroDTO $carro) {
        $sql = 'INSERT INTO carros (marca, modelo, ano, placa, cor, quilometragem, combustivel, preco, imagem) VALUES (:marca, :modelo, :ano, :placa, :cor, :quilometragem, :combustivel, :preco, :imagem)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':marca', $carro->getMarca());
        $stmt->bindValue(':modelo', $carro->getModelo());
        $stmt->bindValue(':ano', $carro->getAno());
        $stmt->bindValue(':placa', $carro->getPlaca());
        $stmt->bindValue(':cor', $carro->getCor());
        $stmt->bindValue(':quilometragem', $carro->getQuilometragem());
        $stmt->bindValue(':combustivel', $carro->getCombustivel());
        $stmt->bindValue(':preco', $carro->getPreco());
        $stmt->bindValue(':imagem', $carro->getImagem());
        return $stmt->execute();
    }

    public function listar() {
        $sql = 'SELECT * FROM carros';
        $stmt = $this->pdo->query($sql);
        $carros = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Garantir que todas as chaves esperadas estejam presentes
        foreach ($carros as &$carro) {
            $carro['imagem_url'] = $carro['imagem'] ?? 'default.jpg';
            $carro['descricao'] = $carro['descricao'] ?? 'Descrição não disponível';
            $carro['tipo'] = $carro['tipo'] ?? 'N/A';
            $carro['portas'] = $carro['portas'] ?? 'N/A';
            $carro['lugares'] = $carro['lugares'] ?? 'N/A';
            $carro['malas'] = $carro['malas'] ?? 'N/A';
        }

        return $carros;
    }

    public function buscarPorId($id) {
        $sql = 'SELECT * FROM carros WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $carro = new CarroDTO();
            $carro->setId($result['id']);
            $carro->setMarca($result['marca']);
            $carro->setModelo($result['modelo']);
            $carro->setAno($result['ano']);
            $carro->setPlaca($result['placa']);
            $carro->setCor($result['cor']);
            $carro->setQuilometragem($result['quilometragem']);
            $carro->setCombustivel($result['combustivel']);
            $carro->setPreco($result['preco']);
            $carro->setImagem($result['imagem']);
            return $carro;
        }
        return null;
    }

    public function atualizar(CarroDTO $carro) {
        $sql = 'UPDATE carros SET marca = :marca, modelo = :modelo, ano = :ano, placa = :placa, cor = :cor, quilometragem = :quilometragem, combustivel = :combustivel, preco = :preco, imagem = :imagem WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':marca', $carro->getMarca());
        $stmt->bindValue(':modelo', $carro->getModelo());
        $stmt->bindValue(':ano', $carro->getAno());
        $stmt->bindValue(':placa', $carro->getPlaca());
        $stmt->bindValue(':cor', $carro->getCor());
        $stmt->bindValue(':quilometragem', $carro->getQuilometragem());
        $stmt->bindValue(':combustivel', $carro->getCombustivel());
        $stmt->bindValue(':preco', $carro->getPreco());
        $stmt->bindValue(':imagem', $carro->getImagem());
        $stmt->bindValue(':id', $carro->getId());
        return $stmt->execute();
    }

    public function excluir($id) {
        $sql = 'DELETE FROM carros WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    public function pesquisar($termo) {
        $sql = 'SELECT * FROM carros WHERE marca LIKE :termo OR modelo LIKE :termo';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':termo', '%' . $termo . '%');
        $stmt->execute();
        $carros = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Garantir que todas as chaves esperadas estejam presentes
        foreach ($carros as &$carro) {
            $carro['imagem_url'] = $carro['imagem'] ?? 'default.jpg';
            $carro['descricao'] = $carro['descricao'] ?? 'Descrição não disponível';
            $carro['tipo'] = $carro['tipo'] ?? 'N/A';
            $carro['portas'] = $carro['portas'] ?? 'N/A';
            $carro['lugares'] = $carro['lugares'] ?? 'N/A';
            $carro['malas'] = $carro['malas'] ?? 'N/A';
        }

        return $carros;
    }
}
?>