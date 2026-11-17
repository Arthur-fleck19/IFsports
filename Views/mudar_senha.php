<?php
    session_start();

    if(!isset($_SESSION['recuperacao_verificada']) || $_SESSION['recuperacao_verificada'] !== true) {
        header("Location: ../Views/redefinir_senha.html?erro=acessoInvalido");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mudar senha</title>
    <link rel="stylesheet" href="../CSS/mudar_senha.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="icon" href="Imagens/logoIF.png">
</head>
<div id="notificacao" class="notificacao"></div>
<body>
    <header class="cabecalho">
        <a href="#"><img src="Imagens/logoIFsports.png" alt="Logo IFsports" height="70px" width="170px" class="logoIFsportsImg"></a>
    </header>
    <div class="container">
        <div class="formulario">
            <form action="../Rotas/trocar_senha.php" method="post">
                <i class="fa-solid fa-lock icone-cadeado"></i>
                <h1>Mudar senha</h1>
                <p class="frase">Coloque uma senha que não esqueça</p>
                <div class="caixa-formulario">
                    <i class="fa-solid fa-lock icone-esquerda"></i>
                    <input type="password" placeholder="Informe sua senha" id="novaSenha" name="novaSenha" required="">
                    <i class="fa-solid fa-eye-slash icone-direita" id="toggleSenha"></i>
                </div>
                <div class="caixa-formulario">
                    <i class="fa-solid fa-lock icone-esquerda"></i>
                    <input type="password" placeholder="Confirme a nova senha" id="confirmarSenha" name="confirmarSenha" required="">
                    <i class="fa-solid fa-eye-slash icone-direita" id="toggleSenha"></i>
                </div>
                <button type="submit">Voltar e logar</button>
            </form>
        </div>
    </div>
    <script src="../JS/mudar_senha.js"></script>
</body>
</html>