<?php
require_once '../message.php';

class DataBase
{
    // element de config 

    protected const USERNAME = "root";
    protected const PASSWORD = "";
    protected const DBNAME = "Gite";
    protected const NAMEDB = "Gite";
    protected $serverName;
    protected $local;
    protected $nameDb;



    //chemin d'acces


    public function __construct($newDb = null)
    {

        $this->serverName = $_SERVER["SERVER_NAME"];
        $this->local = $_SERVER['DOCUMENT_ROOT'];
        if ($newDB = null) {
            $this->nameDb = self::NAMEDB;
        } else {
            $this->nameDb = $newDb;
        }
        //connexion à la BD
        try {
            $myDB = new PDO("mysql:host=" . $this->serverName . ";dbname=" . $this->nameDb . ";", self::USERNAME, self::PASSWORD);
        } catch (Exception $th) {
            echo "ERREUR_BD";
        }
    }
}