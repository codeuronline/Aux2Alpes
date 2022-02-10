<?php
require_once('../librairies/database.php');
//require_once('librairies/database.php');
//require_once('librairies/utils.php');
require_once('../librairies/utils.php');
class Jour
{

    
    public function add($id, $debut, $fin)
    {
        $pdo = getPDO();
        for ($i = 0; $i <= dateDiff($debut, $fin); $i++) {
            $value = date("Y-m-d", strtotime($debut . "+ $i days"));
            $compteur = $i + 1;
            $sql = 'INSERT INTO jour(id_periode,date_jour,periode_jour,etat) VALUES (:id, :date_jour,:periode_jour, 0)';
            $query = $pdo->prepare($sql);
            $query->bindValue(":id", $id);
            $query->bindValue(":date_jour", $value);
            $query->bindValue(":periode_jour", $compteur);
            $query->execute();
        }
    }

    function updateReserved($form): void
    {
        $pdo = getPDO();
        extract($form);
        for ($i = 0; $i <= dateDiff($debut, $fin); $i++) {
            $value = date("Y-m-d", strtotime($debut . "+ $i days"));
            $compteur = $i + 1;
            //echo "valeur à reserver:" . $value . "<br>";
            $sql = 'UPDATE `jour` SET etat=1 WHERE id_periode=:id_periode AND date_jour=:date_jour';
            $query = $pdo->prepare($sql);
            $query->bindValue(":id_periode", $id_periode);
            $query->bindValue(":date_jour", $value);
            $query->execute();
        }
    }
    public function selectFree($id): array
    {
        $pdo = getPDO();

        $sql = "SELECT * FROM `jour` WHERE id_periode=:id AND etat=0";
        $query = $pdo->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();
        return $query->fetchAll();
    }
}