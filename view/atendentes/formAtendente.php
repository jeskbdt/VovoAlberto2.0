<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/../../controller/AtendenteController.php");
require_once(__DIR__ . "/../include/header.php");

$atendenteCont = new AtendenteController();
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$atendente = $id ? $atendenteCont->buscarPorId($id) : new Atendente();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $atendente->setNome($_POST['nome'] ?? null);
    $atendente->setEndereco($_POST['endereco'] ?? null);
    $atendente->setTelefone($_POST['telefone'] ?? null);
    $atendente->setSalarioBase(isset($_POST['salarioBase']) ? (float) $_POST['salarioBase'] : null);
    $atendente->setComissao(isset($_POST['comissao']) ? (float) $_POST['comissao'] : null);
    
    $erros = $atendente->getId() ? $atendenteCont->alterar($atendente) : $atendenteCont->inserir($atendente);
    
    if (empty($erros)) {
        header("Location: listarAtendentes.php");
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
<h3><?= $id ? 'Alterar' : 'Criar Novo' ?> Atendente</h3>
<form action="" method="post">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" value="<?= $atendente->getNome() ?? '' ?>">
    <label for="endereco">Endereço:</label>
    <input type="text" name="endereco" id="endereco" value="<?= $atendente->getEndereco() ?? '' ?>">
    <label for="telefone">Telefone:</label>
    <input type="text" name="telefone" id="telefone" maxlength=15 onkeyup="handlePhone(event)" value="<?= $atendente->getTelefone() ?? '' ?>">
    <label for="salarioBase">Salário Base:</label>
    <input type="number" name="salarioBase" id="salarioBase" value="<?= $atendente->getSalarioBase() ?? '' ?>">
    <label for="comissao">Comissão:</label>
    <input type="number" name="comissao" id="comissao" value="<?= $atendente->getComissao() ?? '' ?>">
    <a href="../atendentes/listarAtendentes.php"><button type="button">Voltar</button></a>
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