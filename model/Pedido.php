<?php
require_once(__DIR__ . '/Atendente.php');
require_once(__DIR__ . '/Entregador.php');

class Pedido {
    private ?int $id = null;
    private ?string $sabor1 = null;
    private ?string $sabor2 = null;
    private ?string $sabor3 = null;
    private ?string $tamanho = null;
    private ?string $endereco = null;
    private ?string $telefoneCliente = null;
    private ?string $metodoPagamento = null;
    private ?Atendente $Atendente = null;
    private ?Entregador $Entregador = null;

    public function getId(): ?int {
        return $this->id;
    }
    public function setId(?int $id): void {
        $this->id = $id;
    }
    public function getSabor1(): ?string {
        return $this->sabor1;
    }
    public function setSabor1(?string $sabor1): void {
        $this->sabor1 = $sabor1;
    }
    public function getSabor2(): ?string {
        return $this->sabor2;
    }
    public function setSabor2(?string $sabor2): void {
        $this->sabor2 = $sabor2;
    }
    public function getSabor3(): ?string {
        return $this->sabor3;
    }
    public function setSabor3(?string $sabor3): void {
        $this->sabor3 = $sabor3;
    }
    public function getTamanho(): ?string {
        return $this->tamanho;
    }
    public function getTamanhoTexto(): ?string {
        if($this->tamanho == "M")
            return "Média";
        if($this->tamanho == "G")
            return "Grande";
        if($this->tamanho == "X")
            return "Gigante";
        if($this->tamanho == "F")
            return "Família";

        return null;
    }
    public function setTamanho(?string $tamanho): void {
        $this->tamanho = $tamanho;
    }
    public function getEndereco(): ?string {
        return $this->endereco;
    }
    public function setEndereco(?string $endereco): void {
        $this->endereco = $endereco;
    }
    public function getTelefoneCliente(): ?string {
        return $this->telefoneCliente;
    }
    public function setTelefoneCliente(?string $telefoneCliente): void {
        $this->telefoneCliente = $telefoneCliente;
    }
    public function getMetodoPagamento(): ?string {
        return $this->metodoPagamento;
    }
    public function getMetodoPagamentoTexto(): ?string {
        if($this->metodoPagamento == "M")
            return "Dinheiro";
        if($this->metodoPagamento == "D")
            return "Débito";
        if($this->metodoPagamento == "C")
            return "Crédito";
        if($this->metodoPagamento == "P")
            return "Pix";

        return null;
    }
    public function setMetodoPagamento(?string $metodoPagamento): void {
        $this->metodoPagamento = $metodoPagamento;
    }
    public function getAtendente(): ?Atendente {
        return $this->Atendente;
    }
    public function setAtendente(?Atendente $atendente): void {
        $this->Atendente = $atendente;
    }
    public function getEntregador(): ?Entregador {
        return $this->Entregador;
    }
    public function setEntregador(?Entregador $entregador): void {
        $this->Entregador = $entregador;
    }
    public function getId_Atendente(): ?int {
        return $this->Atendente ? $this->Atendente->getId() : null;
    }
    public function setId_Atendente(?int $id_atendente): void {
        if ($id_atendente !== null) {
            $this->Atendente = new Atendente();
            $this->Atendente->setId($id_atendente);
        } else {
            $this->Atendente = null;
        }
    }
    public function getId_Entregador(): ?int {
        return $this->Entregador ? $this->Entregador->getId() : null;
    }
    public function setId_Entregador(?int $id_entregador): void {
        if ($id_entregador !== null) {
            $this->Entregador = new Entregador();
            $this->Entregador->setId($id_entregador);
        } else {
            $this->Entregador = null;
        }
    }
}
?>