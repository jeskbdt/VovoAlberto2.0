<?php
require_once(__DIR__ . "/../../controller/PedidoController.php");
require_once(__DIR__ . "/../include/header.php");

$pedidoCont = new PedidoController();
$lista = $pedidoCont->listar();

if (empty($lista)) {
    echo "<p class='error'>Nenhum pedido encontrado. Verifique se há registros na tabela 'pedidos' ou se a consulta está funcionando corretamente.</p>";
}
?>

<?php include_once(__DIR__ . "/../include/header.php");?>

        <h3>Pedidos Anteriores</h3>
        <div>
            <a href="criarPedido.php"><img src="../../img/pedido.png" alt="Criar Pedido"></a> |
            <a href="../atendentes/listarAtendentes.php"><img src="../../img/atendente.png" alt="Gerenciar Atendentes"></a> |
            <a href="../entregadores/listarEntregadores.php"><img src="../../img/entregador.png" alt="Gerenciar Entregadores"></a>
        </div>
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Sabor 1</th>
                    <th>Sabor 2</th>
                    <th>Sabor 3</th>
                    <th>Tamanho</th>
                    <th>Endereço para Entrega</th>
                    <th>Contato</th>
                    <th>Método de Pagamento</th>
                    <th>Atendente</th>
                    <th>Entregador</th>
                    <th>Ações</th>
                </tr>
                <?php foreach ($lista as $pedido): ?>
                    <tr>
                        <td><?= $pedido->getId() ?></td>
                        <td><?= $pedido->getSabor1() ?? '-' ?></td>
                        <td><?= $pedido->getSabor2() ?? '-' ?></td>
                        <td><?= $pedido->getSabor3() ?? '-' ?></td>
                        <td><?= $pedido->getTamanhoTexto() ?></td>
                        <td><?= $pedido->getEndereco() ?></td>
                        <td><?= $pedido->getTelefoneCliente() ?></td>
                        <td><?= $pedido->getMetodoPagamentoTexto() ?></td>
                        <td><?= $pedido->getAtendente()->getNome() ?></td>
                        <td><?= $pedido->getEntregador()->getNome() ?></td>
                        <td>
                            <a href="alterarPedido.php?id=<?$pedido->getId() ?>&a=2">
                                <img src="../../img/editar.png" alt="Editar">
                            </a>
                            <a href="excluirPedido.php?id=<?= $pedido->getId() ?>" onclick="return confirm('Tem certeza que deseja excluir este pedido?');">
                                <img src="../../img/excluir.png" alt="Excluir" style="max-width: 30px;">
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
</body>


<?php include_once(__DIR__ . "/../include/footer.php"); ?>