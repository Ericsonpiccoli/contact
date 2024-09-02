<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Certifique-se de que o PHPMailer está corretamente instalado

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário
    $fullName = htmlspecialchars($_POST['full_name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // Configuração do servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'email-smtp.us-east-1.amazonaws.com'; // Substitua pelo servidor SMTP desejado
        $mail->SMTPAuth = true;
        $mail->Username = 'AKIAIEXAMPLE'; // Substitua pelo seu nome de usuário SMTP
        $mail->Password = 'YOUR_ACTUAL_SMTP_PASSWORD'; // Substitua pela sua senha SMTP
        $mail->SMTPSecure = 'tls'; // Pode ser 'tls' ou 'ssl'
        $mail->Port = 587; // Pode ser 25, 587 ou 2587

        // Remetente e destinatário
        $mail->setFrom('contact@ericsonpiccoli.it', 'Your Name');
        $mail->addAddress('contact@ericsonpiccoli.it'); // Seu e-mail

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<h2>Contato do Formulário</h2>
                          <p><strong>Nome:</strong> $fullName</p>
                          <p><strong>Email:</strong> $email</p>
                          <p><strong>Assunto:</strong> $subject</p>
                          <p><strong>Mensagem:</strong><br>$message</p>";

        // Enviar o e-mail
        $mail->send();
        echo 'Mensagem enviada com sucesso!';
    } catch (Exception $e) {
        echo "Mensagem não pôde ser enviada. Erro do Mailer: {$mail->ErrorInfo}";
    }
} else {
    echo "Solicitação inválida.";
}
?>
