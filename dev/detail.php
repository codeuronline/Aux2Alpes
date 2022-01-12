<?
session_start();
if (isset($_GET['id_Gite']) && !empty($_GET['id_Gite'])) {
    require_once('connect.php');
    $id = strip_tags(($_GET['Id_Gite']));
    $sql = 'SELECT * FROM `Gite` WHERE `Id_Gite` = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $gite = $query->fetch();
    if (!$gite) {
        $_SESSION['erreur'] = "Cet ID n'existe pas";
        header('Location: index.php');
    }
} else {
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
} ?>
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
                <h1>Détails du Gite <?= $gite['Nom'] ?>
                    <p>Id: <?= $gite['Id_Gite'] ?></p>
                    <p>Nom: <?= $gite['Nom'] ?></p>
                    <p>Description: <?= $gite['Description'] ?></p>
                    <p>prix<?= $gite['prix'] ?></p>
                    <p>coordonne_GPS<?= $gite['coordonnee_GPS'] ?></p>
                    <p>Id_Animaux<?= $gite['Id_Animaux'] ?></p>
                    <p>iD_jardin<?= $gite['iD_jardin'] ?></p>
                    <p>Id_piece<?= $gite['Id_piece'] ?></p>
                    <p>Id_sdb<?= $gite['Id_sdb'] ?></p>
                    <p>Id_couchage<?= $gite['Id_couchage'] ?></p>
                    <p>Id_photo<?= $gite['photo'] ?></p>
                    <p>id_categorie<?= $gite['id_categorie'] ?></p>
                    <p>Id_Emplacement_geographique<?= $gite['Id_Emplacement_geographique'] ?></p>
                    <p>Id_periode<?= $gite['Id_periode'] ?></p>
            </section>
        </div>
    </main>
</body>

</html>