<?php
    session_start();

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['caracter1'], $_POST['caracter2'], $_POST['caracter3'], $_POST['caracter4']) && time() <= $_SESSION['recuperacao_expira_em']) {
        $codigo1 = trim($_POST['caracter1']);
        $codigo2 = trim($_POST['caracter2']);
        $codigo3 = trim($_POST['caracter3']);
        $codigo4 = trim($_POST['caracter4']);
        $codigoDigitado = $codigo1 . $codigo2 . $codigo3 . $codigo4;

        if(password_verify($codigoDigitado, $_SESSION['recuperacao_codigo_hash'])) {
            $_SESSION['recuperacao_verificada'] = true;

            header("Location: ../Views/mudar_senha.php");
            exit();
        } else {
            header("Location: ../Views/insira_o_codigo.php?erro=codigoInvalido");
            exit();
        }
    } else {
        header("Location: ../Views/redefinir_senha.html?erro=acessoInvalido");
        exit();
    }