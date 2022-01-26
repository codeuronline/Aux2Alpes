<?php
session_start();
require_once('connect.php');
require_once('tools.php');
echo "date de reservation de l'utilisateur pour l'hebergement n°<br>";
echo '<hr>';
var_dump($_POST);
echo '<hr>';
$sql = 'SELECT date_jour FROM `jour` WHERE `id_periode` = :id AND etat=0';
$query = $db->prepare($sql);
$query->bindValue(':id', $_POST['id_hebergement'], PDO::PARAM_INT);
$query->execute();
$jour_free = $query->fetchALL(PDO::FETCH_ASSOC);
$tabReserdisponible = array();
echo "on recupere les jours disponibles pour la periode de l'hebergement:" . $_POST['id_hebergement'] . "<br>";
echo "<hr>";
var_dump($jour_free);
echo "<hr>";
foreach ($jour_free as $element) {
    array_push($tabReserdisponible, $element['date_jour']);
}
echo "<hr>";
if (in_array($_POST['debutReserv'], $tabReserdisponible)) {
    $indice['debut'] = true;
}
if (in_array($_POST['finReserv'], $tabReserdisponible)) {
    $indice['fin'] = true;
}
echo "On transforme cette liste en un tableau a 1 dimension:<br>";
echo "<hr>";
var_dump($tabReserdisponible);
echo "<hr>";
echo "On affiche l'etat des la periode: <br>";
echo "<hr>";
var_dump($indice);



?>