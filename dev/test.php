<?php
function debugLog($message) {
    $fichier = __DIR__ . '/debug.log'; // Chemin du fichier (dans le même dossier)
    $date = date('Y-m-d H:i:s');
    file_put_contents($fichier, "[$date] $message\n", FILE_APPEND);
}




    debugLog('DONE ');
?>
