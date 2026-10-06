<?php
require 'Usuário_gerenciamento.php';

$nome = $_POST['nome'];
$senha = $_POST['senha'];

if(!Usuário_gerenciamento::login($nome, $senha)){
    header("Location: login.html");
    exit;
}

if($_SESSION['tipo'] == 'admin'){
    header("Location: gerenciamento_usuarios.php");
}else{
    header("Location: dashboard.php");
}
exit;