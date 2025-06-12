<?php
$allowed_extensions = ['pdf'];
$extension = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);

if (!in_array(strtolower($extension), $allowed_extensions)) {
    header("Location: promos.html?upload=error_type"); // ou index.html ou ta page d'accueil
    exit();
}

if ($_FILES['fichier']['error'] === 0) {
    $dossier = 'Promotions/';
    $nom_fichier = 'promotions.pdf'; // 🔁 Nom fixe souhaité

    // Déplace et renomme le fichier
    if (move_uploaded_file($_FILES['fichier']['tmp_name'], $dossier . $nom_fichier)){
        header("Location: promos.html?upload=success"); // ou index.html ou ta page d'accueil
        exit();
    } else {
        header("Location: promos.html?upload=error_nofile"); // ou index.html ou ta page d'accueil
        exit();
    }

} else {
    header("Location: index.html?upload=error_upload");
    exit();
}
?>
