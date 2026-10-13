<?php
require "Usuário_gerenciamento.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["Nome"];
    $senha = $_POST["Senha"];

    Usuário_gerenciamento::login($nome, $senha);
}
?>

<?php if (!empty($mensagem)): ?>
    <p><?php echo htmlspecialchars($mensagem); ?></p>
<?php endif; ?>