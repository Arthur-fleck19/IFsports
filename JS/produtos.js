const botoesEditar = document.querySelectorAll(".botaoEditar");
const modais = document.querySelectorAll('.modal');
const modal_novo_produto = document.getElementById('criar-produto');
const botao_novo_produto = document.getElementById('add_produto');
const cabecalho = document.querySelector('.cabecalho');
const formAddProduto = document.getElementById('formAddProduto');
const imgInputFileAddProduto = document.querySelector(".modalIMG-addProdutos img");
const spanMensagemErroInputFileAddProduto = document.querySelector(".tituloParagrafoAddProduto span");
const inputFileAddProduto = document.querySelector(".modalIMG-addProdutos input");
const inputNomeAddProduto = document.getElementById("inputNomeAddProduto");
const iconeTipoAddProduto = document.getElementById("iconeTipoAddProduto");
const inputTipoAddProduto = document.getElementById("inputTipoAddProduto");
const inputPrecoAddProduto = document.getElementById("inputPrecoAddProduto");
const inputDescricaoAddProduto = document.getElementById("inputDescricaoAddProduto");
const inputEstoqueAddProduto = document.getElementById("inputEstoqueAddProduto");
const contadorDescricaoAddProduto = document.getElementById("contadorDescricaoAddProduto");
const container_perfis = document.querySelector('body');
const tiposProdutosValidos = ["Camisas", "Tênis", "Bolas", "Equipamentos"];
const tiposImagensValidos = ["image/jpeg", "image/png", "image/webp"];
const camposFormAddProduto = [inputNomeAddProduto, inputTipoAddProduto, inputPrecoAddProduto, inputDescricaoAddProduto, inputEstoqueAddProduto];

contadorDescricaoAddProduto.textContent = inputDescricaoAddProduto.value.trim().length + "/500";

imgInputFileAddProduto.addEventListener("click", () => {
    inputFileAddProduto.click();
});

inputFileAddProduto.addEventListener("change", () => {
    validarImagemProduto(inputFileAddProduto);
});

botoesEditar.forEach(function (botao) {
    botao.addEventListener('click', () => {
        const modal = botao.closest('.bu').querySelector('.modal');

        modal.style.display = 'flex';
    });
});

modais.forEach(function (modal) {
    modal.addEventListener('click', (local) => {
        if(local.target === modal) {
            modal.style.display = 'none';
            cabecalho.style.opacity = '1';
            cabecalho.style.pointerEvents = '';
            cabecalho.style.zIndex = '';
            container_perfis.style.overflow = '';
        }
    });
});

botao_novo_produto.addEventListener('click', () => {
    modal_novo_produto.style.display = 'flex';
    cabecalho.style.opacity = '0.651';
    cabecalho.style.pointerEvents = 'none';
    cabecalho.style.zIndex = '0';
    container_perfis.style.overflow = 'hidden';
});

inputTipoAddProduto.addEventListener('change', () => {
    mudarCorOpcaoSelecionada(inputTipoAddProduto);
    mudarIconeOpcaoSelecionada(inputTipoAddProduto, iconeTipoAddProduto);
});

inputDescricaoAddProduto.addEventListener('input', () => {
    atualizarContadorDescricaoProduto(inputDescricaoAddProduto, contadorDescricaoAddProduto);
});

camposFormAddProduto.forEach((campoForm) => {
    campoForm.addEventListener("input", () => {
        limparErroCampoForm(campoForm);
    });
});

formAddProduto.addEventListener('reset', () => {
   inputTipoAddProduto.style.color = "#767676";
   iconeTipoAddProduto.className = "";
   contadorDescricaoAddProduto.textContent = "0/500";
   imgInputFileAddProduto.src = "Imagens/imagem_adicionar_imagem_produto_input_file.jpg";

   iconeTipoAddProduto.classList.add("fa-solid", "fa-volleyball", "fa-xl");

   limparTodosErrosCamposForm("form.modalconteudo-Produtos .labelInputUni > input, form.modalconteudo-Produtos .labelInputUni > select, form.modalconteudo-Produtos .labelInputUni > textarea");
});

formAddProduto.addEventListener('submit', (evento) => {
    const imagemProdutoValido = validarImagemProduto(inputFileAddProduto);
    const nomeProdutoValido = validarNomeProduto(inputNomeAddProduto);
    const tipoProdutoValido = validarTipoProduto(inputTipoAddProduto, tiposProdutosValidos);
    const precoProdutoValido = validarPrecoProduto(inputPrecoAddProduto);
    const descricaoProdutoValido = validarDescricaoProduto(inputDescricaoAddProduto);
    const estoqueProdutoValido = validarEstoqueProduto(inputEstoqueAddProduto);

    if(!(imagemProdutoValido && nomeProdutoValido && tipoProdutoValido && precoProdutoValido && descricaoProdutoValido && estoqueProdutoValido)) {
        evento.preventDefault();
    }
});

function mudarCorOpcaoSelecionada(inputSelect) {
    if(inputSelect.value === "") {
        inputSelect.style.color = "#767676";
    } else {
        inputSelect.style.color = "#000000";
    }
}

function mudarIconeOpcaoSelecionada(select, icone) {
    icone.className = "";

    switch(select.value) {
        case "Camisas":
            icone.classList.add("fa-solid", "fa-shirt", "fa-xl");
        break;

        case "Tênis":
            icone.classList.add("fa-solid", "fa-shoe-prints", "fa-xl");
        break;

        case "Bolas":
            icone.classList.add("fa-regular", "fa-futbol", "fa-xl");
        break;

        case "Equipamentos":
            icone.classList.add("fa-solid", "fa-table-tennis-paddle-ball", "fa-xl");
        break;
    }
}

