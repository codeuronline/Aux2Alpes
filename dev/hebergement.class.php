<?php
require_once '../database.class.php';
class Hebergement extends DataBase
{
   protected const NOM = "";
   protected const TYPE = "";
   protected const ANIMAUX = true;
   protected const PISCINE = true;
   protected const WIFI = true;
   protected const FUMEUR = true;
   protected const CATEGORIE = "Gite";
   protected const PHOTOVIDE = "photo/photovide.jpeg";
   protected $categorie = self::CATEGORIE;
   protected $prix; //correspond à une journee de reservation
   protected $debut;
   protected $fin;
   protected $description;
   protected $piece;
   protected $adresse;
   protected $photo1;
   protected $photo2;
   protected $photo3;
   protected $photo4;
   protected $photo5;
   protected $sdb;
   protected $couchage;
   protected $coordonnee_GPS = array('latitude', 'longitude');
   protected $ville;
   protected $pays;
   protected $tabAssoc;


   // -> Constructeur neccesitant un tableau associatif

   public function __construct($table)
   {
      //on 
      //on  nettoies le code
      foreach ($table as $key => $value) {
         if (empty($table[$key]) && (($key == "photo1") || ($key == "photo2") || ($key == "photo3") || ($key == "photo4") || ($key == "photo5"))) {
            $this->$key = self::PHOTOVIDE;
         } else {
            $table[$key] = strip_tags($value);
            $this->$key = $table[$key];
         }
      }
   }

   public function  insert()
   {

   }
   // -> Prix
   public function getPrix()
   {
      return $this->prix;
   }
   public function setPrix($val)
   {
      $this->prix = strip_tags($val);
      
   }
   // -> periode_debut
   public function getPeriode_debut()
   {
      return $this->debut;
   }
   public function setPeriode_debut($val)
   {
      $this->debut = $val;
   }
   // -> periode_fin
   public function getPeriode_fin()
   {
      return $this->fin;
   }
   public function setPeriode_fin($val)
   {
      $this->fin = $val;
   }
   // -> description
   public function getDescription()
   {
      return $this->description;
   }
   public function setDesciption($val)
   {
      $this->description = $val;
   }
   // -> piece    
   public function getPiece()
   {
      return $this->piece;
   }
   public function setPiece($val)
   {
      $this->piece = $val;
   }
   // -> adresse    
   public function getAdresse()
   {
      return $this->adresse;
   }
   public function setAdresse($val)
   {
      $this->adresse = $val;
   }
   // -> photo 1
   public function getPhoto1()
   {
      return $this->photo1;
   }
   public function setPhoto1($val)
   {
      $this->photo1 = $val;
   }
   // -> photo 2
   public function getPhoto2()
   {
      return $this->photo2;
   }
   public function setPhoto2($val)
   {
      $this->photo2 = $val;
   }
   // -> photo 3
   public function getPhoto3()
   {
      return $this->photo3;
   }
   public function setPhoto3($val)
   {
      $this->photo1 = $val;
   } // -> photo 4
   public function getPhoto4()
   {
      return $this->photo4;
   }
   public function setPhoto4($val)
   {
      $this->photo4 = $val;
   }
   // -> photo 5
   public function getPhoto5()
   {
      return $this->photo5;
   }
   public function setPhoto5($val)
   {
      $this->photo5 = $val;
   }
   // -> nb salle de bains
   public function getNbSdb()
   {
      return $this->nbSdb;
   }

   public function setNbSdb($val)
   {
      $this->nbSdb = $val;
   }
   // -> nb couchage
   public function getNbCouchage()
   {
      return $this->nbCouchage;
   }
   public function setNbCouchage($val)
   {
      $this->nbCouchage = $val;
   }
   // -> coordonnee gps
   public function getCoordonnee_GPS()
   {
      return $this->coordonnee_GPS;
   }
   public function setCoordonnee_GPS($val, $val1)
   {
      $this->coordonnee_GPS['latitude'] = $val;
      $this->coordonnee_GPS['longitude'] = $val1;
   }
   // -> ville
   public function getVille()
   {
      return $this->ville;
   }
   public function setVille($val)
   {
      //expression reguliere sur $this->adresse = $val
      $this->ville = $val;
   }
   // -> Pays
   public function getPays()
   {
      return $this->pays;
   }
   public function setPays($val)
   {
      //expression reguliere sur $this->adresse = $val
      $this->pays = $val;
   }
   // -> categorie
   public function getCategorie()
   {
      return $this->categorie;
   }
   public function setCategorie($val)
   {
      $this->categorie = $val;
   }
   // -> classement
   public function getClassement()
   {
      return $this->classement;
   }
   public function setClassement($val)
   {
      $this->classement = $val;
   }
}