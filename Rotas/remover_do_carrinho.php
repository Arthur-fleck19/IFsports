<?php
session_start();

require_once "../Classes/Carrinho_gerenciamento.php";

if (isset($_SESSION['id']) && isset($_POST['id_item_carrinho'])) {
    Carrinho_gerenciamento::remover_do_carrinho($_POST['id_item_carrinho']);

    header("location: ../Views/carrinho.php");
    exit;
}