<?php
require_once "Usuário_gerenciamento.php";

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

Usuário_gerenciamento::cadastrar($nome, $email, $senha);