<?php
require_once('../librairies/database.php');
class Reservation
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getPDO();
    }

    public function add($idUser, $idHebergement, $debut, $fin): void
    {
        $db = getPDO();
        $sql = "INSERT INTO `reservation` (id_hebergement,id_utilisateur,debut,fin) VALUES (:id_hebergement,:id_utilisateur,:debut,:fin)";
        $query = $db->prepare($sql);
        $query->bindValue(":id_hebergement", $idHebergement);
        $query->bindValue(":id_utilisateur", $idUser);
        $query->bindValue(":debut", $debut);
        $query->bindValue(":fin", $fin);
        $query->execute();
    }
}