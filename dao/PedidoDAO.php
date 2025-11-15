<?php
require_once(__DIR__ . "/../util/Connection.php");
require_once(__DIR__ . "/../model/Pedido.php");
require_once(__DIR__ . "/../model/Atendente.php");
require_once(__DIR__ . "/../model/Entregador.php");
require_once(__DIR__ . "/../model/Sabor.php");

class PedidoDAO {
    private PDO $conexao;

    public function __construct() {
        $this->conexao = Connection::getConnection();
    }

    public function listar() {
        $sql = "SELECT p.*, 
                       a.nome AS nome_atendente, 
                       e.nome AS nome_entregador,
                       GROUP_CONCAT(s.nome) AS sabores
                FROM pedidos p
                JOIN atendente a ON (a.id = p.id_atendente)
                JOIN entregador e ON (e.id = p.id_entregador)
                LEFT JOIN pedido_sabores ps ON (ps.id_pedido = p.id)
                LEFT JOIN sabores s ON (s.id = ps.id_sabor)
                GROUP BY p.id
                ORDER BY p.id";
        $stm = $this->conexao->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $this->map($result);
    }

    public function buscarPorId(int $id) {
        $sql = "SELECT p.*, 
                       a.nome AS nome_atendente, 
                       e.nome AS nome_entregador,
                       GROUP_CONCAT(s.nome) AS sabores
                FROM pedidos p
                JOIN atendente a ON (a.id = p.id_atendente)
                JOIN entregador e ON (e.id = p.id_entregador)
                LEFT JOIN pedido_sabores ps ON (ps.id_pedido = p.id)
                LEFT JOIN sabores s ON (s.id = ps.id_sabor)
                WHERE p.id = ?
                GROUP BY p.id";
        $stm = $this->conexao->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        $pedidos = $this->map($result);
        return count($pedidos) > 0 ? $pedidos[0] : null;
    }

    public function inserir(Pedido $pedido) {
        try {
            $this->conexao->beginTransaction();

            $sql = "INSERT INTO pedidos (tamanho, endereco, telefoneCliente, metodoPagamento, id_atendente, id_entregador)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([
                $pedido->getTamanho(),
                $pedido->getEndereco(),
                $pedido->getTelefoneCliente(),
                $pedido->getMetodoPagamento(),
                $pedido->getId_Atendente(),
                $pedido->getId_Entregador()
            ]);
            $pedidoId = $this->conexao->lastInsertId();

            $sabores = array(
                $pedido->getSabor1() ?: null,
                $pedido->getSabor2() ?: null,
                $pedido->getSabor3() ?: null
            );
            foreach ($sabores as $saborId) {
                if ($saborId) {
                    $sql = "INSERT INTO pedido_sabores (id_pedido, id_sabor) VALUES (?, ?)";
                    $stm = $this->conexao->prepare($sql);
                    $stm->execute([$pedidoId, $saborId]);
                }
            } 

            $this->conexao->commit();
            return null;
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            return $e;
        }
    }

    public function alterar(Pedido $pedido) {
        try {
            $this->conexao->beginTransaction();

            $sql = "UPDATE pedidos SET tamanho = ?, endereco = ?, telefoneCliente = ?, metodoPagamento = ?, id_atendente = ?, id_entregador = ?
                    WHERE id = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([
                $pedido->getTamanho(),
                $pedido->getEndereco(),
                $pedido->getTelefoneCliente(),
                $pedido->getMetodoPagamento(),
                $pedido->getId_Atendente(),
                $pedido->getId_Entregador(),
                $pedido->getId()
            ]);

            $sql = "DELETE FROM pedido_sabores WHERE id_pedido = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([$pedido->getId()]);

            $sabores = array(
                $pedido->getSabor1() ?: null,
                $pedido->getSabor2() ?: null,
                $pedido->getSabor3() ?: null
            );
            foreach ($sabores as $saborId) {
                if ($saborId) {
                    $sql = "INSERT INTO pedido_sabores (id_pedido, id_sabor) VALUES (?, ?)";
                    $stm = $this->conexao->prepare($sql);
                    $stm->execute([$pedido->getId(), $saborId]);
                }
            }

            $this->conexao->commit();
            return null;
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            return $e;
        }
    }

    public function excluir(int $id) {
        try {
            $this->conexao->beginTransaction();

            $sql = "DELETE FROM pedido_sabores WHERE id_pedido = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([$id]);

            $sql = "DELETE FROM pedidos WHERE id = ?";
            $stm = $this->conexao->prepare($sql);
            $stm->execute([$id]);

            $this->conexao->commit();
            return null;
        } catch (PDOException $e) {
            $this->conexao->rollBack();
            return $e;
        }
    }

    private function map(array $result) {
        $pedidos = [];
        foreach ($result as $r) {
            $pedido = new Pedido();
            $pedido->setId($r["id"]);
            $pedido->setTamanho($r["tamanho"]);
            $pedido->setEndereco($r["endereco"]);
            $pedido->setTelefoneCliente($r["telefoneCliente"]);
            $pedido->setMetodoPagamento($r["metodoPagamento"]);

            $sabores = isset($r["sabores"]) ? explode(",", $r["sabores"]) : [];
            if (count($sabores) > 0) $pedido->setSabor1($sabores[0] ?? null);
            if (count($sabores) > 1) $pedido->setSabor2($sabores[1] ?? null);
            if (count($sabores) > 2) $pedido->setSabor3($sabores[2] ?? null);

            $atendente = new Atendente();
            $atendente->setId($r["id_atendente"]);
            $atendente->setNome($r["nome_atendente"]);
            $pedido->setAtendente($atendente);

            $entregador = new Entregador();
            $entregador->setId($r["id_entregador"]);
            $entregador->setNome($r["nome_entregador"]);
            $pedido->setEntregador($entregador);

            $pedidos[] = $pedido;
        }
        return $pedidos;
    }
}
?>