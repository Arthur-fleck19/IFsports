<?php
session_start();

if(!isset($_SESSION["tipo"])){
    header("Location: login.php");
    exit();
}
require_once("../Classes/Carrinho_gerenciamento.php");
require_once "../Classes/Carrinho_gerenciamento.php";

$quant_carrinho = Carrinho_gerenciamento::get_quant_prod_carrinho_usuario($_SESSION["id"]);
$resultado = Carrinho_gerenciamento::consultar_carrinho($_SESSION["id"]);
$carrinho = $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];
$subtotal = Carrinho_gerenciamento::get_subtotal();
$carrinho_vazio = empty($carrinho);
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
    <link rel="stylesheet" href="../CSS/carrinho.css">
    <title>Carrinho</title>
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
            <li><a href="carrinho.php" class="iconeSite"><i class="fa-solid fa-cart-shopping fa-2xl"></i></a><?= ((int) $quant_carrinho > 0) ? "<span class='contadorCarrinho'>" . ($quant_carrinho > 99 ? '+99' : (int) $quant_carrinho) . "</span>" : "" ?></li>
            <li><a href="" class="iconeSite Usuario"><i class="fa-solid fa-circle-user fa-2xl"></i></a></li>
        </ul>
    </nav>
</header>

<section class="container">
    <div>
        <div class="notificacao" id="notificacao"></div>

        <h1 class="gerenciamento">Carrinho</h1>

        <div class="carrinhos-criados">

            <?php
            if(!$carrinho_vazio):
                foreach($carrinho as $produto):
            ?>
                    <div class="carrinho-criado">
                        <div class="divCarrinho">
                            <img src="../uploads/<?= htmlspecialchars($produto['imagem']) ?>" alt="Foto produto" class="usuario">
                        </div>

                        <div class="divProduto">
                            <h1><?= htmlspecialchars($produto['nome']) ?></h1>
                            <p><?= htmlspecialchars($produto['descricao']) ?></p>
                            <p class="Estoque">Estoque: <?= htmlspecialchars($produto['estoque']) ?></p>
                        </div>

                        <div class="InformacoesCompra">
                            <div class="Valor">
                                <p>R$ <?= htmlspecialchars(((float)$produto['quantidade'] * (int)$produto['preco'])) ?></p>
                            </div>

                            <form class="formQuantidade" action="../Rotas/remover_do_carrinho.php" method="post">
                                <div class="controleQuantidade" >
                                    <input type="hidden" name="id_produto" value="<?=htmlspecialchars($produto['id_produtos'])?>">
                                    <input type="hidden" name="id_item_carrinho" value="<?=htmlspecialchars($produto['id_item_carrinho'])?>">
                                    <input type="hidden" name="quantidade" value="1">

                                    <input formaction="../Rotas/subtrair_carrinho.php" type="submit" value="-" class="botaoSubtrair">
                                    <p class="quantidadeAtual"><?= htmlspecialchars($produto['quantidade']) ?></p>
                                    <input formaction="../Rotas/add_carrinho.php" type="submit" value="+" class="botaoSomar">
                                </div>

                                <button type="submit" class="remover"><i class="fa-solid fa-trash Delete"></i></button>

                            </form>
                        </div>
                    </div>
            <?php
                endforeach;
                else:
            ?>
            <p>O carrinho está vazio</p>
            <?php
                endif;
            ?>
        </div>
    </div>

    <?php
    if(!$carrinho_vazio):
    ?>
    <div class="Resumo-pedido">
        <div class="DivInformacao">

            <h1>Resumo do pedido</h1>
            <hr>

            <div><p>Subtotal (<?= htmlspecialchars(Carrinho_gerenciamento::get_quant_prod_carrinho_usuario($_SESSION['id'])) ?> iten(s))</p> <p class="Final">R$ <?= htmlspecialchars($subtotal) ?></p>  </div>
            <div><p>Frete</p> <p class="Frete">a calcular</p></div>
            <hr>

            <div><h1>Total</h1> <h1 class="Frete">R$ <?= htmlspecialchars($subtotal) ?></h1></div>

            <button onclick="window.location.href='finalizar_compra.php'" type="button" class="BotaoFinalizar">
                <i class="fa-solid fa-lock"></i> Finalizar Compra
            </button>

        </div>
    </div>
    <?php
        endif;
    ?>
</section>
<script src="../JS/carrinho.js"></script>
<script src="../JS/notificacao_carrinho.js"></script>
</body>

</html>