<?php
$db = new PDO('sqlite:Formulaires/formulaires.sqlite');

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
$date = date('Y-m-d H:i:s');
$statut = 'Recu';

// Dossier des fichiers
$dossier = 'Formulaires/uploads/';
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
[$fichier1, $fichier1_nom] = traiterFichier('fichier1', $dossier);
[$fichier2, $fichier2_nom] = traiterFichier('fichier2', $dossier);
[$fichier3, $fichier3_nom] = traiterFichier('fichier3', $dossier);

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

echo "Formulaire avec fichiers enregistré.";
?>
