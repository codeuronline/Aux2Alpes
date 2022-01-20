<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////BOITE A OUTILS///////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function barProgress($intervalle, $element)
{
    $cent = $intervalle;
    $taux = floor($element / $intervalle * 100);
    if ($taux > 66) {
        return  '<div class="progress-bar bg-success" role="progressbar" style="width: ' . $taux . '%;" aria-valuenow="' . $taux . '" aria-valuemin="0" aria-valuemax="100">' . $taux . '% </div>';
    } elseif ($taux > 33) {
        return '<div class="progress-bar bg-warning" role="progressbar" style="width: ' . $taux . '%;" aria-valuenow="' . $taux . '" aria-valuemin="0" aria-valuemax="100">' . $taux . '%</div>';
    } else {
        return '<div class="progress-bar bg-danger" role="progressbar" style="width: ' . $taux . '%;" aria-valuenow="' . $taux . '" aria-valuemin="0" aria-valuemax="100">' . $taux . '%</div>';
    }
}
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

//supprime les caracteres specaiux dune chaine de caractere
function delSpecialChar($text)
{
    $utf8 = array(
        '/[áàâãªä]/u' => 'a',
        '/[ÁÀÂÃÄ]/u' => 'A',
        '/[ÍÌÎÏ]/u' => 'I',
        '/[íìîï]/u' => 'i',
        '/[éèêë]/u' => 'e',
        '/[ÉÈÊË]/u' => 'E',
        '/[óòôõºö]/u' => 'o',
        '/[ÓÒÔÕÖ]/u' => 'O',
        '/[úùûü]/u' => 'u',
        '/[ÚÙÛÜ]/u' => 'U',
        '/ç/' => 'c',
        '/Ç/' => 'C',
        '/ñ/' => 'n',
        '/Ñ/' => 'N',
        '//' => '-', // conversion d'un tiret UTF-8 en un tiret simple
        '/[]/u' => ' ', // guillemet simple
        '/[«»]/u' => ' ', // guillemet double
        '/ /' => ' ', // espace insécable (équiv. à 0x160)
    );
    return preg_replace(array_keys($utf8), array_values($utf8), $text);
}
// incremente une date de i jours au format Y-m-d
function dateIncDay($date, $i)
{
    if ($i = 0)
        return $date;
    else

        return date("Y-m-d", strtotime($date . "+ $i days"));
}

//  renvoie la difference  entre 2 date en jours
function dateDiff($date1, $date2)
{
    $firstDate = new DateTime($date1);
    $secondDate = new DateTime($date2);
    $intvl = $firstDate->diff($secondDate);

    //$intvl->y " year, " . 
    //$intvl->m " months and ".
    //$intvl->d." day";
    //$intvl->days . " days ";

    return $intvl->days;
}
/*
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
}*/