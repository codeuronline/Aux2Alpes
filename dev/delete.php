<?php
session_start();

if (isset($_GET['id_hebergement']) && !empty($_GET['id_hebergement'])) {
    require_once('connect.php');

    //on traite leffacement en 3 etapes
    //1-> recupere l'element id_periode dans la table hebergement


    $id_hebergement = intval(strip_tags(($_GET['id_hebergement'])));
    $sql = 'SELECT id_periode FROM `hebergement` WHERE `id_hebergement` = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id_hebergement, PDO::PARAM_INT);
    $query->execute();
    $hebergement = $query->fetch();

    //2-> on efface l'element contenant id_periode dans la table peridode
    $sql1 = 'DELETE  FROM periode  WHERE id_periode = :id';
    $query1 = $db->prepare($sql1);
    $query1->bindValue(':id', intval($hebergement['id_periode']), PDO::PARAM_INT);
    $query1->execute();

    //3-> on efface l'element contenant id_hebergement hebergement dans 
    $sql2 = 'DELETE  FROM hebergement  WHERE id_periode = :id';
    $query2 = $db->prepare($sql2);
    $query2->bindValue(':id', $id_hebergement, PDO::PARAM_INT);
    $query2->execute();

    $_SESSION['message'] = "Hébergement supprimé";
    header('Location index.php');
    require_once 'close.php';

    //on verifie si le hebergement existe
    if (!$hebergement) {
        $_SESSION['erreur'] = "Cet ID n'existe pas";
        //header('Location: index.php');
    }
} else {
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}