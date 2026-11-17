<?php
    session_start();

    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['recuperacao_verificada'] === true) {
        $novaSenha = trim($_POST['novaSenha']);
        $senhaConfirmada = trim($_POST['confirmarSenha']);

        if(mb_strlen($novaSenha, "UTF-8") === 0) {
            header("Location: ../Views/mudar_senha.php?erro=senhaVazia");
            exit();
        } else {
            if($novaSenha === $senhaConfirmada) {
                require_once "../Classes/Usuario_gerenciamento.php";

                Usuario_gerenciamento::editar_senha($_SESSION['recuperacao_id'], $novaSenha);
            } else {
                header("Location: ../Views/mudar_senha.php?erro=confirmacaoErrada");
                exit();
            }
        }
    } else {
        header("Location: ../Views/redefinir_senha.html?erro=acessoInvalido");
        exit();
    }