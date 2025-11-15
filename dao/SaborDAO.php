<?php
require_once(__DIR__ . '/../util/Connection.php');
require_once(__DIR__ . '/../model/Sabor.php');

class SaborDAO {
    private PDO $conexao;

    public function __construct() {
        $this->conexao = Connection::getConnection();
    }

    public function listar() {
        $sql = "SELECT * FROM sabores ORDER BY nome";
        $stm = $this->conexao->prepare($sql);
        $stm->execute();
        $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $this->map($resultado);
    }

    public function salvar(Sabor $sabor) {
        try {
            if ($sabor->getId()) {
                $sql = "UPDATE sabores SET nome = ? WHERE id = ?";
                $stm = $this->conexao->prepare($sql);
                $stm->execute([
                    $sabor->getNome(),
                    $sabor->getId()
                ]);
            } else {
                $sql = "INSERT INTO sabores (nome) VALUES (?)";
                $stm = $this->conexao->prepare($sql);
                $stm->execute([
                    $sabor->getNome()
                ]);
            }
            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function excluir(int $id) {
        try {
            $sql = "DELETE FROM sabores WHERE id = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([$id]);
            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function map($resultado) {
        $sabores = [];
        foreach ($resultado as $r) {
            $sabor = new Sabor();
            $sabor->setId($r['id']);
            $sabor->setNome($r['nome']);
            $sabores[] = $sabor;
        }
        return $sabores;
    }
}
?>