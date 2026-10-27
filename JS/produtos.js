const botoesEditar = document.querySelectorAll(".botaoEditar");
const modais = document.querySelectorAll('.modal');
const modal_novo_produto = document.getElementById('criar-produto');
const botao_novo_produto = document.getElementById('add_produto');
const cabecalho = document.querySelector('.cabecalho');
const formAddProduto = document.getElementById('formAddProduto');
const imgInputFileAddProduto = document.querySelector(".modalIMG-Produtos img");
const inputFileAddProduto = document.querySelector(".modalIMG-Produtos input");
const inputNomeAddProduto = document.getElementById("inputNomeProduto");
const iconeTipoAddProduto = document.getElementById("iconeTipoAddProduto");
const inputTipoAddProduto = document.getElementById("inputTipoProduto");
const tiposProdutosValidos = ["Camisas", "Tênis", "Bolas", "Equipamentos"];
const inputPrecoAddProduto = document.getElementById("inputPrecoProduto");
const inputDescricaoAddProduto = document.getElementById("inputDescricaoProduto");
const inputEstoqueAddProduto = document.getElementById("inputEstoqueProduto");
const contadorDescricaoAddProduto = document.getElementById("contadorDescricaoAddProduto");
const container_perfis = document.querySelector('body');

contadorDescricaoAddProduto.textContent = inputDescricaoAddProduto.value.trim().length + "/500";

imgInputFileAddProduto.addEventListener("click", () => {
    inputFileAddProduto.click();
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
            modal.style.display = 'none'
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
    if(inputDescricaoAddProduto.value.trim().length <= 500) {
        contadorDescricaoAddProduto.textContent = inputDescricaoAddProduto.value.trim().length + "/500";
    } else {
        inputDescricaoAddProduto.value = inputDescricaoAddProduto.value.substring(0, 500);
        contadorDescricaoAddProduto.textContent = "500/500";
    }
});

formAddProduto.addEventListener('reset', () => {
   inputTipoAddProduto.style.color = "#767676";
   iconeTipoAddProduto.className = "";
   iconeTipoAddProduto.classList.add("fa-solid", "fa-volleyball", "fa-xl");
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
    //An "if-else" code block responsible for applying a gray color to the current option of a select tag if its value is empty; otherwise, the color applied to the current option is black.
    if(inputSelect.value === "") {
        //Applying the hexadecimal color "#767676" to the "color" property of the HTML select element.
        inputSelect.style.color = "#767676";
    } else {
        //Applying the hexadecimal color "#000000" to the "color" property of the HTML select element.
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

function validarImagemProduto(inputFile) {

}

function validarNomeProduto(inputNome) {
    if(inputNome.value.trim().length === 0) {
        implementarErroCampoForm(inputNome, "Insira um nome para o produto.");

        return false;
    } else if(inputNome.value.trim().length > 150) {
        implementarErroCampoForm(inputNome, "Não passe de 150 caracteres.");

        return false;
    }

    return true;
}

function validarTipoProduto(inputTipo, tiposProdutosValidos) {
    if(!(tiposProdutosValidos.includes(inputTipo.value.trim()))) {
        implementarErroCampoForm(inputTipo, "Selecione um tipo de produto válido.");

        return false;
    }

    return true;
}

function validarPrecoProduto(inputPreco) {
    const precoTexto = inputPreco.value.trim().replaceAll(",", ".");

    if(precoTexto.length === 0) {
        implementarErroCampoForm(inputPreco, "Insira um preço para o produto.");

        return false;
    } else if(/^\d+([.,]\d+)?$/.test(precoTexto)) {
        implementarErroCampoForm(inputPreco, "Texto de preço inválido.");

        return false;
    } else if(precoTexto.length > 11) {
        implementarErroCampoForm(inputPreco, "Não passe de 10 dígitos.");

        return false;
    } else if(parseFloat(precoTexto) <= 0) {
        implementarErroCampoForm(inputPreco, "Não use valor negativo.");

        return false;
    } else if(parseFloat(precoTexto) > 99999999.99) {
        implementarErroCampoForm(inputPreco, "Não use valor maior que 99999999.99");

        return false;
    }

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

    return true;
}

function validarEstoqueProduto(inputEstoque) {
    if(/^[1-9]\d*$/.test(inputEstoque.value.trim())) {
        implementarErroCampoForm(inputEstoque, "Insira um valor de estoque válido.");

        return false;
    }

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

function limparTodosErrosCamposForm() {

}