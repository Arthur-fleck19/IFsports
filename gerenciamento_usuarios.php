<?php
require_once "Usuário_gerenciamento.php";

$usuarios = Usuário_gerenciamento::get_usuarios();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
          integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg=="
          crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="CSS/dashboard.css">
    <link rel="icon" href="logoIF.png">
    <link rel="stylesheet" href="CSS/trabalho.css">
    <title>Dashboard</title>
</head>

<body>
<header class="cabecalho">
    <a href="dashboard.php"><img src="logoIFsports.png" alt="Logo IFsports" height="70px" width="170px"
                                 class="logoIFsportsImg"></a>
    <form class="containerInputLupa">
        <input type="text" name="" id="" class="inputPesquisa" placeholder="">
        <button type="submit" class="lupaInput"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
    </form>
    <nav>
        <ul class="icones">
            <li><a href="" class="iconeSite"><i class="fa-solid fa-cart-shopping fa-2xl"></i></a><span
                        class="contadorCarrinho">1</span></li>
            <li><a href="" class="iconeSite Usuario"><i class="fa-solid fa-circle-user fa-2xl"></i></a></li>
        </ul>
    </nav>
</header>
<!-- Cards testes para ver como fica -->
<main class="vitrineProdutos">
    <div class="botoesNav">
        <button class="botaoNav corFundoBotaoSelecionado"><i class="fa-solid fa-globe fa-xl"></i>Todos</button>
        <button class="botaoNav"><i class="fa-solid fa-shirt fa-xl"></i>Camisas</button>
        <button class="botaoNav"><i class="fa-solid fa-shoe-prints fa-xl"></i>Tênis</button>
        <button class="botaoNav"><i class="fa-regular fa-futbol fa-xl"></i>Bolas</button>
        <button class="botaoNav"><i class="fa-solid fa-table-tennis-paddle-ball fa-xl"></i>Equipamentos</button>
        <h1 class="admin"> - ADM - </h1>
        <button class="botaoNav botaoAdmin "><i class="fa-solid fa-user fa-xl"></i>Usuários</button>
        <button class="botaoNav botaoAdmin"><i class="fa-solid fa-box fa-xl"></i>Produtos</button>
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
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ63lctB9SWfz7PyfuaXZW4aGwfOlZNC5_72EK_BoRBKA&s=10"
                                alt="Foto Usuário" class="usuario"></div>

                    <div class="infosUsuario">
                        <p>
                            ID: <?= htmlspecialchars($usuario['id_usuarios']) ?>
                        </p>

                        <h3>
                            Nome: <?= htmlspecialchars($usuario['nome']) ?>
                        </h3>

                        <p>
                            Email: <?= htmlspecialchars($usuario['email']) ?>
                        </p>

                    </div>
                    <div class="bu">

                        <button class="botaoExcluir">Excluir perfil</button>
                        <button class="botaoEditar">Editar perfil</button>
                        <div class="modal">
                            <div class="modalConteudo">
                                <div class="modalIMG"><img
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ63lctB9SWfz7PyfuaXZW4aGwfOlZNC5_72EK_BoRBKA&s=10"
                                            alt="Foto Usuário"></div>

                                <form class="modalInfos" action="editar_usuario.php" method="post">

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

                                    <input type="submit" value="Alterar">
                                </form>
                            </div>
                        </div>



                    </div>
                </div>

            <?php endwhile; ?>
        </div>
        <script>

            const botoesEditar = document.querySelectorAll(".botaoEditar");

            botoesEditar.forEach(function (botao) {
                botao.addEventListener('click', () => {
                    const modal = botao.closest('.bu').querySelector('.modal');

                    modal.style.display = 'flex';
                })
            })

            const modais = document.querySelectorAll('.modal');

            modais.forEach(function (modal){
                modal.addEventListener('click', (local) => {
                    if (local.target === modal) {
                        modal.style.display = 'none'

                    }
                })
            })


        </script>
    </div>
</main>
</body>

</html>