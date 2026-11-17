// Pega os parâmetros que estão na URL
const parametros = new URLSearchParams(window.location.search);
// Pega o valor de "erro"
const erro = parametros.get("erro");
// Pega a div da notificação
const notificacao = document.getElementById("notificacao");

if(erro === "codigoInvalido") {
    notificacao.textContent = "Código errado!";
    notificacao.classList.add("erro");
    notificacao.classList.add("mostrar");
}

if(erro) {
    setTimeout(function() {
        notificacao.classList.remove("mostrar");
    }, 3000);
}