<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../DAO/CarroDAO.php';
require_once '../DTO/CarroDTO.php';

class CarroController {
    public function cadastrarCarro($marca, $modelo, $ano, $placa, $cor, $quilometragem, $combustivel, $preco, $imagem) {
        $carroDTO = new CarroDTO();
        $carroDTO->setMarca($marca);
        $carroDTO->setModelo($modelo);
        $carroDTO->setAno($ano);
        $carroDTO->setPlaca($placa);
        $carroDTO->setCor($cor);
        $carroDTO->setQuilometragem($quilometragem);
        $carroDTO->setCombustivel($combustivel);
        $carroDTO->setPreco($preco);
        $carroDTO->setImagem($imagem);

        $carroDAO = new CarroDAO();
        if ($carroDAO->cadastrar($carroDTO)) {
            $_SESSION['success_message'] = 'Carro cadastrado com sucesso!';
        } else {
            $_SESSION['error_message'] = 'Erro ao cadastrar carro.';
        }
    }

    public function listarCarros() {
        $carroDAO = new CarroDAO();
        return $carroDAO->listar();
    }

    public function buscarCarroPorId($id) {
        $carroDAO = new CarroDAO();
        return $carroDAO->buscarPorId($id);
    }

    public function atualizarCarro($id, $marca, $modelo, $ano, $placa, $cor, $quilometragem, $combustivel, $preco, $imagem) {
        $carroDTO = new CarroDTO();
        $carroDTO->setId($id);
        $carroDTO->setMarca($marca);
        $carroDTO->setModelo($modelo);
        $carroDTO->setAno($ano);
        $carroDTO->setPlaca($placa);
        $carroDTO->setCor($cor);
        $carroDTO->setQuilometragem($quilometragem);
        $carroDTO->setCombustivel($combustivel);
        $carroDTO->setPreco($preco);
        $carroDTO->setImagem($imagem);

        $carroDAO = new CarroDAO();
        return $carroDAO->atualizar($carroDTO);
    }

    public function excluirCarro($id) {
        $carroDAO = new CarroDAO();
        return $carroDAO->excluir($id);
    }

    public function pesquisarCarros($termo) {
        $carroDAO = new CarroDAO();
        return $carroDAO->pesquisar($termo);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carroController = new CarroController();

    if ($_POST['acao'] === 'cadastrar') {
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $ano = $_POST['ano'];
        $placa = $_POST['placa'];
        $cor = $_POST['cor'];
        $quilometragem = $_POST['quilometragem'];
        $combustivel = $_POST['combustivel'];
        $preco = $_POST['preco'];
        $imagem = $_FILES['imagem']['name'];
        move_uploaded_file($_FILES['imagem']['tmp_name'], '../uploads/' . $imagem);
        $carroController->cadastrarCarro($marca, $modelo, $ano, $placa, $cor, $quilometragem, $combustivel, $preco, $imagem);
        header('Location: ../view/lista_carros.php');
        exit();
    } elseif ($_POST['acao'] === 'atualizar') {
        $id = $_POST['id'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $ano = $_POST['ano'];
        $placa = $_POST['placa'];
        $cor = $_POST['cor'];
        $quilometragem = $_POST['quilometragem'];
        $combustivel = $_POST['combustivel'];
        $preco = $_POST['preco'];
        $imagem = $_FILES['imagem']['name'];
        move_uploaded_file($_FILES['imagem']['tmp_name'], '../uploads/' . $imagem);
        $carroController->atualizarCarro($id, $marca, $modelo, $ano, $placa, $cor, $quilometragem, $combustivel, $preco, $imagem);
        header('Location: ../view/lista_carros.php');
    } elseif ($_POST['acao'] === 'excluir') {
        $id = $_POST['id'];
        $carroController->excluirCarro($id);
        header('Location: ../view/lista_carros.php');
    }
}
?>