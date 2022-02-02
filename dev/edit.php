<?php
session_start();

if (isset($_GET['id_hebergement']) && !empty($_GET['id_hebergement'])) {
    require_once('connect.php');
    //traite les element de la table hebergement

    $id = strip_tags(($_GET['id_hebergement']));
    $sql = 'SELECT * FROM `hebergement` WHERE `id_hebergement` = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $hebergement = $query->fetch(PDO::FETCH_ASSOC);
    //traite les elements de la table periode
    $sql1 = 'SELECT * FROM periode  WHERE id_periode = :id';
    $query1 = $db->prepare($sql1);
    $query1->bindValue(':id', $hebergement['id_periode'], PDO::PARAM_INT);
    $query1->execute();
    $periode = $query1->fetch(PDO::FETCH_ASSOC);
    //traite le cas image
    //trait les elmements de la table jours
    //on verifie si le hebergement existe
    if (!$hebergement) {
        $_SESSION['erreur'] = "Cet ID n'existe pas";
        header('Location: index.php');
        exit;
    }
} else {
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../gitebonbon.css">
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
                <form method="POST" action="update.php" enctype="multipart/form-data">
                    <div class=" form-group">
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
                            value=""><?= $hebergement['description'] ?></textarea>
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
                        <label for="photo">Photo </label>

                        <?php

                        for ($i = 1; $i < 6; $i++) {
                            if (isset($hebergement['photo' . $i]) && !(empty($hebergement['photo' . $i]))) {
                                echo "<img src='photo/" . $hebergement['photo' . $i] . "' alt='photo" . $i . "' width=200>";
                                echo "<input type='file' id='photo" . $i . "' name='photo" . $i . "' class='form-controls'>";
                            } else {
                                echo "<img src='../image/vide.png" . $hebergement['photo' . $i] . "' alt='photo" . $i . "' width=200>";
                                echo "<input type='file' id='photo" . $i . "' name='photo" . $i . "' class='form-controls'>";
                            }
                        }                     ?>
                    </div>
                    <div class="form-group">
                        <h2>Période disponibilité de l'hébergement(1 période déclarable) Obligatoire</h2>
                        <!--on besoin  id l'herbergement pour creer une entree dans periode -->
                        <label for="debut">Début</label>
                        <input type="date" id="debut" name="debut" class="form-controls" required
                            value="<?= $periode['debut'] ?>">
                        <label for="fin">Fin</label>
                        <input type="date" id="fin" name="fin" class="form-controls" value="<?= $periode['fin'] ?>">
                    </div>
                    <div class="form-group">
                        <h2>Option(s) de l'hébergement</h2>
                        L'état du picto prédéfini l'option de l'hébergement <br>
                        <!--animaux-->
                        <?php $check['animaux'] = (($hebergement['animaux'] == '1') || ($hebergement['animaux'] == 1)) ? " checked " : ""; ?>
                        <input type="radio" name="chien" class="chien demoyes" id="chien-a" <?= $check['animaux'] ?>
                            value=1>
                        <label for="chien-a"><img src='../image/animauxpicto.png' width="60"></label>
                        <?php $check['animaux'] = (($hebergement['animaux'] == '0') || ($hebergement['animaux'] == 0)) ? " checked " : ""; ?>
                        <input type="radio" name="chien" class="chien demono" id="chien-b" <?= $check['animaux'] ?>
                            value="0">
                        <label for="chien-b"><img src="../image/animauxpictorouge.png" width="60" alt=""></label>
                        <!--wifi-->
                        <?php $check['wifi'] = (($hebergement['wifi'] == '1') || ($hebergement['wifi'] == 1)) ? " checked " : ""; ?>
                        <input type="radio" name="wifi" class="wifi demoyes" id="wifi-a" <?= $check['wifi'] ?> value=1>
                        <label for="wifi-a"><img src='../image/wifipicto.png' width="60" alt=''></label>
                        <?php $check['wifi'] = (($hebergement['wifi'] == '0') || ($hebergement['wifi'] == 0)) ? " checked" : ""; ?>
                        <input type="radio" name="wifi" class="wifi demono" id="wifi-b" <?= $check['wifi'] ?> value=0>
                        <label for="wifi-b"><img src="../image/wifipictorouge.png" width="60" alt=""></label>
                        <!--fumeur-->
                        <?php $check['fumeur'] = (($hebergement['fumeur'] == '1') || ($hebergement['fumeur'] == 1)) ? " checked" : ""; ?>
                        <input type="radio" name="fumeur" class="fumeur demoyes" id="fumeur-a" <?= $check['fumeur'] ?>
                            value=1>
                        <label for="fumeur-a"><img src='../image/fumeurpicto.png' width="60" alt=''></label>
                        <?php $check['fumeur'] = (($hebergement['fumeur'] == '0') || ($hebergement['fumeur'] == 0)) ? " checked" : ""; ?>
                        <input type="radio" name="fumeur" class="fumeur demono" id="fumeur-b" <?= $check['fumeur'] ?>
                            value=0>
                        <label for="fumeur-b"><img src="../image/fumeurpictorouge.png" width="60" alt=""></label>
                        <!--piscine-->
                        <?php $check['piscine'] = (($hebergement['piscine'] == '1') || ($hebergement['piscine'] == 1)) ? "checked" : ""; ?>
                        <input type="radio" name="piscine" class="piscine demoyes" id="piscine-a"
                            <?= $check['piscine'] ?> value=1>
                        <label for="piscine-a"><img src='../image/piscinepicto.png' width="60" alt=''></label>
                        <?php $check['piscine'] = (($hebergement['piscine'] == '0') || ($hebergement['piscine'] == 0)) ? " checked" : ""; ?>
                        <input type="radio" name="piscine" class="piscine demono" id="piscine-b"
                            <?= $check['piscine'] ?> value=0 class=form>
                        <label for="piscine-b"><img src="../image/piscinepictorouge.png" width="60" alt=""></label>
                        <!--taxi-->
                        <?php $check['taxi'] = (($hebergement['taxi'] == '1') || ($hebergement['taxi'] == 1)) ? "checked" : ""; ?>
                        <input type="radio" name="taxi" class="taxi demoyes" id="taxi-a" <?= $check['taxi'] ?> value=1>
                        <label for="taxi-a"><img src='../image/taxipicto.png' width="60" alt=''></label>
                        <?php $check['taxi'] = (($hebergement['taxi'] == '0') || ($hebergement['taxi'] == 0)) ? " checked" : ""; ?>
                        <input type="radio" name="taxi" class="taxi demono" id="taxi-b" <?= $check['taxi'] ?> value=0>
                        <label for="taxi-b"><img src="../image/taxipictorouge.png" width="60" alt=""></label>
                        <input type="hidden" name="id_periode" id="id_periode"
                            value='<?= $hebergement['id_periode']; ?>'>
                        <input type="hidden" name="id_hebergement" id="id_hebergement"
                            value='<?= $hebergement['id_hebergement'] ?>'>
                        <!--douche-->
                        <?php $check['douche'] = (($hebergement['douche'] == '1') || ($hebergement['douche'] == 1)) ? "checked" : ""; ?>
                        <input type="radio" name="douche" class="douche demoyes" id="douche-a" <?= $check['douche'] ?>
                            value=1>
                        <label for="douche-a"><img src='../image/douchepicto.png' width="60" alt=''></label>
                        <?php $check['douche'] = (($hebergement['douche'] == '0') || ($hebergement['douche'] == 0)) ? " checked" : ""; ?>
                        <input type="radio" name="douche" class="douche demono" id="douche-b" <?= $check['douche'] ?>
                            value=0>
                        <label for="douche-b"><img src="../image/douchepictorouge.png" width="60" alt=""></label>


                        <input type="hidden" name="id_periode" id="id_periode"
                            value='<?= $hebergement['id_periode']; ?>'>
                        <input type="hidden" name="id_hebergement" id="id_hebergement"
                            value='<?= $hebergement['id_hebergement'] ?>'>

                    </div>

                    <button class="btn btn-primary" type="submit">Modifier</button>
                    <button class="btn btn-primary" type="reset">Annuler</button>
                    <a href='index.php' class='btn btn-primary'>Retour<a>
                </form>

            </section>
        </div>
    </main>
</body>

</html>