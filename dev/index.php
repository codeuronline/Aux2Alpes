<?php
session_start();
$web= 'dev';
$dev= "../librairies/";
require_once($dev."models/Hebergement.php");
require_once($dev.'toolformikadev.php');
require_once($dev.'utils.php');

//require_once('tools.php');
/*$sql = 'SELECT * FROM `hebergement`';
$query = $db->prepare($sql);
$query->execute();*/
$modelhebergement = new Hebergement();
$hebergements = $modelhebergement->selectAll();
//$result = $query->fetchAll(PDO::FETCH_ASSOC);


// on recupere les elements pour chaque pour chaque id_periode



?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../gitebonbon.css">

    <title>Liste des hébergement(s))</title>
</head>

<body>
    <main class="container">
        <div class=row>
            <section class="col-12">
                <?php
                if (!empty($_SESSION['warning'])) {
                    echo '<DIV class="alert alert-warning" role="alert">' . $_SESSION['warning'] . '
                    </DIV>';
                    $_SESSION['warning'] = "";
                }
                if (!empty($_SESSION['erreur'])) {
                    echo '<DIV class="alert alert-danger" role="alert">' . $_SESSION['erreur'] . '
                    </DIV>';
                    $_SESSION['erreur'] = "";
                }
                if (!empty($_SESSION['message'])) {
                    echo '<DIV class="alert alert-success" role="alert">' . $_SESSION['message'] . '
                    </DIV>';
                    $_SESSION['message'] = "";
                }
                ?>

                <h1>Liste des Hébergement(s)</h1>
                <table class="table">
                    <th>Id Hébergement</th>
                    <th>Catégorie</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Ville</th>
                    <th>Taux de disponibilité</th>
                    <th>Action</th>
                    <tbody>
                        <?php foreach ($hebergements as $hebergement) : ?>
                        <tr>
                            <td><?= $hebergement['id_hebergement'] ?></td>
                            <td><?= $hebergement['categorie'] ?></td>
                            <td><?= $hebergement['nom'] ?></td>
                            <td><?= $hebergement['prix'] ?></td>
                            <td><?= $hebergement['ville'] ?></td>
                            <td>


                                <div class="row no-gutters">
                                    <div class="col-md-12">
                                        <div class="progress-1 align-items-center">
                                            <div class="progress">
                                                <?= barProgress(maxDaybyId($hebergement['id_periode']), nbJourFreebyId($hebergement['id_periode'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><a href="details.php?id_hebergement=<?= $hebergement['id_hebergement'] ?>">Voir</a>
                                <a href="delete.php?id_hebergement=<?= $hebergement['id_hebergement'] ?>">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href='add.php' class='btn btn-primary'>Ajouter d'un Hébergement<a>
            </section>
        </div>
    </main>
</body>
<?php require_once('close.php'); ?>

</html>