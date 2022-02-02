<?php
session_start();
//require_once('../librairies/database.php');
require_once('../librairies/toolformikadev.php');
require_once('../librairies/utils.php');



//require_once('tools.php');
/*$sql = 'SELECT * FROM `hebergement`';
$query = $db->prepare($sql);
$query->execute();*/
$result = selectAllHebergement();
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
    <link rel="stylesheet" href="gitebonbon.css">

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
                        <?php
                        foreach ($result as $hebergement) {

                            /*$sql1 = 'SELECT count(id_jour) AS max_jour FROM `jour` WHERE id_periode=:id'; // max de jour
                            $query1 = $db->prepare($sql1);
                            $query1->bindValue(':id', $hebergement['id_periode']);
                            $query1->execute();
                            $result1 = $query1->fetch();*/
                            $hebergement['max_jour'] = maxDayById($hebergement['id_periode']);

                            /* $sql2 = 'SELECT count(id_jour) AS max_jour_libre FROM `jour` WHERE id_periode=:id AND etat=0'; // nb jour libre
                            $query2 = $db->prepare($sql2);
                            $query2->bindValue(':id', $hebergement['id_periode']);
                            $query2->execute();
                            $result2 = $query2->fetch();*/
                            $hebergement['max_jour_libre'] = intval(nbJourFreebyId($hebergement['id_periode']));

                        ?>
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
                                                <?= barProgress($hebergement['max_jour'], $hebergement['max_jour_libre']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><a href="details.php?id_hebergement=<?= $hebergement['id_hebergement'] ?>">Voir</a>
                                <a href="delete.php?id_hebergement=<?= $hebergement['id_hebergement'] ?>">Supprimer</a>
                            </td>
                        </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
                <a href='add.php' class='btn btn-primary'>Ajouter d'un Hébergement<a>
            </section>
        </div>
    </main>
</body>
<?php require_once('close.php'); ?>

</html>