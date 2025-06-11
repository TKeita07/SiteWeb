<?php
if ($_FILES['fichier']['error'] === 0) {
    $dossier = 'Promotions/';
    $nom_fichier = 'promotions.pdf'; // 🔁 Nom fixe souhaité

    // Déplace et renomme le fichier
    move_uploaded_file($_FILES['fichier']['tmp_name'], $dossier . $nom_fichier);

    echo "Fichier reçu et enregistré sous le nom promotions.pdf.";
} else {
    echo "Erreur lors de l'envoi : " . $_FILES['fichier']['error'];
}
?>
