const modais = document.querySelectorAll(".modal");

const modalNovoProduto = document.getElementById("criar-produto");
const botaoNovoProduto = document.getElementById("add_produto");

const botoesEditar = document.querySelectorAll(".botaoAbrirEdicao");
const botoesAtivarInputFile = document.querySelectorAll(".botaoAtivarInputFile");

const cabecalho = document.querySelector(".cabecalho");
const corpo = document.body;

const formsProdutos = document.querySelectorAll("form.modalconteudo-Produtos");

const tiposProdutosValidos = ["Camisas", "Tênis", "Bolas", "Equipamentos"];
const tiposImagensValidos = ["image/jpeg", "image/png", "image/webp"];

const tamanhoMaximoImagem = 5 * 1024 * 1024;
/*contadoresDescricaoProduto.forEach(contadorDescricaoProduto => {
    contadorDescricaoProduto.textContent = contadorDescricaoProduto.previousElementSibling.previousElementSibling.value.length + "/500";
});*/

formsProdutos.forEach((form) => {
    const inputFile = form.querySelector(".inputImagem");

    inputFile.addEventListener("change", () => {
        validarImagemProduto(inputFile);
    });

    const selectTipo = form.querySelector(".selectTipo");
    const iconeTipo = selectTipo.previousElementSibling;

    selectTipo.addEventListener("change", () => {
        mudarCorOpcaoSelecionada(selectTipo);

        mudarIconeOpcaoSelecionada(selectTipo, iconeTipo);
    });

    // Inicializa a aparência de cada formulário.
    mudarCorOpcaoSelecionada(selectTipo);

    mudarIconeOpcaoSelecionada(selectTipo, iconeTipo);

    const descricao = form.querySelector(".textareaDescricao");
    const contador = form.querySelector(".contadorDescricao");

    atualizarContadorDescricaoProduto(descricao, contador);

    descricao.addEventListener("input", () => {
        atualizarContadorDescricaoProduto(descricao, contador);
    });

    // Limpa os erros enquanto o usuário altera os campos.
    const campos = form.querySelectorAll(".inputForm");

    campos.forEach((campo) => {
        campo.addEventListener("input", () => {
            limparErroCampoForm(campo);
        });

        campo.addEventListener("change", () => {
            limparErroCampoForm(campo);
        });
    });

    // Valida o formulário antes do envio.
    form.addEventListener("submit", (evento) => {
        const formularioValido = validarFormularioProduto(form);

        if (!formularioValido) {
            evento.preventDefault();
        }

    });

    const preview = form.querySelector(".previewImagemProduto");

    // Guarda a imagem que estava sendo exibida inicialmente.
    preview.dataset.imagemOriginal = preview.src;

    form.addEventListener("reset", () => {

        // Espera o navegador restaurar os valores originais dos campos.
        setTimeout(() => {

            // Restaura a imagem original.
            if (preview.dataset.urlObjeto) {
                URL.revokeObjectURL(preview.dataset.urlObjeto);

                delete preview.dataset.urlObjeto;
            }

            preview.src = preview.dataset.imagemOriginal;

            // Limpa erros dos campos.
            form.querySelectorAll(".inputForm").forEach((campo) => {
                limparErroCampoForm(campo);
            });

            // Limpa mensagem de erro da imagem.
            form.querySelector(".mensagemErroImagem").textContent = "";

            // Atualiza o contador da descrição.
            const descricao = form.querySelector(".textareaDescricao");

            const contador = form.querySelector(".contadorDescricao");

            atualizarContadorDescricaoProduto(descricao, contador);

            // Restaura a aparência do select e seu ícone.
            const selectTipo = form.querySelector(".selectTipo");

            const iconeTipo = selectTipo.previousElementSibling;

            mudarCorOpcaoSelecionada(selectTipo);

            mudarIconeOpcaoSelecionada(selectTipo, iconeTipo);

        }, 0);

    });
});

