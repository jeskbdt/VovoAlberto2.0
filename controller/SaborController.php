<?php
require_once(__DIR__ . '/../model/Sabor.php');
require_once(__DIR__ . '/../dao/SaborDAO.php');

class SaborController {
    private ?Sabor $sabor;
    private ?SaborDAO $saborDAO;

    public function __construct(){
        $this->sabor = new Sabor();
        $this->saborDAO = new SaborDAO();
    }

    public function listar(){

        return $this->saborDAO->listar();

    }

    

}
?>