<?php
session_start();

if(!isset($_SESSION["tipo"])){
    header("Location: login.html");
    exit;
}

if($_SESSION['tipo'] == 'comum'){
    header("location: dashboard.php");
    exit;
}

require_once "../Classes/Usuario_gerenciamento.php";
require_once "../Classes/Carrinho_gerenciamento.php";

$quant_carrinho = Carrinho_gerenciamento::get_quant_prod_carrinho_usuario($_SESSION["id"]);
$usuarios = Usuario_gerenciamento::get_usuarios();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
          integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg=="
          crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="../CSS/dashboard.css">
    <link rel="icon" href="Imagens/logoIF.png">
    <link rel="stylesheet" href="../CSS/trabalho.css">
    <title>Dashboard</title>
</head>

<body>
<header class="cabecalho">
    <a href="dashboard.php"><img src="Imagens/logoIFsports.png" alt="Logo IFsports" height="70px" width="170px"
                                 class="logoIFsportsImg"></a>
    <form class="containerInputLupa">
        <input type="text" name="" id="" class="inputPesquisa" placeholder="">
        <button type="submit" class="lupaInput"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
    </form>
    <nav>
        <ul class="icones">
            <li><a href="" class="iconeSite"><i class="fa-solid fa-cart-shopping fa-2xl"></i></a><?= ((int) $quant_carrinho > 0) ? "<span class='contadorCarrinho'>" . ($quant_carrinho > 99 ? '+99' : (int) $quant_carrinho) . "</span>" : "" ?></li>
            <li><a href="perfil.php" class="iconeSite Usuario"><i class="fa-solid fa-circle-user fa-2xl"></i></a></li>
        </ul>
    </nav>
</header>
<!-- Cards testes para ver como fica -->
<main class="vitrineProdutos">
    <div class="botoesNav">
        <div class="grupoFiltros">
                <button class="botaoNav botaocategoria corFundoBotaoSelecionado" data-categoria="Todos" onclick="window.location.href='dashboard.php'">
                    <i class="fa-solid fa-globe fa-xl"></i>Todos
                </button>

                <button class="botaoNav botaocategoria" data-categoria="Camisas" onclick="window.location.href='dashboard.php'">
                    <i class="fa-solid fa-shirt fa-xl"></i>Camisas
                </button>

                <button class="botaoNav botaocategoria" data-categoria="Tênis" onclick="window.location.href='dashboard.php'">
                    <i class="fa-solid fa-shoe-prints fa-xl"></i>Tênis
                </button>

                <button class="botaoNav botaocategoria" data-categoria="Bolas" onclick="window.location.href='dashboard.php'">
                    <i class="fa-regular fa-futbol fa-xl"></i>Bolas
                </button>

                <button class="botaoNav botaocategoria" data-categoria="Equipamentos"  onclick="window.location.href='dashboard.php'">
                    <i class="fa-solid fa-table-tennis-paddle-ball fa-xl"></i>Equipamentos
                </button>
            </div>
        <h1 class="admin"> - ADM - </h1>
        <button onclick="window.location.href='gerenciamento_usuarios.php'" class="botaoNav botaoAdmin botaousuario"><i class="fa-solid fa-user fa-xl"></i>Usuários</button>
        <button onclick="window.location.href='produtos.php'" class="botaoNav botaoAdmin"><i class="fa-solid fa-box fa-xl"></i>Produtos</button>
    </div>


    <div class="container">

        <div class="gerenciamento">
            <h1>Perfis</h1>
            <p>Gerenciamento dos perfil do IFsports</p>
        </div>

        <div class="perfis">

            <?php
            while ($usuario = $usuarios->fetch_assoc()):
                ?>
                <div class="perfil">
                    <div class="divUsuario"><img
                                src="Imagens/perfil.jpg"
                                alt="Foto Usuário" class="usuario"></div>

                    <div class="infosUsuario">
                        <p>
                            ID: <?= htmlspecialchars($usuario['id_usuarios']) ?>
                        </p>

                        <h3>
                            Nome: <?= htmlspecialchars($usuario['nome']) ?>
                        </h3>

                        <p>
                           <i class="fa-solid fa-envelope"></i> Email: <?= htmlspecialchars($usuario['email']) ?>
                        </p>

                    </div>
                    <div class="bu">

                        <form action="../Rotas/excluir_usuario.php" method="post" style="width: 100%;display: inline-flex" onsubmit="return confirm('Tem certeza de que deseja remover este usuário do sistema?');">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id_usuarios']) ?>">
                            <input type="submit" class="botaoExcluir" value="Excluir perfil">
                        </form>

                        <button class="botaoEditar">Editar perfil</button>
                        <div class="modal">
                            <div class="modalConteudo">
                                <div class="modalIMG"><img
                                            src="Imagens/perfil.jpg"
                                            alt="Foto Usuário"></div>

                                <form class="modalInfos" action="../Rotas/editar_usuario.php" method="post">

                                    <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id_usuarios']) ?>">

                                    <div class="info-alterar"><i class="fa-solid fa-circle-user"></i>
                                        <div>
                                            <p class="EscritaMenor">Nome:</p>
                                            <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>">
                                        </div><i class="fa-solid fa-pencil"></i>
                                    </div>
                                    <div class="info-alterar"><i class="fa-solid fa-envelope"></i>
                                        <div>
                                            <p class="EscritaMenor">E-mail:</p>
                                            <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>">
                                        </div><i class="fa-solid fa-pencil"></i>
                                    </div>
                                    <div class="info-alterar"><i class="fa-solid fa-lock"></i>
                                        <div>
                                            <p class="EscritaMenor">Senha:</p>
                                            <input type="password" name="senha" placeholder="(deixe em branco para manter)*****">
                                        </div><i class="fa-solid fa-pencil"></i>
                                    </div>

                                    <input class="alterarBotao" type="submit" value="Alterar">
                                </form>
                            </div>
                        </div>



                    </div>
                </div>

            <?php endwhile; ?>
        </div>
        <script src="../JS/gerenciamento_usuarios.js"></script>
    </div>
</main>
</body>

</html>