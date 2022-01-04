<?php
include "config.php";
function IsDir_or_CreateIt($path)
{
    if (is_dir($path)) {
        return true;
    } else {
        if (mkdir($path)) {
            return true;
        } else {
            return false;
        }
    }
}

/*creation de la BD*/
try {
    $connectdb = new PDO(
        "mysql:host=$servername",
        $username,
        $password
    );
    $connectdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    $connectdb->exec($sql);
} catch (PDOException $e) {
    echo "Message d'erreur : [" . $e->getMessage() . "]<br>:";
}

/*Creation d'une table de musiques*/
try {
    $connectdb = new PDO('mysql:host=' . $servername . ';dbname=' . $namedb, $username, $password);
    $connectdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql =
    "CREATE TABLE Musique(
            `Id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT ,
            `Titre` VarCHAR(100) NOT NULL,
            `Album` VarCHAR(100) NOT NULL,
            `Artiste` VarCHAR(100) NOT NULL,
            `Genre` VarCHAR(30) NOT NULL,
            `Cover` VarCHAR(255) NOT NULL,
            `Sound` Varchar(255) NOT NULL ,
            `User` Varchar(100) NOT NULL)";
    $connectdb->exec($sql);
    echo 'Table Musique bien créée !<br />';

} catch (PDOException $e) {
    echo "Message d'erreur : [" . $e->getMessage() . "]<br>:";
}
 /**Creation de la table Inscription */
try {
   
    $connectdb = new PDO('mysql:host=' . $servername . ';dbname=' . $namedb, $username, $password);
    $connectdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql2 =
    "CREATE TABLE Inscription(
            `Id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT ,
            `name` VARCHAR(100) NOT NULL,
            `mail` VARCHAR (100) NOT NULL UNIQUE,
            `password` VARCHAR (100) NOT NULL)";
    $connectdb->exec($sql2);
    echo 'Table Inscription bien créée !<br>';

} catch (PDOException $e){
    echo 'Erreur : '.$e->getMessage();
}
IsDir_or_CreateIt('sound');
IsDir_or_CreateIt('image');