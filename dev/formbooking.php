<?php

session_start();
require_once('connect.php');
require_once('tools.php');
$id = $_GET['id'];
$sql = 'SELECT * FROM `hebergement` WHERE `id_hebergement` = :id';
$query = $db->prepare($sql);
$query->bindValue(':id', $id);
$query->execute();
$hebergement = $query->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="booking.php" method="post">
        <input type="date" name="debutReserv" value="<?= date("Y-m-d"); ?>">
        <input type="date" name="finReserv" value="">
        <input type="submit" value="Réserver">
        <input type="reset" value="Annuler">
        <input type="hidden" name="id_hebergement" value="<?= $_GET['id']; ?>">
    </form>
</body>

</html>