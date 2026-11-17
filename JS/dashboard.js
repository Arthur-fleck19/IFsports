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