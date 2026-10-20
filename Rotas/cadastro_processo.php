<?php
require_once "../Classes/Usuario_gerenciamento.php";

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

Usuario_gerenciamento::cadastrar($nome, $email, $senha);

header("Location: ../Views/dashboard.php");
exit;