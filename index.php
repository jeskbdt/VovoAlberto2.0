<?php

require_once("controller/SaborController.php");

if(isset($_GET['acao']) && isset($_GET['classe'])){

    $nomeClasse = $_GET['classe'];
    $acao = $_GET['acao'];
    
    $arquivoController = $nomeClasse . "Controller.php"; 
    $nomeController = $nomeClasse . "Controller";
    $objController = new $nomeController();

    if(method_exists($objController, $acao)){
        $input = file_get_contents("php://input");
        $dados = json_decode($input, true);
        return $objController->$acao($dados);        
    }else{
        header("location: ./view/pedidos/listarPedidos.php");
        exit();
    }

}else {
    header("location: ./view/pedidos/listarPedidos.php");
    exit();
}