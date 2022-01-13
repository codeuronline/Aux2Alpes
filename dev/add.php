<?
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                        <input type="text" id="id_categorie" name="id_categorie">
                    </div>
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="prix" name="prix">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="descprition" id="description" name="description">
                    </div>
                    <div class="form-group">
                        <label for="periode">Période</label>
                        <input type="date" id="dispo_debut" name="dispo_debut">
                        <input type="date" id="dispo_fin" name="dispo_fin">
                    </div>
                    <input type="submit" class="btn btn-primary">

                </form>

            </section>
        </div>
    </main>
</body>

</html>