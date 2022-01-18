<?php
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
                unset($form[$key]);
            }
            if (($key == 'prix') || ($key == 'couchage') || ($key == 'sdb') || $key = 'id_hebergement') {
                $form[$key] = intval(strip_tags($_POST[$key]));
            }
        }
        $rep_photo = $_SERVER['DOCUMENT_ROOT'] . strstr($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME']), true);
        $extensionsAutorisees_image = array(".jpeg", ".jpg");
        for ($i = 1; $i < 6; $i++) {
            if (empty($_FILES['photo' . $i]['name'])) {
                //unset($form['photo' . $i]);
            } elseif (is_uploaded_file($_FILES['photo' . $i]['tmp_name'])) {
                // test si le repertoire de destination exist sinon il le crée
                IsDir_or_CreateIt("photo");
                $maphoto = $_FILES['photo' . $i]['name'];
                $extension = substr($monphoto, strrpos($monphoto, '.'));
                // Contrôle de l'extension du fichier
                if (!(in_array($extension, $extensionsAutorisees_image))) {
                    $_SESSION['erreur'] = 'photo' . $i . ": Format non conforme";
                } else {
                    $form['photo' . $i] = "/" . $form['categorie'] . '_' . $form['ville'] . '_' . $i . $extension;
                    rename($_FILES['photo' . $i]['tmp_name'], $rep_photo . $form['photo' . $i]);
                }
            } else {
                $form['photo' . $i] = "";
            }
        }
    
        $sql = "SELECT `id_periode` FROM `hebergement` WHERE `id_hebergement` = :id_hebergement";
        $query = $db->prepare($sql);
        $query->bindValue(':id_hebergement', $form['id_hebergement'], PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch();
        $form['id_periode'] = intval($result[0]);
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
        exit;
        
    } else {
        $_SESSION['erreur'] = "probleme dans la modification methode post";
    }
}