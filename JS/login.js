// Pega os parâmetros que estão na URL
const parametros = new URLSearchParams(window.location.search);
// Pega o valor de "erro"
const erro = parametros.get("erro");
// Pega a div da notificação
const notificacao = document.getElementById("notificacao");

// Verifica qual erro aconteceu
if(erro === "usuario") {
    notificacao.textContent = "Usuário não encontrado!";
    notificacao.classList.add("erro");
    notificacao.classList.add("mostrar");
} else if(erro === "senha") {
    notificacao.textContent = "Senha incorreta!";
    notificacao.classList.add("erro");
    notificacao.classList.add("mostrar");
}

// Faz a notificação desaparecer depois de 3 segundos
if(erro) {
    setTimeout(function() {
        notificacao.classList.remove("mostrar");
    }, 3000);
}

const senha = document.getElementById("senha");
const olho = document.getElementById("toggleSenha");

olho.addEventListener("click", () => {
    if(senha.type === "password") {
        senha.type = "text"; // mostra a senha
        olho.classList.remove("fa-eye-slash");
        olho.classList.add("fa-eye");
    } else {
        senha.type = "password"; // esconde a senha
        olho.classList.remove("fa-eye");
        olho.classList.add("fa-eye-slash");
    }
});