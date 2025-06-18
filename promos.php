<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.html');
    exit;
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

  <link rel="stylesheet" href="CSS/style.css" />
  <link rel="stylesheet" href="CSS/header.css" />
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
    <a href="formulaires.php" class="nav-item">Formulaires</a>
    <a href="promos.php" class="nav-item" style="background-color: white; color: #000;">Promotions</a>
  </nav>
</header>



<!--------------------------------------------------- Fin du Header --------------------------------------------------->

<body>
    <div class="vbox_center"
        style="
        height: 85vh;
        margin: 0;
        text-align: center;
        padding-top: 150px;">
        <p class="blue-text">Mise à jour du fichier de promotions</p>
        <form action="upload.php" method="post" enctype="multipart/form-data">
          <br>
          <br>
          <br>

        
          <div class="hbox_center" style="gap: 100px;">
            <div class="vbox_center" style="gap: 10px;">
              <input type="file" id="fichier" name="fichier" accept=".pdf" style="display: none;">

              <!-- Lier un label à l'input caché, et utiliser une image comme déclencheur -->

              <h3>Cliquer sur Polly pour ajouter un fichier promotions.pdf</h3>
              <label for="fichier" style="cursor: pointer;">
                <div class="image_container send" style="width: 326px;">
                  <img src="images/Promotions/polly.png" alt="Choisir un fichier">
                </div>
              </label>
              <!-- Ici le nom du fichier sélectionné s'affichera -->
              <p id="nom-fichier" style="font-weight: bold;">Fichier sélectionné : </p>

            </div>
            <div class="vbox_center" style="gap: 10px;">
              <h3>Cliquer sur Watson pour Télécharger</h3>
              <!-- Bouton submit remplacé par une image -->
              <div class="image_container send" style="width: 326px; height: 250px;">
                <button type="submit" style="all: unset; cursor: pointer;">
                    <img src="images/Promotions/watson.png" alt="Envoyer"  style="padding-top: 20px;">
                </button>              
              </div>
            </div>
          
          
          </div>

        </form>
          <br>
          <br>
          <br>
        <button onclick="document.location='index.html'">Retour au site</button>

    </div>


<script>
  const inputFichier = document.getElementById('fichier');
  const affichageNom = document.getElementById('nom-fichier');

  inputFichier.addEventListener('change', function () {
    if (this.files && this.files.length > 0) {
      affichageNom.textContent = "Fichier sélectionné : " + this.files[0].name;
      localStorage.setItem('nomFichierPromo', nom);
    } else {
      affichageNom.textContent = "Fichier sélectionné : ";
      localStorage.removeItem('nomFichierPromo');
    }
  });

  window.addEventListener('DOMContentLoaded', () => {
  const nomSauvegarde = localStorage.getItem('nomFichierPromo');
  if (nomSauvegarde) {
    affichageNom.textContent = "Fichier sélectionné : " + nomSauvegarde;
  }
});
</script>

<script>
  // Fonction pour lire les paramètres dans l'URL
  function getParam(name) {
    return new URLSearchParams(window.location.search).get(name);
  }

  const message = getParam("upload");
  if (message === "success") {
    alert("✅ Fichier téléversé avec succès !");
  } else if (message === "error_type") {
    alert("❌ Type de fichier non autorisé. Seuls les PDF sont acceptés.");
  } else if (message === "error_upload") {
    alert("❌ Erreur lors du téléversement du fichier.");
  } else if (message === "error_nofile") {
    alert("❌ Impossible de déplacer le fichier sur le serveur.");
  }
</script>

</body>
</html>

