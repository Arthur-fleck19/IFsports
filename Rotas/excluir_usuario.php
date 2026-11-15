<?php

require_once '../Classes/Usuario_gerenciamento.php';

$id = $_POST['id'];

Usuario_gerenciamento::excluir($id);

if(parse_url($_SERVER["HTTP_REFERER"], PHP_URL_PATH) == '/IFsports/Views/perfil.php'){
   Usuario_gerenciamento::logout();
}

header("Location: ../Views/gerenciamento_usuarios.php");
exit();