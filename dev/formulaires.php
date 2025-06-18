<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.html');
    exit;
}
?>

<?php

$db = new PDO('sqlite:../Formulaires/formulaires.sqlite');

// Traitement des mises à jour de statut
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mise à jour du statut
    if (isset($_POST['id'], $_POST['statut'])) {
        $stmt = $db->prepare("UPDATE forms SET statut = ? WHERE id = ?");
        $stmt->execute([$_POST['statut'], $_POST['id']]);
    }

    // Suppression du formulaire
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];

        // Récupérer les chemins des fichiers
        $stmt = $db->prepare("SELECT fichier1, fichier2, fichier3 FROM forms WHERE id = ?");
        $stmt->execute([$id]);
        $formulaire = $stmt->fetch(PDO::FETCH_ASSOC);

        // Supprimer les fichiers s’ils existent
        foreach (['fichier1', 'fichier2', 'fichier3'] as $fichierChamp) {
            if (!empty($formulaire[$fichierChamp]) && file_exists($formulaire[$fichierChamp])) {
                unlink($formulaire[$fichierChamp]);
            }
        }

        // Supprimer la ligne de la base
        $stmt = $db->prepare("DELETE FROM forms WHERE id = ?");
        $stmt->execute([$id]);
    }
}

// Récupération des formulaires
$resultat = $db->query("SELECT * FROM forms ORDER BY date DESC");
$formulaires = $resultat->fetchAll(PDO::FETCH_ASSOC);

function couleurStatut($statut) {
    switch ($statut) {
        case 'Recu':
            return '#e0f0ff';
        case 'EnCours':
            return '#fff5cc';
        case 'Terminer':
            return '#d8ffd8';
        default:
            return '#ffffff';
    }
}

