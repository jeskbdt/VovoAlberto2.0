<?php
require_once(__DIR__ . '/../util/Connection.php');
require_once(__DIR__ . '/../model/Entregador.php');

class EntregadorDAO {
    private PDO $conexao;

    public function __construct() {
        $this->conexao = Connection::getConnection();
    }

    public function listar() {
        $sql = "SELECT * FROM entregador ORDER BY nome";
        $stm = $this->conexao->prepare($sql);
        $stm->execute();
        $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $this->map($resultado);
    }

    public function inserir(Entregador $entregador) {
        try {
            $sql = "INSERT INTO entregador (nome, endereco, telefone, salarioBase, comissao, placaMoto, modeloMoto) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([
                $entregador->getNome(),
                $entregador->getEndereco(),
                $entregador->getTelefone(),
                $entregador->getSalarioBase(),
                $entregador->getComissao(),
                $entregador->getPlacaMoto(),
                $entregador->getModeloMoto()
            ]);
            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function alterar(Entregador $entregador) {
        try {
            $sql = "UPDATE entregador 
                       SET nome = ?, endereco = ?, telefone = ?, salarioBase = ?, comissao = ?, placaMoto = ?, modeloMoto = ? 
                     WHERE id = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([
                $entregador->getNome(),
                $entregador->getEndereco(),
                $entregador->getTelefone(),
                $entregador->getSalarioBase(),
                $entregador->getComissao(),
                $entregador->getPlacaMoto(),
                $entregador->getModeloMoto(),
                $entregador->getId()
            ]);
            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function excluir(int $id) {
        try {
            $sql = "DELETE FROM entregador WHERE id = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([$id]);
            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function buscarPorId(int $id): ?Entregador {
        $sql = "SELECT * FROM entregador WHERE id = ?";
        $stm = $this->conexao->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        $entregadores = $this->map($result);
        return count($entregadores) > 0 ? $entregadores[0] : null;
    }

    public function map($resultado) {
        $entregadores = [];
        foreach ($resultado as $r) {
            $entregador = new Entregador();
            $entregador->setId($r['id']);
            $entregador->setNome($r['nome']);
            $entregador->setEndereco($r['endereco']);
            $entregador->setTelefone($r['telefone']);
            $entregador->setSalarioBase($r['salarioBase']);
            $entregador->setComissao($r['comissao']);
            $entregador->setPlacaMoto($r['placaMoto']);
            $entregador->setModeloMoto($r['modeloMoto']);
            $entregadores[] = $entregador;
        }
        return $entregadores;
    }
}
?>