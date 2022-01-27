<?php

session_start();
require_once('dev/connect.php');
require_once('dev/tools.php');

$sql='SELECT * FROM `hebergement` WHERE `id_hebergement` = :id';
    $query = $db->prepare($sql);
    $query->bindValue(':id', $_POST['nom']);
    $query->execute();
    $hebergement = $query->fetch(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="gitebonbon.css">
</head>

<header> 
  <a href="inscription.php"><button class="btn-inscription-connexion" type=submit>Inscription</button></a>
  <a href="connexion.php"><button class="btn-inscription-connexion" type=submit>Connexion</button></a>
</header>

<a href="rechercheutilisateur.php"><img class="logo1" src="image/logo.png" width="100px" height="100px" alt="Logo"></a>



<div class="container4">
  <div class="a">
    <img src='<?php echo "dev/photo/".$hebergement['photo1']; ?>'></div>
  <div class="b"><img src='<?php echo "dev/photo/".$hebergement['photo2']; ?>'></div>
  <div class="c"><img src='<?php echo "dev/photo/".$hebergement['photo3']; ?>'></div>
  <div class="d"><img src='<?php echo "dev/photo/".$hebergement['photo4']; ?>'></div>
  <div class="e"><img src='<?php echo "dev/photo/".$hebergement['photo5']; ?>'></div>
</div>

<body>
  <article>
    <div id="slides">

    <?php
    for ($i=1; $i <= 5; $i++) { 
        $image=$hebergement['photo'.$i];
      echo "<img src='$image'  alt=''>";  
    }
    ?>

    </div>
  </article>

                                <div class="g">
                                <!--------------------Description de l'hotel ---------------->
                                
                                <img src=image/calendrierpicto.png height="50" width="50">
                                <div class="groupe"><input type="date" name="Arriver" id="Arriver" required><input type="date" name="Retour" id="Retour" required></div></button>
                                
                                <h2>
                                <?php echo $hebergement['nom'];?><br>
                                </h2>

                                <div>Description: <?php echo $hebergement['description'];?><br>
                                couchage: <?php echo $hebergement['couchage'];?><br>
                                
                                </div>

                                
                                
                              

                                
                            </div>
                            </div>

                            

                          <div><?php //ici pour demander a l utilisateur de s'enregristré  
                            
                            $_SESSION['id_user']=2;
                            
                            if (!(@$_SESSION['id_user'])){
                              
                              echo  "<label><input placeholder='prenom' type='text'></label><br>";
                              echo  "<label><input placeholder='nom' type='text'></label><br>";
                              echo  "<label><input placeholder='mail' type='email'></label><br>";
                            }
                              echo "<input type='hidden' name='couchage' value='".$hebergement['couchage']."'>";
                              echo "<input type='hidden' name='id_hebergement' value='".$hebergement['id_hebergement']."'>";
                              
                              


                            
                            //requet sur periode & jour
                            $sql="SELECT date_jour FROM jour WHERE id_periode=".$hebergement['id_periode'];
                            $query=$db->prepare($sql);
                            $query->execute();

                            $result=$query->fetch(PDO::FETCH_ASSOC);
                            
                            
                            echo "<input type='date' value='".$result['date_jour']."' name='debut'>";
                            
                            echo "<input type='date' value='' name='fin'>";
                              

                          ?></div>


                          <button class=btn-recherche type='submit' class='bg-text-light'>Reservation</button>

                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
</body>


</html>