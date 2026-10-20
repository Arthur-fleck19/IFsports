<?php

require_once '../Classes/Usuario_gerenciamento.php';

$id = $_POST['id'];

Usuario_gerenciamento::excluir($id);

header("Location: ../Views/gerenciamento_usuarios.php");