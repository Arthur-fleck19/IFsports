<?php
require_once "../Classes/Carrinho_gerenciamento.php";

$id_produto = $_POST["id_produto"];
$quantidade = $_POST["quantidade"];

Carrinho_gerenciamento::atualizar_carrinho($id_produto, $quantidade);