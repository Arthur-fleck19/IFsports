<?php
session_start();
require_once("../Classes/Produtos_gerenciamento.php");

if ($_SESSION['tipo'] != 'admin') {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        Produtos_gerenciamento::excluir($id);
    }
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
    <link rel="stylesheet" href="../CSS/dashboard.css">
    <link rel="icon" href="Imagens/logoIF.png">
    <link rel="stylesheet" href="../CSS/produtos.css">
   
    
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
            <li><a href="" class="iconeSite"><i class="fa-solid fa-cart-shopping fa-2xl"></i></a><span
                        class="contadorCarrinho">1</span></li>
                <li><a href="perfil.php" class="iconeSite Usuario"><i class="fa-solid fa-circle-user fa-2xl"></i></a></li>
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
            <button class="botaoNav botaoAdmin "><a class="aAdmin" href="gerenciamento_usuarios.php"><i class="fa-solid fa-user fa-xl"></i>Usuários</a></button>
            <button class="botaoNav corFundoBotaoSelecionado"><i class="fa-solid fa-box fa-xl"></i>Produtos</button>
        </div>
    <div class="container">
        <!-- Tela de adicionar produto -->
        <div class="modal" id="criar-produto">
            <form action="../Rotas/criar_produto.php" method="post" id="formAddProduto" class="modalconteudo-Produtos" enctype="multipart/form-data" novalidate>
                <header>
                    <div class="modalIMG-Produtos">
                        <img src="Imagens/imagem_adicionar_imagem_produto_input_file.jpg" alt="Imagem input adicionar imagem" height="100px">
                        <input class="inputImg" type="file" name="imagem" id="imagem" accept="image/*" required>
                    </div>
                    <div class="tituloParagrafoAddProduto">
                        <h2>Adicionar produto</h2>
                        <p>Selecione uma imagem clicando no botão verde e preencha as informações do produto para adicioná-lo ao seu catálogo.</p>
                    </div>
                </header>

                    <div class="labelInputUni">
                        <label for="inputNomeProduto">Nome do Produto</label>
                        <input type="text" minlength="1" maxlength="150" placeholder="Ex.: Bola de vôlei" name="nome-produto" id="inputNomeProduto" required>
                        <span></span>
                    </div>
                    <div class="labelInputUni">
                        <label for="inputTipoProduto">Tipo</label>
                        <i class="fa-solid fa-volleyball fa-xl" id="iconeTipoAddProduto"></i>
                        <select name="tipo-produto" id="inputTipoProduto" required>
                            <option value="" disabled selected>Selecione o tipo</option>
                            <option value="Camisas">Camisas</option>
                            <option value="Tênis">Tênis</option>
                            <option value="Bolas">Bolas</option>
                            <option value="Equipamentos">Equipamentos</option>
                        </select>
                        <span></span>
                    </div>
                    <div class="labelInputUni">
                        <label for="inputPrecoProduto">Preço</label>
                        <input type="number" step="0.01" min="0.01" max="99999999.99" name="preco-produto" placeholder="R$ 0,01" id="inputPrecoProduto" required>
                        <span></span>
                    </div>
                    <div class="labelInputUni">
                        <label for="inputDescricaoProduto">Descrição</label>
                        <textarea placeholder="Descreva o produto..." name="desc-produto" id="inputDescricaoProduto" minlength="1" maxlength="500" required></textarea>
                        <span></span>
                        <span class="contadorDescricao" id="contadorDescricaoAddProduto">0/500</span>
                    </div>
                    <div class="labelInputUni">
                        <label for="inputEstoqueProduto">Estoque</label>
                        <input type="number" name="estoque-produto" id="inputEstoqueProduto" min="1" value="1" required>
                        <span></span>
                    </div>
                    <div class="containerBotoesCriarCancelarFormAdd">
                        <input type="reset" class="botaoFormAdd" value="Cancelar">
                        <input type="submit" class="botaoFormAdd" value="+ Adicionar produto">
                    </div>
            </form>
        </div>
        <!-- Fim da tela de adicionar produto -->
        <div class="gerenciamento">
            <h1>Produtos</h1>
            <p>Gerenciamento dos produtos do IFsports</p>

            <button id="add_produto" class="botaoEditar">Adicionar produto</button>
        </div>

        <!--Alguém vai ter que ajeitar os nomes dessas classes-->

        <div class="produtos">
            <?php
            while ($produto = $produtos->fetch_assoc()):
                ?>
                <div class="produto">
                    <div class="divProduto"><img src="../uploads/<?= htmlspecialchars($produto['imagem']) ?>"
                                                 alt="Foto produto" class="usuario"></div>

                    <div class="infosProduto">
                        <p>ID: <?= $produto['id_produtos'] ?></p>
                        <h3>Produto: <?= $produto['nome'] ?></h3>
                        <p>Valor: R$ <?= $produto['preco'] ?></p>
                    </div>

                    <div class="bu">
                        <form style="width: 100%;display: inline-flex" method="POST" action=""
                              onsubmit="return confirm('Tem certeza de que deseja remover este produto do catálogo?');">

                            <input type="hidden" name="id"
                                   value="<?= (int)$produto["id_produtos"] ?>">

                            <button type="submit" class="botaoExcluir">Remover produto</button>
                        </form>
                        <button class="botaoEditar" id="BotaoEditar">Editar produto</button>
                        <div class="modal" id="modal">

                                <div class="modalconteudo-Produtos">

                                    <div class="modalIMG-Produtos"><img src="uploads/<?=htmlspecialchars($produto['imagem'])?>" alt="Foto produto"></div>
                                    <div class="Lapis">
                                        <i class="fa-solid fa-pencil"></i>
                                    </div>
                                    <form action="../Rotas/editar_produto.php" method="post">
                                        <div class="camposProdutos">
                                            <h4>Nome do Produto</h4>
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($produto['id_produtos']) ?>">
                                            <input type="text" name="nome" id="" class="inforProduto" value="<?= htmlspecialchars($produto['nome']) ?>">


                                            <h4>Preço</h4>
                                            <div class="preco">
                                                <i class="fa-solid fa-dollar-sign"></i>
                                                <input type="number" step="0.01" min="0" value="<?= htmlspecialchars($produto['preco']) ?>" id="" name="preco" class="inforProduto">
                                            </div>

                                            <h4>Descrição</h4>
                                            <textarea name="descricao" id="" class="inforProduto"><?= $produto['descricao'] ?></textarea>
                                            <h4>Estoque</h4>
                                            <input type="number" name="estoque" id="" class="inforProduto" value="<?= htmlspecialchars($produto['estoque']) ?>">
                                        </div>
                                        <div class="botoesProdutos">
                                            <button class="botaoProdutosCan">Cancelar</button> <button class="botaoProdutos">Salvar Alterações</button>
                                        </div>
                                    </form>

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
<script src="../JS/produtos.js"></script>
</html>