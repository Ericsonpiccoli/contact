<?php
// Define variáveis e inicializa com valores vazios
$nome = $email = $mensagem = '';
$erro = '';

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processa os dados do formulário
    $nome = test_input($_POST["nome"]);
    $email = test_input($_POST["email"]);
    $mensagem = test_input($_POST["mensagem"]);

    // Verifica se o e-mail é válido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Endereço de e-mail inválido";
    } else {
        // E-mail de destino
        $destino = "contct@ericsonpiccoli.it";
        // Assunto do e-mail
        $assunto = "Mensagem do formulário de contato";

        // Monta o corpo do e-mail
        $corpo_email = "Nome: $nome\n";
        $corpo_email .= "E-mail: $email\n";
        $corpo_email .= "Mensagem:\n$mensagem";

        // Envia o e-mail
        if (mail($destino, $assunto, $corpo_email)) {
            echo "<p>Mensagem enviada com sucesso!</p>";
        } else {
            echo "<p>Ocorreu um erro ao enviar a mensagem. Por favor, tente novamente mais tarde.</p>";
        }
    }
}

// Função para validar dados do formulário
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
