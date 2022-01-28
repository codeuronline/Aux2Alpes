<?php
require_once 'dev/connect.php';
session_start();


echo "";





unset($_SESSION['id_user']);
if (isset($_SESSION['id_user'])) {
} else {
echo " <a href='inscription.php'><button class='btn-recherche' type=submit>Inscription</button></a>";
echo "<a href='connexion.php'><button class='btn-recherche' type=submit>Connexion</button></a>";
}
$recherche = $_POST['recherche'];
$personne = $_POST['personne'];
$sql = "SELECT * FROM `hebergement` WHERE ville like '%$recherche%' AND couchage>=$personne";
$query = $db->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="gitebonbon.css">
</head>

<body>



    
        <?php
        
    foreach ($result as $hebergement) { ?>
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
                href='detail.php'><button class='btn-recherche' type=submit>Details</button></a></div>
                
        <div class="c"></span><img src='<?php echo "dev/photo/" . $hebergement['photo1'] ?>'></div>
        </div><?php }


    require_once 'dev/close.php';
    ?>
    
</body>

</html>