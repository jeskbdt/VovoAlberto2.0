<?php

require_once(__DIR__ . "/../../controller/EntregadorController.php");

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$entregadorCont = new EntregadorController();

if ($id) {
    $erros = $entregadorCont->excluir($id);
    if (empty($erros)) {
        header("Location: listarEntregadores.php");
        exit();
    } else {
        echo "<p class='error'>Erro ao excluir: " . implode(", ", $erros) . "</p>";
    }
} else {
    echo "<p class='error'>ID inválido!</p>";
}
?>