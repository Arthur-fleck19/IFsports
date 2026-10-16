<?php

$apiKey = 'SUA_API_KEY_DA_BREVO_AQUI'; // Substitua pela sua chave real

$url = 'https://brevo.com';

// Dados do e-mail estruturados em JSON
$data = [
    "sender" => [
        "name" => "IFsports",
        "email" => "rebecacampos.nh015@academico.ifsul.edu.br" // Deve ser um e-mail verificado na Brevo
    ],
    "to" => [
        [
            "email" => "destinatario@exemplo.com",
        ]
    ],
    "subject" => "Testando envio via API!",
    "htmlContent" => "<html><head></head><body><p>Olá,</p><p>Este e-mail foi enviado usando a <b>API da Brevo</b> via PHP puro!</p></body></html>"
];

// Configuração da requisição HTTP via cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: application/json',
    'api-key: ' . $apiKey,
    'content-type: application/json'
]);

// Executa a requisição
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Verifica o resultado
if ($httpCode === 201) {
    echo "E-mail enviado com sucesso via API!";
} else {
    echo "Erro ao enviar. Resposta do servidor: " . $response;
}