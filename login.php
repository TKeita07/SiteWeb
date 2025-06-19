<?php
session_start();

$valid_username = 'admin';

$hashed_password = '$2y$10$s7BhfdBUyRWrwinQqb3RTu2FWuy034PNW4.jLvfl/Zy4oECeJpqvy';

// Vérification
if ($_POST['username'] === $valid_username && password_verify($_POST['password'], $hashed_password)) {
    $_SESSION['admin'] = true;
    header('Location: admin.php');
    exit;
} else {
    echo "Identifiants invalides. <a href='login.html'>Réessayer</a>";
}
?>