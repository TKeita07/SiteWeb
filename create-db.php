<?php
$mot_de_passe = 'giraffe33'; // Ton mot de passe réel ici
$hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);
echo "Hash : " . $hash;
?>