const elementoResumo = document.getElementById('inputValorTotal');
const subtotalPedido = parseFloat(elementoResumo.dataset.subtotal) || 0;

// Variáveis globais para guardar os valores calculados pelo CEP
let fretePadraoAtual = 0;
let freteExpressaAtual = 19.90;

// 1. Evento ao clicar no botão "Buscar"
document.getElementById('btnBuscarCep').addEventListener('click', buscarCep);

// Busca automaticamente ao sair do campo CEP (se já tiver 8 dígitos)
document.getElementById('cep').addEventListener('blur', () => {
    const cepLimpo = document.getElementById('cep').value.replace(/\D/g, '');
    if (cepLimpo.length === 8) {
        buscarCep();
    }
});

async function buscarCep() {
    const inputCep = document.getElementById('cep').value;
    const cepLimpo = inputCep.replace(/\D/g, '');

    if (cepLimpo.length !== 8) {
        alert('Digite um CEP válido com 8 números.');
        return;
    }

    try {
        const url = 'https://viacep.com.br/ws/' + cepLimpo + '/json/';
        const resposta = await fetch(url);
        const dados = await resposta.json();

        if (dados.erro) {
            alert('CEP não encontrado!');
            return;
        }

        // Preenche os inputs de endereço
        document.getElementById('rua').value = dados.logradouro || '';
        document.getElementById('bairro').value = dados.bairro || '';
        document.getElementById('cidade').value = dados.localidade || '';
        document.getElementById('uf').value = dados.uf || '';

        // Calcula o frete baseado no Estado (UF)
        calcularFretePorEstado(dados.uf);

        // Coloca o cursor direto no campo "Número"
        document.getElementById('numero').focus();

    } catch (erro) {
        alert('Erro ao consultar o CEP. Verifique sua conexão.');
    }
}

// 2. Lógica de cálculo de frete por região
function calcularFretePorEstado(uf) {
    let prazoPadrao = 7;
    let prazoExpressa = 3;

    if (uf === 'RS') {
        fretePadraoAtual = 0;
        prazoPadrao = 4;
        freteExpressaAtual = 14.90;
        prazoExpressa = 1;
    } else if (['SC', 'PR', 'SP', 'RJ', 'MG', 'ES'].includes(uf)) {
        fretePadraoAtual = 15.00;
        prazoPadrao = 7;
        freteExpressaAtual = 29.90;
        prazoExpressa = 3;
    } else {
        fretePadraoAtual = 28.50;
        prazoPadrao = 12;
        freteExpressaAtual = 49.90;
        prazoExpressa = 5;
    }

    // Atualiza os textos das opções de entrega na tela
    document.getElementById('prazoPadrao').innerText = `Receba em até ${prazoPadrao} dias úteis`;
    document.getElementById('valorPadrao').innerText = fretePadraoAtual === 0
        ? 'Grátis'
        : fretePadraoAtual.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

    document.getElementById('prazoExpressa').innerText = `Receba em até ${prazoExpressa} dias úteis`;
    document.getElementById('valorExpressa').innerText = freteExpressaAtual.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

    // Atualiza o resumo do pedido (Frete + Total)
    atualizarResumoPedido();
}

document.querySelectorAll('input[name="entrega"]').forEach((radio) => {
    radio.addEventListener('change', atualizarResumoPedido);
});

function atualizarResumoPedido() {
    const entregaSelecionada = document.querySelector('input[name="entrega"]:checked').value;
    const resumoFrete = document.getElementById('frete');
    const resumoTotal = document.getElementById('totalPedido');
    const inputTotal = document.getElementById('inputValorTotal');

    let valorFreteEscolhido = 0;

    if (entregaSelecionada === 'padrao') {
        valorFreteEscolhido = fretePadraoAtual;
        resumoFrete.innerText = fretePadraoAtual === 0
            ? 'Grátis'
            : fretePadraoAtual.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    } else {
        valorFreteEscolhido = freteExpressaAtual;
        resumoFrete.innerText = freteExpressaAtual.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    }

    const totalFinal = subtotalPedido + valorFreteEscolhido;

    resumoTotal.innerText = totalFinal.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

    inputTotal.value = totalFinal.toFixed(2);
}