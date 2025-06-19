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

  <link rel="stylesheet" href="../CSS/style.css" />
  <link rel="stylesheet" href="../CSS/header.css" />
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
    <a href="admin.php" class="nav-item" style="background-color: white; color: #000;">Admin Acceuil</a>
    <a href="formulaires.php" class="nav-item">Formulaires</a>
    <a href="promos.php" class="nav-item">Promotions</a>
  </nav>
</header>



<!--------------------------------------------------- Fin du Header --------------------------------------------------->

<div class="vbox_center" 
  style="
  gap: 20px;
  padding-top: 30px;
  padding-bottom: 30px;
  width: auto;">
  <div class="blue-text" style="max-width: 75%; align-self: center; text-align: center;">
    <p >Bienvenue dans la page d'administration du site web pliagequebec.com.</p>
  </div>
  <h3></h3>

</div>
</body>
</html>
