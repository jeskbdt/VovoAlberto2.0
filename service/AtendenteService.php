<?php

require_once(__DIR__ . "/../model/Atendente.php");

class AtendenteService {

    public function validarAtendente(Atendente $atendente): array {
        $erros = [];
        if (!$atendente->getNome()){
            $erros[] = "Nome é obrigatório!";
        }
        
        if (!$atendente->getEndereco()){
            $erros[] = "Endereço é obrigatório!";
        }
        
        if (!$atendente->getTelefone()){
            $erros[] = "Telefone é obrigatório!";
        }if ($atendente->getTelefone() && !preg_match('/^\(\d{2}\) 9\d{4}-\d{4}$/', $atendente->getTelefone())) {
            $erros[] = "Telefone inválido! Use o formato (XX) 9XXXX-XXXX";
        }
        
        if (!$atendente->getSalarioBase()){
            $erros[] = "O salário inicial é obrigatório!";
        }
        return $erros;
    }

}