<?php
session_start();

if (isset($_SESSION['id']) && isset($_POST['id_produto']) && isset($_SERVER['HTTP_REFERER'])) {
    $origem = $_SERVER['HTTP_REFERER'];

    require_once "../Classes/Carrinho_gerenciamento.php";

    $id_produto = $_POST["id_produto"];
    $quantidade = $_POST["quantidade"];

    Carrinho_gerenciamento::atualizar_carrinho($id_produto, $quantidade);

    echo $origem;

    header("Location: $origem");
    exit;
}