<?php
    session_start();

    if(!isset($_SESSION["tipo"])){
        header("Location: login.php");
        exit();
    }

    require_once "../Classes/Produtos_gerenciamento.php";
    require_once "../Classes/Carrinho_gerenciamento.php";

    $quant_carrinho = Carrinho_gerenciamento::get_quant_prod_carrinho_usuario($_SESSION["id"]);

    $pesquisa = trim($_GET['pesquisa'] ?? '');

if ($pesquisa != '') {
    $produtos = Produtos_gerenciamento::pesquisar_produtos($pesquisa);
} else {
    $produtos = Produtos_gerenciamento::get_produtos();
}

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
    <title>Dashboard</title>
</head>
<body>
    <header class="cabecalho">
        <a href="dashboard.php"><img src="Imagens/logoIFsports.png" alt="Logo IFsports" height="70px" width="170px" class="logoIFsportsImg"></a>
        <form class="containerInputLupa" method="GET" action="dashboard.php">
            <input type="text"
             name="pesquisa"
             id="inputPesquisa"
             class="inputPesquisa"
             placeholder="Digite sua pesquisa..."
              value="<?= htmlspecialchars($pesquisa, ENT_QUOTES, 'UTF-8') ?>">

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
    <main class="vitrineProdutos">
        <div class="botoesNav">
            <div class="grupoFiltros">
                <button class="botaoNav corFundoBotaoSelecionado" data-categoria="Todos">
                    <i class="fa-solid fa-globe fa-xl"></i>Todos
                </button>

                <button class="botaoNav" data-categoria="Camisas">
                    <i class="fa-solid fa-shirt fa-xl"></i>Camisas
                </button>

                <button class="botaoNav" data-categoria="Tênis">
                    <i class="fa-solid fa-shoe-prints fa-xl"></i>Tênis
                </button>

                <button class="botaoNav" data-categoria="Bolas">
                    <i class="fa-regular fa-futbol fa-xl"></i>Bolas
                </button>

                <button class="botaoNav" data-categoria="Equipamentos">
                    <i class="fa-solid fa-table-tennis-paddle-ball fa-xl"></i>Equipamentos
                </button>
            </div>

            <?php if ($_SESSION['tipo'] == 'admin'): ?>
                <div class="grupoAdmin">
                    <h1 class="admin">- ADM -</h1>

                    <button onclick="window.location.href='gerenciamento_usuarios.php'"
                            class="botaoNav botaoAdmin">
                        <i class="fa-solid fa-user fa-xl"></i>Usuários
                    </button>

                    <button onclick="window.location.href='produtos.php'"
                            class="botaoNav botaoAdmin">
                        <i class="fa-solid fa-box fa-xl"></i>Produtos
                    </button>
                </div>
            <?php endif; ?>
        </div>
        <div id="notificacao" class="notificacao"></div>
        <script src="../JS/notificacao_carrinho.js"></script>
        <section class="cardsProdutos">

    <?php if ($produtos && $produtos->num_rows > 0): ?>

        <?php while ($produto = $produtos->fetch_assoc()): ?>

            <a class="a-cardProduto" href="detalhesItem.php?id=<?= htmlspecialchars($produto['id_produtos']); ?>">
                <article class="cardProduto">
                    <img src="../uploads/<?= htmlspecialchars($produto['imagem']) ?>" alt="Imagem do produto" height="200px" width="80%" class="imagemProduto">
                    <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                    <span><span class="corRS">R$</span> <span class="corPreco"><?= htmlspecialchars($produto['preco']) ?></span></span>
                    <input type="hidden" name="categoria" class="produto-categoria" value="<?= htmlspecialchars($produto['tipo']) ?>">
                    <form action="../Rotas/add_carrinho.php" method="post">
                        <input type="hidden" name="id_produto" value="<?= htmlspecialchars($produto['id_produtos']); ?>">
                        <input type="hidden" name="quantidade" value="1">
                        <button type="submit" class="botaoAdCarrinho"><i class="fa-solid fa-cart-shopping fa-xl"></i>Adicionar</button>
                    </form>

                </article>
            </a>

        <?php endwhile; ?>

    <?php else: ?>

        <p class="mensagemSemProdutos">
            Nenhum produto encontrado.
        </p>

    <?php endif; ?>

        </section>
        <script>
            const botoesFiltro = document.querySelectorAll('.botaoNav[data-categoria]');
            const inputPesquisa = document.querySelector('#inputPesquisa');
            const formPesquisa = document.querySelector('.containerInputLupa');
            const vitrine = document.querySelector('.cardsProdutos');

            let categoriasSelecionadas = ['Todos'];
            let controladorBusca = null;
            let temporizadorBusca = null;

            // Atualiza a aparência dos botões de categoria
            function atualizarBotoes() {
                botoesFiltro.forEach(btn => {
                    btn.classList.toggle(
                        'corFundoBotaoSelecionado',
                        categoriasSelecionadas.includes(btn.dataset.categoria)
                    );
                });
            }

            // Filtra os cards que estão na vitrine NO MOMENTO (busca os cards a cada chamada)
            function aplicarFiltro() {
                vitrine.querySelectorAll('.a-cardProduto').forEach(card => {
                    const categoriaProduto = card.querySelector('.produto-categoria').value;
                    const visivel =
                        categoriasSelecionadas.includes('Todos') ||
                        categoriasSelecionadas.includes(categoriaProduto);

                    card.style.display = visivel ? 'flex' : 'none';
                });
            }

            // Clique nos botões de categoria
            botoesFiltro.forEach(botao => {
                botao.addEventListener('click', () => {
                    const categoria = botao.dataset.categoria;

                    if (categoria === 'Todos') {
                        categoriasSelecionadas = ['Todos'];
                    } else {
                        // Remove "Todos" ao escolher uma categoria específica
                        categoriasSelecionadas = categoriasSelecionadas.filter(cat => cat !== 'Todos');

                        // Alterna a categoria clicada
                        if (categoriasSelecionadas.includes(categoria)) {
                            categoriasSelecionadas = categoriasSelecionadas.filter(cat => cat !== categoria);
                        } else {
                            categoriasSelecionadas.push(categoria);
                        }

                        // Se não sobrou nenhuma, volta para "Todos"
                        if (categoriasSelecionadas.length === 0) {
                            categoriasSelecionadas = ['Todos'];
                        }
                    }

                    atualizarBotoes();
                    aplicarFiltro();
                });
            });

            // Pesquisa via fetch
            function pesquisar() {
                // Cancela a requisição anterior, se ainda estiver em andamento
                if (controladorBusca) {
                    controladorBusca.abort();
                }
                controladorBusca = new AbortController();

                const termo = inputPesquisa.value.trim();

                fetch('dashboard.php?pesquisa=' + encodeURIComponent(termo), {
                    signal: controladorBusca.signal
                })
                    .then(resposta => {
                        if (!resposta.ok) {
                            throw new Error('Resposta inválida: ' + resposta.status);
                        }
                        return resposta.text();
                    })
                    .then(html => {
                        const documento = new DOMParser().parseFromString(html, 'text/html');
                        const novosProdutos = documento.querySelector('.cardsProdutos');

                        if (!novosProdutos) {
                            throw new Error('Vitrine não encontrada na resposta.');
                        }

                        vitrine.innerHTML = novosProdutos.innerHTML;

                        // Reaplica os filtros de categoria nos novos cards
                        aplicarFiltro();
                    })
                    .catch(erro => {
                        if (erro.name === 'AbortError') return; // cancelamento esperado
                        console.error('Erro ao pesquisar produtos:', erro);
                    });
            }

            // Pesquisa enquanto o usuário digita (com debounce de 300ms)
            inputPesquisa.addEventListener('input', () => {
                clearTimeout(temporizadorBusca);
                temporizadorBusca = setTimeout(pesquisar, 300);
            });

            // Enter ou clique na lupa: pesquisa sem recarregar a página
            formPesquisa.addEventListener('submit', event => {
                event.preventDefault();
                clearTimeout(temporizadorBusca);
                pesquisar();
            });

            // Se a página abriu com ?pesquisa=..., o PHP já filtrou os produtos
            atualizarBotoes();
        </script>
    </main>
</body>
</html>