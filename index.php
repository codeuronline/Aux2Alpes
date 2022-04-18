<?php
session_start();
$web='site';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="gitebonbon.css">
</head>

<body class='bg'>
    <header>
        <?php
        if (isset($_SESSION['user'])) {
        } else {
            echo " <a href='inscription.php'><button class='btn-recherche' type=submit>Inscription</button></a>";
            echo "<a href='connexion.php'><button class='btn-recherche' type=submit>Connexion</button></a>";
        }
        ?>
    </header>
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
                    </div>
                    <button class=btn-recherche type='submit'>Recherche</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>