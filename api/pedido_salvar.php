<?php

require_once(__DIR__ . "/../controller/PedidoController.php");
require_once(__DIR__ . "/../controller/SaborController.php");
require_once(__DIR__ . "/../controller/AtendenteController.php");
require_once(__DIR__ . "/../controller/EntregadorController.php");
require_once(__DIR__ . "/../service/PedidoService.php");

header("Content-Type: application/json");

$saborCont = new SaborController();
$entregadorCont = new EntregadorController();
$atendenteCont = new AtendenteController();
$pedidoCont = new PedidoController();
$pedidoService = new PedidoService();

$erros = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $pedido = $id ? $pedidoCont->buscarPorId($id) : new Pedido();

    // Sabores
    $pedido->setSabor1(isset($_POST['sabor1']) && is_numeric($_POST['sabor1']) ? (int)$_POST['sabor1'] : null);
    $pedido->setSabor2(isset($_POST['sabor2']) && is_numeric($_POST['sabor2']) ? (int)$_POST['sabor2'] : null);
    $pedido->setSabor3(isset($_POST['sabor3']) && is_numeric($_POST['sabor3']) ? (int)$_POST['sabor3'] : null);

    // Campos básicos
    $pedido->setTamanho(isset($_POST['tamanho']) ? trim($_POST['tamanho']) : null);
    $pedido->setEndereco(isset($_POST['endereco']) ? trim($_POST['endereco']) : null);
    $pedido->setTelefoneCliente(isset($_POST['telefoneCliente']) ? trim($_POST['telefoneCliente']) : null);
    $pedido->setMetodoPagamento(isset($_POST['metodoPagamento']) ? trim($_POST['metodoPagamento']) : null);

    // Relacionamentos
    $pedido->setId_Atendente(isset($_POST['atendente']) && is_numeric($_POST['atendente']) ? (int)$_POST['atendente'] : null);
    $pedido->setId_Entregador(isset($_POST['entregador']) && is_numeric($_POST['entregador']) ? (int)$_POST['entregador'] : null);

    // Validação
    $erros = $pedidoService->validarPedido($pedido);

    if (empty($erros)) {

        // Inserir ou alterar
        if (!$id) {
            $erros = $pedidoCont->inserir($pedido);
        } else {
            $erros = $pedidoCont->alterar($pedido);
        }

        // Comissão
        if (empty($erros)) {

            $atendente = $atendenteCont->buscarPorId($pedido->getId_Atendente());
            $atendente->setComissao($atendente->getComissao() + 10);
            $atendenteCont->alterar($atendente);

            $entregador = $entregadorCont->buscarPorId($pedido->getId_Entregador());
            $entregador->setComissao($entregador->getComissao() + 10);
            $entregadorCont->alterar($entregador);
        }
    }

    // Se houver erros:
    if (!empty($erros)) {
        echo json_encode([
            "success" => false,
            "errors" => $erros
        ]);
        exit();
    }

    // Sucesso:
    echo json_encode([
        "success" => true,
        "errors" => []
    ]);
    exit();
}


exit();

?>
