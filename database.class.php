<?php

class DataBase
{
    // element de config 

    protected const USERNAME = "root";
    protected const PASSWORD = "";
    public const DBNAME = "hebergementdb";
    public const NAMEDB = "hebergementdb";
    protected const SERVERNAME = "localhost";
    protected $local;
    protected $serverName;
    protected $nameDB;
    protected $tab = array();


    public function __construct($newDB = self::DBNAME)
    {
        $this->serverName = $_SERVER["SERVER_NAME"];

        $this->local = $_SERVER["DOCUMENT_ROOT"];
        $this->nameDB = $newDB;

        // creation de à la BD si elle n'existe pas
        try {

            $myDB = new PDO("mysql:host=" . self::SERVERNAME, self::USERNAME, self::PASSWORD);
            $myDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE DATABASE IF NOT EXISTS " . $newDB;
            $myDB->exec($sql);
        } catch (PDOException $e) {
            echo "erreur";
        }
    }
    public function connect()
    {
        try {
            
            $myDB = new PDO('mysql:host=' . self::SERVERNAME . ";dbname=" . $this->nameDB, self::USERNAME, self::PASSWORD);
            $myDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            
        } catch (PDOException $e) {
            echo "probleme";
        }
    }
}