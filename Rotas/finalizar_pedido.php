<?php
require_once "../Classes/Pedidos_gerenciamento.php";

if(isset($_POST['entrega']) && isset($_POST['cep'])) {
    $entrega = $_POST['entrega'] ?? '';
    if(!in_array($entrega, ['padrao', 'expressa'], true)){
        throw new Exception('Ripo de entrega inválido');
    }
    $cep = $_POST['cep'];

    Pedidos_gerenciamento::finalizar_pedido($entrega, $cep);

    header("Location: ../Views/perfil.php");
    exit();
}