<?php
session_start();
//require_once('librairies/toolformikadev.php');
require_once('librairies/models/Hebergement.php');
$recherche = $_POST['recherche'];
$personne = $_POST['personne'];
$modelHebergement = new Hebergement();
$hebergements = $modelHebergement->researchAll($recherche, $personne);
//$hebergements = researchHebergementAll($recherche, $personne);
//unset($_SESSION['id_user']);
if (isset($_SESSION['id_user'])) {
} else {
    echo " <a href='inscription.php'><button class='btn-recherche' type=submit>Inscription</button></a>";
    echo "<a href='connexion.php'><button class='btn-recherche' type=submit>Connexion</button></a>";
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="gitebonbon.css">
    <link rel="stylesheet" href="carrousel.css">
</head>

<body>
    <div class="nbh">
        <h1> Nombre d'hébergement(s) trouvé(s) correspondant à votre recherche : <?= count($hebergements) ?></h1>
    </div>
    <?php
    foreach ($hebergements as $hebergement) { ?>
    <div class="list">
        <div class="a"><span class=h1><?= $hebergement['nom']; ?></span></div>
        <hr>
        <div class="b">Description:<?= $hebergement['description']; ?>Prix:<?= $hebergement['prix']; ?>€ /pers.
            Capacité:<?= $hebergement['couchage']; ?>
            <?= ($hebergement['animaux'] == "1") ? "<img src='image/animauxpictorouge.png' width='50'>" : "<img src='image/animauxpicto.png' width='50'>"; ?>
            <?= ($hebergement['wifi'] == "1") ? "<img src='image/wifipictorouge.png' width='50'>" : "<img src='image/wifipicto.png' width='50'>"; ?>
            <?= ($hebergement['fumeur'] == "1") ? "<img src='image/fumeurpictorouge.png' width='50'>" : "<img src='image/fumeurpicto.png' width='50'>"; ?>
            <?= ($hebergement['piscine'] == "1") ? "<img src='image/piscinepictorouge.png' width='50'>" : "<img src='image/piscinepicto.png' width='50'>"; ?>
            <?= ($hebergement['taxi'] == "1") ? "<img src='image/taxipictorouge.png' width='50'>" : "<img src='image/taxipicto.png' width='50'>"; ?>
            <?= ($hebergement['douche'] == "1") ? "<img src='image/douchepictorouge.png' width='50'>" : "<img src='image/douchepicto.png' width='50'>"; ?><br>
            <a href='detail.php?id=<?= $hebergement["id_hebergement"] ?>'><button class='btn-recherche'
                    type=submit>Details</button></a>
        </div>
        <div class="c">
            <!--insertion d'un carrouselici-->
            <div class="carousel-container">
                <i class="fas fa-arrow-left" id='prevBtn'></i>
                <i class="fas fa-arrow-right" id='nextBtn'></i>
                <div class="carousel-slide">
                    <img src="dev/photo/<?= @$hebergement['photo5'] ?>" id='lastClone' alt='photo'>
                    <?php
                        for ($i = 1; $i < 6; $i++) {
                            if (empty(@$hebergement['photo' . $i])) {
                                echo "<img src='image/vide.png' alt='vide'>";
                            }
                            echo "<img src='dev/photo/" . @$hebergement['photo' . $i] . "' alt='photo'>";
                        } ?>
                    <img src="dev/photo/<?= $hebergement['photo1'] ?>" id="firstClone" alt="photo">
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'dev/close.php';
    }
    ?>
    <script src='carrousel.js'></script>
</body>

</html>