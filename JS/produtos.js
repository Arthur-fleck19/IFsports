const botoesEditar = document.querySelectorAll(".botaoEditar");
const imgInputFile = document.querySelector(".modalIMG-Produtos img");
const inputFile = document.querySelector(".modalIMG-Produtos input");
const cabecalho = document.querySelector('.cabecalho');
const modais = document.querySelectorAll('.modal');
const modal_novo_produto = document.getElementById('criar-produto');
const botao_novo_produto = document.getElementById('add_produto');
const container_perfis = document.querySelector('body');

imgInputFile.addEventListener("click", () => {
    inputFile.click();
});

botoesEditar.forEach(function (botao) {
    botao.addEventListener('click', () => {
        const modal = botao.closest('.bu').querySelector('.modal');

        modal.style.display = 'flex';
    })
})

modais.forEach(function (modal) {
    modal.addEventListener('click', (local) => {
        if (local.target === modal) {
            modal.style.display = 'none'
            cabecalho.style.opacity = '1';
            cabecalho.style.pointerEvents = '';
            cabecalho.style.zIndex = '';
            container_perfis.style.overflow = '';
        }
    })
})

botao_novo_produto.addEventListener('click', () => {
    modal_novo_produto.style.display = 'flex';
    cabecalho.style.opacity = '0.651';
    cabecalho.style.pointerEvents = 'none';
    cabecalho.style.zIndex = '0';
    container_perfis.style.overflow = 'hidden';
})