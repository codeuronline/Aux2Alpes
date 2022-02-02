<?php

//renvoie tous les hebergements
function selectAllHebergement()
{
    global $db;
    require_once 'connect.php';
    require_once 'tools.php';

    $sql = "SELECT * FROM `hebergement`";
    $query = $db->prepare($sql);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

//renvoie tous les hebergements ainsi que la periode associée
function selectHebergementbyAllFull($id)
{
    global $db;
    require_once 'connect.php';
    require_once 'tools.php';

    $sql = "SELECT * FROM `hebergement`";
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

//renvoie un hebergement ainsi que ca periode associée
function selectHebergementbyIdFull($id)
{
    global $db;
    require_once 'connect.php';
    require_once 'tools.php';

    $sql = "SELECT * FROM hebergement,periode WHERE hebergement.id_hebergement = :id AND periode.id_periode = hebergement.id_hebergement";
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}
//renvoie les jours associés a un id_periode
function selectJourFreebyId($id)
{
    global $db;
    require_once 'connect.php';
    require_once 'tools.php';

    $sql1 = "SELECT * FROM `jour` WHERE id_periode=:id AND etat=0";
    $query1 = $db->prepare($sql1);
    $query1->bindValue(':id', $id);
    $query1->execute();
    return $query1->fetchAll(PDO::FETCH_ASSOC);
}

//renvoie un hebergement en fonction de l'id 
function selectHebergementbyId($id)
{
    global $db;
    require_once 'connect.php';
    require_once 'tools.php';

    $sql = "SELECT * FROM hebergement WHERE id_hebergement = :id";
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}
// renvoie le resultat de la recherche d'hebergements avec 
// $recherhe qui doit etre une ville
// $personne qui correspond à nombre de couchage 
function researchHebergementAll($recherche, $personne)
{
    global $db;
    require_once 'connect.php';
    require_once 'tools.php';
    $sql = "SELECT * FROM `hebergement` WHERE ville like '%$recherche%' AND couchage>=$personne";
    $query = $db->prepare($sql);
    $query->execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
}
//met jour la table jour en fonction d'une date de debut d'une date fin et d'un id
function updateJour($id, $debut, $fin)
{
    global $db;
    require_once 'connect.php';
    $indice['intervalle'] = dateDiff($debut, $fin);
    for ($i = 0; $i <= $indice['intervalle']; $i++) {
        $value = date("Y-m-d", strtotime($_POST['debutReserv'] . "+ $i days"));
        $compteur = $i + 1;
        echo "valeur à reserver:" . $value . "<br>";
        $sql5 = 'UPDATE `jour` SET etat=1 WHERE id_periode=:id_periode AND date_jour=:date_jour';
        $query5 = $db->prepare($sql5);
        $query5->bindValue(":id_periode", $_POST['id_hebergement']);
        $query5->bindValue(":date_jour", $value);
        $query5->execute();
    }
}
//supprime un hebergement en fonction de l'id 
// -->      supprime la periode associé
// -->      supprime les jours liés à la periode et l'hebergement
function delHebergementbyId($id)
{
    global $db;

    require_once 'connect.php';
    require_once 'tools.php';
    //1-> recupere les elements id_periode, et le lien des photo1a5 dans la table hebergement
    $sql = 'SELECT id_periode,photo1,photo2,photo3,photo4,photo5 FROM `hebergement` WHERE `id_hebergement` = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $hebergement = $query->fetch(PDO::FETCH_ASSOC);

    //2-> on efface l'element contenant id_periode dans la table periode
    $sql1 = 'DELETE FROM `periode`  WHERE `id_periode` = :id';
    $query1 = $db->prepare($sql1);
    $query1->bindValue(':id', intval($id), PDO::PARAM_INT);
    $query1->execute();

    //
    //3-> on efface les elements contenant id_periode dans la table jour
    // cas suppression de la periode meme si un des jours est reservé
    // on cherche les jours de la periode qui ont un état réservé avant

    $sql21 = 'SELECT count(id_periode) as compteur from `jour` WHERE `id_periode`= :id AND etat=1';
    $query21 = $db->prepare($sql21);
    $query21->bindValue(':id', intval($id), PDO::PARAM_INT);
    $query21->execute();
    //on recupere le nombre d'enregistrement qui presente deja une reservation
    $row = $query21->fetch(PDO::FETCH_ASSOC);

    // puis on supprime les elements de la table jour
    $sql31 = 'DELETE FROM `jour` WHERE `id_periode`= :id';
    $query31 = $db->prepare($sql31);
    $query31->bindValue(':id', intval($id), PDO::PARAM_INT);
    $query31->execute();


    if ($row['compteur'] > 0) {
        $_SESSION['warning'] = $row['compteur'] . "correpondance(s) trouvée(s); Procédure d'avertissement des utilisateur(s) concerné(s) lancée";
    }

    //4-> on efface l'element contenant id_hebergement hebergement dans 
    $sql3 = 'DELETE FROM `hebergement`  WHERE `id_hebergement` = :id';
    $query3 = $db->prepare($sql3);
    $query3->bindValue(':id', $id, PDO::PARAM_INT);
    $query3->execute();

    //5-> on efface physiquement les fichiers à partir des elements lien photo1à5
    for ($i = 1; $i < 6; $i++) {
        if (!(empty($hebergement['photo' . $i]))) {
            unlink('photo/' . $hebergement['photo' . $i]);
        }
    }
    return $hebergement;
}