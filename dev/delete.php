<?php
session_start();

if (isset($_GET['id_hebergement']) && !empty($_GET['id_hebergement'])) {
    require_once('connect.php');

    //on traite leffacement en 3 etapes
   
   //1-> recupere les elements id_periode, et le lien des photo1a5 dans la table hebergement
    $id_hebergement = intval(strip_tags(($_GET['id_hebergement'])));
    $sql = 'SELECT id_periode,photo1,photo2,photo3,photo4,photo5 FROM `hebergement` WHERE `id_hebergement` = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id_hebergement, PDO::PARAM_INT);
    $query->execute();
    $hebergement = $query->fetch(PDO::FETCH_ASSOC);
   
    //2-> on efface l'element contenant id_periode dans la table periode
    $sql1 = 'DELETE FROM `periode`  WHERE `id_periode` = :id';
    $query1 = $db->prepare($sql1);
    $query1->bindValue(':id', intval($hebergement['id_periode']), PDO::PARAM_INT);
    $query1->execute();

    //3-> on efface les elements contenant id_periode dans la table jour
    $sql2 = 'DELETE FROM `jour` WHERE `id_periode`= :id';
    $query2 = $db->prepare($sql2);
    $query2->bindValue(':id', intval($hebergement['id_periode']), PDO::PARAM_INT);
    $query2->execute();

    //4-> on efface l'element contenant id_hebergement hebergement dans 
    $sql3 = 'DELETE  FROM `hebergement`  WHERE `id_hebergement` = :id';
    $query3 = $db->prepare($sql3);
    $query3->bindValue(':id', $id_hebergement, PDO::PARAM_INT);
    $query3->execute();

    //5-> on efface physiquement les fichiers à partir des elements lien photo1à5
    for ($i = 1; $i < 6; $i++) {
        if (!(empty($hebergement['photo' . $i]))) {
            unlink('photo/' . $hebergement['photo' . $i]);
        }
    }
    
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