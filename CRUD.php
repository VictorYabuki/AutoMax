<?php
    header('Access-Control-Allow-Origin: *'); //Permite acesso de todas as origens
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    //Permite acesso dos métodos GET, POST, PUT, DELETE
    //PUT é utilizado para fazer um UPDATE no banco
    //DELETE é utilizado para deletar algo do banco
    header('Access-Control-Allow-Headers: Content-Type'); //Permite com que qualquer header consiga acessar o sistema
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
        exit;
    }
    include 'conexao.php';
    //inclui os dados de conexão com o bd no sistema abaixo

    //Rota para obter todos os livros
    //Utilizando o GET
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $stmt = $conn->prepare("SELECT * FROM carros");
        $stmt -> execute();
        $automax = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($automax);
        //converter dados em json
    }
    //-------------------------------------------------
    //Rota para inserir livros
    //Utilizando o POST
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $anoFabricacao = $_POST['anoFabricacao'];
        $preco = $_POST['preco'];
        //inserir outros campos caso necessario ....

        $stmt = $conn->prepare("INSERT INTO carros (id_carro, marca, modelo, anoFabricacao, preco) VALUES (:id_carro, :marca, :modelo, :anoFabricacao, :preco)");
        $stmt -> bindParam(':marca', $marca);
        $stmt -> bindParam(':modelo', $modelo);
        $stmt -> bindParam(':anoFabricacao', $anoFabricacao);
        $stmt -> bindParam(':preco', $preco);
        $stmt -> bindParam(':id_carro', $id_carro);
        //Outros bindParams ....

        if($stmt->execute()){
            echo "carros inserido com sucesso!!";
        } else {
            echo "Erro ao inserir carros";
        }
    }

    //Rota para atualizar uma rota existente
    if($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id_carro'])){
        //convertendo dados recebidos em string
        parse_str(file_get_contents("php://input"), $_PUT);

        $id_carro = $_GET['id_carro'];
        $novo_marca = $_PUT['marca'];
        $novo_modelo = $_PUT['modelo'];
        $novo_anoFabricacao = $_PUT['anoFabricacao'];
        $novo_preco = $_PUT['preco'];

        $stmt = $conn->prepare("UPDATE carros SET marca = :marca, modelo = :modelo, anoFabricacao = :anoFabricacao, preco = :preco WHERE id = :id_carro");
        $stmt->bindParam(':marca', $novo_marca);
        $stmt->bindParam(':modelo', $novo_modelo);
        $stmt->bindParam(':anoFabricacao', $novo_anoFabricacao);
        $stmt->bindParam(':preco', $novo_preco);
        $stmt->bindParam(':id_carro', $id_carro);

        if($stmt->execute()){
            echo "carros atualizada com sucesso!!";
        } else {
            echo "Erro ao atualizar a carros :( ";
        }
    }

    //rota para deletar uma carros existente
    if($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id_carro'])){
        $id_carro = $_GET['id_carro'];
        $stmt = $conn->prepare("DELETE FROM carros WHERE id_carro = :id_carro");
        $stmt->bindParam(':id_carro', $id_carro);

        if($stmt->execute()){
            echo "carros excluida com sucesso!!";
        } else {
            echo "erro ao excluir carros";
        }
}