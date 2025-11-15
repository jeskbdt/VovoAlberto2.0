<?php

require_once __DIR__ . '/../dao/PedidoDAO.php';
require_once __DIR__ . '/../model/Pedido.php';
require_once __DIR__ . '/../service/PedidoService.php';

class PedidoController {
    private PedidoDAO $pedidoDAO;
    private PedidoService $pedidoService;

    public function __construct() {
        $this->pedidoDAO = new PedidoDAO();
        $this->pedidoService = new PedidoService();
    }

    public function listar(): array {
        return $this->pedidoDAO->listar();
    }

    public function buscarPorId(int $id): ?Pedido {
        return $this->pedidoDAO->buscarPorId($id);
    }

    public function inserir(Pedido $pedido): array {
        $erros = $this->pedidoService->validarPedido($pedido);
        if (count($erros) > 0) {
            return $erros;
        }

        $erro = $this->pedidoDAO->inserir($pedido);
        if ($erro) {
            $erros[] = "Erro ao salvar o pedido!";
            if (defined('AMB_DEV') && AMB_DEV) {
                $erros[] = $erro->getMessage();
            }
        }

        return $erros;
    }

    public function alterar(Pedido $pedido): array {
        $erros = $this->pedidoService->validarPedido($pedido);
        if (count($erros) > 0) {
            return $erros;
        }

        $erro = $this->pedidoDAO->alterar($pedido);
        if ($erro) {
            $erros[] = "Erro ao alterar o pedido!";
            if (defined('AMB_DEV') && AMB_DEV) {
                $erros[] = $erro->getMessage();
            }
        }

        return $erros;
    }

    public function excluir(int $id): array {
        $erros = [];
        $erro = $this->pedidoDAO->excluir($id);
        if ($erro) {
            $erros[] = "Erro ao excluir o pedido!";
            if (defined('AMB_DEV') && AMB_DEV) {
                $erros[] = $erro->getMessage();
            }
        }
        return $erros;
    }
}
?>