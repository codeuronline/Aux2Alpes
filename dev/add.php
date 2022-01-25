<?php

session_start();
// il faut d'abord traité la table periode pour ensuite  traiter la table hebergement
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
        require_once 'tools.php';
        var_dump($_POST);
        //parcours du tableau post et constitution des elements d'entree des tables form et periode
        foreach ($_POST as $key => $value) {
            $form[$key] = strip_tags($_POST[$key]);
            if ($key == 'chien') {
                $form['animaux'] = (strip_tags($_POST[$key]) == "false") ? 0 : 1;
                unset($form[$key]);
            }
            if (($key == 'wifi') || ($key == 'fumeur') || ($key == 'piscine') || ($key == 'douche') || ($key == 'taxi')) {
                $form[$key] = (strip_tags($_POST[$key]) == "false") ? 0 : 1;
            }
            if (($key == 'debut') || ($key = "fin")) {
                $periode[$key] = strip_tags($_POST[$key]);
                unset($form[$key]);
            }
            if (($key == 'prix') || ($key == 'couchage') || ($key == 'sdb')) {
                $form[$key] = intval(strip_tags($_POST[$key]));
            }
        }
        echo"<br>";var_dump($form);
        //cas des images
        //$rep_photo = $_SERVER['DOCUMENT_ROOT'] . strstr($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME']), true);
        $extensionsAutorisees_image = array(".jpeg", ".jpg");
        for ($i = 1; $i < 6; $i++) {
            if ((isset($_FILES['photo' . $i]['name'])) &&  (is_uploaded_file($_FILES['photo' . $i]['tmp_name']))) {
                // test si le repertoire de destination exist sinon il le crée
                IsDir_or_CreateIt("photo");
                $maphoto = $_FILES['photo' . $i]['name'];
                $maphoto_tmp = $_FILES['photo' . $i]['tmp_name'];
                $extension = substr($maphoto, strrpos($maphoto, '.'));
                // Contrôle de l'extension du fichier
                if (!(in_array($extension, $extensionsAutorisees_image))) {
                    $_SESSION['erreur'] = 'photo' . $i . ": Format non conforme";
                } else {
                    $form['photo' . $i] =  'photo_' . $i . '_' . date("Y_m_d_H_i") . $extension;
                    copy($maphoto_tmp, "photo/" . $form['photo' . $i]);
                }
            } else {
                $form['photo' . $i] = "";
            }
        }

        //on insere les elements la table periode
        //puis on insere les elements dans la table de hebergement et dans la table
        // 3 etapes pb des nombres convertient en chaine de caracetres par stip_tags
        $form['prix'] = intval($form['prix']);
        $form['couchage'] = intval($form['couchage']);
        $form['sdb'] = intval($form['sdb']);

        $sql1 = 'INSERT INTO periode (debut,fin ) VALUES ( :debut, :fin )';
        $query1 = $db->prepare($sql1);
        $query1->bindValue(':debut', $periode['debut']);
        $query1->bindValue(':fin', $periode['fin']);
        $query1->execute();
        //on recupere l'id_periode
        $sql2 = 'SELECT LAST_INSERT_ID() from `periode`';
        $query2 = $db->prepare($sql2);
        $query2->execute();
        $last = $query2->fetch();
        $form['id_periode'] = intval($last[0]);

        //traite le cas creation jour +1 pour compter le dernier jour 
        // -> ou on commence a incrementer a partir de 0
        $jour['intervalle'] = dateDiff($periode['debut'], $periode['fin']);
        $jour['id_periode'] = $form['id_periode'];

        var_dump($jour);
        die;
        for ($i = 0; $i <= $jour['intervalle']; $i++) {
            $value = date("Y-m-d", strtotime($periode['debut'] . "+ $i days"));
            $compteur = $i + 1;
            // echo dateIncDay($periode['debut'], $i) . "--$i--<br>";
            $sql5 = 'INSERT INTO jour(id_periode,date_jour,periode_jour,etat) VALUES (:id, :date_jour,:periode_jour, 0)';
            $query5 = $db->prepare($sql5);
            $query5->bindValue(":id", $form['id_periode']);
            $query5->bindValue(":date_jour", $value);
            $query5->bindValue(":periode_jour", $compteur);
            $query5->execute();
        }

        //raccourci pour les photo2a5
        for ($i = 2; $i < 6; $i++) {
            $form['photo' . $i] = "";
        }

        //traiter le cas du gps
        $form['gps'] = "";

        $sql3 =
            'INSERT INTO hebergement 
        (nom,description,prix,adresse,gps,wifi,fumeur,piscine,animaux,douche,taxi,categorie,couchage,sdb,ville,pays,photo1,photo2,photo3,photo4,photo5,id_periode)
        VALUES 
        (:nom, :description, :prix, :adresse, :gps, :wifi, :fumeur,:piscine, :animaux, :douche, :taxi, :categorie, :couchage, :sdb, :ville, :pays, :photo1, :photo2, :photo3, :photo4, :photo5, :id_periode)';

        $query3 = $db->prepare($sql3);
        foreach ($form as $key => $value) {
            $query3->bindValue(":$key", $value);
        }
        $query3->execute();

        require_once 'close.php';
        die;
        $_SESSION['message'] = "Hébergement Ajouté";


        header('Location: index.php');
    } else {
        $_SESSION['erreur'] = "le formulaire est incomplet";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="radio.css">-->
    <link rel="stylesheet" href="gitebonbon.css">
    <title>Détails du Produit</title>
</head>

<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                if (!empty($_SESSION['erreur'])) {
                    echo '<DIV class="alert alert-danger" role="alert">' . $_SESSION['erreur'] . '
                    </DIV>';
                    $_SESSION['erreur '] = "";
                }
                ?>
                <h1>Ajouter un Hébergement</h1>
                <form method="post" action="add.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="d1">
                            <div><label for="categorie">Catégorie</label>
                                <input type="text" id="categorie" name="categorie" class="form-controls">
                            </div>

                            <div class="d2"><label for="nom">Nom</label>
                                <input type="text" id="nom" name="nom" class="form-controls">
                                <label for="adresse">Adresse</label>
                                <input type="text" id="adresse" name="adresse" class="form-controls">
                            </div>

                            <div class="d3"><label for="pays">Pays</label>
                                <input type="text" id="pays" name="pays" class="form-controls">
                                <label for="ville">Ville</label>
                                <input type="text" id="Ville" name="ville" class="form-controls">
                            </div>
                        </div><br>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea type="descprition" id="description" name="description"
                                class="form-controls"></textarea>
                        </div>

                        <!--element numeraire-->

                        <div class="form-group">

                            <div class="d4"><label for="prix">Prix</label>
                                <input type="number" id="prix" name="prix" class="form-controls" min=0 value=0>
                            </div>

                            <div class="d5"><label for="couchage">Couchage</label>
                                <input type="number" id="couchage" name="couchage" class="form-controls" min=1 value=1>
                                <label for="sdb">Salle de bains</label>
                                <input type="number" id="sdb" name="sdb" class="form-controls" min=1 value=1>
                            </div>
                        </div>



                        <!--album photo de l hebergement-->
                        <!--on besoin  id l'herbergement pour creer une entree dans albums -->
                        <div class="form-group">
                            <label for="Album"></label>
                            <input type="file" id="photo1" name="photo1" class="form-controls" accept=".jpg, .jpeg"
                                required><br>
                        <input type="file" id="photo2" name="photo2" class="form-controls" accept=".jpg, .jpeg"><br>
                        <input type="file" id="photo3" name="photo3" class="form-controls" accept=".jpg, .jpeg"><br>
                        <input type="file" id="photo4" name="photo4" class="form-controls" accept=".jpg, .jpeg"><br>
                        <input type="file" id="photo5" name="photo5" class="form-controls" accept=".jpg, .jpeg"><br>
                        </div>
                        <div class="form-group">



                            <!--on besoin  id l'herbergement pour creer une entree dans periode -->
                            <label for="fin">Début</label>
                            <input type="date" id="debut" name="debut" class="form-controls"
                                value="<?= date('Y-m-d', time()); ?>" required>
                            <label for="fin">Fin</label>
                            <input type="date" id="fin" name="fin" class="form-controls"
                                value="<?php echo date('Y-m-d', strtotime("+5 day")); ?>" required>
                        </div><br>
                        <div class="form-group">
                            <input type="radio" name="chien" class="chien demoyes" id="chien-a" checked value="false">
                            <label for="chien-a"><img src='../image/animauxpictorouge.png' width="60"
                                    alt='autorisation animaux' height="60" width="50"></label>
                            <input type="radio" name="chien" class="chien demono" id="chien-b" value="true">
                            <label for="chien-b"><img src="../image/animauxpicto.png" width="60"
                                    alt="interdiction animaux" height="60" width="50"></label>

                            <input type="radio" name="wifi" class="wifi demoyes" id="wifi-a" checked value="false">
                            <label for="wifi-a"><img src='../image/wifipictorouge.png' width="60"
                                    alt='wifi autorisation' height="60" width="50"></label>
                            <input type="radio" name="wifi" class="wifi demono" id="wifi-b" value="true">
                            <label for="wifi-b"><img src="../image/wifipicto.png" width="60" alt="wifi refuser"
                                    height="60" width="50"></label>

                            <input type="radio" name="fumeur" class="fumeur demoyes" id="fumeur-a" checked
                                value="false">
                            <label for="fumeur-a"><img src='../image/fumeurpictorouge.png' width="60"
                                    alt='fumer interdiction' height="60" width="50"></label>
                            <input type="radio" name="fumeur" class="fumeur demono" id="fumeur-b" value="true">
                            <label for="fumeur-b"><img src="../image/fumeurpicto.png" width="60"
                                    alt="fumer autorisation" height="60" width="50"></label>

                            <input type="radio" name="piscine" class="piscine demoyes" id="piscine-a" checked
                                value="false">
                            <label for="piscine-a"><img src='../image/piscinepictorouge.png' width="60"
                                    alt='piscine interdiction' height="60" width="50"></label>
                            <input type="radio" name="piscine" class="piscine demono" id="piscine-b" value="true"
                                class=form>
                            <label for="piscine-b"><img src="../image/piscinepicto.png" width="60"
                                    alt="piscine autorisation" height="60" width="50"></label>

                            <input type="radio" name="douche" class="douche demoyes" id="douche-a" checked
                                value="false">
                            <label for="douche-a"><img src='../image/douchepictorouge.png' width="60"
                                    alt='douche interdiction' height="60" width="50"></label>
                            <input type="radio" name="douche" class="douche demono" id="douche-b" value="true"
                                class=form>
                            <label for="douche-b"><img src="../image/douchepicto.png" width="60"
                                    alt="douche autorisation" height="60" width="50"></label>

                            <input type="radio" name="taxi" class="taxi demoyes" id="taxi-a" checked value="false">
                            <label for="taxi-a"><img src='../image/taxipictorouge.png' width="60"
                                    alt='taxi interdiction' height="60" width="50"></label>
                            <input type="radio" name="taxi" class="taxi demono" id="taxi-b" value="true" class=form>
                            <label for="taxi-b"><img src="../image/taxipicto.png" width="60" alt="taxi autorisation"
                                    height="60" width="50"></label>



                        </div><br>

                        <button class="btn btn-primary" type="submit">Ajouter</button>
                        <button class="btn btn-primary" type="reset">Annuler</button>
                        <a href='index.php' class='btn btn-primary'> Retour<a>
                </form>
            </section>
        </div>
    </main>
</body>

</html>