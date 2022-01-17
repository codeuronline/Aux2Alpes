<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" href=".\radio.css">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../gitebonbon.css">
    <link rel="stylesheet" href="radio.css">
    <title>Détails du Produit</title>
</head>

<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Ajouter un Hébergement</h1>
                <form method="post " action="">
                    <div class="form-group">
                        <label for="categorie">Type</label>
                        <input type="text" id="categorie" name="categorie" class="form-controls">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" class="form-controls">
                        <label for="ville">Ville</label>
                        <input type="text" id="Ville" name="ville" class="form-controls">
                        <label for="coordonne_gps_ville"></label>
                        <input type="text" id="coordonne_gps_ville" name="coordonne_gps_ville" class="form-controls">
                        <label for="Pays">Pays</label>
                        <input type="text" id="pays" name="pays" class="form-controls">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea type="descprition" id="description" name="description"
                            class="form-controls"></textarea>
                    </div>
                    <!--element numeraire-->
                    <div class="form-group">
                        <label for="prix">Prix</label>
                        <input type="number" id="Prix" name="Prix" class="form-controls">
                        <label for="couchage">Couchage</label>
                        <input type="number" id="couchage" name="couchage" class="form-controls">
                        <label for="sdb">Salle de bains</label>
                        <input type="number" id="sdb" name="sdb" class="form-controls">
                        <label for="piece">Pièce</label>
                        <input type="number" id="piece" name="piece" class="form-controls">
                        <label for="classement">Classement</label>
                        <input type="number" id="classement" name="classement" class="form-controls">

                    </div>
                    <div class="form-group">
                        <label for="Album">Album</label>
                        <input type="file" id="photo1" name="photo1" class="form-controls">
                        <input type="file" id="photo2" name="photo2" class="form-controls">
                        <input type="file" id="photo3" name="photo3" class="form-controls">
                        <input type="file" id="photo4" name="photo4" class="form-controls">
                        <input type="file" id="photo5" name="photo5" class="form-controls">
                    </div>

                    <!--creation en cascadeentree dans albums et entree dans periode-->

                    <div class="form-group">
                        <!--on besoin  id l'herbergement pour creer une entree dans albums -->

                    </div>

                    <div class="form-group">
                        <!--on besoin  id l'herbergement pour creer une entree dans periode -->
                        <label for="periode">Période</label>
                        <input type="date" id="h_debut" name="dispo_debut" class="form-controls">
                        <input type="date" id="h_fin" name="dispo_fin" class="form-controls">
                    </div>
                    <div class="form-group">
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

                    <button class="btn btn-primary">Ajouter</button>
                </form>

            </section>
        </div>
    </main>
</body>

</html>