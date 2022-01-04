<?php
//test si un repertoire existe sinon il le crée
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
//select id Max
function select_Max_id()
{
    include 'config.php';

    try {

        $User = $_SESSION['user'];
        $codb = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $codb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql2 = "SELECT max(id) as Id FROM Musique WHERE User='$User'";
        $prepare2 = $codb->prepare($sql2);
        $prepare2->execute();
        $max = $prepare2->fetch(PDO::FETCH_ASSOC);
        if ($max['Id'] == NULL) {
            return 0;
        } else {
            return $max['Id'];
        }
        $codb = null;
    } catch (PDOException $e) {

        return "Message d'erreur : " . $e->getMessage() . "<br />";
    }
}

function selectElmentby($element, $id)
{
    include 'config.php';
    try {
        $User = $_SESSION['user'];
        $codb = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $codb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT $element FROM $table Where Id=$id";
        $prepare = $codb->prepare($sql);
        $prepare->execute();
        $resultat = $prepare->fetch(PDO::FETCH_ASSOC);
        $codb = null;
    } catch (PDOException $e) {
        return "Message d'erreur : " . $e->getMessage() . "<br />";
    }
    return $resultat[$element];
}

function select_All()
{
    include 'config.php';
    try {
        $User = $_SESSION["user"];
        $codb = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $codb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM Musique WHERE User='$User'";
        $prepare = $codb->prepare($sql);
        $prepare->execute();
        $resultat = $prepare->fetchAll(PDO::FETCH_ASSOC);
        return $resultat;
        $codb = null;
    } catch (PDOException $e) {

        return "Message d'erreur : " . $e->getMessage() . "<br />";
    }
}
function select_by_Id($id)
{
    include 'config.php';


    try {
        $user = $_SESSION['user'];
        $codb = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $codb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM $table WHERE id=$id and user='$user'";
        $prepare = $codb->prepare($sql);
        $prepare->execute();
        $resultat = $prepare->fetch(PDO::FETCH_ASSOC);
        return $resultat;
        $codb = null;
    } catch (PDOException $e) {
        return "Message d'erreur : " . $e->getMessage() . "<br />";
    }
}