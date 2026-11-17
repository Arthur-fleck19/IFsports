const olhos = document.querySelectorAll(".caixa-formulario i.fa-eye-slash");
// Pega os parâmetros que estão na URL
const parametros = new URLSearchParams(window.location.search);
// Pega o valor de "erro"
const erro = parametros.get("erro");
// Pega a div da notificação
const notificacao = document.getElementById("notificacao");

if(erro === "senhaVazia") {
    notificacao.textContent = "Senha vazia!";
    notificacao.classList.add("erro");
    notificacao.classList.add("mostrar");
} else if(erro === "confirmacaoErrada") {
    notificacao.textContent = "Senha confirmada incorreta!";
    notificacao.classList.add("erro");
    notificacao.classList.add("mostrar");
}

if(erro) {
    setTimeout(function() {
        notificacao.classList.remove("mostrar");
    }, 3000);
}

olhos.forEach( (olho) => {
    olho.addEventListener("click", () => {
        if(olho.previousElementSibling.type === "password") {
            olho.previousElementSibling.type = "text"; // mostra a senha
            olho.classList.remove("fa-eye-slash");
            olho.classList.add("fa-eye");
        } else {
            olho.previousElementSibling.type = "password"; // esconde a senha
            olho.classList.remove("fa-eye");
            olho.classList.add("fa-eye-slash");
        }
    });
});