function afficherFichier($chemin, $nom) {
    if (!$chemin) return '—';
    $ext = strtolower(pathinfo($chemin, PATHINFO_EXTENSION));
    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    
    if ($isImage) {
        return "<a href='$chemin' download>
                    <img src='$chemin' alt='$nom' style='max-height: 60px;'>
                </a>";
    } else {
        return "<a href='$chemin' download>" . htmlspecialchars($nom) . "</a>";
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pliage Québec</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="../CSS/style.css" />
  <link rel="stylesheet" href="../CSS/header.css" />

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
            position: relative;
        }
        .close-btn {
            position: absolute;
            top: 15px; right: 20px;
            font-size: 34px;
            font-weight: bold;
            cursor: pointer;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        .inline-form {
            display: inline;
            margin: 0;
        }
        .delete-button {
            background-color: #ffdddd;
            border: 1px solid #cc0000;
            color: #a00;
            padding: 8px 16px;
            font-weight: bold;
            border-radius: 4px;
            margin-top: 15px;
        }
    </style>



</head>


<!--------------------------------------------------- Debut du Header --------------------------------------------------->

<body id="top">

<header>
  <div class="hbox header">
    <div class="image_container image_header" style="width: 233px; height: 83px; margin-left: 150px;">
      <img src="images/Logo_PNG.png" alt="Logo Pliage Québec">
    </div>
    <div class="hbox_center header_infos" style="gap: 20px; height: 95px; color: white;  margin-right: 150px;">
      <div class="vbox header_contact" style="gap: 15px; align-items: end;">
        <div><a href="tel:14186828653">418-682-8653</a></div>
        <div><a href="mailto:info@pliagequebec.com">info@pliagequebec.com</a></div>
      </div>
      <div class="header_contact" style="width: 120px;">
        <p>1023 rue Rivard, Québec, QC G1M 3G8</p>
      </div>
      
    </div>

  </div>


  <nav>
    <a href="admin.php" class="nav-item">Admin Acceuil</a>
    <a href="formulaires.php" class="nav-item" style="background-color: white; color: #000;">Formulaires</a>
    <a href="promos.php" class="nav-item">Promotions</a>
    <a href="soumission.php" class="nav-item">Tests de Soumissions</a>
  </nav>
</header>



<!--------------------------------------------------- Fin du Header --------------------------------------------------->

<body>
    <div class="blue-text">
        <p>Formulaires reçus</p>
    </div>
    <?php if (count($formulaires) === 0): ?>
        <p>Aucun formulaire reçu.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Statut</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Matériel</th>
                    <th>Couleur</th>
                    <th>Dimension</th>
                    <th>Épaisseur</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Fichier 1</th>
                    <th>Fichier 2</th>
                    <th>Fichier 3</th>
                    <th>Afficher</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($formulaires as $form): ?>
                    <tr style="background-color: <?= couleurStatut($form['statut']) ?>;">
                        <td>
                            <form method="post" class="inline-form">
                                <input type="hidden" name="id" value="<?= $form['id'] ?>">
                                <select name="statut" onchange="this.form.submit()">
                                    <option value="Recu" <?= $form['statut'] === 'Recu' ? 'selected' : '' ?>>Reçu</option>
                                    <option value="EnCours" <?= $form['statut'] === 'EnCours' ? 'selected' : '' ?>>En cours</option>
                                    <option value="Terminer" <?= $form['statut'] === 'Terminer' ? 'selected' : '' ?>>Terminé</option>
                                </select>
                            </form>
                        </td>
                        <td><?= htmlspecialchars($form['nom']) ?></td>
                        <td><?= htmlspecialchars($form['prenom']) ?></td>
                        <td><?= htmlspecialchars($form['email']) ?></td>
                        <td><?= htmlspecialchars($form['telephone']) ?></td>
                        <td><?= htmlspecialchars($form['materiel']) ?></td>
                        <td><?= htmlspecialchars($form['couleur']) ?></td>
                        <td><?= htmlspecialchars($form['dimension']) ?></td>
                        <td><?= htmlspecialchars($form['epaisseur']) ?></td>
                        <td><?= nl2br(htmlspecialchars($form['message'])) ?></td>
                        <td><?= htmlspecialchars($form['date']) ?></td>
                        <td><?= afficherFichier($form['fichier1'], $form['fichier1_nom']) ?></td>
                        <td><?= afficherFichier($form['fichier2'], $form['fichier2_nom']) ?></td>
                        <td><?= afficherFichier($form['fichier3'], $form['fichier3_nom']) ?></td>
                        <td>
                            <button onclick="openModal(<?= $form['id'] ?>)">Afficher</button>
                        </td>

                    </tr>
                    <div id="modal-<?= $form['id'] ?>" class="modal">
                        <div class="modal-content">
                            <span class="close-btn" onclick="closeModal(<?= $form['id'] ?>)">&times;</span>
                            <h2>Détails du formulaire</h2>
                            <p><strong>Statut :</strong> <?= htmlspecialchars($form['statut']) ?></p>
                            <p><strong>Date :</strong> <?= htmlspecialchars($form['date']) ?></p>
                            <p><strong>Nom :</strong> <?= htmlspecialchars($form['nom']) ?></p>
                            <p><strong>Prénom :</strong> <?= htmlspecialchars($form['prenom']) ?></p>
                            <p><strong>Email :</strong> <?= htmlspecialchars($form['email']) ?></p>
                            <p><strong>Téléphone :</strong> <?= htmlspecialchars($form['telephone']) ?></p>
                            <p><strong>Matériel :</strong> <?= htmlspecialchars($form['materiel']) ?></p>
                            <p><strong>Couleur :</strong> <?= htmlspecialchars($form['couleur']) ?></p>
                            <p><strong>Dimension :</strong> <?= htmlspecialchars($form['dimension']) ?></p>
                            <p><strong>Épaisseur :</strong> <?= htmlspecialchars($form['epaisseur']) ?></p>
                            <p><strong>Message :</strong><br><?= nl2br(htmlspecialchars($form['message'])) ?></p>
                            <p><strong>Fichiers :</strong><br>
                                <?php if ($form['fichier1']): ?>
                                    📎 <a href="<?= $form['fichier1'] ?>" download><?= htmlspecialchars($form['fichier1_nom']) ?></a></br>
                                <?php endif; ?>
                                <?php if ($form['fichier2']): ?>
                                    📎 <a href="<?= $form['fichier2'] ?>" download><?= htmlspecialchars($form['fichier2_nom']) ?></a></br>
                                <?php endif; ?>
                                <?php if ($form['fichier3']): ?>
                                    📎 <a href="<?= $form['fichier3'] ?>" download><?= htmlspecialchars($form['fichier3_nom']) ?></a></br>
                                <?php endif; ?>
                            </p>
                            <form method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer ce formulaire ?');">
                                <input type="hidden" name="delete_id" value="<?= $form['id'] ?>">
                                <button type="submit" class="delete-button">🗑️ Supprimer ce formulaire</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <script>
        function openModal(id) {
            document.getElementById('modal-' + id).style.display = 'block';
        }
        function closeModal(id) {
            document.getElementById('modal-' + id).style.display = 'none';
        }
    </script>
</body>
</html>
