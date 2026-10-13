<?php
    require_once("Usuário_gerenciamento.php");

    $nome = $_SESSION['nome-produto'];
    $preco = $_SESSION['preco-produto'];
    $descricao = $_SESSION['desc-produto'];
    $estoque = $_SESSION['estoque-produto'];

    Usuário_gerenciamento::add_produto($nome, $preco, $descricao, $estoque);
?>