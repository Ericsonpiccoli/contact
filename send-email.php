<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Carregar o autoloader do Composer

// Configurações do banco de dados
$host = 'database-1-instance-1.cncss0m4cg1u.us-east-1.rds.amazonaws.com';
$port = '5432';
$dbname = 'database-1';  // Nome do banco de dados
$user = 'postgres';  // Nome de usuário do banco de dados
$password = 'ELP0911$$';  // Senha do banco de dados

// Criar a conexão com o banco de dados
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    echo "Não foi possível conectar ao banco de dados.";
} else {
    echo "Conexão estabelecida com sucesso!";
}

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
        $mail->Host = 'email-smtp.us-east-1.amazonaws.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'AKIAIEXAMPLE'; // Substitua pelo seu nome de usuário SMTP do Amazon SES
        $mail->Password = 'YOUR_ACTUAL_SMTP_PASSWORD'; // Substitua pela sua senha SMTP do Amazon SES
        $mail->SMTPSecure = 'tls'; // Pode ser 'tls' ou 'ssl'
        $mail->Port = 587; // Pode ser 25, 587 ou 2587

        // Remetente e destinatário
        $mail->setFrom('contact@ericsonpiccoli.it', 'Your Name');
        $mail->addAddress('contact@ericsonpiccoli.it'); // Seu e-mail

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<h2>Contact Form Submission</h2>
                          <p><strong>Name:</strong> $fullName</p>
                          <p><strong>Email:</strong> $email</p>
                          <p><strong>Subject:</strong> $subject</p>
                          <p><strong>Message:</strong><br>$message</p>";

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
