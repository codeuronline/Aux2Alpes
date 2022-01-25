<?php
$_POST[];
session_start();
var_dump($_POST);
    $periode['debut']=$_POST['debut'];

    $sql = 'SELECT * FROM `hebergement` WHERE `id_hebergement` = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $hebergement = $query->fetch(PDO::FETCH_ASSOC);
    //traite les elements de la table periode
    $sql1 = 'SELECT date_jour,etat FROM jour  WHERE id_periode = :id AND etat=0';
    $query1 = $db->prepare($sql1);
    $query1->bindValue(':id', $hebergement['id_periode'], PDO::PARAM_INT);
    $query1->execute();
    $periodeRef = $query1->fetchALL(PDO::FETCH_ASSOC);
    var_dump($hebergement);
    $value= compareDate($periode,$ref)
if (isset($_SESSION['user'])) {
    #
}

//info astuce pour jdepart= jour d'arrivée-> passage du jour a 3 etats 1 réservé
//                                                                    0 libre  
//                                                                    2 libre et reservé mais mais doit correspondre au dernier jour d'une periode de reservations
// ce fichier traite la reservertion d'un hebergement selectionné à la page precedent --> id de l'hebergement debut fin
// methode post on recupere les informations id_hebergement si user identifié on recuperes les infos en BD sinon on recupere les infos du post à savoir pour un user nom adresse 
// si la reservertion est ok --> correspondance des dates de disponibilité de l'herbergement
//                            --> si  le formulaire est rempli ou user identifié
//
// alors -> on inscrit la reservation 
//         au niveau db --> ajout de l'utilisateur(sauf si identifié)
//                      --> ajout reservation
//                      --> mise a jour de la table jour pour associé à cette reservation et introdcution de l'etat 2 transitions pour terminer
//                      -->
//        --> envoi d'un mail de confirmation
//        --> confirmation ecran
//sinon selon la cause on redirige au pt de conflit dans l'interface 
//pt conflit --> pb au niveau du formulaire
//           --> pb au niveau du user
//           --> pb au niveau des dates-       