<?php

session_start();
require_once('toolsformika.php');

$hebergement = selectHebergementbyIdFull($_GET['id']);


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="griddetail.css">
</head>

<!--<header> 
    <a href="inscription.php"><button class="btn-inscription-connexion" type=submit>Inscription</button></a>
    <a href="connexion.php"><button class="btn-inscription-connexion" type=submit>Connexion</button></a>
</header>-->




<body>
<div class="container">

    <div class="logo">
        <a href="index1.php"><img class="logo1" src="image/logo.png" width="100px" height="100px" alt="Logo"></a>
    </div>

    <div class="album">
    <div class="photo1"><img src='<?php echo "dev/photo/".$hebergement['photo1']; ?>'></div>
    <div class="photo2"><img src='<?php echo "dev/photo/".$hebergement['photo2']; ?>'></div>
    <div class="photo3"><img src='<?php echo "dev/photo/".$hebergement['photo3']; ?>'></div>
    <div class="photo4"><img src='<?php echo "dev/photo/".$hebergement['photo4']; ?>'></div>
    <div class="photo5"><img src='<?php echo "dev/photo/".$hebergement['photo5']; ?>'></div>
    </div>

    <div class="nom"><h1><?php echo $hebergement['nom'];?><br></h1>

    <div class="disponible"><img src=image/calendrierpicto.png height="50" width="50"><?php echo $hebergement['debut'];?>/<?php echo $hebergement['fin'];?></div>
    <div class="couchage"><img src=image/litpicto.png height="50" width="50">couchage: <?php echo $hebergement['couchage'];?></div>
    <div class="prix"><?php echo $hebergement['prix'];?><img src=image/europicto.png height="50" width="50"></div>
    </div>

    <div class="description">Description: <?php echo $hebergement['description'];?></div>

    <div class="option">
    <?= ($hebergement['animaux'] == "1") ? "<img src='image/animauxpictorouge.png' width='50'>" : "<img src='image/animauxpicto.png' width='50'>"; ?>
            <?= ($hebergement['wifi'] == "1") ? "<img src='image/wifipictorouge.png' width='50'>" : "<img src='image/wifipicto.png' width='50'>"; ?>
            <?= ($hebergement['fumeur'] == "1") ? "<img src='image/fumeurpictorouge.png' width='50'>" : "<img src='image/fumeurpicto.png' width='50'>"; ?>
            <?= ($hebergement['piscine'] == "1") ? "<img src='image/piscinepictorouge.png' width='50'>" : "<img src='image/piscinepicto.png' width='50'>"; ?>
            <?= ($hebergement['taxi'] == "1") ? "<img src='image/taxipictorouge.png' width='50'>" : "<img src='image/taxipicto.png' width='50'>"; ?>
            <?= ($hebergement['douche'] == "1") ? "<img src='image/douchepictorouge.png' width='50'>" : "<img src='image/douchepicto.png' width='50'>"; ?>
    </div>
    <div class='formulaire'>

    <form method="POST" action="booking.php"><input type="hidden" value="<?=$hebergement['id_hebergement']?>" name="id_hebergement">

        <?php //ici pour demander a l utilisateur de s'enregristré  
                            
                            $_SESSION['id_user']=2;
                            
                            if (!(@$_SESSION['id_user'])){
                            
                            echo  "<label><input placeholder='prenom' type='text'></label><br>";
                            echo  "<label><input placeholder='nom' type='text'></label><br>";
                            echo  "<label><input placeholder='mail' type='email'></label><br>";
                            }
                            echo "<input type='hidden' name='couchage' value='".$hebergement['couchage']."'>";
                            echo "<input type='hidden' name='id_hebergement' value='".$hebergement['id_hebergement']."'>";?>
                            
                            <form method="POST" action="booking.php">
                             <input type='date' value='<?=date('Y-m-d')?>' name='debut'>
                            <input type='date' value='' name='fin'>
                        

                        </form>


                        
    </form>
    <button class=btn-inscription-connexion type='submit' class='bg-text-light'>Reservation</button>
    </div>
    
</div>

</body>


</html>