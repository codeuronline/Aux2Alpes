<?php
session_start();
if ($_POST) {
    if (
        isset($_POST['categorie']) && !empty($_POST['categorie'])
        && isset($_POST['nom']) && !empty($_POST['nom'])
        && isset($_POST['ville']) && !empty($_POST['ville'])
        && isset($_POST['pays']) && !empty($_POST['pays'])
        && isset($_POST['description']) && !empty($_POST['description'])
        && isset($_POST['debut']) && !empty($_POST['debut'])
        && isset($_POST['fin']) && !empty($_POST['fin'])
    ) {
        require_once 'connect.php';
        require_once  'tools.php';

        foreach ($_POST as $key => $value) {
            $form[$key] = strip_tags($_POST[$key]);
            if ($key == 'chien') {
                $form['animaux'] = ((strip_tags($_POST[$key]) == "0") || (strip_tags($_POST[$key]) == 0)) ? 0 : 1;
                unset($form[$key]);
            }
            
            if (($key == 'wifi') || ($key == 'fumeur') || ($key == 'piscine')) {
                $form[$key] = ((strip_tags($_POST[$key]) == 0) || (strip_tags($_POST[$key]) == "0")) ? 0 : 1;
            }
            if (($key == 'debut') || ($key = "fin")) {
                $periode[$key] = strip_tags($_POST[$key]);
            }
            if (($key == 'prix') || ($key == 'couchage') || ($key == 'sdb') || $key = 'id_hebergement') {
                $form[$key] = intval(strip_tags($_POST[$key]));
            }
        }

        // cas des photos
        $extensionsAutorisees_image = array(".jpeg", ".jpg");
        for ($i = 1; $i < 6; $i++) {
            if ((isset($_FILES['photo' . $i]['name'])) &&  (is_uploaded_file($_FILES['photo' . $i]['tmp_name']))) {

                //on recupere le nom du fichier a partir de celui dans la bd
                $sql = "SELECT `photo$i` FROM `hebergement` WHERE `id_hebergement` = :id_hebergement";
                $query = $db->prepare($sql);
                $query->bindValue(':id_hebergement', $form['id_hebergement'], PDO::PARAM_INT);
                $query->execute();

                $result = $query->fetch(PDO::FETCH_ASSOC);
                $file = "photo/" . $result['photo' . $i];

                if (!(empty($form['photo' . $i]))) {
                    $form['photo' . $i] =  'photo_' . $i . '_' . date("Y_m_d_H_i") . $extension;
                }


                $maphoto = $_FILES['photo' . $i]['name'];
                $maphoto_tmp = $_FILES['photo' . $i]['tmp_name'];

                $extension = substr($maphoto, strrpos($maphoto, '.'));
                // Contrôle de l'extension du fichier
                if (!(in_array(
                    $extension,
                    $extensionsAutorisees_image
                ))) {
                    $_SESSION['erreur'] = 'photo' . $i . ": Format non conforme";
                } else {
                    unlink($file);
                    move_uploaded_file($maphoto_tmp, "photo/" . $result['photo' . $i]);
                }
            } else {
                
                //$form['photo' . $i] = "";
            }
        }


        //1 on traite la table jour
        //1.5 on verifie qu'il n'y a pas de correspondance avec une periode de reservation
        $sql20 = 'SELECT count(date_jour) AS compteur from `jour` WHERE `id_periode`= :id AND etat=1';
        $query20 = $db->prepare($sql20);
        $query20->bindValue(':id', intval($form['id_periode']), PDO::PARAM_INT);
        $query20->execute();
        $row = $query20->fetch(PDO::FETCH_ASSOC);

        $sql21 = 'SELECT date_jour from `jour` WHERE `id_periode`= :id AND etat=1';
        $query21 = $db->prepare($sql21);
        $query21->bindValue(':id', intval($form['id_periode']), PDO::PARAM_INT);
        $query21->execute();
        $elements = $query21->fetchAll(PDO::FETCH_ASSOC);

        $newtab = array();
        foreach ($elements as $correspondance) {
            array_push($newtab, $correspondance['date_jour']);
        }

        if ($row['compteur'] > 0) {
            $_SESSION['warning'] = $row['compteur'] . " correpondance(s) trouvée(s)<br>Procédure d'avertissement des utilisateur(s) concerné(s) lancées";
        }

        //1.6 a faire on enregistre les correspondance de reservation et regarde si elles sont disponibles dans la nouvelle periode
        //si oui reaffecté en les jours reservé

        //si non detruire la variable $_SESSION['warning']
        // impacté en parti --> declenché la procedure de remboursement

        //2. on supprime les élements de la table jour
        $sql2 = 'DELETE FROM `jour` WHERE `id_periode`= :id';
        $query2 = $db->prepare($sql2);
        $query2->bindValue(':id', intval($form['id_periode']), PDO::PARAM_INT);
        $query2->execute();

        $jour['intervalle'] = dateDiff($periode['debut'], $periode['fin']);
        $jour['id_periode'] = $form['id_periode'];
        //1.on insere les nouveau élémentS dan la table jour
        for ($i = 0; $i <= $jour['intervalle']; $i++) {
            $value = date("Y-m-d", strtotime($periode['debut'] . "+ $i days"));
            $compteur = $i + 1;
            // echo dateIncDay($periode['debut'], $i) . "--$i--<br>";
            if (in_array($value, $newtab)) {
                $sql5 = 'INSERT INTO jour(id_periode,date_jour,periode_jour,etat) VALUES (:id, :date_jour,:periode_jour, 1)';
            } else {
                $sql5 = 'INSERT INTO jour(id_periode,date_jour,periode_jour,etat) VALUES (:id, :date_jour,:periode_jour, 0)';
            }
            $query5 = $db->prepare($sql5);
            $query5->bindValue(":id", $form['id_periode']);
            $query5->bindValue(":date_jour", $value);
            $query5->bindValue(":periode_jour", $compteur);
            $query5->execute();
        }
        //3. on selectionne les nouveaux élements de la nouvelle periode;
        $sql = "SELECT `id_periode` FROM `hebergement` WHERE `id_hebergement` = :id_hebergement";
        $query = $db->prepare($sql);
        $query->bindValue(':id_hebergement', $form['id_hebergement'], PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch();
        $form['id_periode'] = intval($result[0]);
        // on met jour les autre champ de la table hebergement et de la table periode
        foreach ($form as $key => $value) {
            if (!($key == "id_hebergement") || (!($key == "id_periode"))) {
                if (($key == 'debut') || ($key == 'fin')) {
                    $sql = "UPDATE `periode` SET $key=:$key WHERE `id_periode`=" . $form['id_periode'];
                    $query = $db->prepare($sql);
                    $query->bindValue(":$key", $value);
                } else {
                    $sql = "UPDATE `hebergement` SET $key=:$key WHERE `id_hebergement`=" . $form['id_hebergement'];
                    $query = $db->prepare($sql);
                    $query->bindValue(":$key", $value);
                }
                $query->execute();
            }
        }
        require_once 'close.php';
        $_SESSION['message'] = "Hébergement Modifié";
        header('Location: index.php');
    } else {
        $_SESSION['erreur'] = "probleme dans la modification methode post";
    }
}