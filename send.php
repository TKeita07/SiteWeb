<?php
$to = "thomas.keita@hotmail.com";
$subject = "Nouveau message du formulaire";
$message = "Nom: " . $_POST['name'] . "\n";
$message .= "Email: " . $_POST['email'] . "\n";
$message .= "Message: " . $_POST['message'] . "\n";
$headers = "From: " . $_POST['email'];

if(mail($to, $subject, $message, $headers)) {
    echo "Message envoyé avec succès.";
} else {
    echo "Erreur lors de l'envoi du message.";
}
?>
