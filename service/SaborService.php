<?php
require_once(__DIR__ . '/../dao/SaborDAO.php');

class SaborService {
    private $saborDAO;

    public function __construct() {
        $this->saborDAO = new SaborDAO();
    }

    public function listar() {
        return $this->saborDAO->listar();
    }

    public function excluir($id) {
        return $this->saborDAO->excluir($id);
    }
}
?>