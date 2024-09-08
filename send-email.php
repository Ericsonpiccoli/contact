<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Dados de conexão com o banco de dados
$servername = "";
$username = "admin";
$password = "";
$dbname = ""; // Nome do seu banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se a solicitação é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário
    $fullName = htmlspecialchars($_POST['full_name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? htmlspecialchars($_POST['email']) : '';
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    if (!$email) {
        die("Endereço de e-mail inválido.");
    }

    // Inserir dados no banco de dados
    $stmt = $conn->prepare("INSERT INTO contatos (full_name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullName, $email, $subject, $message);
    
    if ($stmt->execute()) {
        echo "Dados inseridos com sucesso!";
    } else {
        error_log("Erro ao inserir dados: " . $stmt->error);
        echo "Erro ao inserir dados.";
    }

    // Fechar declaração e conexão
    $stmt->close();
    $conn->close();

    // Configuração do servidor SMTP
    $mail = new PHPMailer(true);

    try {
        // Enviar e-mail para o administrador
        $mail->isSMTP();
        $mail->Host = 'email-smtp.us-east-1.amazonaws.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'AKIA6D6JBNZUFAJGW6GV';
        $mail->Password = 'BKrpzA278ao4x0bj8EpgSXoRc5wb6CVNJmSZHFDlgi9U';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587;

        $mail->setFrom('contact@ericsonpiccoli.it', 'Ericson Piccoli');
        $mail->addAddress('contact@ericsonpiccoli.it');

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<h2>Contato do Formulário</h2>
                          <p><strong>Nome:</strong> $fullName</p>
                          <p><strong>Email:</strong> $email</p>
                          <p><strong>Assunto:</strong> $subject</p>
                          <p><strong>Mensagem:</strong><br>$message</p>";

        $mail->send();
        echo 'Mensagem enviada com sucesso!';

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
        echo 'Risposta automatica inviata com sucesso!';
    } catch (Exception $e) {
        error_log("Mensagem não pôde ser enviada. Erro do Mailer: {$mail->ErrorInfo}");
        echo "Mensagem não pôde ser enviada.";
    }
} else {
    echo "Solicitação inválida.";
}
?>
