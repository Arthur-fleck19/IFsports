

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
require_once "Usuário_gerenciamento.php";

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

echo (Usuário_gerenciamento::cadastrar($nome, $email, $senha));

?>    
</body>
</html>