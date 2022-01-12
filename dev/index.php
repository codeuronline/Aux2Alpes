<?php
session_start();
require_once('connect.php');
$sql = 'SELECT * FROM `gite`';
$query = $db->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
require_once('close.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Liste des gite</title>
</head>

<body>
    <main class="container">
        <div class=row>
            <section class="col-12">
                <?php 
                
                if(!empty($_SESSION['erreur'])){
                    echo '<DIV class="alert alert-danger" role="alert"'.$_SESSION['message'].'
                    </DIV>';
                    $_SESSION['erreur']= null;
                }
                ?>
                <h1>Liste des Gites</h1>
                <table class="table">
                    <th>Id_gite</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>prix
                    <th>adresse</th>
                    <th>coordonnee_GPS</th>
                    <th>Id_Animaux</th>
                    <th>Id_classement</th>
                    <th>id_jardin</th>
                    <th>Id_piece</th>
                    <th>Id_jour</th>
                    <th>Id_periode</th>
                    <th>Id_sdb</th>
                    <th>Id_Emplacement_geographique</th>
                    <th>Id_couchage</th>
                    <th>Id_photo</th>
                    <th>Id_categorie</th>
                    <tbody>
                        <?php
                        foreach ($result as $gite) {
                        ?>
                        <tr>
                            <td><?= $gite['Id_gite'] ?></td>
                            <td><?= $gite['Nom'] ?></td>
                            <td><?= $gite['Description'] ?></td>
                            <td><?= $gite['prix'] ?></td>
                            <td><?= $gite['adresse'] ?></td>
                            <td><?= $gite['coordonnes_GPS'] ?></td>
                            <td><?= $gite['Id_animaux'] ?></td>
                            <td><?= $gite['Id_classement'] ?></td>
                            <td><?= $gite['Id_jour'] ?></td>
                            <td><?= $gite['Id_periode'] ?></td>
                            <td><?= $gite['id_sdb'] ?></td>
                            <td><?= $gite['Id_Emplacementgeographique'] ?></td>
                            <td><?= $gite['Id_couchage'] ?></td>
                            <td><?= $gite['Id_photo'] ?></td>
                            <td><?= $gite['id_categorie'] ?></td>
                            <td><a href="detail.php?Id_gite=<?= $gite['Id_gite'] ?>">Voir<a></td>
                        </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
                <a href='add.php' class='btn btn-primary'>Ajouter un produit<a>
            </section>
        </div>
    </main>
</body>

</html>