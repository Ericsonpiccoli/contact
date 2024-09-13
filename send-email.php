<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Carregar o autoload do Composer
require '/var/www/html/vendor/autoload.php';

// Carregar configurações
$emailConfig = require '/var/www/config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = htmlspecialchars($_POST['full_name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? htmlspecialchars($_POST['email']) : '';
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    if (!$email) {
        die("Endereço de e-mail inválido.");
    }

    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host = $emailConfig['smtp_host'];
        $mail->SMTPAuth = true;
        $mail->Username = $emailConfig['smtp_username'];
        $mail->Password = $emailConfig['smtp_password'];
        $mail->SMTPSecure = $emailConfig['smtp_secure'] === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $emailConfig['smtp_port'];

        // Enviar e-mail para o administrador
        $mail->setFrom($emailConfig['from_email'], $emailConfig['from_name']);
        $mail->addAddress($emailConfig['from_email']); // Adicionar destinatário (administrador)

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<h2>Contato do Formulário</h2>
                          <p><strong>Nome:</strong> $fullName</p>
                          <p><strong>Email:</strong> $email</p>
                          <p><strong>Assunto:</strong> $subject</p>
                          <p><strong>Mensagem:</strong><br>$message</p>";

        $mail->send();

        // Enviar resposta automática para o usuário
        $mail->clearAddresses();
        $mail->addAddress($email);

        $mail->Subject = 'Grazie per averci contattato';
        $mail->Body    = "<p>Grazie per averci contattato attraverso il nostro sito!</p>
                          <p>Abbiamo ricevuto il tuo messaggio e le tue informazioni sono state registrate con successo. Ti risponderemo al più presto all'indirizzo email fornito.</p>  
                          <p>Per ulteriori informazioni o assistenza, puoi contattarci al telefono o via WhatsApp al +393501021359.</p>
                          <p>Visita il nostro sito web: <a href='http://www.ericsonpiccoli.it'>www.ericsonpiccoli.it</a></p>
                          <p>Grazie per il tuo contatto e per la tua pazienza.</p>
                          <p>Cordiali saluti,<br>Ericson Piccoli</p>";

        $mail->send();

        // Exibir mensagem de sucesso
        echo '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Ericson Piccoli</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700&family=Rubik:wght@400;500&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/Mailler-1.0.0/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/Mailler-1.0.0/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="/Mailler-1.0.0/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/Mailler-1.0.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/Mailler-1.0.0/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid header position-relative overflow-hidden p-0">
        <div class="hero-header overflow-hidden px-5">
            <div class="rotate-img">
                <img src="/Mailler-1.0.0/img/sty-1.png" class="img-fluid w-100" alt="">
                <div class="rotate-sty-2"></div>
            </div>
            <div class="row gy-5 align-items-center">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                    <h1 class="display-4 text-dark mb-4 wow fadeInUp" data-wow-delay="0.3s">Grazie per averci Contattato!</h1>
                    <p class="fs-4 mb-4 wow fadeInUp" data-wow-delay="0.5s">Grazie per averci contattato per richiedere i miei servizi di programmazione web! Ti risponderemo presto per discutere i dettagli. Clicca sul pulsante "Torna" per tornare alla pagina iniziale.</p>
                    <a href="/index.html" class="btn btn-primary rounded-pill py-3 px-5 wow fadeInUp" data-wow-delay="0.7s">Torna</a>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                    <img src="/Mailler-1.0.0/img/hero-img-1.png" class="img-fluid w-100 h-100" alt="">
                </div>
            </div>
        </div>
    </div>
</body>

</html>';
    } catch (Exception $e) {
        echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
} else {
    echo "Método de solicitação inválido.";
}
?>
