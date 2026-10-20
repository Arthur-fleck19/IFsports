<?php
require_once("Usuario_gerenciamento.php");

$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

Usuario_gerenciamento::editar_usuario($id, $nome, $email, $senha);

header("Location: gerenciamento_usuarios.php");