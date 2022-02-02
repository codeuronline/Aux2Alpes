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