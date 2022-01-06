<?php
require_once 'constructor.class.php';
class Table extends DataBase
{
    // element de config 
    private  $serverName;
    private  $local;
    private $webWay;
    private $tableNameBD_Way = [];
    private $tableNameBD_Name_Var = [];

    //chemin d'acces


    public function __construct($newTable, $withRepository = false)
    {

        $this->serverName = $_SERVER["SERVER_NAME"];
        $this->local = $_SERVER['DOCUMENT_ROOT'];
        $this->webway = strstr($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME']), true);

        //fonction interne pour verfiier si le repertoire existe ou non
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


        // creation du repertoire si le constructeur le demande etril n'existe pas
        if ($withRepository) {
            IsDir_or_CreateIt('$newTable');
            $this->tableNameBD_Way[$newTable] = $this->local . $this->serverName .  $newTable;
            $this->tableNameBD_Name_Var = "rep_" . $newTable;
        }
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