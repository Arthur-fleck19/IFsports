let contadorQuant = 1;
const botaoMenosQuant = document.getElementById("botaoMenosQuant");
const botaoMaisQuant = document.getElementById("botaoMaisQuant");
const inputQuant = document.getElementById("inputQuantItem");

botaoMenosQuant.addEventListener("click", () => {
    if(contadorQuant !== 1) {
        contadorQuant--;
        inputQuant.value = contadorQuant;
    }
});
botaoMaisQuant.addEventListener("click", () => {
    contadorQuant++;
    inputQuant.value = contadorQuant;
});
inputQuant.addEventListener("blur", () => {
    if(inputQuant.validity.patternMismatch) {
        inputQuant.value = 1;
    }
});