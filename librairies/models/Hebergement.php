<?php
require_once('../datebase.php');
class Hebergement
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getPDO();
    }

    public function selectAll()
    {
        $sql = "SELECT * FROM `hebergement`";
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }


    public function selectbyIdFull($id)
    {
        $sql = "SELECT * FROM hebergement,periode WHERE hebergement.id_hebergement = :id AND periode.id_periode = hebergement.id_hebergement";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();
        return $query->fetch();
    }

    public function selectbyId($id)
    {
        $sql = "SELECT * FROM hebergement WHERE id_hebergement = :id";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();
        return $query->fetch();
    }

    // renvoie le resultat de la recherche d'hebergements avec 
    // $recherhe qui doit etre une ville
    // $personne qui correspond à nombre de couchage 
    public function researchAll($recherche, $personne)
    {
        $sql = "SELECT * FROM `hebergement` WHERE ville like '%$recherche%' AND couchage>=$personne";
        $query = $this->pdo->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
}