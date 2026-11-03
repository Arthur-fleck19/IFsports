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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="../CSS/dashboard.css">
    <link rel="icon" href="Imagens/logoIF.png">
    <link rel="stylesheet" href="../CSS/produtos.css">
    <title>Dashboard</title>
</head>
<body>
    <header class="cabecalho">
        <a href="dashboard.php"><img src="Imagens/logoIFsports.png" alt="Logo IFsports" height="70px" width="170px" class="logoIFsportsImg"></a>
        <form class="containerInputLupa">
            <input type="text" name="" id="" class="inputPesquisa" placeholder="Digite sua pesquisa...">
            <button type="submit" class="lupaInput"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
        </form>
        <nav>
            <ul class="icones">
                <li><a href="" class="iconeSite"><i class="fa-solid fa-cart-shopping fa-2xl"></i></a><span class="contadorCarrinho">1</span></li>
                <li><a href="perfil.php" class="iconeSite Usuario"><i class="fa-solid fa-circle-user fa-2xl"></i></a></li>
            </ul>
        </nav>
    </header>
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
                    <div class="modalIMG-addProdutos">
                        <img class="botaoAtivarInputFile" src="Imagens/imagem_adicionar_imagem_produto_input_file.jpg" alt="Imagem input adicionar imagem" height="100px" width="100px">
                        <label for="inputImagemAddProduto" hidden>Imagem do produto</label>
                        <input type="file" name="imagem" class="inputImagem" id="inputImagemAddProduto" accept="image/png, image/jpeg, image/webp" required hidden>
                    </div>
                    <div class="tituloParagrafoAddProduto">
                        <h2>Adicionar produto</h2>
                        <p>Selecione uma imagem clicando no botão ao lado e preencha as informações do produto para adicioná-lo ao seu catálogo.</p>
                        <span></span>
                    </div>
                </header>
                <div class="labelInputUni">
                    <label for="inputNomeAddProduto">Nome do Produto</label>
                    <input type="text" class="inputNome" minlength="1" maxlength="150" placeholder="Ex.: Bola de vôlei" name="nome-produto" id="inputNomeAddProduto" required>
                    <span></span>
                </div>
                <div class="labelInputUni">
                    <label for="inputTipoAddProduto">Tipo</label>
                    <i class="fa-solid fa-volleyball fa-xl" id="iconeTipoAddProduto"></i>
                    <select name="tipo-produto" id="inputTipoAddProduto" required>
                        <option value="" disabled selected>Selecione o tipo</option>
                        <option value="Camisas">Camisas</option>
                        <option value="Tênis">Tênis</option>
                        <option value="Bolas">Bolas</option>
                        <option value="Equipamentos">Equipamentos</option>
                    </select>
                    <span></span>
                </div>
                <div class="labelInputUni">
                    <label for="inputPrecoAddProduto">Preço</label>
                    <input type="number" step="0.01" min="0.01" max="99999999.99" name="preco-produto" placeholder="R$ 0,01" id="inputPrecoAddProduto" required>
                    <span></span>
                </div>
                <div class="labelInputUni">
                    <label for="inputDescricaoAddProduto">Descrição</label>
                    <textarea placeholder="Descreva o produto..." name="desc-produto" id="inputDescricaoAddProduto" minlength="1" maxlength="500" required></textarea>
                    <span></span>
                    <span class="contadorDescricao" id="contadorDescricaoAddProduto">0/500</span>
                </div>
                <div class="labelInputUni">
                    <label for="inputEstoqueAddProduto">Estoque</label>
                    <input type="number" name="estoque-produto" id="inputEstoqueAddProduto" min="1" value="1" required>
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
            <h2>Produtos</h2>
            <p>Gerenciamento dos produtos do IFsports</p>
            <button id="add_produto" class="botaoEditar">Adicionar produto</button>
        </div>
        <!--Alguém vai ter que ajeitar os nomes dessas classes-->
        <div class="produtos">
            <?php while ($produto = $produtos->fetch_assoc()): ?>
                <div class="produto">
                    <div class="divProduto">
                        <img src="../uploads/<?= htmlspecialchars($produto['imagem']) ?>" alt="Foto produto" class="usuario">
                    </div>
                    <div class="infosProduto">
                        <p>ID: <?= $produto['id_produtos'] ?></p>
                        <h3>Produto: <?= $produto['nome'] ?></h3>
                        <p>Valor: R$ <?= $produto['preco'] ?></p>
                    </div>
                    <div class="bu">
                        <form style="width: 100%; display: inline-flex;" method="POST" action="" onsubmit="return confirm('Tem certeza de que deseja remover este produto do catálogo?');">
                            <input type="hidden" name="id" value="<?= $produto["id_produtos"] ?>">
                            <button type="submit" class="botaoExcluir">Remover produto</button>
                        </form>
                        <button class="botaoEditar" id="BotaoEditar">Editar produto</button>
                        <div class="modal" id="<?= "editar-produto" . $produto['id_produtos'] ?>">
                            <form action="../Rotas/editar_produto.php" method="post" id="<?= "formEditarProduto" . $produto['id_produtos'] ?>" class="modalconteudo-Produtos" enctype="multipart/form-data" novalidate>
                                <header>
                                    <div class="modalIMG-editarProdutos">
                                        <div>
                                            <img src="../uploads/<?= htmlspecialchars($produto['imagem']) ?>" alt="Imagem input editar imagem" height="100px" width="100px">
                                            <button type="button" class="botaoCamEditarProduto botaoAtivarInputFile"><i class="fa-regular fa-camera fa-xl"></i></button>
                                        </div>
                                        <label for="<?= "inputImagemEditarProduto" . $produto['id_produtos'] ?>" hidden>Imagem do produto</label>
                                        <input type="file" name="imagem" class="inputImagem" id="<?= "inputImagemEditarProduto" . $produto['id_produtos'] ?>" accept="image/png, image/jpeg, image/webp" required hidden>
                                    </div>
                                    <div class="tituloParagrafoEditarProduto">
                                        <h2>Editar produto</h2>
                                        <p>Altere as informações do produto.</p>
                                        <span></span>
                                    </div>
                                </header>
                                <div class="labelInputUni">
                                    <label for="<?= "inputNomeEditarProduto" . $produto['id_produtos'] ?>">Nome do Produto</label>
                                    <input type="text" class="inputNome" minlength="1" maxlength="150" value="<?= $produto['nome'] ?>" placeholder="Ex.: Bola de vôlei" name="nome-produto" id="<?= "inputNomeEditarProduto" . $produto['id_produtos'] ?>" required>
                                    <span></span>
                                </div>
                                <div class="labelInputUni">
                                    <label for="<?= "inputTipoEditarProduto" . $produto['id_produtos'] ?>">Tipo</label>
                                    <i class="fa-solid fa-volleyball fa-xl" id="<?= "iconeTipoEditarProduto" . $produto['id_produtos'] ?>"></i>
                                    <select name="tipo-produto" id="<?= "inputTipoEditarProduto" . $produto['id_produtos'] ?>" required>
                                        <option value="" disabled>Selecione o tipo</option>
                                        <option value="Camisas" <?= $produto['tipo'] === "Camisas" ? "selected" : "" ?>>Camisas</option>
                                        <option value="Tênis" <?= $produto['tipo'] === "Tênis" ? "selected" : "" ?>>Tênis</option>
                                        <option value="Bolas" <?= $produto['tipo'] === "Bolas" ? "selected" : "" ?>>Bolas</option>
                                        <option value="Equipamentos" <?= $produto['tipo'] === "Equipamentos" ? "selected" : "" ?>>Equipamentos</option>
                                    </select>
                                    <span></span>
                                </div>
                                <div class="labelInputUni">
                                    <label for="<?= "inputPrecoEditarProduto" . $produto['id_produtos'] ?>">Preço</label>
                                    <input type="number" step="0.01" min="0.01" max="99999999.99" name="preco-produto" value="<?= $produto['preco'] ?>" placeholder="R$ 0,01" id="<?= "inputPrecoEditarProduto" . $produto['id_produtos'] ?>" required>
                                    <span></span>
                                </div>
                                <div class="labelInputUni">
                                    <label for="<?= "inputDescricaoEditarProduto" . $produto['id_produtos'] ?>">Descrição</label>
                                    <textarea placeholder="Descreva o produto..." name="desc-produto" id="<?= "inputDescricaoEditarProduto" . $produto['id_produtos'] ?>" minlength="1" maxlength="500" required><?= $produto['descricao'] ?></textarea>
                                    <span></span>
                                    <span class="contadorDescricao" id="<?= "contadorDescricaoEditarProduto" . $produto['id_produtos'] ?>">0/500</span>
                                </div>
                                <div class="labelInputUni">
                                    <label for="<?= "inputEstoqueEditarProduto" . $produto['id_produtos'] ?>">Estoque</label>
                                    <input type="number" name="estoque-produto" id="<?= "inputEstoqueEditarProduto" . $produto['id_produtos'] ?>" min="1" value="<?= $produto['estoque'] ?>" required>
                                    <span></span>
                                </div>
                                <div class="containerBotoesCriarCancelarFormEditar">
                                    <input type="reset" class="botaoFormEditar" value="Cancelar">
                                    <button type="submit" class="botaoFormEditar"><i class="fa-regular fa-floppy-disk fa-xl"></i> Salvar alterações</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </main>
</body>
<script src="../JS/produtos.js"></script>
</html>