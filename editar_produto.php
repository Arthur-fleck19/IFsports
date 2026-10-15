<?php
    require_once "Produtos_gerenciamento.php";

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    $estoque = $_POST['estoque'];

    Produtos_gerenciamento::editar_produto($id, $nome, $preco, $descricao, $estoque);

    header("Location: gerenciamento_produtos.php");