<?php
    session_start();
    require_once("../Classes/Produtos_gerenciamento.php");
    require_once "../Classes/Carrinho_gerenciamento.php";

    if($_SESSION['tipo'] != 'admin'){
        header('Location: dashboard.php');
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['id'])){
            $id = $_POST['id'];
            Produtos_gerenciamento::excluir($id);
        }
    }

$quant_carrinho = Carrinho_gerenciamento::get_quant_prod_carrinho_usuario($_SESSION["id"]);
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
    <title>Dashboard de produtos</title>
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
            <form action="../Rotas/criar_produto.php" method="post" id="formAddProduto" class="modalconteudo-Produtos" enctype="multipart/form-data" novalidate data-imagem-obrigatoria="true">
                <header>
                    <div class="modalIMG-addProdutos">
                        <img class="botaoAtivarInputFile previewImagemProduto" src="Imagens/imagem_adicionar_imagem_produto_input_file.jpg" alt="Adicionar imagem do produto" height="100" width="100">
                        <label for="inputImagemAddProduto" hidden>Imagem do produto</label>
                        <input type="file" name="imagem" class="inputImagem" id="inputImagemAddProduto" accept="image/png, image/jpeg, image/webp" required hidden>
                    </div>
                    <div class="tituloParagrafoAddProduto">
                        <h2>Adicionar produto</h2>
                        <p>Selecione uma imagem clicando no botão ao lado e preencha as informações do produto para adicioná-lo ao seu catálogo.</p>
                        <span class="mensagemErroImagem"></span>
                    </div>
                </header>
                <div class="labelInputUni">
                    <label for="inputNomeAddProduto">Nome do Produto</label>
                    <input type="text" class="inputNome inputForm" minlength="1" maxlength="150" placeholder="Ex.: Bola de vôlei" name="nome-produto" id="inputNomeAddProduto" required>
                    <span></span>
                </div>
                <div class="labelInputUni">
                    <label for="inputTipoAddProduto">Tipo</label>
                    <i class="fa-solid fa-volleyball fa-xl"></i>
                    <select name="tipo-produto" class="selectTipo inputForm" id="inputTipoAddProduto" required>
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
                    <input type="number" step="0.01" min="0.01" max="99999999.99" name="preco-produto" placeholder="R$ 0,01" class="inputPreco inputForm" id="inputPrecoAddProduto" required>
                    <span></span>
                </div>
                <div class="labelInputUni">
                    <label for="inputDescricaoAddProduto">Descrição</label>
                    <textarea placeholder="Descreva o produto..." name="desc-produto" class="textareaDescricao inputForm" id="inputDescricaoAddProduto" minlength="1" maxlength="500" required></textarea>
                    <span></span>
                    <span class="contadorDescricao" id="contadorDescricaoAddProduto">0/500</span>
                </div>
                <div class="labelInputUni">
                    <label for="inputEstoqueAddProduto">Estoque</label>
                    <input type="number" name="estoque-produto" class="inputEstoque inputForm" id="inputEstoqueAddProduto" min="1" value="1" required>
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
        <div class="produtos">
            <?php while($produto = $produtos->fetch_assoc()): ?>
                <div class="produto">
                    <div class="divProduto">
                        <img src="../uploads/<?= htmlspecialchars($produto['imagem'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?>" class="usuario">
                    </div>
                    <div class="infosProduto">
                        <p>ID: <?= (int)$produto['id_produtos'] ?></p>
                        <h3>Produto: <?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <p>Valor: R$ <?= htmlspecialchars((string)$produto['preco'], ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                    <div class="bu">
                        <form style="width: 100%; display: inline-flex;" method="POST" action="" onsubmit="return confirm('Tem certeza de que deseja remover este produto do catálogo?');">
                            <input type="hidden" name="id" value="<?= (int)$produto['id_produtos'] ?>">
                            <button type="submit" class="botaoExcluir">Remover produto</button>
                        </form>
                        <button type="button" class="botaoEditar botaoAbrirEdicao">Editar produto</button>
                        <div class="modal" id="<?= 'editar-produto' . (int)$produto['id_produtos'] ?>">
                            <form action="../Rotas/editar_produto.php" method="post" class="formEditarProduto modalconteudo-Produtos" id="<?= 'formEditarProduto' . (int)$produto['id_produtos'] ?>" enctype="multipart/form-data" novalidate data-imagem-obrigatoria="false">
                                <input type="hidden" name="id" value="<?= (int)$produto['id_produtos'] ?>">
                                <header>
                                    <div class="modalIMG-editarProdutos">
                                        <div class="containerPreviewImagem">
                                            <img class="previewImagemProduto" src="../uploads/<?= htmlspecialchars($produto['imagem'], ENT_QUOTES, 'UTF-8') ?>" alt="Imagem atual do produto" height="100" width="100">
                                            <button type="button" class="botaoCamEditarProduto botaoAtivarInputFile" aria-label="Alterar imagem do produto">
                                                <i class="fa-regular fa-camera fa-xl"></i>
                                            </button>
                                        </div>
                                        <label for="<?= 'inputImagemEditarProduto' . (int)$produto['id_produtos'] ?>" hidden>Imagem do produto</label>
                                        <input type="file" name="imagem" class="inputImagem" id="<?= 'inputImagemEditarProduto' . (int)$produto['id_produtos'] ?>" accept="image/png, image/jpeg, image/webp" hidden>
                                    </div>
                                    <div class="tituloParagrafoEditarProduto">
                                        <h2>Editar produto</h2>
                                        <p>Altere as informações do produto.</p>
                                        <span class="mensagemErroImagem"></span>
                                    </div>
                                </header>
                                <div class="labelInputUni">
                                    <label for="<?= 'inputNomeEditarProduto' . (int)$produto['id_produtos'] ?>">Nome do Produto</label>
                                    <input type="text" class="inputNome inputForm" minlength="1" maxlength="150" value="<?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?>" placeholder="Ex.: Bola de vôlei" name="nome" id="<?= 'inputNomeEditarProduto' . (int)$produto['id_produtos'] ?>" required>
                                    <span></span>
                                </div>
                                <div class="labelInputUni">
                                    <label for="<?= 'inputTipoEditarProduto' . (int)$produto['id_produtos'] ?>">Tipo</label>
                                    <i class="fa-solid fa-volleyball fa-xl"></i>
                                    <select name="tipo" class="selectTipo inputForm" id="<?= 'inputTipoEditarProduto' . (int)$produto['id_produtos'] ?>" required>
                                        <option value="" disabled>Selecione o tipo</option>
                                        <option value="Camisas" <?= $produto['tipo'] === "Camisas" ? "selected" : "" ?>>Camisas</option>
                                        <option value="Tênis" <?= $produto['tipo'] === "Tênis" ? "selected" : "" ?>>Tênis</option>
                                        <option value="Bolas" <?= $produto['tipo'] === "Bolas" ? "selected" : "" ?>>Bolas</option>
                                        <option value="Equipamentos" <?= $produto['tipo'] === "Equipamentos" ? "selected" : "" ?>>Equipamentos</option>
                                    </select>
                                    <span></span>
                                </div>
                                <div class="labelInputUni">
                                    <label for="<?= 'inputPrecoEditarProduto' . (int)$produto['id_produtos'] ?>">Preço</label><input type="number" step="0.01" min="0.01" max="99999999.99" name="preco" value="<?= htmlspecialchars((string)$produto['preco'], ENT_QUOTES, 'UTF-8') ?>" placeholder="R$ 0,01" class="inputPreco inputForm" id="<?= 'inputPrecoEditarProduto' . (int)$produto['id_produtos'] ?>" required>
                                    <span></span>
                                </div>
                                <div class="labelInputUni">
                                    <label for="<?= 'inputDescricaoEditarProduto' . (int)$produto['id_produtos'] ?>">Descrição</label>
                                    <textarea placeholder="Descreva o produto..." name="descricao" class="textareaDescricao inputForm" id="<?= 'inputDescricaoEditarProduto' . (int)$produto['id_produtos'] ?>" minlength="1" maxlength="500" required><?= htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8') ?></textarea>
                                    <span></span>
                                    <span class="contadorDescricao" id="<?= 'contadorDescricaoEditarProduto' . (int)$produto['id_produtos'] ?>">0/500</span>
                                </div>
                                <div class="labelInputUni">
                                    <label for="<?= 'inputEstoqueEditarProduto' . (int)$produto['id_produtos'] ?>">Estoque</label>
                                    <input type="number" name="estoque" class="inputEstoque inputForm" id="<?= 'inputEstoqueEditarProduto' . (int)$produto['id_produtos'] ?>" min="1" value="<?= (int)$produto['estoque'] ?>" required>
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