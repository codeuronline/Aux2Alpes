<?php
class Hebergement
{
   protected const NOM = "";
   protected const TYPE = "";
   protected const ANIMAUXACCEPTE = true;
   protected const CATEGORIE = "Gite";
   protected $prix; //correspond à une journee de reservation
   protected $periode_debut;
   protected $periode_fin;
   protected $description;
   protected $nbpiece;
   protected $adresse;
   protected $photo = array();
   protected $nbSdb;
   protected $nbCouchage;
   protected $coordonnee_GPS = array('latitude', 'longitude');
   protected $ville;
   protected $pays;
   protected $classement;
   protected $categorie;

   // -> Constructeur
   public function __construct($monPrix, $maPeriode_debut, $maPeriode_fin, $maDescription, $monNbpiece, $monAdresse, $mesPhotos, $monNbcouchage, $monNbSdb, $mesCoordonnee_GPS, $maVille, $monPays, $monClassement, $maCategorie = self::CATEGORIE)
   {
      $this->prix = $monPrix; //correspond à une journee de reservation
      $this->periode_debut = $maPeriode_debut;
      $this->periode_fin = $maPeriode_fin;
      $this->description = $maDescription;
      $this->nbpiece = $monNbpiece;
      $this->adresse = $monAdresse;
      $this->photo = $mesPhotos;
      $this->nbSdb = $monNbSdb;
      $this->nbCouchage = $monNbcouchage;
      $this->coordonnee_GPS = $mesCoordonnee_GPS;
      $this->ville = $maVille;
      $this->pays = $monPays;
      $this->classement = $monClassement;
      $this->categorie = $maCategorie;
   }
   // -> Prix
   public function getPrix()
   {
      return $this->prix;
   }
   public function setPrix($val)
   {
      $this->prix = $val;
   }
   // -> periode_debut
   public function getPeriode_debut()
   {
      return $this->periode_debut;
   }
   public function setPeriode_debut($val)
   {
      $this->periode_debut = $val;
   }
   // -> periode_fin
   public function getPeriode_fin()
   {
      return $this->periode_fin;
   }
   public function setPeriode_fin($val)
   {
      $this->periode_fin = $val;
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
   public function getNbPiece()
   {
      return $this->nbpiece;
   }
   public function setNbpiece($val)
   {
      $this->nbpiece = $val;
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
   // -> photo
   public function getPhoto()
   {
      return $this->photo;
   }
   public function setPohto($val)
   {
      $this->photo[] = $val;
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