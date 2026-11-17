<?php
require_once("../Classes/Usuario_gerenciamento.php");

$caminho = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    Usuario_gerenciamento::editar_usuario($id, $nome, $email, $senha);
}
header("Location: $caminho");
exit();