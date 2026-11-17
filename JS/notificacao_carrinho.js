// Pega os parâmetros que estão na URL
const parametros = new URLSearchParams(window.location.search);
// Pega o valor de "feedback"
const feedback = parametros.get("feedback");
// Pega a div da notificação
const notificacao = document.getElementById("notificacao");

// Verifica qual erro aconteceu
if(feedback === "add-sucesso") {
    notificacao.textContent = "Item adicionado ao carrinho!";
    notificacao.classList.add("sucesso");
    notificacao.classList.add("mostrar");
} else if(feedback === "limite") {
    notificacao.textContent = "Sem estoque!";
    notificacao.classList.add("erro");
    notificacao.classList.add("mostrar");
}

// Faz a notificação desaparecer depois de 1.5 segundos
if(feedback) {
    setTimeout(function() {
        notificacao.classList.remove("mostrar");
    }, 1500);
}