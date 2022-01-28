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
function updateJour($id, $debut, $fin)
{
    global $db;
    require_once 'connect.php';
    $indice['intervalle'] = dateDiff($id, $debut, $fin);
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