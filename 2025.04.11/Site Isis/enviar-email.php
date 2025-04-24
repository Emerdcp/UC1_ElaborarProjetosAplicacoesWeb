<?php
//================== DADOS FO FORMULÁRIO ==================//
# composer init
# composer require phpmailer/phpmailer

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

if (isset($_POST['enviar'])) {
    // Cria uma nova instância do PHPMailer
    $mail = new PHPMailer();
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $nome = $_POST['nome'];

    $email_from = getenv("CONTROL_PROJ_EMAIL_MAIL");

    if (empty($email_from)) {
        http_response_code(400);
        die(json_encode([
            "Status" => "Alerta",
            "Message" => "E-mail de remetente para envio se encontra vazio.",
            "color-div" => "alert-danger"
        ]));
    }

    // Configura o servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->CharSet = 'UTF-8';
    $mail->Username = $email_from; // Insira aqui o e-mail que será utilizado para enviar a mensagem
    $mail->Password = getenv("CONTROL_PROJ_EMAIL_PWD"); // Insira aqui a senha do e-mail
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $destinatario_email = "emersoncarvalho@hotmail.com.br"; //$_POST['email_enviar']
    if (empty($destinatario_email)) {
        http_response_code(400);
        die(json_encode([
            "Status" => "Alerta",
            "Message" => "E-mail do destinatário se encontra vazio.",
            "color-div" => "alert-danger"
        ]));
    }

    // Configura o remetente
    $mail->setFrom($email_from, 'ISIS - Site');//Nome do emial que está enviando 
    
    // Configura o destinatário
    $mail->addAddress($destinatario_email);
    //$mail->addCC("suporte@vlcorrea.com.br", "Suporte");

    // Configura o assunto
    $mail->Subject = 'Proposta Site';

    // Configura o corpo da mensagem
    $mail->Body = "Solicitação de Proposta Via Site. <br>Nome: $nome. <br>Telefone: $telefone. <br>e-mail: $email.<br>Assunto: $mensagem";

    // Configura o corpo da mensagem em texto simples, caso o destinatário não aceite HTML
    $mail->AltBody = "Solicitação de Proposta Via Site. <br>Nome: $nome. <br>Telefone: $telefone. <br>e-mail: $email.<br>Assunto: $mensagem";

    // Envia o e-mail
    if(!$mail->send()) {
        http_response_code(400);
        die(json_encode([
            "Status" => "Alerta",
            "Message" => "Não foi possível enviar o e-mail: " . $mail->ErrorInfo,
            "color-div" => "alert-danger"
        ]));
    } else {
        http_response_code(201);
        die(json_encode([
            "Status" => "Sucesso",
            "Message" => 'E-mail enviado com sucesso!',
            "color-div" => "alert-success"
        ]));
    }
}


//================== CHAVE CAPTCHA ==================//

// if ($_SERVER["REQUEST_METHOD"] === "POST") {

//   //================== VERIFICA CAPTCHA PRIMEIRO ==================//
//   $secret = "6Ldy3BkrAAAAAEaMegBLeNK0B6Z0fsLr7IQUcL-U"; // sua chave secreta
//   $response = $_POST['g-recaptcha-response'];
//   $remoteip = $_SERVER['REMOTE_ADDR'];

//   $url = "https://www.google.com/recaptcha/api/siteverify";
//   $data = [
//     'secret' => $secret,
//     'response' => $response,
//     'remoteip' => $remoteip
//   ];

//   $options = [
//     'http' => [
//       'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
//       'method'  => 'POST',
//       'content' => http_build_query($data)
//     ]
//   ];

//   $context = stream_context_create($options);
//   $verify = file_get_contents($url, false, $context);
//   $captchaSuccess = json_decode($verify);

//   if ($captchaSuccess->success) {
//     //================== CAPTCHA OK - PEGA OS DADOS DO FORMULÁRIO ==================//
//     $nome     = $_POST['nome'];
//     $email    = $_POST['email'];
//     $telefone = $_POST['telefone'];
//     $mensagem = $_POST['mensagem'];

//     //================== DESTINATÁRIO ==================//
//     $para = "emersoncarvalho@hotmail.com.br";
//     $assunto = "Solicitação via site";

//     //================== CORPO DO E-MAIL ==================//
//     $corpo = "
//       <strong>Nome:</strong> $nome<br>
//       <strong>E-mail:</strong> $email<br>
//       <strong>Telefone:</strong> $telefone<br>
//       <strong>Mensagem:</strong><br>$mensagem
//     ";

//     //================== CABEÇALHO ==================//
//     $headers  = "MIME-Version: 1.0\r\n";
//     $headers .= "Content-type: text/html; charset=UTF-8\r\n";
//     $headers .= "From: $nome <$email>\r\n";

//     //================== ENVIA E-MAIL ==================//
//     $sucesso = mail($para, $assunto, $corpo, $headers);

//     if ($sucesso) {
//       echo "<script>alert('Mensagem enviada com sucesso!'); window.history.back();</script>";
//     } else {
//       echo "<script>alert('Erro ao enviar. Tente novamente.'); window.history.back();</script>";
//     }

//   } else {
//     // CAPTCHA inválido
//     echo "<script>alert('Erro: verificação do reCAPTCHA falhou. Tente novamente.'); window.history.back();</script>";
//   }
// }
// ?>
