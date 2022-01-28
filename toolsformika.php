<?php
session_start();


function selectAllHebergement()
{
    require_once 'dev/connect.php';
    require_once 'dev/tools.php';

    $sql = "SELECT * FROM `hebergement`";
    $query = $db->prepare($sql);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
function selectHebergementbyAllFull($id)
{
    require_once 'dev/connect.php';
    require_once 'dev/tools.php';

    $sql = "SELECT * FROM `hebergement`,`periode`";
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function selectHebergementbyIdFull($id)
{
    require_once 'dev/connect.php';
    require_once 'dev/tools.php';

    $sql = "SELECT * FROM `hebergement`,`periode` WHERE `id_hebergement` = :id AND `id_periode`=`id_hebergement`";
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id);
    $query->execute();
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
    return $query->fetch(PDO::FETCH_ASSOC);
}