<?php
require_once(__DIR__ . "/../../controller/PedidoController.php");
require_once(__DIR__ . "/../../service/PedidoService.php");
require_once(__DIR__ . "/../../controller/SaborController.php");
require_once(__DIR__ . "/../../controller/AtendenteController.php");
require_once(__DIR__ . "/../../controller/EntregadorController.php");
require_once(__DIR__ . "/../include/header.php");

$saborCont = new SaborController();
$entregadorCont = new EntregadorController();
$atendenteCont = new AtendenteController();
$pedidoCont = new PedidoController();
$pedidoService = new PedidoService();

$entregadores = $entregadorCont->listar();
$atendentes = $atendenteCont->listar();
$sabores = $saborCont->listar();

$id = isset($_GET['id']) ? $_GET['id'] : null;
$pedido = $id ? $pedidoCont->buscarPorId($id) : header("location: listarPedidos.php");;

$qtdSabores = 1;
if ($pedido->getSabor3()) $qtdSabores = 3;
elseif ($pedido->getSabor2()) $qtdSabores = 2;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pedido->setSabor1(isset($_POST['sabor1']) && is_numeric($_POST['sabor1']) ? (int)$_POST['sabor1'] : null);
    $pedido->setSabor2(isset($_POST['sabor2']) && is_numeric($_POST['sabor2']) ? (int)$_POST['sabor2'] : null);
    $pedido->setSabor3(isset($_POST['sabor3']) && is_numeric($_POST['sabor3']) ? (int)$_POST['sabor3'] : null);
    $tamanho = isset($_POST['tamanho']) ? $_POST['tamanho'] : null;
    $endereco = isset($_POST['endereco']) ? trim($_POST['endereco']) : null;
    $telefoneCliente = isset($_POST['telefoneCliente']) ? trim($_POST['telefoneCliente']) : null;
    $metodoPagamento = isset($_POST['metodoPagamento']) ? trim($_POST['metodoPagamento']) : null;
    $pedido->setTamanho($tamanho);
    $pedido->setEndereco($endereco);
    $pedido->setTelefoneCliente($telefoneCliente);
    $pedido->setMetodoPagamento($metodoPagamento);
    $pedido->setId_Atendente(isset($_POST['atendente']) && is_numeric($_POST['atendente']) ? (int)$_POST['atendente'] : null);
    $pedido->setId_Entregador(isset($_POST['entregador']) && is_numeric($_POST['entregador']) ? (int)$_POST['entregador'] : null);

    $erros = $pedidoService->validarPedido($pedido);
    

    if (empty($erros)) {
        $erros = $pedidoCont->alterar($pedido);
        if (empty($erros)) {
            header("Location: listarPedidos.php");
            exit();
        }
    }

    if (!empty($erros)) {
        echo "<div class='error'>";
        foreach ($erros as $erro) {
            echo "<p>" . $erro . "</p>";
        }
        echo "</div>";
    }
}
?>

    <?php include_once(__DIR__ . "/../include/header.php")?>
        
    <?php include_once("./form.php")?>

    <?php include_once(__DIR__ . "/../include/footer.php"); ?>