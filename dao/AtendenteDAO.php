<?php
require_once(__DIR__ . '/../util/Connection.php');
require_once(__DIR__ . '/../model/Atendente.php');

class AtendenteDAO {
    private PDO $conexao;

    public function __construct() {
        $this->conexao = Connection::getConnection();
    }

    public function listar() {
        $sql = "SELECT * FROM atendente ORDER BY nome";    
        $stm = $this->conexao->prepare($sql);
        $stm->execute();
        $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $this->map($resultado);
    }

    public function inserir(Atendente $atendente) {
        try {
            
                $sql = "INSERT INTO atendente (nome, endereco, telefone, salarioBase, comissao) VALUES (?, ?, ?, ?, ?)";
                $stm = $this->conexao->prepare($sql);
                $stm->execute([
                    $atendente->getNome(),
                    $atendente->getEndereco(),
                    $atendente->getTelefone(),
                    $atendente->getSalarioBase(),
                    $atendente->getComissao()
                ]);
            
            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function alterar(Atendente $atendente) {
        try {
                $sql = "UPDATE atendente SET nome = ?, endereco = ?, telefone = ?, salarioBase = ?, comissao = ? WHERE id = ?";
                $stm = $this->conexao->prepare($sql);
                $stm->execute([
                    $atendente->getNome(),
                    $atendente->getEndereco(),
                    $atendente->getTelefone(),
                    $atendente->getSalarioBase(),
                    $atendente->getComissao(),
                    $atendente->getId()
                ]);
            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function excluir(int $id) {
        try {
            $sql = "DELETE FROM atendente WHERE id = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([$id]);
            return null;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function buscarPorId(int $id): ?Atendente {
        $sql = "SELECT * FROM atendente WHERE id = ?";
        $stm = $this->conexao->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        $atendentes = $this->map($result);
        return count($atendentes) > 0 ? $atendentes[0] : null;
    }

    public function map($resultado) {
        $atendentes = [];
        foreach ($resultado as $r) {
            $atendente = new Atendente();
            $atendente->setId($r['id']);
            $atendente->setNome($r['nome']);
            $atendente->setEndereco($r['endereco']);
            $atendente->setTelefone($r['telefone']);
            $atendente->setSalarioBase($r['salarioBase']);
            $atendente->setComissao($r['comissao']);
            $atendentes[] = $atendente;
        }
        return $atendentes;
    }
}
?>