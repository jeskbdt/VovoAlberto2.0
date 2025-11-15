<?php
require_once(__DIR__ . "/../../controller/AtendenteController.php");
require_once(__DIR__ . "/../include/header.php");

$atendenteCont = new AtendenteController();
$lista = $atendenteCont->listar();

?>

<?php include_once(__DIR__ . "/../include/header.php");?>

        <h3>Atendentes</h3>
        <div>
            <a href="../../index.php"><img src="../../img/botao-de-inicio.png" alt="Inicio"></a>
            ||
            <a href="formAtendente.php"><img src="../../img/adicionar-usuario.png" alt="criarAtendente"></a>            
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
                    <th>Ações</th>
                </tr>
                <?php foreach ($lista as $atendente): ?>
                    <tr>
                        <td><?= $atendente->getId() ?></td>
                        <td><?= $atendente->getNome() ?></td>
                        <td><?= $atendente->getEndereco() ?></td>
                        <td><?= $atendente->getTelefone() ?></td>
                        <td><?= $atendente->getSalarioBase() ?></td>
                        <td><?= $atendente->getComissao() ?></td>
                        <td>
                            <a href="formAtendente.php?id=<?= $atendente->getId() ?>">
                                <img src="../../img/editar.png" alt="Editar" style="max-width: 30px;">
                            </a>
                            <a href="excluirAtendente.php?id=<?= $atendente->getId() ?>" onclick="return confirm('Tem certeza que deseja excluir este atendente?');">
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