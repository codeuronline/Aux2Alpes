<?php
session_start();
require_once('librairies/toolformikadev.php');


$result = selectAllHebergement();
$result2 = selectAllHebergement();





//require_once('dev/hebergement.class.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="gitebonbon.css">
</head>

<header>
    <?php
    if (isset($_SESSION['user'])) {
    } else {
        echo " <a href='inscription.php'><button class='btn-recherche' type=submit>Inscription</button></a>";
        echo "<a href='connexion.php'><button class='btn-recherche' type=submit>Connexion</button></a>";
    }
    ?>
</header>


<body class='bg'>
    <a href="index.php"><img class="logo1" src="image/logo.png" width="100px" height="100px" alt="Logo"></a>
    <div class='container'>
        <div class='row1'>
            <form method="POST" action="listsearch.php">
                <div class='col-lg-4 col-md-8 col-sm-8'>
                    <div class='card shadow'>
                        <div class='card-title text-center border-bottom'>
                        </div>

                        <div class='mb-9'>
                            <img class="groupepicto" src=image/picto-map-blanc.png height="70" width="70">
                            <div class="corpsformulaire">
                                <input type="search" name="recherche" id="recherche" placeholder="ville"><br>
                            </div>
                        </div>

                        <div class='mb-4'>
                            <img class="groupepicto" src=image/groupepicto.png height="70" width="70">
                            <div class="corpsformulaire">
                                <label for="personne"></label>
                                <input type="number" min="1" name="personne" id="personne" placeholder="personne">
                            </div>
                        </div>




                        <!---
                        <div class="e">


                            <input type="radio" name="fumeur" class="fumeur demoyes" id="fumeur-a" checked
                                value="false">
                            <label for="fumeur-a"><img src='./image/fumeurpictorouge.png' width="60"
                                    alt='fumer interdiction' height="60" width="50"></label>
                            <input type="radio" name="fumeur" class="fumeur demono" id="fumeur-b" value="true">
                            <label for="fumeur-b"><img src="./image/fumeurpicto.png" width="60" alt="fumer autorisation"
                                    height="60" width="50"></label>

                            <input type="radio" name="piscine" class="piscine demoyes" id="piscine-a" checked
                                value="false">
                            <label for="piscine-a"><img src='./image/piscinepictorouge.png' width="60"
                                    alt='piscine interdiction' height="60" width="50"></label>
                            <input type="radio" name="piscine" class="piscine demono" id="piscine-b" value="true"
                                class=form>
                            <label for="piscine-b"><img src="./image/piscinepicto.png" width="60"
                                    alt="piscine autorisation" height="60" width="50"></label>

                            <input type="radio" name="animaux" class="animaux demoyes" id="animaux-a" checked
                                value="false">
                            <label for="animaux-a"><img src='./image/animauxpictorouge.png' width="60"
                                    alt='piscine interdiction' height="60" width="50"></label>
                            <input type="radio" name="animaux" class="animaux demono" id="animaux-b" value="true"
                                class=form>
                            <label for="animaux-b"><img src="./image/animauxpicto.png" width="60"
                                    alt="piscine autorisation" height="60" width="50"></label>

                            <input type="radio" name="wifi" class="wifi demoyes" id="wifi-a" checked value="false">
                            <label for="wifi-a"><img src='./image/wifipictorouge.png' width="60" alt='wifi interdiction'
                                    height="60" width="50"></label>
                            <input type="radio" name="wifi" class="wifi demono" id="wifi-b" value="true" class=form>
                            <label for="wifi-b"><img src="./image/wifipicto.png" width="60" alt="wifi autorisation"
                                    height="60" width="50"></label>

                            <input type="radio" name="douche" class="douche demoyes" id="douche-a" checked
                                value="false">
                            <label for="douche-a"><img src='./image/douchepictorouge.png' width="60"
                                    alt='douche interdiction' height="60" width="50"></label>
                            <input type="radio" name="douche" class="douche demono" id="douche-b" value="true"
                                class=form>
                            <label for="douche-b"><img src="./image/douchepicto.png" width="60"
                                    alt="douche autorisation" height="60" width="50"></label>

                            <input type="radio" name="taxi" class="taxi demoyes" id="taxi-a" checked value="false">
                            <label for="taxi-a"><img src='./image/taxipictorouge.png' width="60" alt='taxi interdiction'
                                    height="60" width="50"></label>
                            <input type="radio" name="taxi" class="taxi demono" id="taxi-b" value="true" class=form>
                            <label for="taxi-b"><img src="./image/taxipicto.png" width="60" alt="taxi autorisation"
                                    height="60" width="50"></label>
---->

                    </div>

                    <button class=btn-recherche type='submit'>Recherche</button>
                </div>
        </div>
        </form>
    </div>
    </div>
    </div>
    </div>
    </div>
</body>


</html>