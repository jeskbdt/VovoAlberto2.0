<?php
require_once(__DIR__ . '/../model/Entregador.php');
require_once(__DIR__ . '/../dao/EntregadorDAO.php');
require_once(__DIR__ . '/../service/EntregadorService.php');

class EntregadorController {
    private ?Entregador $entregador;
    private ?EntregadorDAO $entregadorDAO;
    private ?EntregadorService $entregadorSvc;

    public function __construct() {
        $this->entregador = new Entregador();
        $this->entregadorDAO = new EntregadorDAO();
        $this->entregadorSvc = new EntregadorService();
    }

    public function listar() {
        return $this->entregadorDAO->listar();
    }

    public function inserir(Entregador $entregador): array {
        $erros = $this->entregadorSvc->validarEntregador($entregador);
        if (count($erros) > 0) {
            return $erros;
        }

        $erro = $this->entregadorDAO->inserir($entregador);
        if ($erro) {
            $erros[] = "Erro ao cadastrar o entregador!";
            if (defined('AMB_DEV') && AMB_DEV) {
                $erros[] = $erro->getMessage();
            }
        }
        return $erros;
    }

    public function alterar(Entregador $entregador): array {
        $erros = $this->entregadorSvc->validarEntregador($entregador);
        if (count($erros) > 0) {
            return $erros;
        }

        $erro = $this->entregadorDAO->alterar($entregador);
        if ($erro) {
            $erros[] = "Erro ao alterar o entregador!";
            if (defined('AMB_DEV') && AMB_DEV) {
                $erros[] = $erro->getMessage();
            }
        }
        return $erros;
    }

    public function excluir(int $id): array {
        $erros = [];
        $erro = $this->entregadorDAO->excluir($id);
        if ($erro) {
            $erros[] = "Erro ao excluir o entregador!";
            if (defined('AMB_DEV') && AMB_DEV) {
                $erros[] = $erro->getMessage();
            }
        }
        return $erros;
    }

    public function buscarPorId(int $id): ?Entregador {
        return $this->entregadorDAO->buscarPorId($id);
    }

    
}
?>
