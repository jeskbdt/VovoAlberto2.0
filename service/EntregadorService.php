<?php

require_once(__DIR__ . "/../model/Entregador.php");

class EntregadorService {

    public function validarEntregador(Entregador $entregador): array {
        $erros = [];

        if (empty($entregador->getNome())) {
            $erros[] = "Nome é obrigatório!";
        }

        if (empty($entregador->getEndereco())) {
            $erros[] = "Endereço é obrigatório!";
        }

        if (empty($entregador->getTelefone())) {
            $erros[] = "Telefone é obrigatório!";
        } elseif (!preg_match('/^\(\d{2}\) 9\d{4}-\d{4}$/', $entregador->getTelefone())) {
            $erros[] = "Telefone inválido! Use o formato (XX) 9XXXX-XXXX";
        }

        if (empty($entregador->getSalarioBase())) {
            $erros[] = "O salário base é obrigatório!";
        }

        if (empty($entregador->getPlacaMoto())) {
            $erros[] = "A placa da moto é obrigatória!";
        }

        if (empty($entregador->getModeloMoto())) {
            $erros[] = "O modelo da moto é obrigatório!";
        }

        return $erros;
    }

}