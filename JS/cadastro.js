const senha = document.getElementById("senha");
const olho = document.getElementById("toggleSenha");

olho.addEventListener("click", () => {
    if (senha.type === "password") {
        senha.type = "text"; // mostra a senha
        olho.classList.remove("fa-eye-slash");
        olho.classList.add("fa-eye");
    } else {
        senha.type = "password"; // esconde a senha
        olho.classList.remove("fa-eye");
        olho.classList.add("fa-eye-slash");
    }
});

const parametros = new URLSearchParams(window.location.search);

const erro = parametros.get("erro");

const notificacao = document.getElementById("notificacao");

if(erro) {
    notificacao.textContent = "Erro ao cadastrar usuario, informações inválidas";
    notificacao.classList.add("erro");
    notificacao.classList.add("mostrar");
    setTimeout(function() {
        notificacao.classList.remove("mostrar");
    }, 3000);
}