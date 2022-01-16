<?php
session_start();

if (isset($_GET['Id_hebergement']) && !empty($_GET['Id_hebergement'])) {
    require_once('connect.php');
    $id = strip_tags(($_GET['Id_hebergement']));
    $sql = 'SELECT * FROM `hebergement` WHERE Id_hebergement = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $hebergement = $query->fetch();
    //on virifie si le hebergement existe
    if (!$hebergement) {
        $_SESSION['erreur'] = "Cet ID n'existe pas";
        header('Location: index.php');
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
    <title>Détails de l'hébergement</title>
</head>

<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Détails du hebergement <?= $hebergement['Nom'] ?>
                    <p>Id: <?= $hebergement['Id_hebergement'] ?></p>
                    <p>id_categorie<?= $hebergement['categorie'] ?></p>
                    <p>Nom: <?= $hebergement['nom'] ?></p>
                    <p>Adresse: <?= $hebergement['adresse'] ?></p>
                    <p>Description: <?= $hebergement['description'] ?></p>
                    <p>Prix<?= $hebergement['prix'] ?></p>
                    <p>coordonne_GPS<?= $hebergement['coordonnee_GPS'] ?></p>
                    <p>animaux<?= ($hebergement['animaux']) ? "<img src='../image/animauxpicto.png' width='25'>" : "<img src='..image/animauxpictorouge.png'>";  ?></p>
                    <p>wifi<?= ($hebergement['wifi']) ? "<img src='../image/wifipicto.png' width='25'>" : "<img src='..image/wifipictorouge.png'>";  ?></p>
                    <p>fumeur<?= ($hebergement['fumeur']) ? "<img src='../image/fumeurpicto.png' width='25'>" : "<img src='..image/fumeurpictorouge.png'>";  ?></p>
                    <p>piscine<?= ($hebergement['piscine']) ? "<img src='../image/piscinepicto.png' width='25'>" : "<img src='..image/piscinepictorouge.png'>";  ?></p>
                    <p>sdb<?= $hebergement['sdb'] ?></p>
                    <p>couchage<?= $hebergement['couchage'] ?></p>
                    <p>Id_photo<?= $hebergement['ville'] ?></p>

                    <p>Id_Emplacement_geographique<?= $hebergement['ville_gps'] ?></p>
                    <p>Id_periode<?= $hebergement['Id_periode'] ?></p>
                    <p><a href="index.php">Retour</a><a href="edit.php?Id_hebergement="><?= $hebergement['Id_hebergement']; ?>>Modifier</a>
                    </p>
            </section>
        </div>
    </main>
</body>

</html>