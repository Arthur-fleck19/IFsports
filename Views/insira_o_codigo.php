<?php
    session_start();

    if(!isset($_SESSION['recuperacao_codigo_enviado'], $_SESSION['recuperacao_codigo_hash'], $_SESSION['recuperacao_expira_em']) && time() <= $_SESSION['recuperacao_expira_em']) {
        header("Location: ../Views/redefinir_senha.html");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="../CSS/insira_o_codigo.css">
    <link rel="icon" href="Imagens/logoIF.png">
</head>
<body>
    <header class="cabecalho">
        <a href="#"><img src="Imagens/logoIFsports.png" alt="Logo IFsports" height="70px" width="170px" class="logoIFsportsImg"></a>
    </header>
    <div class="container">
        <form class="caixa" action="../Rotas/verificar_codigo_deixar_trocar_senha.php" method="post">
            <i class="fa-solid fa-lock icone-cadeado"></i>
            <h1>Insira o código</h1>
            <div class="codigo">
                <input name="caracter1" type="text" maxlength="1">
                <input name="caracter2" type="text" maxlength="1">
                <input name="caracter3" type="text" maxlength="1">
                <input name="caracter4" type="text" maxlength="1">
            </div>
            <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>