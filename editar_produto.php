<?php
    require_once "Produtos_gerenciamento.php";

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    $estoque = $_POST['estoque'];
    $nomeValido = validarNome($nome);
    $precoValido = validarPreco($preco);
    $descricaoValida = validarDescricao($descricao);
    $estoqueValido = validarEstoque($estoque);

    if(!($nomeValido && $precoValido && $descricaoValida && $estoqueValido)) {

    }

    Produtos_gerenciamento::editar_produto($id, $nome, $preco, $descricao, $estoque);

    header("Location: produtos.php");
    exit();

    function validarNome($nome) {
        if(empty($nome) || strlen($nome) > 150) {
            return false;
        }

        return true;
    }

    function validarPreco($preco) {
        if(empty($preco) || gettype($preco) != "double" || gettype($preco) != "integer") {

        }

        return true;
    }

    function validarDescricao() {
        return true;
    }

    function validarEstoque() {
        return true;
    }