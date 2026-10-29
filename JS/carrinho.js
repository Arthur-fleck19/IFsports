const botoesRemover = document.querySelectorAll('.remover');
const botoesSubtrair = document.querySelectorAll('.botaoSubtrair')

botoesSubtrair.forEach(botaoSubtrair => {
    botaoSubtrair.addEventListener('click', function(event){
        const item = this.closest('.itemCarrinho');

        const quantidadeString = item.querySelector('.quantidadeAtual').innerText;
        const quantidadeAtual = parseInt(quantidadeString, 10);

        if(quantidadeAtual === 1){
            const remover = confirm("Deseja remover esse item do carrinho?");

            if(!remover){
                event.preventDefault();
            }
        }
    });
});

botoesRemover.forEach(botaoRemover => {
    botaoRemover.addEventListener('click', function(event) {
        const remover = confirm("Deseja remover esse item do carrinho?");

        if(!remover){
            event.preventDefault();
        }
    });
});