<?php
function sendContactEmail($to, $subject, $message, $from) {
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . $from . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($to, $subject, $message, $headers)) {
        return "Email envoyé avec succès.";
    } else {
        return "Échec de l'envoi de l'email.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = "gomes.ethan02@gmail.com"; 
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
    $from = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if ($from) {
        echo sendContactEmail($to, $subject, $message, $from);
    } else {
        echo "Adresse email invalide.";
    }
}
?>