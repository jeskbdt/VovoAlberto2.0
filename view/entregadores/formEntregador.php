<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../../controller/EntregadorController.php");
require_once(__DIR__ . "/../include/header.php");

$entregadorCont = new EntregadorController();
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$entregador = $id ? $entregadorCont->buscarPorId($id) : new Entregador();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entregador->setNome($_POST['nome'] ?? null);
    $entregador->setEndereco($_POST['endereco'] ?? null);
    $entregador->setTelefone($_POST['telefone'] ?? null);
    $entregador->setSalarioBase(isset($_POST['salarioBase']) ? (float) $_POST['salarioBase'] : null);
    $entregador->setComissao(isset($_POST['comissao']) ? (float) $_POST['comissao'] : null);
    $entregador->setPlacaMoto($_POST['placaMoto'] ?? null);
    $entregador->setModeloMoto($_POST['modeloMoto'] ?? null);
    
    $erros = $entregador->getId() ? $entregadorCont->alterar($entregador) : $entregadorCont->inserir($entregador);
    
    if (empty($erros)) {
        header("Location: listarEntregadores.php");
        exit();
    }
    
    if (!empty($erros)) {
        echo "<div class='error'>";
        foreach ($erros as $erro) {
            echo "<p>" . $erro . "</p>";
        }
        echo "</div>";
    }
}
?>
<?php include_once(__DIR__ . "/../include/header.php"); ?>
<h3><?= $id ? 'Alterar' : 'Criar Novo' ?> Entregador</h3>
<form action="" method="post">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" value="<?= $entregador->getNome() ?? '' ?>">
    <label for="endereco">Endereço:</label>
    <input type="text" name="endereco" id="endereco" value="<?= $entregador->getEndereco() ?? '' ?>">
    <label for="telefone">Telefone:</label>
    <input type="text" name="telefone" id="telefone" maxlength=15 onkeyup="handlePhone(event)" value="<?= $entregador->getTelefone() ?? '' ?>">
    <label for="salarioBase">Salário Base:</label>
    <input type="number" name="salarioBase" id="salarioBase" value="<?= $entregador->getSalarioBase() ?? '' ?>">
    <label for="comissao">Comissão:</label>
    <input type="number" name="comissao" id="comissao" value="<?= $entregador->getComissao() ?? '' ?>">
    <label for="placaMoto">Placa da Moto:</label>
    <input type="text" name="placaMoto" id="placaMoto" value="<?= $entregador->getPlacaMoto() ?? '' ?>">
    <label for="modeloMoto">Modelo da Moto:</label>
    <input type="text" name="modeloMoto" id="modeloMoto" value="<?= $entregador->getModeloMoto() ?? '' ?>">
    <a href="../entregadores/listarEntregadores.php"><button type="button">Voltar</button></a>
    <input type="submit" value="Salvar">
</form>
</main>
</body>
<script>
const handlePhone = (event) => {
    let input = event.target
    input.value = phoneMask(input.value)
}
const phoneMask = (value) => {
    if (!value) return ""
    value = value.replace(/\D/g,'')
    value = value.replace(/(\d{2})(\d)/,"($1) $2")
    value = value.replace(/(\d)(\d{4})$/,"$1-$2")
    return value
}
</script>
<?php include_once(__DIR__ . "/../include/footer.php"); ?>