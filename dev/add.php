<?
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

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
                <form method="post " action="add.php">
                    <div class="form-group">
                        <label for="id_categorie">Type d'Hébergement</label>
                        <input type="text" id="id_categorie" name="id_categorie" class="form-controls">
                    </div>
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="prix" name="prix" class="form-controls">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="descprition" id="description" name="description" class="form-controls">
                    </div>
                    <div class="form-group">
                        <label for="periode">Période</label>
                        <input type="date" id="dispo_debut" name="dispo_debut" class="form-controls">
                        <input type="date" id="dispo_fin" name="dispo_fin" class="form-controls">
                    </div>
                    <div class="form-group">
                        <input type="radio" name="chien3" class="chien3 demoyes" id="chien3-a" checked value="false">
                        <label for="chien3-a"><img src='../image/animauxpictorouge.png' width="60" alt=''></label>
                        <input type="radio" name="chien3" class="chien3 demono" id="chien3-b" value="true">
                        <label for="chien3-b"><img src="../image/animauxpicto.png" width="60" alt=""></label>

                        <input type="radio" name="wifi3" class="wifi3 demoyes" id="wifi3-a" checked value="false">
                        <label for="wifi3-a"><img src='../image/wifipictorouge.png' width="60" alt=''></label>
                        <input type="radio" name="wifi3" class="wifi3 demono" id="wifi3-b" value="true">
                        <label for="wifi3-b"><img src="../image/wifipicto.png" width="60" alt=""></label>

                        <input type="radio" name="fumeur3" class="fumeur3 demoyes" id="fumeur3-a" checked value="false">
                        <label for="fumeur3-a"><img src='../image/fumeurpictorouge.png' width="60" alt=''></label>
                        <input type="radio" name="fumeur3" class="fumeur3 demono" id="fumeur3-b" value="true">
                        <label for="fumeur3-b"><img src="../image/fumeurpicto.png" width="60" alt=""></label>

                        <input type="radio" name="piscine3" class="piscine3 demoyes" id="piscine3-a" checked
                            value="false">
                        <label for="piscine3-a"><img src='../image/piscinepictorouge.png' width="60" alt=''></label>
                        <input type="radio" name="piscine3" class="piscine3 demono" id="piscine3-b" value="true">
                        <label for="piscine3-b"><img src="../image/piscinepicto.png" width="60" alt=""></label>
                    </div>
                    <button class="btn btn-primary">Ajouter</button>
                </form>

            </section>
        </div>
    </main>
</body>

</html>