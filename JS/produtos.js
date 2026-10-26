const botoesEditar = document.querySelectorAll(".botaoEditar");
const modais = document.querySelectorAll('.modal');
const modal_novo_produto = document.getElementById('criar-produto');
const botao_novo_produto = document.getElementById('add_produto');
const cabecalho = document.querySelector('.cabecalho');
const formAddProduto = document.getElementById('add_produto');
const imgInputFile = document.querySelector(".modalIMG-Produtos img");
const inputFile = document.querySelector(".modalIMG-Produtos input");
const inputTipoAddProduto = document.getElementById("inputTipoProduto");
const inputDescricaoAddProduto = document.getElementById("inputDescricaoProduto");
const contadorDescricaoAddProduto = document.getElementById("contadorDescricaoAddProduto");
const container_perfis = document.querySelector('body');

contadorDescricaoAddProduto.textContent = inputDescricaoAddProduto.value.trim().length + "/500";

imgInputFile.addEventListener("click", () => {
    inputFile.click();
});

botoesEditar.forEach(function (botao) {
    botao.addEventListener('click', () => {
        const modal = botao.closest('.bu').querySelector('.modal');

        modal.style.display = 'flex';
    });
});

modais.forEach(function (modal) {
    modal.addEventListener('click', (local) => {
        if (local.target === modal) {
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
});

inputDescricaoAddProduto.addEventListener('input', () => {
    if(inputDescricaoAddProduto.value.trim().length <= 500) {
        contadorDescricaoAddProduto.textContent = inputDescricaoAddProduto.value.trim().length + "/500";
    } else {
        inputDescricaoAddProduto.value = inputDescricaoAddProduto.value.substring(0, 500);
        contadorDescricaoAddProduto.textContent = "500/500";
    }
});

/*formAddProduto.addEventListener('reset', () => {
   setTimeout(() => {
       inputDescricaoAddProduto.style.color = "#767676";
   }, 0);
});*/

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