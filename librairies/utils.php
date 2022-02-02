<?php

/**
 *  Retourne une connection à la base de données 
 * 
 * @return PDO
 * 
 */
function getPDO(): PDO
{
    $pdo = new PDO('mysql:host=localhost;dbname=hebergementdb;charset=utf8', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    return $pdo;
}
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
function redirect($path): void
{
    header('Location: ' . $path);
    exit;
}

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

//mailer
function mailerRéservation($reservation): void
{
}