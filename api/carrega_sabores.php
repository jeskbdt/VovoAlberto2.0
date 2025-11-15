<?php

require_once(__DIR__ . "\..\controller\SaborController.php");

$saborCont = new SaborController();

$sabores = $saborCont->listar();

$sigma = json_encode($sabores, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
return $sigma;

?>