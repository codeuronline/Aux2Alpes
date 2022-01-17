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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href=".\radio.css">
=======
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
>>>>>>> 3b0369e0deb5240d7d38fd122b21d4e6d919cd3e
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
                                <td><a href="details.php?id_hebergement=<?= $hebergement['id_hebergement'] ?>">Voir<a></td>
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