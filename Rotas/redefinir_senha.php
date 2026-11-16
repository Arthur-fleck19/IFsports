<?php
    session_start();

    require_once "../Classes/Usuario_gerenciamento.php";

    $emailUsuario = $_POST['Email'];
    $_SESSION['recuperacao_id'] = Usuario_gerenciamento::email_existente_retorna_id($emailUsuario);

    if($_SESSION['recuperacao_id'] !== "-1") {
        //Gerar senha de 4 caracteres, enviar um email ao usuário e depois o seu hash para maior segurança
        $codigoRecuperacaoInt = str_pad((string) random_int(0, 9999), 4, "0", STR_PAD_LEFT);

        $_SESSION['recuperacao_codigo_hash'] = password_hash($codigoRecuperacaoInt, PASSWORD_DEFAULT);
        $_SESSION['recuperacao_expira_em'] = time() + 180;
        $_SESSION['recuperacao_codigo_enviado'] = true;

        header("Location: ../Views/insira_o_codigo.php");
        exit();
    } else {
        header("Location: ../Views/redefinir_senha.html?erro=emailNaoAchado");
        exit();
    }