<?php
require_once('../utils.php');
class Hebergement
{
    function selectAllHebergement()
    {
        $db = getPDO();
        $sql = "SELECT * FROM `hebergement`";
        $query = $db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    function selectHebergementbyIdFull($id)
    {
        $db = getPDO();
        $sql = "SELECT * FROM hebergement,periode WHERE hebergement.id_hebergement = :id AND periode.id_periode = hebergement.id_hebergement";
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();
        return $query->fetch();
    }
}