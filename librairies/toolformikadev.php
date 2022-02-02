<?php
require_once('database.php');
//renvoie tous les hebergements
function selectAllHebergement()
{

    $db = getPDO();
    $sql = "SELECT * FROM `hebergement`";
    $query = $db->prepare($sql);
    $query->execute();
    return $query->fetchAll();
}

//renvoie tous les hebergements ainsi que la periode associée
function selectHebergementbyAllFull($id)
{
    $db = getPDO();
    $sql = "SELECT * FROM `hebergement`";
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();
    return $query->fetch();
}

//renvoie un hebergement ainsi que ca periode associée
function selectHebergementbyIdFull($id)
{
    $db = getPDO();
    $sql = "SELECT * FROM hebergement,periode WHERE hebergement.id_hebergement = :id AND periode.id_periode = hebergement.id_hebergement";
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}
//renvoie le nb jours free
function nbJourFreebyId($id): INT
{
    $db = getPDO();
    $sql = 'SELECT count(id_jour) AS max_jour_libre FROM `jour` WHERE id_periode=:id AND etat=0'; // nb jour libre
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();
    $result = $query->fetch();
    return $result['max_jour_libre'];
}
/*
$sql1 = 'SELECT count(id_jour) AS max_jour FROM `jour` WHERE id_periode=:id'; // max de jour
$query1 = $db->prepare($sql1);
$query1->bindValue(':id', $hebergement['id_periode']);
$query1->execute();
$result1 = $query1->fetch();*/
//renvoie le max de jour d'une periode
function maxDayById($id): int
{
    $db = getPDO();
    $sql = 'SELECT count(id_jour) AS max_jour FROM `jour` WHERE id_periode=:id'; // max de jour
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();
    $result = $query->fetch();
    return $result['max_jour'];
}

//renvoie les jours associés a un id_periode
function selectJourFreebyId($id)
{
    $db = getPDO();

    $sql1 = "SELECT * FROM `jour` WHERE id_periode=:id AND etat=0";
    $query1 = $db->prepare($sql1);
    $query1->bindValue(':id', $id);
    $query1->execute();
    return $query1->fetchAll(PDO::FETCH_ASSOC);
}

function selectHebergementbyId($id)
{
    $db = getPDO();
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
    $db = getPDO();
    $sql = "SELECT * FROM `hebergement` WHERE ville like '%$recherche%' AND couchage>=$personne";
    $query = $db->prepare($sql);
    $query->execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
}
function updateJour($id, $debut, $fin)
{
    $db = getPDO();
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