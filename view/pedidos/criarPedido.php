<?php
require_once(__DIR__ . "/../../controller/PedidoController.php");
require_once(__DIR__ . "/../../controller/SaborController.php");
require_once(__DIR__ . "/../../controller/AtendenteController.php");
require_once(__DIR__ . "/../../controller/EntregadorController.php");
require_once(__DIR__ . "/../../service/PedidoService.php");
require_once(__DIR__ . "/../include/header.php");

$saborCont = new SaborController();
$entregadorCont = new EntregadorController();
$atendenteCont = new AtendenteController();
$pedidoCont = new PedidoController();
$pedidoService = new PedidoService();

$entregadores = $entregadorCont->listar();
$atendentes = $atendenteCont->listar();
$sabores = $saborCont->listar();
$id = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pedido = new Pedido();
    $pedido->setSabor1(isset($_POST['sabor1']) && is_numeric($_POST['sabor1']) ? $_POST['sabor1'] : null);
    $pedido->setSabor2(isset($_POST['sabor2']) && is_numeric($_POST['sabor2']) ? $_POST['sabor2'] : null);
    $pedido->setSabor3(isset($_POST['sabor3']) && is_numeric($_POST['sabor3']) ? $_POST['sabor3'] : null);
    $tamanho = isset($_POST['tamanho']) ? trim($_POST['tamanho']) : null;
    $endereco = isset($_POST['endereco']) ? trim($_POST['endereco']) : null;
    $telefoneCliente = isset($_POST['telefoneCliente']) ? trim($_POST['telefoneCliente']) : null;
    $metodoPagamento = isset($_POST['metodoPagamento']) ? trim($_POST['metodoPagamento']) : null;
    $pedido->setTamanho($tamanho);
    $pedido->setEndereco($endereco);
    $pedido->setTelefoneCliente($telefoneCliente);
    $pedido->setMetodoPagamento($metodoPagamento);
    $pedido->setId_Atendente(isset($_POST['atendente']) && is_numeric($_POST['atendente']) ? (int)$_POST['atendente'] : null);
    $pedido->setId_Entregador(isset($_POST['entregador']) && is_numeric($_POST['entregador']) ? (int)$_POST['entregador'] : null);

    $erros = [];
    
    $erros = $pedidoService->validarPedido($pedido);

    if (empty($erros)) {
        $erros = $pedidoCont->inserir($pedido);
        
        if (empty($erros)) {

            $atendente = $atendenteCont->buscarPorId($pedido->getId_Atendente());
        $atendente->setComissao($atendente->getComissao() + 10);
        $atendenteCont->alterar($atendente);
        
        $entregador = $entregadorCont->buscarPorId($pedido->getId_Entregador());
        $entregador->setComissao($entregador->getComissao() + 10);
        $entregadorCont->alterar($entregador);
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