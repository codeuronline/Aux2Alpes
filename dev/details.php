<?php
$web='dev';
session_start();
//require_once('toolformikadev.php');
require_once('../librairies/models/Hebergement.php');
if (isset($_GET['id_hebergement']) && !empty($_GET['id_hebergement'])) {
    $herbergementModel =   new Hebergement();
    $hebergement = $herbergementModel->selectFull(intval(strip_tags($_GET['id_hebergement'])));

    //on verifie si le hebergement existe
    if (!$hebergement) {
        $_SESSION['erreur'] = "Cet ID n'existe pas";
        header('Location: index.php');
    }
} else {
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
} ?>
<!--code html-->
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
                <h1>Détails de l'hébergement : <?= $hebergement['nom'] ?></h1>
                <p>Id: <?= $hebergement['id_hebergement'] ?></p>
                <p>Categorie:<?= $hebergement['categorie'] ?></p>
                <p>Nom: <?= $hebergement['nom'] ?></p>
                <p>Adresse: <?= $hebergement['adresse'] ?></p>
                <p>Description: <?= $hebergement['description'] ?></p>
                <p>Prix: <?= $hebergement['prix'] ?></p>
                <p>Couchage: <?= $hebergement['couchage'] ?></p>
                <p>Sdb: <?= $hebergement['sdb'] ?></p>
                <p>
                    <?= ($hebergement['animaux'] == "1") ?  "<img src='../image/animauxpictorouge.png' width='50'>" : "<img src='../image/animauxpicto.png' width='50'>";  ?>
                    <?= ($hebergement['wifi'] == "1") ? "<img src='../image/wifipictorouge.png' width='50'>" : "<img src='../image/wifipicto.png' width='50'>";  ?>
                    <?= ($hebergement['fumeur'] == "1") ? "<img src='../image/fumeurpictorouge.png' width='50'>" : "<img src='../image/fumeurpicto.png' width='50'>";  ?>
                    <?= ($hebergement['piscine'] == "1") ? "<img src='../image/piscinepictorouge.png' width='50'>" : "<img src='../image/piscinepicto.png' width='50'>";  ?>
                    <?= ($hebergement['taxi'] == "1") ? "<img src='../image/taxipictorouge.png' width='50'>" : "<img src='../image/taxipicto.png' width='50'>";  ?>
                    <?= ($hebergement['douche'] == "1") ?  "<img src='../image/douchepictorouge.png' width='50'>" : "<img src='../image/douchepicto.png' width='50'>";  ?>
                </p>
                <p>
                    Photo :
                    <input type="hidden" id="id_periode" name="id_periode" value=<?= $hebergement['id_periode'] ?>>


                    <?php
                    for ($i = 1; $i < 6; $i++) {
                        if (!(empty(@$hebergement['photo' . $i]))) {
                            echo "<img src='photo/" . $hebergement['photo' . $i] . "' width='200'>";
                        } else {
                            echo "<img src='../image/vide.png' width='200'";
                        }
                    } ?>
                </p>
                <p>Debut: <?= $hebergement['debut']; ?></p>
                <p>Fin: <?= $hebergement['fin']; ?></p>
                <p>
                    <a href='index.php' class='btn btn-primary'>Retour<a>
                            <a href="edit.php?id_hebergement=<?= $hebergement['id_hebergement']; ?>"
                                class='btn btn-primary'>Modifier</a>
                </p>
            </section>
        </div>
    </main>
</body>

</html>