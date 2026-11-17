<?php
session_start();

if (isset($_SESSION['id']) && isset($_POST['id_produto']) && isset($_SERVER['HTTP_REFERER']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $origem = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);

    require_once "../Classes/Carrinho_gerenciamento.php";

    $id_produto = $_POST["id_produto"];
    $quantidade = $_POST["quantidade"];

    $feedback = Carrinho_gerenciamento::atualizar_carrinho($id_produto, $quantidade);

    header("Location: ../Views/finalizar_compra.php");
}else{
    header("Location: dashboard.php");
}