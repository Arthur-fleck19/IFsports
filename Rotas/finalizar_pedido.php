<?php
require_once "../Classes/Pedidos_gerenciamento.php";

if(isset($_POST['frete'])) {
    $frete = $_POST['frete'];

    Pedidos_gerenciamento::finalizarPedido($frete);

    header("Location: ../Views/perfil.php");
    exit();
}
echo "Por favor, preencha todos os campos";