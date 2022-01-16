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
        foreach ($_POST as $key => $value) {
            $form[$key] = strip_tags($_POST[$key]);
        }

        $extensionsAutorisees_image = array(".jpeg", ".jpg");
        $rep_photo = $_SERVER['DOCUMENT_ROOT'] . strstr($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME']), true);
        for ($i = 1; $i < 6; $i++) {
            if (empty($_FILES['photo' . $i]['name'])) {
                unset($form['photo' . $i]);
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
        $id = "id_hebergement";
        foreach ($form as $key => $value) {
            if (!($key = $id)) {
                if (($key == 'debut') || ($key == 'fin')) {
                    $periode[$key] = $_GET[$key];
                    $sql = "UPDATE `periode` SET $key=:$key WHERE `id_periode`=:$id";
                    $query = $db->prepare($sql);
                    $query->bindValue(':id_periode', $form['id_periode']);
                    $query->execute();
                }
                $sql = "UPDATE `hebergement` SET $key=:$key WHERE `id_hebergement`=:$id";
                $query = $db->prepare($sql);
                $query1->bindValue(':' . $key, $value);
                $query1->execute();
            }
        }    //on insere les elements la table periode
        //puis on insere les elements dans la table de hebergement et dans la table


        $_SESSION['message'] = "Produit Modifié";
        header('Location index.php');
        require_once 'close.php';
    } else {
        $_SESSION['erreur'] = "probleme dans la modfication";
    }
} elseif (isset($_GET['id_hebergement']) && !empty($_GET['id_hebergement'])) {
    require_once('connect.php');
    //traite les element de la table hebergement
    $id = strip_tags(($_GET['id_hebergement']));
    $sql = 'SELECT * FROM `hebergement` WHERE `id_hebergement` = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $hebergement = $query->fetch();
    //traite les elements de la table periode
    $sql1 = 'SELECT * FROM `periode`  WHERE id_periode = :id';
    $query1 = $db->prepare($sql1);
    $query1->bindValue(':id', $hebergement['id_periode'], PDO::PARAM_INT);
    $query1->execute();
    $periode = $query1->fetch();

    //trait les elmements de la table jours
    //on verifie si le hebergement existe
    if (!$hebergement) {
        $_SESSION['erreur'] = "Cet ID n'existe pas";
        //header('Location: index.php');
    }
} else {
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
} ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../gitebonbon.css">
    <link rel="stylesheet" href="radio.css">
    <title>Détails de l'hébergement</title>
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
                <h1>Edition d'un Hébergement</h1>
                <form method="POST" action="edit.php">
                    <div class="form-group">
                        <label for="categorie">Catégorie</label>
                        <input type="text" id="categorie" name="categorie" class="form-controls"
                            value="<?= $hebergement['categorie'] ?>">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" class="form-controls" value="<?= $hebergement['nom'] ?>">
                        <label for="adresse">Adresse</label>
                        <input type="text" id="adresse" name="adresse" class="form-controls"
                            value="<?= $hebergement['adresse'] ?>">
                        <label for="pays">Pays</label>
                        <input type="text" id="pays" name="pays" class="form-controls"
                            value="<?= $hebergement['pays'] ?>">
                        <label for="ville">Ville</label>
                        <input type="text" id="Ville" name="ville" class="form-controls"
                            value="<?= $hebergement['ville'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea type="description" id="description" name="description" class="form-controls"
                            value="<?= $hebergement['description'] ?>"></textarea>
                    </div>
                    <!--element numeraire-->
                    <div class="form-group">
                        <h2>Eléments numéraires(Obligatoire)</h2>
                        <label for="prix">Prix</label>
                        <input type="number" id="prix" name="prix" class="form-controls" min=0
                            value="<?= $hebergement['prix'] ?>">
                        <label for="couchage">Couchage</label>
                        <input type="number" id="couchage" name="couchage" class="form-controls" min=1
                            value="<?= $hebergement['couchage'] ?>">
                        <label for="sdb">Salle de bains</label>
                        <input type="number" id="sdb" name="sdb" class="form-controls" min=1
                            value="<?= $hebergement['sdb'] ?>">
                    </div>
                    <!--album photo de l hebergement-->
                    <!--on besoin  id l'herbergement pour creer une entree dans albums -->
                    <div class="form-group">
                        <h2>Photo de l'hébergement</h2>
                        <label for="Album">Album</label>
                        <input type="file" id="photo1" name="photo1" class="form-controls" accept=".jpg, .jpeg" ?><br>
                        <!--<input type="file" id="photo2" name="photo2" class="form-controls" accept=".jpg, .jpeg"><br>
                        <input type="file" id="photo3" name="photo3" class="form-controls" accept=".jpg, .jpeg"><br>
                        <input type="file" id="photo4" name="photo4" class="form-controls" accept=".jpg, .jpeg"><br>
                        <input type="file" id="photo5" name="photo5" class="form-controls" accept=".jpg, .jpeg"><br>-->
                    </div>
                    <div class="form-group">
                        <h2>Période disponibilité de l'hébergement(1 période déclarable) Obligatoire</h2>
                        <!--on besoin  id l'herbergement pour creer une entree dans periode -->
                        <label for="fin">Début</label>
                        <input type="date" id="debut" name="debut" class="form-controls" required
                            value="<?= $periode['debut'] ?>">
                        <label for="fin">Fin</label>
                        <input type="date" id="fin" name="fin" class="form-controls" value="<?= $periode['fin'] ?>">
                    </div>
                    <div class="form-group">
                        <h2>Option(s) de l'hébergement</h2>
                        L'état du picto prédéfini l'option de l'hébergement <br>
                        <input type="radio" name="chien" class="chien demoyes" id="chien-a" checked value="false">
                        <label for="chien-a"><img src='../image/animauxpictorouge.png' width="60" alt=''></label>
                        <input type="radio" name="chien" class="chien demono" id="chien-b" value="true">
                        <label for="chien-b"><img src="../image/animauxpicto.png" width="60" alt=""></label>

                        <input type="radio" name="wifi" class="wifi demoyes" id="wifi-a" checked value="false">
                        <label for="wifi-a"><img src='../image/wifipictorouge.png' width="60" alt=''></label>
                        <input type="radio" name="wifi" class="wifi demono" id="wifi-b" value="true">
                        <label for="wifi-b"><img src="../image/wifipicto.png" width="60" alt=""></label>

                        <input type="radio" name="fumeur" class="fumeur demoyes" id="fumeur-a" checked value="false">
                        <label for="fumeur-a"><img src='../image/fumeurpictorouge.png' width="60" alt=''></label>
                        <input type="radio" name="fumeur" class="fumeur demono" id="fumeur-b" value="true">
                        <label for="fumeur-b"><img src="../image/fumeurpicto.png" width="60" alt=""></label>

                        <input type="radio" name="piscine" class="piscine demoyes" id="piscine-a" checked value="false">
                        <label for="piscine-a"><img src='../image/piscinepictorouge.png' width="60" alt=''></label>
                        <input type="radio" name="piscine" class="piscine demono" id="piscine-b" value="true"
                            class=form>
                        <label for="piscine-b"><img src="../image/piscinepicto.png" width="60" alt=""></label>
                    </div>

                    <button class="btn btn-primary">Modifier</button>
                    <button class="btn btn-primary" type="reset">Annuler</button>
                    <a href='index.php' class='btn btn-primary'>Retour<a>
                </form>

            </section>
        </div>
    </main>
</body>

</html>