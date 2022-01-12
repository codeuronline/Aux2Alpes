<?php 
try {
    //connection
    $db = new PDO('mysql:host=localhost;dbname=gitebd','root','');
    $db->exec('SET NAMES "UTF8"');

} catch (PDOException $e) {
    echo "Erreur: ".$e->getMessage();
    die();
}