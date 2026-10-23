<?php
    require_once "../Classes/Produtos_gerenciamento.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $arquivo = $_FILES['imagem'];
        $nome = trim($_POST['nome-produto']);
        $preco = str_replace(",", ".", trim($_POST['preco-produto']));
        $preco = (double) $preco;
        $descricao = trim($_POST['desc-produto']);
        $estoque = (int) trim($_POST['estoque-produto']);
        $tipo = trim($_POST['tipo-produto']);
        $tiposPermitidos = ["Camisas", "Tênis", "Bolas", "Equipamentos"];
        $nomeValido = validarNome($nome);
        $tipoValido = validarTipo($tipo, $tiposPermitidos);
        $precoValido = validarPreco($preco);
        $descricaoValida = validarDescricao($descricao);
        $estoqueValido = validarEstoque($estoque);

        if(!($nomeValido && $precoValido && $descricaoValida && $estoqueValido)) {
            //Se precisar depois, adicionar lógica de alertar erro ou algo assim.
            header('Location: ../Views/produtos.php');
            exit();
        }

        $img = Produtos_gerenciamento::salvar_imagem($arquivo);
        Produtos_gerenciamento::add_produto($nome, $preco, $descricao, $estoque, $img, $tipo);

        header('Location: ../Views/produtos.php');
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
    }
?>