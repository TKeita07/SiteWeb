<?php

$db = new PDO('sqlite:Formulaires/formulaires.sqlite');

date_default_timezone_set('America/Toronto');

// Récupération des données
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$materiel = $_POST['materiel'];
$couleur = $_POST['couleur'];
$dimension = $_POST['dimension'];
$epaisseur = $_POST['epaisseur'];
$message = $_POST['message'];
$date = date('Y-m-d H:i');
$statut = 'Recu';
// Dossier des fichiers
$dossier = '../Formulaires/uploads/';
if (!is_dir($dossier)) {
    mkdir($dossier, 0755, true);
}

// Fonction pour traiter chaque fichier
function traiterFichier($champ, $dossier) {
    if (isset($_FILES[$champ]) && $_FILES[$champ]['error'] === UPLOAD_ERR_OK) {
        $nomOriginal = $_FILES[$champ]['name'];
        $nomTemp = $_FILES[$champ]['tmp_name'];
        $nomFinal = uniqid() . '_' . basename($nomOriginal);
        $cheminFinal = $dossier . $nomFinal;
        if (move_uploaded_file($nomTemp, $cheminFinal)) {
            return [$cheminFinal, $nomOriginal];
        }
    }
    return [null, null];
}

// Traitement des 3 fichiers
$resultat = traiterFichier('fichier1', $dossier);
$fichier1 = $resultat[0];
$fichier1_nom = $resultat[1];

$resultat = traiterFichier('fichier2', $dossier);
$fichier2 = $resultat[0];
$fichier2_nom = $resultat[1];

$resultat = traiterFichier('fichier3', $dossier);
$fichier3 = $resultat[0];
$fichier3_nom = $resultat[1];

// Insertion
$stmt = $db->prepare("
    INSERT INTO forms 
    (nom, prenom, email, telephone, materiel, couleur, dimension, epaisseur, message, date, statut, 
     fichier1, fichier2, fichier3, fichier1_nom, fichier2_nom, fichier3_nom) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $nom, $prenom, $email, $telephone, $materiel, $couleur,
    $dimension, $epaisseur, $message, $date, $statut,
    $fichier1, $fichier2, $fichier3,
    $fichier1_nom, $fichier2_nom, $fichier3_nom
]);

?>
