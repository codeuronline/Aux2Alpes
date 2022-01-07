<?php

class DataBase
{
    // element de config 

    protected const USERNAME = "root";
    protected const PASSWORD = "";
    public const DBNAME = "gitebd";
    public const NAMEDB = "gitebd";
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
            $myDB->exec($sql);
        } catch (PDOException $e) {
            echo "acces";
        }

        try {
            include_once 'elementDB.php';
            $myDB = new PDO('mysql:host=' . self::SERVERNAME . ";dbname=" . $this->nameDB, self::USERNAME, self::PASSWORD);
            $myDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            foreach ($table as $key => $value) {
                $table[$key] = $value;

                if ($value == "()") {

                    $requete = "INSERT INTO" . $key . "(id_" . $key . " INT UNSIGNED PRIMARY KEY AUTO_INCREMENT)";
                } else {
                    $requete = "INSERT INTO" . $key . "(" . $value . ")";
                }
                $myDB->exec($requete);
            }
        } catch (PDOException $e) {
            echo "probleme";
        }
    }
}