<?php
session_start();

if(!isset($_SESSION["tipo"])){
    header("Location: login.html");
    exit();
}

require_once "../Classes/Carrinho_gerenciamento.php";

$produtos = Carrinho_gerenciamento::consultar_carrinho($_SESSION["id"]);
$quant_carrinho = Carrinho_gerenciamento::get_quant_prod_carrinho_usuario($_SESSION["id"]);
$subtotal = Carrinho_gerenciamento::get_subtotal();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/dashboard.css">
    <link rel="icon" href="Imagens/logoIF.png">
    <link rel="stylesheet" href="../CSS/finalizar_compra.css">
    <title>Finalizar Pedido</title>
</head>
<body>
<header class="cabecalho">
    <a href="dashboard.php"><img src="Imagens/logoIFsports.png" alt="Logo IFsports" height="70px" width="170px" class="logoIFsportsImg"></a>
    <form class="containerInputLupa">
        <input type="text" name="pesquisa" id="inputPesquisa" class="inputPesquisa" placeholder="Digite sua pesquisa...">
        <button type="submit" class="lupaInput"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
    </form>
    <nav>
        <ul class="icones">
            <li><a href="carrinho.php" class="iconeSite"><i class="fa-solid fa-cart-shopping fa-2xl"></i></a><?= ((int) $quant_carrinho > 0) ? "<span class='contadorCarrinho'>" . ($quant_carrinho > 99 ? '+99' : (int) $quant_carrinho) . "</span>" : "" ?></li>
            <?php
            if($_SESSION['tipo'] != 'admin'){
                echo '<li><a href="perfil.php" class="iconeSite"><i class="fa-solid fa-circle-user fa-2xl"></i></a></li>';
            }else{
                echo '<li><a href="perfil.php" class="iconeSite Usuario"><i class="fa-solid fa-circle-user fa-2xl"></i></a></li>';
            }
            ?>
        </ul>
    </nav>
