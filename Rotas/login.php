<?php
require "Usuario_gerenciamento.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["Nome"];
    $senha = $_POST["Senha"];

    $mensagem = Usuario_gerenciamento::login($nome, $senha);
}
?>

<?php if (!empty($mensagem)): ?>
    <p><?php echo htmlspecialchars($mensagem); ?></p>
<?php endif; ?>