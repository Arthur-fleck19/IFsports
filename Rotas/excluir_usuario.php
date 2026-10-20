<?php

require_once 'Usuario_gerenciamento.php';

$id = $_POST['id'];

Usuario_gerenciamento::excluir($id);

header("Location: gerenciamento_usuarios.php");