</header>
<main class="container">
    <h1 class="tituloPagina">Finalizar compra</h1>

    <form action="../Rotas/finalizar_pedido.php" method="POST" class="checkout">

        <div class="checkoutEtapas">

            <!-- ENDEREÇO -->
            <section class="cartao" aria-labelledby="tituloEndereco">
                <h2 id="tituloEndereco" class="cartaoTitulo">
                    <i class="fa-solid fa-location-dot"></i> Endereço de entrega
                </h2>

                <div class="camposEndereco">
                    <div class="campo campoCep">
                        <label for="cep" class="sr-only">CEP</label>
                        <input class="inputsTexto" type="text" name="cep" id="cep" placeholder="CEP" maxlength="9" autocomplete="postal-code" inputmode="numeric">
                        <button type="button" id="btnBuscarCep" class="btnBuscar">
                            <i class="fa-solid fa-magnifying-glass"></i> Buscar
                        </button>
                    </div>

                    <div class="campo campoCheio">
                        <label for="rua" class="sr-only">Rua / Avenida</label>
                        <input class="inputsTexto" type="text" name="rua" id="rua" placeholder="Rua / Avenida" autocomplete="address-line1">
                    </div>

                    <div class="campo">
                        <label for="numero" class="sr-only">Número</label>
                        <input class="inputsTexto" type="number" name="numero" id="numero" placeholder="Número" min="1">
                    </div>

                    <div class="campo">
                        <label for="complemento" class="sr-only">Complemento</label>
                        <input class="inputsTexto" type="text" name="complemento" id="complemento" placeholder="Complemento" autocomplete="address-line2">
                    </div>

                    <div class="campo">
                        <label for="bairro" class="sr-only">Bairro</label>
                        <input class="inputsTexto" type="text" name="bairro" id="bairro" placeholder="Bairro">
                    </div>

                    <div class="campo">
                        <label for="cidade" class="sr-only">Cidade</label>
                        <input class="inputsTexto" type="text" name="cidade" id="cidade" placeholder="Cidade" autocomplete="address-level2">
                    </div>

                    <div class="campo campoUf">
                        <label for="uf" class="sr-only">UF</label>
                        <select name="uf" id="uf" autocomplete="address-level1">
                            <option value="" selected disabled>UF</option>
                            <?php
                            $ufs = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
                            foreach ($ufs as $uf) {
                                echo "<option value=\"$uf\">$uf</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="campo campoCheio">
                        <label for="destinatario" class="sr-only">Nome de quem receberá o pedido</label>
                        <input class="inputsTexto" type="text" name="destinatario" id="destinatario" placeholder="Nome de quem receberá o pedido" autocomplete="name">
                    </div>
                </div>
            </section>

            <!-- ENTREGA -->
            <section class="cartao" aria-labelledby="tituloEntrega">
                <h2 id="tituloEntrega" class="cartaoTitulo">
                    <i class="fa-solid fa-truck"></i> Forma de entrega
                </h2>

                <div class="opcoes opcoesEntrega">
                    <label class="opcao" for="padrao">
                        <input type="radio" name="entrega" id="padrao" value="padrao" checked>
                        <i class="fa-solid fa-truck-fast opcaoIcone"></i>
                        <span class="opcaoTexto">
                            <strong>Entrega padrão</strong>
                            <small id="prazoPadrao">Receba em até 7 dias úteis</small>
                        </span>
                        <span class="opcaoValor" id="valorPadrao">Grátis</span>
                    </label>

                    <label class="opcao" for="expressa">
                        <input type="radio" name="entrega" id="expressa" value="expressa">
                        <i class="fa-solid fa-bolt opcaoIcone"></i>
                        <span class="opcaoTexto">
                            <strong>Entrega expressa</strong>
                            <small id="prazoExpressa">Receba em até 3 dias úteis</small>
                        </span>
                        <span class="opcaoValor" id="valorExpressa">R$ 19,90</span>
                    </label>
                </div>
            </section>

            <!-- PAGAMENTO -->
            <section class="cartao" aria-labelledby="tituloPagamento">
                <h2 id="tituloPagamento" class="cartaoTitulo">
                    <i class="fa-solid fa-credit-card"></i> Forma de pagamento
                </h2>

                <div class="opcoes opcoesPagamento">
                    <label class="opcao" for="credito">
                        <input type="radio" name="pagamento" id="credito" value="credito" required>
                        <i class="fa-regular fa-credit-card opcaoIcone"></i>
                        <span class="opcaoTexto"><strong>Cartão de crédito</strong></span>
                    </label>

                    <label class="opcao" for="pix">
                        <input type="radio" name="pagamento" id="pix" value="pix">
                        <i class="fa-brands fa-pix opcaoIcone"></i>
                        <span class="opcaoTexto"><strong>PIX</strong></span>
                    </label>

                    <label class="opcao" for="boleto">
                        <input type="radio" name="pagamento" id="boleto" value="boleto">
                        <i class="fa-solid fa-barcode opcaoIcone"></i>
                        <span class="opcaoTexto"><strong>Boleto bancário</strong></span>
                    </label>
                </div>
            </section>
        </div>

        <!-- RESUMO -->
        <aside class="resumoPedido cartao" aria-labelledby="tituloResumo">
            <h2 id="tituloResumo" class="cartaoTitulo">Resumo do pedido</h2>

            <ul class="listaProdutos">
                <?php while($produto = $produtos->fetch_assoc()): ?>
                    <li class="produto">
                        <img src="../uploads/<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['descricao']) ?>">
                        <div class="produtoInfo">
                            <h3><?= htmlspecialchars($produto['nome_produto']) ?></h3>
                            <p><?= (int)$produto['quantidade'] ?> unidade<?= (int)$produto['quantidade'] > 1 ? 's' : '' ?></p>
                        </div>
                        <span class="produtoPreco">
                            R$ <?= number_format((float)$produto['preco'] * (int)$produto['quantidade'], 2, ',', '.') ?>
                        </span>
                    </li>
                <?php endwhile; ?>
            </ul>

            <dl class="valoresResumo">
                <div class="linhaResumo">
                    <dt>Subtotal</dt>
                    <dd>R$ <?= number_format((float)$subtotal, 2, ',', '.') ?></dd>
                </div>
                <div class="linhaResumo">
                    <dt>Frete</dt>
                    <dd id="frete">Grátis</dd>
                </div>
                <div class="linhaResumo linhaTotal">
                    <dt>Total</dt>
                    <dd id="totalPedido">R$ <?= number_format((float)$subtotal, 2, ',', '.') ?></dd>
                </div>
            </dl>

            <input type="hidden" name="valor_total" id="inputValorTotal" data-subtotal="<?= (float)$subtotal ?>" value="<?= (float)$subtotal ?>">

            <button type="submit" class="btnFinalizar">
                <i class="fa-solid fa-lock"></i> Finalizar pedido
            </button>
            <p class="compraSegura">
                <i class="fa-solid fa-shield-halved"></i> Compra segura
            </p>
        </aside>

    </form>
</main>

<script src="../JS/finalizar_compra.js"></script>
</body>
</html>