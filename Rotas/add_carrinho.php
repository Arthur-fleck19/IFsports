<?php
session_start();

if (isset($_SESSION['id']) && isset($_POST['id_produto']) && isset($_SERVER['HTTP_REFERER'])) {
    $origem = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);

    require_once "../Classes/Carrinho_gerenciamento.php";

    $id_produto = $_POST["id_produto"];
    $quantidade = $_POST["quantidade"];

    Carrinho_gerenciamento::atualizar_carrinho($id_produto, $quantidade);

    if($origem == "/IFsports/Views/dashboard.php"){
        header("Location: $origem");
        exit();
    }

    header("Location: /IFsports/Views/carrinho.php");
    exit();
}