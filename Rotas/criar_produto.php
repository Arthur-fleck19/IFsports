<?php
    require_once("../Classes/Produtos_gerenciamento.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $arquivo = $_FILES['imagem'];
        $nome = $_POST['nome-produto'];
        $preco = $_POST['preco-produto'];
        $descricao = $_POST['desc-produto'];
        $estoque = $_POST['estoque-produto'];
        $tipo = $_POST['tipo-produto'];

        $img = Produtos_gerenciamento::salvar_imagem($arquivo);
        Produtos_gerenciamento::add_produto($nome, $preco, $descricao, $estoque, $img, $tipo);

        header('Location: ../Views/produtos.php');
        exit;
    }
?>