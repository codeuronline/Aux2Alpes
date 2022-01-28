<?php

function selectAllHebergement()
{
    global $db;
    require_once 'dev/connect.php';
    require_once 'dev/tools.php';

    $sql = "SELECT * FROM `hebergement`";
    $query = $db->prepare($sql);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
function selectHebergementbyAllFull($id)
{
    global $db;
    require_once 'dev/connect.php';
    require_once 'dev/tools.php';

    $sql = "SELECT * FROM `hebergement`,`periode`";
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();
    require_once 'dev/close.php';
    return $query->fetch(PDO::FETCH_ASSOC);
}

function selectHebergementbyIdFull($id)
{
    global $db;
    require_once 'dev/connect.php';
    require_once 'dev/tools.php';

    $sql = "SELECT * FROM `hebergement`,`periode` WHERE `id_hebergement` = :id AND `id_periode`=`id_hebergement`";
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();
    require_once 'dev/close.php';
    return $query->fetch(PDO::FETCH_ASSOC);
}
function selectHebergementbyId($id)
{
    require_once 'dev/connect.php';
    require_once 'dev/tools.php';


    $sql = "SELECT * FROM `hebergement`,`periode` WHERE `id_hebergement` = :id";
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();
    require_once 'dev/close.php';
    return $query->fetch(PDO::FETCH_ASSOC);
}
function researchHebergementAll($recherche, $personne)
{
    global $db;
    require_once 'dev/connect.php';
    require_once 'dev/tools.php';
    $sql = "SELECT * FROM `hebergement` WHERE ville like '%$recherche%' AND couchage>=$personne";
    $query = $db->prepare($sql);
    $query->execute();
    require_once 'dev/close.php';
    return $query->fetchAll(PDO::FETCH_ASSOC);
}