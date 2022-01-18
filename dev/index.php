<?php
session_start();
require_once('connect.php');
$sql = 'SELECT * FROM `hebergement`';
$query = $db->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
require_once('close.php');
require_once('hebergement.class.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href=".\radio.css">

    <title>Liste des hébergement(s))</title>
</head>

<body>
    <main class="container">
        <div class=row>
            <section class="col-12">
                <?php
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
                    <th>prix</th>
                    <th>adresse</th>
                    <th>Taux d'occupation</th>
                    <th>action</th>
                    <tbody>
                        <?php
                        foreach ($result as $hebergement) {
                        ?>
                        <tr>
                            <td><?= $hebergement['id_hebergement'] ?></td>
                            <td><?= $hebergement['categorie'] ?></td>
                            <td><?= $hebergement['nom'] ?></td>
                            <td><?= $hebergement['prix'] ?></td>
                            <td><?= $hebergement['adresse'] ?></td>
                            <td>
                                <div class="container mt-5">
                                    <div class="card">
                                        <div class="row no-gutters">
                                            <div class="col-md-12">
                                                <div class="progress-1 align-items-center">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: 80%;" aria-valuenow="70" aria-valuemin="0"
                                                            aria-valuemax="100"> 81% </div>
                                                    </div>
                                                    <!--<div class="progress">
                                                            <div class="progress-bar bg-custom" role="progressbar"
                                                                style="width: 55%;" aria-valuenow="25" aria-valuemin="0"
                                                                aria-valuemax="100">55%</div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-primary" role="progressbar"
                                                                style="width: 48%;" aria-valuenow="25" aria-valuemin="0"
                                                                aria-valuemax="100">48%</div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                style="width: 30%;" aria-valuenow="25" aria-valuemin="0"
                                                                aria-valuemax="100">30%</div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-danger" role="progressbar"
                                                                style="width: 15%;" aria-valuenow="25" aria-valuemin="0"
                                                                aria-valuemax="100">15%</div>
                                                        </div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><a href="details.php?id_hebergement=<?= $hebergement['id_hebergement'] ?>">Voir<a>
                                        <a href="delete.php?id_hebergement=<?= $hebergement['id_hebergement'] ?>">Suppimer<a>
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

</html>