botoesAtivarInputFile.forEach((botao) => {
    botao.addEventListener("click", () => {
        const container = botao.closest(
            ".modalIMG-addProdutos, .modalIMG-editarProdutos"
        );

        const inputFile = container.querySelector(".inputImagem");

        inputFile.click();
    });
});

/*inputsFileImagemProduto.forEach((inputFileImagemProduto) => {
    inputFileImagemProduto.addEventListener("change", () => {
        validarImagemProduto(inputFileImagemProduto);
    });
});*/

botoesEditar.forEach((botaoEditar) => {
    botaoEditar.addEventListener("click", () => {
        console.log("fdfdg");
        const modal = botaoEditar.closest(".bu").querySelector(".modal");

        abrirModal(modal);
    });
});

modais.forEach((modal) => {
    console.log("fdfdg");
    modal.addEventListener("click", (evento) => {
        if (evento.target === modal) {
            fecharModal(modal);
        }
    });
});

botaoNovoProduto.addEventListener("click", () => {
    abrirModal(modalNovoProduto);
});

/*inputsTipoProduto.forEach((inputTipoProduto) => {
    inputTipoProduto.addEventListener("change", () => {
        mudarCorOpcaoSelecionada(inputTipoProduto);
        mudarIconeOpcaoSelecionada(inputTipoProduto, inputTipoProduto.previousElementSibling);
    });

    mudarCorOpcaoSelecionada(inputTipoProduto);
    mudarIconeOpcaoSelecionada(inputTipoProduto, inputTipoProduto.previousElementSibling);
});*/

/*inputsDescricaoProduto.forEach((inputDescricaoProduto) => {
    inputDescricaoProduto.addEventListener('input', () => {
        atualizarContadorDescricaoProduto(inputDescricaoProduto, inputDescricaoProduto.nextElementSibling.nextElementSibling);
    });
});*/

/*todosCamposFormsProdutos.forEach((campoForm) => {
    campoForm.addEventListener("input", () => {
        limparErroCampoForm(campoForm);
    });
});*/

/*formAddProduto.addEventListener('reset', () => {
   formAddProduto.querySelector(".selectTipo").style.color = "#767676";
   iconeTipoAddProduto.className = "";
   formAddProduto.querySelector(".contadorDescricao").textContent = "0/500";
   formAddProduto.querySelector(".botaoAtivarInputFile").src = "Imagens/imagem_adicionar_imagem_produto_input_file.jpg";

   iconeTipoAddProduto.classList.add("fa-solid", "fa-volleyball", "fa-xl");

   limparTodosErrosCamposForm("form.modalconteudo-Produtos .labelInputUni > input, form.modalconteudo-Produtos .labelInputUni > select, form.modalconteudo-Produtos .labelInputUni > textarea");
});*/

/*formAddProduto.addEventListener('submit', (evento) => {
    const imagemProdutoValido = validarImagemProduto(formAddProduto.querySelector(".inputImagem"));
    const nomeProdutoValido = validarNomeProduto(formAddProduto.querySelector(".inputNome"));
    const tipoProdutoValido = validarTipoProduto(formAddProduto.querySelector(".selectTipo"));
    const precoProdutoValido = validarPrecoProduto(formAddProduto.querySelector(".inputPreco"));
    const descricaoProdutoValido = validarDescricaoProduto(formAddProduto.querySelector(".textareaDescricao"));
    const estoqueProdutoValido = validarEstoqueProduto(formAddProduto.querySelector(".inputEstoque"));

    if(!(imagemProdutoValido && nomeProdutoValido && tipoProdutoValido && precoProdutoValido && descricaoProdutoValido && estoqueProdutoValido)) {
        evento.preventDefault();
    }
});*/

