// Pega os parâmetros que estão na URL
const parametros = new URLSearchParams(window.location.search);
// Pega o valor de "erro"
const erro = parametros.get("erro");
// Pega a div da notificação
const notificacao = document.getElementById("notificacao");

// Verifica qual erro aconteceu
if(erro === "emailNaoAchado") {
    notificacao.textContent = "Email não encontrado!";
    notificacao.classList.add("erro");
    notificacao.classList.add("mostrar");
}

// Faz a notificação desaparecer depois de 3 segundos
if(erro) {
    setTimeout(function() {
        notificacao.classList.remove("mostrar");
    }, 3000);
}