<?php
session_start();
//info astuce pour jdepart= jourd'arrivée-> passage du jour a 3 etats 1 réservé
//                                                                    0 libre  
//                                                                    2 libre et reservé mais correspnd au dernier jour d'une periode de reservations
// ce fichier traite la reservertion d'un hebergement selectionné à la page precedente 
// methode post on recupere les informations id_hebergement si user identifié on recuperes les infos en BD sinon on recupere les infos du post à savoir pour un user nom adresse 
// si la reservertion est ok --> correspondance des dates de disponibilité de l'herbergement
//                            --> si  le formulaire est rempli 

// alors -> on inscrit la reservation 
//         au niveau db --> ajout de l'utilisateur
//                      --> ajout reservation
//                      --> mise a jour de la table jour pour associé à cette reservation et introdcution de l'etat 2 transitions
//        --> envoi d'un mail de confirmation
//        --> confirmation ecran
//sinon selon la cause on redirige au pt de conflit dans l'interface 
//pt conflit --> pb au niveau du formualaire
//                   