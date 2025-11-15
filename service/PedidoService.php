<?php

require_once(__DIR__ . "/../model/Pedido.php");

class PedidoService {

    public function validarPedido(Pedido $pedido) {
        $erros = array();

        if (!$pedido->getSabor1()) {
        $erros[] = "Selecione pelo menos um sabor!";
        }
        if (!in_array($pedido->getTamanho(), ['M', 'G', 'X', 'F'], true)) {
            $erros[] = "Tamanho inválido!";
        }
        if (empty($pedido->getEndereco())) {
            $erros[] = "Endereço é obrigatório!";
        }
        if (!preg_match('/^\(\d{2}\) 9\d{4}-\d{4}$/', $pedido->getTelefoneCliente())) {
            $erros[] = "Telefone inválido! Use o formato (XX) 9XXXX-XXXX";
        }
        if (!in_array($pedido->getMetodoPagamento(), ['D', 'C', 'M', 'P'], true)) {
            $erros[] = "Método de pagamento inválido!";
        }
        if (!$pedido->getId_Atendente()) {
            $erros[] = "Selecione um atendente!";
        }
        if (!$pedido->getId_Entregador()) {
            $erros[] = "Selecione um entregador!";
        }

        return $erros;
    }
}