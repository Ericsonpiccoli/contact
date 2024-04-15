<?php
if(isset($_POST['submit'])) {
    $to = "contact@ericsonpiccoli.it";
    $from = $_POST['email'];
    $name = $_POST['name'];
    $headers = "From: $from";
    $subject = "Message from $name";

    $message = "Name: $name\n";
    $message .= "Email: $from\n";
    $message .= "Phone: ".$_POST['phone']."\n";
    $message .= "Message: ".$_POST['message']."\n";

    if(mail($to, $subject, $message, $headers)) {
        echo '<p class="green textcenter">Your message was sent successfully! I will be in touch as soon as I can.</p>';
    } else {
        echo '<p>Something went wrong, try refreshing and submitting the form again.</p>';
    }
}
?>
