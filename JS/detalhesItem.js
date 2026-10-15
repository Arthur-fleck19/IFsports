const botaoMenosQuant = document.getElementById("botaoMenosQuant");
const botaoMaisQuant = document.getElementById("botaoMaisQuant");
const inputQuant = document.getElementById("inputQuantItem");

const maximo = Number(inputQuant.max);
console.log("Estoque máximo:", maximo);
botaoMenosQuant.addEventListener("click", () => {
    let contadorQuant = Number(inputQuant.value);

    if(contadorQuant > 1) {
        contadorQuant--;
        inputQuant.value = contadorQuant;
    }
});
botaoMaisQuant.addEventListener("click", () => {
    let contadorQuant = Number(inputQuant.value);

    if(contadorQuant < maximo){
        contadorQuant++;
        inputQuant.value = contadorQuant;
    }
});
inputQuant.addEventListener("input", () => {
    if (inputQuant.value === "") return;

    const quantidade = Number(inputQuant.value);

    if (quantidade > maximo) {
        inputQuant.value = maximo;
    }
});

inputQuant.addEventListener("change", () => {
    let quantidade = Number(inputQuant.value);

    if (inputQuant.value === "" || quantidade < 1) {
        quantidade = 1;
    }

    if (quantidade > maximo) {
        quantidade = maximo;
    }

    inputQuant.value = quantidade;
});