<?php
    session_start();
    require_once("Produtos_gerenciamento.php");

    if($_SESSION['tipo'] != 'admin'){
        header('Location: dashboard.php');
        exit;
    }

    $produtos = Produtos_gerenciamento::get_produtos();
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
    <link rel="stylesheet" href="CSS/produtos.css">
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
            <button class="botaoNav"><i class="fa-solid fa-globe fa-xl"></i>Todos</button>
            <button class="botaoNav"><i class="fa-solid fa-shirt fa-xl"></i>Camisas</button>
            <button class="botaoNav"><i class="fa-solid fa-shoe-prints fa-xl"></i>Tênis</button>
            <button class="botaoNav"><i class="fa-regular fa-futbol fa-xl"></i>Bolas</button>
            <button class="botaoNav"><i class="fa-solid fa-table-tennis-paddle-ball fa-xl"></i>Equipamentos</button>
            <h1 class="admin"> - ADM - </h1>
            <button class="botaoNav botaoAdmin "><i class="fa-solid fa-user fa-xl"></i>Usuários</button>
            <button class="botaoNav corFundoBotaoSelecionado"><i class="fa-solid fa-box fa-xl"></i>Produtos</button>
        </div>

        <div class="container">

            <!-- Tela de adicionar produto -->

            <div class="modal" id="criar-produto">

                <form action="criar_produto.php" method="post" class="modalconteudo-Produtos"  enctype="multipart/form-data">

                    <div class="modalIMG-Produtos">
                        <input class="inputImg" type="file" name="imagem" id="imagem" accept="image/*" required>
                    </div>
                    <div class="Lapis">
                        <i class="fa-solid fa-pencil"></i>
                    </div>
                    <div>
                        <div class="camposProdutos">
                            <h4>Nome do Produto</h4>
                            <input type="text" name="nome-produto" id="" class="inforProduto" required>


                            <h4>Preço</h4>
                            <div class="preco">
                                <i class="fa-solid fa-dollar-sign"></i>
                                <input type="number" step="0.01" min="0" name="preco-produto" placeholder="0.00" id="" class="inforProduto" required>
                            </div>

                            <h4>Descrição</h4>
                            <textarea name="desc-produto" id="" class="inforProduto" required></textarea>

                            <h4>Categoria</h4>
                            <input type="text" name="tipo-produto" id="tipo-produto" class="inforProduto" required>

                            <h4>Estoque</h4>
                            <input type="number" name="estoque-produto" id="" class="inforProduto" value="1" required>
                        </div>
                        <div class="botoesProdutos">
                            <button class="botaoProdutosCan">Cancelar</button> <input type="submit" class="botaoProdutos" value="Criar">
                        </div>
                    </div>

                </form>

            </div>

            <!-- Fim da tela de adicionar produto -->

            <div class="gerenciamento">
                <h1>Produtos</h1>
                <p>Gerenciamento dos produtos do IFsports</p>

                <button id="add_produto">Adicionar produto</button>
            </div>

            <!--Alguém vai ter que ajeitar os nomes dessas classes-->

            <div class="perfis">
                <?php
                while($produto = $produtos->fetch_assoc()):
                ?>
                    <div class="perfil">
                        <div class="divUsuario"><img src="uploads/<?=htmlspecialchars($produto['imagem'])?>" alt="Foto produto" class="usuario"></div>

                        <div class="infosUsuario">
                            <p>ID: <?= $produto['id_produtos'] ?></p>
                            <h3>Produto: <?= $produto['nome'] ?></h3>
                            <p>Valor: R$ <?= $produto['preco'] ?></p>
                        </div>

                        <div class="bu">
                            <button class="botaoExcluir" id="BotaoExcluir">Excluir produto</button>
                            <button class="botaoEditar" id="BotaoEditar">Editar produto</button>
                            <div class="modal" id="modal">

                                <div class="modalconteudo-Produtos">

                                    <div class="modalIMG-Produtos"><img src="uploads/<?=htmlspecialchars($produto['imagem'])?>" alt="Foto produto"></div>
                                    <div class="Lapis">
                                        <i class="fa-solid fa-pencil"></i>
                                    </div>
                                    <div>
                                        <div class="camposProdutos">
                                            <h4>Nome do Produto</h4>
                                            <input type="text" name="" id="" class="inforProduto" value="<?= htmlspecialchars($produto['nome']) ?>">


                                            <h4>Preço</h4>
                                            <div class="preco">
                                                <i class="fa-solid fa-dollar-sign"></i>
                                                <input type="number" step="0.01" min="0" value="<?= htmlspecialchars($produto['preco']) ?>" id="" class="inforProduto">
                                            </div>

                                            <h4>Descrição</h4>
                                            <textarea name="" id="" class="inforProduto"><?= $produto['descricao'] ?></textarea>
                                            <h4>Estoque</h4>
                                            <input type="number" name="" id="" class="inforProduto" value="<?= htmlspecialchars($produto['estoque']) ?>">
                                        </div>
                                        <div class="botoesProdutos">
                                            <button class="botaoProdutosCan">Cancelar</button> <button class="botaoProdutos">Salvar Alterações</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                endwhile;
                ?>
            </div>
    </main>

</body>

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

    const modal_novo_produto = document.getElementById('criar-produto');
    const botao_novo_produto = document.getElementById('add_produto')

    botao_novo_produto.addEventListener('click', () => {
        modal_novo_produto.style.display = 'flex';
    })
</script>

</html>