function atualizarContadorDescricaoProduto(inputDescricao, contadorDescricao) {
    if(inputDescricao.value.trim().length <= 500) {
        contadorDescricao.textContent = inputDescricao.value.trim().length + "/500";
    } else {
        inputDescricao.value = inputDescricao.value.substring(0, 500);
        contadorDescricao.textContent = "500/500";
    }
}

function validarImagemProduto(inputFile) {
    if(inputFile.files.length > 0) {
        if(inputFile.files.length < 2) {
            const arquivoImgProduto = inputFile.files[0];

            if(tiposImagensValidos.includes(arquivoImgProduto.type)) {
                if(arquivoImgProduto.size <= 5242880) {
                    spanMensagemErroInputFileAddProduto.innerHTML = "";
                    imgInputFileAddProduto.src = URL.createObjectURL(arquivoImgProduto);

                    return true;
                } else {
                    spanMensagemErroInputFileAddProduto.innerHTML = "<i class='fa-solid fa-circle-exclamation'></i> Tamanho da imagem é muito grande, selecione uma imagem com menos de 5 MiB.";
                    imgInputFileAddProduto.src = "Imagens/imagem_erro_arquivo_imagem_produto.png";

                    return false;
                }
            } else {
                spanMensagemErroInputFileAddProduto.innerHTML = "<i class='fa-solid fa-circle-exclamation'></i> Tipo de imagem inválido.";
                imgInputFileAddProduto.src = "Imagens/imagem_erro_arquivo_imagem_produto.png";

                return false;
            }
        } else {
            spanMensagemErroInputFileAddProduto.innerHTML = "<i class='fa-solid fa-circle-exclamation'></i> Não selecione mais de um arquivo de imagem.";
            imgInputFileAddProduto.src = "Imagens/imagem_erro_arquivo_imagem_produto.png";

            return false;
        }
    } else {
        spanMensagemErroInputFileAddProduto.innerHTML = "<i class='fa-solid fa-circle-exclamation'></i> Selecione uma imagem para o produto.";

        return false;
    }
}

function validarNomeProduto(inputNome) {
    if(inputNome.value.trim().length === 0) {
        implementarErroCampoForm(inputNome, "Insira um nome para o produto.");

        return false;
    } else if(inputNome.value.trim().length > 150) {
        implementarErroCampoForm(inputNome, "Não passe de 150 caracteres.");

        return false;
    }

    limparErroCampoForm(inputNome);

    return true;
}

function validarTipoProduto(inputTipo, tiposProdutosValidos) {
    if(!(tiposProdutosValidos.includes(inputTipo.value.trim()))) {
        implementarErroCampoForm(inputTipo, "Selecione um tipo de produto válido.");

        return false;
    }

    limparErroCampoForm(inputTipo);

    return true;
}

function validarPrecoProduto(inputPreco) {
    const precoTexto = inputPreco.value.trim().replaceAll(",", ".");

    if(precoTexto.length === 0) {
        implementarErroCampoForm(inputPreco, "Insira um preço para o produto.");

        return false;
    } else if(!(/^(0|[1-9]\d*)(\.\d{1,2})?$/.test(precoTexto))) {
        implementarErroCampoForm(inputPreco, "Texto de preço inválido.");

        return false;
    } else if(precoTexto.length > 11) {
        implementarErroCampoForm(inputPreco, "Não passe de 10 dígitos.");

        return false;
    } else if(parseFloat(precoTexto) <= 0) {
        implementarErroCampoForm(inputPreco, "Não use valor negativo ou nulo.");

        return false;
    } else if(parseFloat(precoTexto) > 99999999.99) {
        implementarErroCampoForm(inputPreco, "Não use valor maior que 99999999.99");

        return false;
    }

    limparErroCampoForm(inputPreco);

    return true;
}

function validarDescricaoProduto(inputDescricao) {
    if(inputDescricao.value.trim().length === 0) {
        implementarErroCampoForm(inputDescricao, "Insira uma descrição para o produto.");

        return false;
    } else if(inputDescricao.value.trim().length > 500) {
        implementarErroCampoForm(inputDescricao, "Não exceda 500 caracteres.");

        return false;
    }

    limparErroCampoForm(inputDescricao);

    return true;
}

function validarEstoqueProduto(inputEstoque) {
    if(!(/^[1-9]\d*$/.test(inputEstoque.value.trim()))) {
        implementarErroCampoForm(inputEstoque, "Insira um valor de estoque válido.");

        return false;
    }

    limparErroCampoForm(inputEstoque);

    return true;
}

function implementarErroCampoForm(campoForm, mensagemErro) {
    campoForm.classList.add("erroInput");
    campoForm.nextElementSibling.innerHTML = "<i class='fa-solid fa-circle-exclamation'></i> " + mensagemErro;
}

function limparErroCampoForm(campoForm) {
    campoForm.classList.remove("erroInput");
    campoForm.nextElementSibling.innerHTML = "";
}

function limparTodosErrosCamposForm(cssQuerySelector) {
    const inputsForm = document.querySelectorAll(cssQuerySelector);

    inputsForm.forEach((input) => {
        limparErroCampoForm(input);
    });
}