/*formsEditarProduto.forEach((formEditarProduto) => {
    formEditarProduto.addEventListener('submit', (evento) => {
        const imagemProdutoValido = validarImagemProduto(formEditarProduto.querySelector(".inputImagem"));
        const nomeProdutoValido = validarNomeProduto(formEditarProduto.querySelector(".inputNome"));
        const tipoProdutoValido = validarTipoProduto(formEditarProduto.querySelector(".selectTipo"));
        const precoProdutoValido = validarPrecoProduto(formEditarProduto.querySelector(".inputPreco"));
        const descricaoProdutoValido = validarDescricaoProduto(formEditarProduto.querySelector(".textareaDescricao"));
        const estoqueProdutoValido = validarEstoqueProduto(formEditarProduto.querySelector(".inputEstoque"));

        if(!(imagemProdutoValido && nomeProdutoValido && tipoProdutoValido && precoProdutoValido && descricaoProdutoValido && estoqueProdutoValido)) {
            evento.preventDefault();
        }
    });
});*/

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

        default:
            icone.classList.add("fa-solid", "fa-volleyball", "fa-xl");
    }
}

function atualizarContadorDescricaoProduto(inputDescricao, contadorDescricao) {
    if(inputDescricao.value.length <= 500) {
        contadorDescricao.textContent = inputDescricao.value.length + "/500";
    } else {
        inputDescricao.value = inputDescricao.value.substring(0, 500);
        contadorDescricao.textContent = "500/500";
    }
}

function validarImagemProduto(inputFile) {
    const form = inputFile.closest("form");

    const imagemObrigatoria =
        form.dataset.imagemObrigatoria === "true";

    const mensagemErro = form.querySelector(".mensagemErroImagem");

    const preview = form.querySelector(".previewImagemProduto");

    const arquivo = inputFile.files[0];

    // Verifica se o usuário selecionou uma imagem.
    if (!arquivo) {
        mensagemErro.textContent = imagemObrigatoria
            ? "Selecione uma imagem para o produto."
            : "";

        return !imagemObrigatoria;
    }

    // Verifica a quantidade de arquivos.
    if (inputFile.files.length !== 1) {
        mensagemErro.textContent = "Selecione apenas uma imagem.";

        return false;
    }

    // Verifica o formato da imagem.
    if (!tiposImagensValidos.includes(arquivo.type)) {
        mensagemErro.textContent = "Tipo de imagem inválido.";

        return false;
    }

    // Verifica o tamanho da imagem.
    if (arquivo.size > tamanhoMaximoImagem) {
        mensagemErro.textContent =
            "A imagem deve possuir no máximo 5 MiB.";

        return false;
    }

    // Libera uma URL temporária anterior, caso exista.
    if (preview.dataset.urlObjeto) {
        URL.revokeObjectURL(preview.dataset.urlObjeto);
    }

    // Cria uma URL temporária para a imagem selecionada.
    const urlImagem = URL.createObjectURL(arquivo);

    preview.src = urlImagem;

    preview.dataset.urlObjeto = urlImagem;

    mensagemErro.textContent = "";

    return true;
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

function validarTipoProduto(inputTipo) {
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
    } else if(inputDescricao.value.length > 500) {
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

function validarFormularioProduto(form) {

    const imagemValida = validarImagemProduto(
        form.querySelector(".inputImagem")
    );

    const nomeValido = validarNomeProduto(
        form.querySelector(".inputNome")
    );

    const tipoValido = validarTipoProduto(
        form.querySelector(".selectTipo")
    );

    const precoValido = validarPrecoProduto(
        form.querySelector(".inputPreco")
    );

    const descricaoValida = validarDescricaoProduto(
        form.querySelector(".textareaDescricao")
    );

    const estoqueValido = validarEstoqueProduto(
        form.querySelector(".inputEstoque")
    );

    return (
        imagemValida &&
        nomeValido &&
        tipoValido &&
        precoValido &&
        descricaoValida &&
        estoqueValido
    );
}

function abrirModal(modal) {
    modal.style.display = "flex";

    cabecalho.style.opacity = "0.651";
    cabecalho.style.pointerEvents = "none";

    corpo.style.overflow = "hidden";
}

function fecharModal(modal) {
    modal.style.display = "none";

    cabecalho.style.opacity = "1";
    cabecalho.style.pointerEvents = "";

    corpo.style.overflow = "";
}