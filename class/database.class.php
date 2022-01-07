<?php

class DataBase
{
    // element de config 

    protected const USERNAME = "root";
    protected const PASSWORD = "";
    protected const DBNAME = "gitebd";
    protected const NAMEDB = "gitebd";
    protected const SERVERNAME = "localhost";
    protected $local;
    protected $serverName;
    protected $nameDB;
    protected $table = array();


    public function __construct($newDB = self::DBNAME)
    {
        $this->serverName = $_SERVER["SERVER_NAME"];
        echo $this->serverName;

        $this->local = $_SERVER["DOCUMENT_ROOT"];
        $this->nameDB = $newDB;

        // creation de à la BD
        echo $this->nameDB . "||" . $newDB;
        try {

            $myDB = new PDO("mysql:host=" . self::SERVERNAME, self::USERNAME, self::PASSWORD);

            $myDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE DATABASE IF NOT EXISTS " . $newDB;
            //liste requetes de creation de table
            include_once '../elementDB.php';

            //creation
            foreach ($variable as $key => $value) {
                if (
                    $table[$key] == null
                ) {

                    $requete = "INSERT " . $variable . "(id_" . $variable . ");";
                } else {
                    $requete = "INSERT $variable" . $table[$variable];
                }
                $myBD->exec($requete[$variable]);
            }



            $myDB->exec($sql);
        } catch (PDOException $e) {
            echo "Message d'erreur : [" . $e->getMessage() . "]<br>:";
        }
    }
}