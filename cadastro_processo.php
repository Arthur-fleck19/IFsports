<?php
require_once "Usuário_gerenciamento.php";

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

echo (Usuário_gerenciamento::cadastrar($nome, $email, $senha));

header("Location: dashboard.php");