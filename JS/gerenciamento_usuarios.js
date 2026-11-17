const botoesEditar = document.querySelectorAll(".botaoEditar");

            botoesEditar.forEach(function (botao) {
                botao.addEventListener('click', () => {
                    const modal = botao.closest('.bu').querySelector('.modal');

                    modal.style.display = 'flex';
                })
            })

            const modais = document.querySelectorAll('.modal');

            modais.forEach(function (modal){
                modal.addEventListener('click', (local) => {
                    if (local.target === modal) {
                        modal.style.display = 'none'

                    }
                })
            })
