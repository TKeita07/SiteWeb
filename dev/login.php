<?php
session_start();

// Nom d'utilisateur fixe
$valid_username = 'admin';

// Hash généré avec password_hash() — NE PAS le modifier ensuite
$hashed_password = '$2y$12$V95Uo1VryYb2DZzTvTW88el0TPTQjIQdirFaZ3Z7OC1ddYQGCqIOq'; // Remplace par ton vrai hash

// Vérification
if ($_POST['username'] === $valid_username && password_verify($_POST['password'], $hashed_password)) {
    $_SESSION['admin'] = true;
    header('Location: admin.php');
    exit;
} else {
    echo "Identifiants invalides. <a href='login.html'>Réessayer</a>";
}
?>