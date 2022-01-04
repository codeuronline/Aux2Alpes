<?php
include 'config.php';
$liste = select_All(); //->erreur

echo
"
      <div class='row'>
         <div class='col order-last'>
         </div>
         <div class='col text-center'>
            <a href='inserer.php'><button type='button' class='btn btn-light btn-lg border'><img src='img\sound2.png' class='img-fluid' alt='Bouton Ajouter'> Ajouter</button></a>
         </div>
         <div class='col order-first'>
         </div>
      </div>";
//debut  du container
echo "<div class='container'>";
echo "   <div class='accordion' id='accordionExample'>";
foreach ($liste as $ligne) {
   $compteur = $ligne['Id'];
   $Cover_vide = "<img src='img/cover1.png' width='100'>";
   // a faire test sur le nombre de ligne du tableau pour affecte le compteur

   if ($compteur == select_Max_id()) {
      $btn_class = "accordion-button";
      $div_class = "accordion-collapse collapse show";
      $btn_expended = "arial-expended='true'";
   } else {
      $btn_class = "accordion-button collapsed";
      $div_class = "accordion-collapse collapse";
      $btn_expended = "arial-expended='false'";
   }
         echo "   <div class='accordion-item'>
                     <h2 class='accordion-header' id='heading$compteur'>
                        <button class='$btn_class fw-bolder' style='color:#1b3954' type='button' data-bs-toggle='collapse' data-bs-target='#collapse$compteur' $btn_expended aria-controls='collapse$compteur'>" . $ligne['Titre'] . "</button>
                     </h2>
                     <div id='collapse$compteur' class='$div_class' aria-labelledby='heading$compteur' data-bs-parent='#accordionExample'>
                        <div class='accordion-body'>
                           <div class='container'>
                              <div class='row'>
                                 <div class='col'>
                                    <p style='color:#1b3954'>
                                       Artiste : 
                                       <strong style='color:#1b3954'>" . $ligne['Artiste'] . "</strong>
                                    </p>
                                 </div>
                                 <div class='col'>
                                    <p style='color:#1b3954'>
                                       Album : 
                                       <strong style='color:#1b3954'>" . $ligne['Album'] . "</strong>
                                    </p>
                                 </div>
                              </div>
                           <div class='row'>
                              <div class='col'>
                                 <p style='color:#1b3954'>
                                 Genre : 
                                    <strong>" . $ligne['Genre'] . "</strong>
                                 </p>
                              </div>
                           <div class='col'>
                              <p>";
   echo ($ligne['Cover'] == "") ? $Cover_vide : "<img src='" . "image/" . $ligne['Cover'] . "'>";

   echo "             </p>
                           </div>
                        </div>
                        <div class='row'>
                           <div class='col'>
                              <p>
                                 <audio title='" . $ligne['Titre'] . "' preload='auto' controls loop>
                                    <source src='" . "sound" . $ligne['Sound'] . "' type='audio/mp3'>
                                 </audio>
                              </p>
                           </div>
                           <div class='col'>
                              <p>
                                 <a href='supprimer.php?Etat=DEL&Id=" . $ligne['Id'] . "'><button type='button' class='btn btn-outline-secondary float-end btn-lg'><i class='bi bi-trash'></i></button></a>
                                 <a href='modif_form.php?Etat=UP&Id=" . $ligne['Id'] . "'><button type='button' class='btn btn-outline-warning me-md-2 float-end btn-lg'><i class='bi bi-pencil'></i></button></a>
                              </p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
         </div>

";
}

echo " </div>
</div>";