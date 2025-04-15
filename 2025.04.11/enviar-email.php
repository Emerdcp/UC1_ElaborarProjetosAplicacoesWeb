<?php
//================== DADOS FO FORMULÁRIO ==================//
$nome     = $_POST['nome'];
$email    = $_POST['email'];
$telefone = $_POST['telefone'];
$mensagem = $_POST['mensagem'];

//================== DESTINATÁRIO FIXO ==================//
$para = "emersoncarvalho@hotmail.com.br";

//================== ASSUNTO ==================//
$assunto = "Solicitação via site";

//================== CORPO DO E-MAIL ==================//
$corpo = "
  <strong>Nome:</strong> $nome<br>
  <strong>E-mail:</strong> $email<br>
  <strong>Telefone:</strong> $telefone<br>
  <strong>Mensagem:</strong><br>$mensagem
";

//================== CABEÇALHOS ==================//
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "From: $nome <$email>\r\n";

//================== ENVIA O E-MAIL ==================//
$sucesso = mail($para, $assunto, $corpo, $headers);

if ($sucesso) {
  echo "<script>alert('Mensagem enviada com sucesso!'); window.history.back();</script>";
} else {
  echo "<script>alert('Erro ao enviar. Tente novamente.'); window.history.back();</script>";
}


//================== CHAVE CAPTCHA ==================//

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  //================== VERIFICA CAPTCHA PRIMEIRO ==================//
  $secret = "6Ldy3BkrAAAAAEaMegBLeNK0B6Z0fsLr7IQUcL-U"; // sua chave secreta
  $response = $_POST['g-recaptcha-response'];
  $remoteip = $_SERVER['REMOTE_ADDR'];

  $url = "https://www.google.com/recaptcha/api/siteverify";
  $data = [
    'secret' => $secret,
    'response' => $response,
    'remoteip' => $remoteip
  ];

  $options = [
    'http' => [
      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
      'method'  => 'POST',
      'content' => http_build_query($data)
    ]
  ];

  $context = stream_context_create($options);
  $verify = file_get_contents($url, false, $context);
  $captchaSuccess = json_decode($verify);

  if ($captchaSuccess->success) {
    //================== CAPTCHA OK - PEGA OS DADOS DO FORMULÁRIO ==================//
    $nome     = $_POST['nome'];
    $email    = $_POST['email'];
    $telefone = $_POST['telefone'];
    $mensagem = $_POST['mensagem'];

    //================== DESTINATÁRIO ==================//
    $para = "emersoncarvalho@hotmail.com.br";
    $assunto = "Solicitação via site";

    //================== CORPO DO E-MAIL ==================//
    $corpo = "
      <strong>Nome:</strong> $nome<br>
      <strong>E-mail:</strong> $email<br>
      <strong>Telefone:</strong> $telefone<br>
      <strong>Mensagem:</strong><br>$mensagem
    ";

    //================== CABEÇALHO ==================//
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: $nome <$email>\r\n";

    //================== ENVIA E-MAIL ==================//
    $sucesso = mail($para, $assunto, $corpo, $headers);

    if ($sucesso) {
      echo "<script>alert('Mensagem enviada com sucesso!'); window.history.back();</script>";
    } else {
      echo "<script>alert('Erro ao enviar. Tente novamente.'); window.history.back();</script>";
    }

  } else {
    // CAPTCHA inválido
    echo "<script>alert('Erro: verificação do reCAPTCHA falhou. Tente novamente.'); window.history.back();</script>";
  }
}
?>
