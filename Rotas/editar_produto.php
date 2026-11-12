<?php
    require_once "../Classes/Produtos_gerenciamento.php";

    $id = $_POST['id'];
    $nome = trim($_POST['nome']);
    $tipo = trim($_POST['tipo']);
    $tiposPermitidos = ["Camisas", "Tênis", "Bolas", "Equipamentos"];
    $preco = str_replace(",", ".", trim($_POST['preco']));
    $preco = (double) trim($preco);
    $descricao = trim($_POST['descricao']);
    $estoque = (int) trim($_POST['estoque']);
    $nomeValido = validarNome($nome);
    $tipoValido = validarTipo($tipo, $tiposPermitidos);
    $precoValido = validarPreco($preco);
    $descricaoValida = validarDescricao($descricao);
    $estoqueValido = validarEstoque($estoque);

    if(!($nomeValido && $precoValido && $descricaoValida && $estoqueValido)) {
        //Se precisar depois, adicionar lógica de alertar erro ou algo assim.
        header("Location: ../Views/produtos.php");
        exit();
    }

    Produtos_gerenciamento::editar_produto($id, $nome, $preco, $descricao, $estoque);

    header("Location: ../Views/produtos.php");
    exit();

    function validarNome($nome):bool {
        if(empty($nome) || strlen($nome) > 150) {
            return false;
        }

        return true;
    }

    function validarTipo($tipo, $tiposPermitidos):bool {
        if(empty($tipo) || !in_array($tipo, $tiposPermitidos)) {
            return false;
        }

        return true;
    }

    function validarPreco($preco):bool {
        if(empty($preco) || $preco <= 0.0 || $preco > 99999999.99) {
            return false;
        }

        return true;
    }

    function validarDescricao($descricao):bool {
        if(empty($descricao) || strlen($descricao) > 500) {
            return false;
        }

        return true;
    }

    function validarEstoque($estoque):bool {
        if(empty($estoque) || $estoque <= 0) {
            return false;
        }

        return true;
    }