<?php
require_once(__DIR__ . "/../../controller/AtendenteController.php");

$id = $_GET['id'] ?? null;
$atendenteCont = new AtendenteController();

if ($id) {
    $erros = $atendenteCont->excluir($id);
    if (empty($erros)) {
        header("Location: listarAtendentes.php");
        exit();
    } else {
        echo "<p class='error'>Erro ao excluir: " . implode(", ", $erros) . "</p>";
    }
} else {
    echo "<p class='error'>ID inválido!</p>";
}
?>