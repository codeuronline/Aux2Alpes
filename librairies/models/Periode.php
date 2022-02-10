<?php
require_once('../librairies/database.php');

class Periode
{
    public function add($id, $debut, $fin): void
    {
        $pdo = getPDO();
        $sql = "INSERT INTO `periode`(id_periode,debut,fin) VALUES (:id,:debut,:fin)";
        $query = $pdo->prepare($sql);
        $query->bindValue(":id", $id);
        $query->bindValue(":debut", $debut);
        $query->bindValue(":fin", $fin);
        $query->execute();
    }
    public function select($id): array
    {
        $pdo = getPDO();
        $sql = "SELECT * FROM `periode` WHERE id_periode=:id";
        $query = $pdo->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->fetch();
    }

    public function del($id): void
    {

        $pdo = getPDO();
        $sql = "DELETE * FROM `periode` WHERE id_periode=:id";
        $query = $pdo->prepare($sql);
        $query->bindValue(":id", $id);
        $query->execute();
    }

    public function update($form): void
    {
        $pdo = getPDO();
        foreach ($form as $key => $value) {
            if (($key == 'debut') || ($key == 'fin')) {
                $sql = "UPDATE `periode` SET $key=:$key WHERE `id_periode`=" . $form['id_periode'];
                $query = $pdo->prepare($sql);
                $query->bindValue(":$key", $value);
            }
        }
        $query->execute();;
    }
}
?>