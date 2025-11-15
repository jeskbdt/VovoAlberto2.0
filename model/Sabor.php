<?php
class Sabor implements JsonSerializable{
	private $id;
	private $nome;

	public function jsonSerialize(): array
    {
        return array("id" => $this->id,
                     "nome" => $this->nome);
    }

	function getId(){
		return $this->id;
	}
	function setId($id){
		$this->id=$id;
	}
	function getNome(){
		return $this->nome;
	}
	function setNome($nome){
		$this->nome=$nome;
	}

}
?>