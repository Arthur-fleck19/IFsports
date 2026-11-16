<?php
    $codigo1 = $_POST['caracter1'];
    $codigo2 = $_POST['caracter2'];
    $codigo3 = $_POST['caracter3'];
    $codigo4 = $_POST['caracter4'];
    $codigoDigitado = $codigo1 . $codigo2 . $codigo3 . $codigo4;

    if(isset($_SESSION['recuperacao_codigo_enviado'], $_SESSION['recuperacao_codigo_hash'], $_SESSION['recuperacao_expira_em']) && time() >= $_SESSION['recuperacao_expira_em'] && password_verify($codigoDigitado, $_SESSION['recuperacao_codigo_hash'])) {
        $_SESSION['recuperacao_verificada'] = true;

        header("Location: ../Views/mudar_senha.html");
        exit();
    } else {
        header("Location: ../Views/insira_o_codigo.php?erro=codigoInvalido");
        exit();
    }