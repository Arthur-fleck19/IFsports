<?php

require_once 'Usuário_gerenciamento.php';

$id = $_POST['id'];

Usuário_gerenciamento::excluir($id);

header("Location: gerenciamento_usuarios.php");