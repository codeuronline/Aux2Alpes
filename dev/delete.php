<?php
session_start();
require_once('../librairies/models/Periode.php');
//require_once('libraires/models/Periode.php');
require_once('../librairies/models/Jour.php');
require_once('../librairies/models/Hebergement.php');
$modelHebergement = new Hebergement();
require_once('toolformikadev.php');
if (isset($_GET['id_hebergement']) && !empty($_GET['id_hebergement'])) {

    $hebergement = $modelHebergement->del(intval(strip_tags(($_GET['id_hebergement']))));
    
    //6-> on renvoie le message de fin de traitement
    
    $_SESSION['message'] = "Hébergement supprimé";
    header('Location: index.php');
    require_once 'close.php';
    //on verifie si le hebergement existe
    if (!$hebergement) {
        $_SESSION['erreur'] = "Cet ID n'existe pas";
        header('Location: index.php');
        exit;
    }
} else {
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
    exit;
}