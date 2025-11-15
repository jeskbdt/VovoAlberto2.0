<?php
require_once(__DIR__ . '/../model/Atendente.php');
require_once(__DIR__ . '/../dao/AtendenteDAO.php');
require_once(__DIR__ . '/../service/AtendenteService.php');

class AtendenteController {
    private ?Atendente $atendente;
    private ?AtendenteDAO $atendenteDAO;
    private ?AtendenteService $atendenteSvc;

    public function __construct(){
        $this->atendente = new Atendente();
        $this->atendenteDAO = new AtendenteDAO();
        $this->atendenteSvc = new AtendenteService();
    }

    public function listar(){

        return $this->atendenteDAO->listar();

    }

    public function inserir(Atendente $atendente): array {
        $erros = $this->atendenteSvc->validarAtendente($atendente);
        if (count($erros) > 0) {
            return $erros;
        }

        $erro = $this->atendenteDAO->inserir($atendente);
        if ($erro) {
            $erros[] = "Erro ao cadastrar o atendente!";
            if (defined('AMB_DEV') && AMB_DEV) {
                $erros[] = $erro->getMessage();
            }
        }
        return $erros;
    }

    public function alterar(Atendente $atendente): array {
        $erros = $this->atendenteSvc->validarAtendente($atendente);
        if (count($erros) > 0) {
            return $erros;
        }

        $erro = $this->atendenteDAO->alterar($atendente);
        if ($erro) {
            $erros[] = "Erro ao alterar o atendente!";
            if (defined('AMB_DEV') && AMB_DEV) {
                $erros[] = $erro->getMessage();
            }
        }
        return $erros;
    }

    public function excluir(int $id): array {
        $erros = [];
        $erro = $this->atendenteDAO->excluir($id);
        if ($erro) {
            $erros[] = "Erro ao excluir o atendente!";
            if (defined('AMB_DEV') && AMB_DEV) {
                $erros[] = $erro->getMessage();
            }
        }
        return $erros;
    }

    
    public function buscarPorId(int $id): ?Atendente {
        return $this->atendenteDAO->buscarPorId($id);
    }
}
?>