<?php
require_once 'database.class.php';
class Table extends DataBase
{
    // element de config 

    protected $webWay;
    protected $tableNameBD_Way = [];
    protected $tableNameBD_Name_Var = [];

    public function __construct($newTable, $withRepository = false)
    {

        $this->serverName = $_SERVER["SERVER_NAME"];
        $this->local = $_SERVER['DOCUMENT_ROOT'];
        //chemin d'acces
        $this->webway = strstr($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME']), true);

        //fonction interne pour verfier si le repertoire existe ou non et le cas echeant le creer
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
        // creation de la table correspondante si elle n'existe pas
        // à faire 
        try {
            $myDB = new PDO("mysql:host=" . $this->serverName . ";dbname=" . $this->nameDb . ";", self::USERNAME, self::PASSWORD);
            $myDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE TABLE IF NOT EXISTS " . $newTable . "(
                   `Id_gite` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT ,
                    `nom` VarCHAR(100) NOT NULL,
                    `Album` VarCHAR(100) NOT NULL,
                    `Artiste` VarCHAR(100) NOT NULL,
                    `Genre` VarCHAR(30) NOT NULL,
                    `Cover` VarCHAR(255) NOT NULL,
                    `Sound` Varchar(255) NOT NULL ,
                    `User` Varchar(100) NOT NULL)";
            $myDB->exec($sql);
            echo 'Table Musique bien créée !<br />';
        } catch (PDOException $e) {
            echo MSG_ERROR_BD;
        }
        
        ///////////////////////////////////////////////////////////


        // creation du repertoire si le constructeur le demande etril n'existe pas
        if ($withRepository) {
            IsDir_or_CreateIt('$newTable');
            $this->tableNameBD_Name_Var = "rep_" . $newTable;    
        }
        $this->tableNameBD_Way[$newTable] = $this->local . $this->serverName .  $newTable;
        
    }

    public function getTableBD_Way()
    {
        return $this->tableNameBD_Way;
    }

    public function getTableBD_Name_Var()
    {
        return $this->tableNameDB_Name_Var;
    }
}