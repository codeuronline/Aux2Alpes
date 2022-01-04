<?php
// chemin d'acces de base
$servername = $_SERVER["SERVER_NAME"];
$local = $_SERVER['DOCUMENT_ROOT'];

$file = $_SERVER['SCRIPT_NAME'];
$file2 = basename($_SERVER['SCRIPT_FILENAME']);


//chemin d'acces
$WebWay = strstr($file, $file2, true);

//repertoire à créer
$rep_sound = $local . $WebWay . "sound";
$rep_image = $local . $WebWay . "image";

$username = "root";
$password = "";
$table = "musique";
//define('DBname','mamusique');
$dbname = "mamusique";
$namedb = "mamusique";