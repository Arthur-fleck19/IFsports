<?php
    session_start();

    require_once "../Classes/Usuario_gerenciamento.php";

    $env = parse_ini_file(dirname(__DIR__) . "/.env");
    $chaveApiBrevo = $env['BREVO_API_CHAVE'];
    $emailUsuario = $_POST['Email'];
    $_SESSION['recuperacao_id'] = Usuario_gerenciamento::email_existente_retorna_id($emailUsuario);

    if($_SESSION['recuperacao_id'] !== "-1") {
        $codigoRecuperacaoInt = str_pad((string) random_int(0, 9999), 4, "0", STR_PAD_LEFT);
        $ch = curl_init();
        $dadosEnvioEmail = [
            "sender" => [
                "name" => "IFsports",
                "email" => "josue.frauzino@gmail.com"
            ],
            "to" => [
                ["email" => $emailUsuario]
            ],
            "subject" => "Código de recuperação de senha — IFsports",
            "htmlContent" => "<p>Olá!<br><br>Recebemos uma solicitação para redefinir a senha da sua conta na IFsports.<br><br>Seu código de verificação é:<br><br><span style='font-size: 1.5rem;'>$codigoRecuperacaoInt</span><br><span style='font-size: 0.7rem;'>Código ilustrativo — válido por 3 minutos.</span><br><br>Caso não tenha solicitado essa recuperação, ignore esta mensagem.<br><br>Atenciosamente,<br><br><span style='font-weight: bold;'>Equipe de suporte IFsports</span></p>"
        ];

        curl_setopt_array($ch, [
            CURLOPT_URL => "https://api.brevo.com/v3/smtp/email",
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "api-key: " . $chaveApiBrevo,
                "Content-Type: application/json",
                "accept: application/json"
            ],
            CURLOPT_POSTFIELDS => json_encode($dadosEnvioEmail),
            CURLOPT_RETURNTRANSFER => true
        ]);

        $respostaApi = curl_exec($ch);

        if($respostaApi === false) {
            curl_close($ch);
            header("Location: ../Views/redefinir_senha.html?erro=emailNaoEnviado");
            exit();
        } else {
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            if($status == 201) {
                $_SESSION['recuperacao_codigo_hash'] = password_hash($codigoRecuperacaoInt, PASSWORD_DEFAULT);
                $_SESSION['recuperacao_expira_em'] = time() + 180;
                $_SESSION['recuperacao_codigo_enviado'] = true;

                header("Location: ../Views/insira_o_codigo.php");
                exit();
            } else {
                header("Location: ../Views/redefinir_senha.html?erro=emailNaoEnviado");
                exit();
            }
        }
    } else {
        header("Location: ../Views/redefinir_senha.html?erro=emailNaoAchado");
        exit();
    }