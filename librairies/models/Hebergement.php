<?php
require_once('../librairies/database.php');
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


    public function selectFull($id)
    {
        $sql = "SELECT * FROM hebergement,periode WHERE hebergement.id_hebergement = :id AND periode.id_periode = hebergement.id_hebergement";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();
        return $query->fetch();
    }

    public function select($id)
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

    function insert(array $form)
    {
        $sql =
            'INSERT INTO `hebergement` 
    (nom,description,prix,adresse,gps,wifi,fumeur,piscine,animaux,douche,taxi,categorie,couchage,sdb,ville,pays,photo1,photo2,photo3,photo4,photo5,id_periode)
    VALUES 
    (:nom, :description, :prix, :adresse, :gps, :wifi, :fumeur,:piscine, :animaux, :douche, :taxi, :categorie, :couchage, :sdb, :ville, :pays, :photo1, :photo2, :photo3, :photo4, :photo5, :id_periode)';

        $query = $this->pdo->prepare($sql);
        foreach ($form as $key => $value) {
            $query->bindValue(":$key", $value);
        }
        $query->execute();
    }

    function del($id)
    {
        //1-> recupere les elements id_periode, et le lien des photo1a5 dans la table hebergement
        $sql = 'SELECT id_periode,photo1,photo2,photo3,photo4,photo5 FROM `hebergement` WHERE `id_hebergement` = :id';
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $hebergement = $query->fetch();

        //2-> on efface l'element contenant id_periode dans la table periode
        $sql1 = 'DELETE FROM `periode`  WHERE `id_periode` = :id';
        $query1 = $this->pdo->prepare($sql1);
        $query1->bindValue(':id', intval($id), PDO::PARAM_INT);
        $query1->execute();

        //
        //3-> on efface les elements contenant id_periode dans la table jour
        // cas suppression de la periode meme si un des jours est reservé
        // on cherche les jours de la periode qui ont un état réservé avant

        $sql21 = 'SELECT count(id_periode) as compteur from `jour` WHERE `id_periode`= :id AND etat=1';
        $query21 = $this->pdo->prepare($sql21);
        $query21->bindValue(':id', intval($id), PDO::PARAM_INT);
        $query21->execute();
        //on recupere le nombre d'enregistrement qui presente deja une reservation
        $row = $query21->fetch(PDO::FETCH_ASSOC);

        // puis on supprime les elements de la table jour
        $sql31 = 'DELETE FROM `jour` WHERE `id_periode`= :id';
        $query31 = $this->pdo->prepare($sql31);
        $query31->bindValue(':id', intval($id), PDO::PARAM_INT);
        $query31->execute();


        if ($row['compteur'] > 0) {
            $_SESSION['warning'] = $row['compteur'] . "correpondance(s) trouvée(s); Procédure d'avertissement des utilisateur(s) concerné(s) lancée";
        }

        //4-> on efface l'element contenant id_hebergement hebergement dans 
        $sql3 = 'DELETE FROM `hebergement`  WHERE `id_hebergement` = :id';
        $query3 = $this->pdo->prepare($sql3);
        $query3->bindValue(':id', $id, PDO::PARAM_INT);
        $query3->execute();

        //5-> on efface physiquement les fichiers à partir des elements lien photo1à5
        for (
            $i = 1;
            $i < 6;
            $i++
        ) {
            if (!(empty($hebergement['photo' . $i]))) {
                unlink('photo/' . $hebergement['photo' . $i]);
            }
        }
        return $hebergement;
    }
}