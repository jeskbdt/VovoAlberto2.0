<?php
require_once(__DIR__ . "/../../controller/EntregadorController.php");
require_once(__DIR__ . "/../include/header.php");

$entregadorCont = new EntregadorController();
$lista = $entregadorCont->listar();

?>

<?php include_once(__DIR__ . "/../include/header.php");?>

        <h3>Entregadores</h3>
        <div>
            <a href="../../index.php"><img src="../../img/botao-de-inicio.png" alt="Inicio"></a>
            ||
            <a href="formEntregador.php"><img src="../../img/adicionar-usuario.png" alt="criarAtendente"></a>            
        </div>
        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Telefone</th>
                    <th>Salário Base</th>
                    <th>Comissão</th>
                    <th>Placa Moto</th>
                    <th>Modelo Moto</th>
                    <th>Ações</th>
                </tr>
                <?php foreach ($lista as $entregador): ?>
                    <tr>
                        <td><?= $entregador->getId() ?></td>
                        <td><?= $entregador->getNome() ?></td>
                        <td><?= $entregador->getEndereco() ?></td>
                        <td><?= $entregador->getTelefone() ?></td>
                        <td><?= $entregador->getSalarioBase() ?></td>
                        <td><?= $entregador->getComissao() ?></td>
                        <td><?= $entregador->getPlacaMoto() ?></td>
                        <td><?= $entregador->getModeloMoto() ?></td>
                        <td>
                            <a href="formEntregador.php?id=<?= $entregador->getId() ?>">
                                <img src="../../img/editar.png" alt="Editar">
                            </a>
                            <a href="excluirEntregador.php?id=<?= $entregador->getId() ?>" onclick="return confirm('Tem certeza que deseja excluir este entregador?');">
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