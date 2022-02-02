<?php
session_start();
include_once('librairies/toolformikadev.php');

//doit etre obtenu pour l'identification
$_SESSION['email'] = "jkasperski@free.fr";
$_SESSION["id_user"] = 1;
$_SESSION['personne'] = 2 /*$_POST['personne']*/;
//doit etre obtenu par la recherche


$hebergement = selectHebergementbyIdFull($_POST['id_hebergement']);
$jour_free = selectJourFreebyId($_POST['id_hebergement']);

echo '<hr>';
echo "date de reservation de l'utilisateur pour l'hebergement n°<br>";
echo "debut : " . $_POST['debut'] . "<br>";
echo "fin : " . $_POST['fin'] . "<br>";
echo '<hr>';

$tabReserdisponible = array();
echo "on recupere les jours disponibles pour la periode de l'hebergement:" . $_POST['id_hebergement'] . "<br>";
echo "<hr>";
var_dump($jour_free);
echo "<hr>";

foreach ($jour_free as $element) {
    array_push($tabReserdisponible, $element['date_jour']);
}
echo "<hr>";
if (in_array($_POST['debut'], $tabReserdisponible)) {
    $indice['debut'] = true;
}
if (in_array($_POST['fin'], $tabReserdisponible)) {
    $indice['fin'] = true;
}
echo "On transforme cette liste en un tableau a 1 dimension:<br>";
echo "<hr>";
var_dump($tabReserdisponible);
echo "<hr>";
echo "On affiche l'etat des la periode: <br>";
echo "<hr>";
var_dump(@$indice);
echo "<hr>";
//mise a jour de l'etat pour la table jour
if (isset($indice)) {
    if (($indice['debut'] == true) && ($indice['fin'] == true)) {
        updateAllDayWithId($_POST['id_hebergement'], $_POST['debut'], $_POST['fin']);
        addReservation($_SESSION['id_user'], $_POST['id_hebergement'], $_POST['debut'], $_POST['fin']);
        //envoyer un mail a l'utilisateur

        //calcul des element du mail
        $prix = $hebergement['prix'];
        //$indice['intervalle'] = dateDiff($_POST['debut'], $_POST['fin']);
        $nb_jour = dateDiff($_POST['debut'], $_POST['fin']) + 1;
        $nb_personne = $_SESSION['personne'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // on recupere les donnée
            $mailto     = $_SESSION['email'];
            $mailfrom   = "contact-client@gite.com";
            $sujet      = "Confirmation de Réservation d'un hébergement";
            $message    = "Nous vous confirmons la réservation de l'hébergement(" . $hebergement['nom'] . "pour $nb_personne
             personne(s) pour une durée de $nb_jour jours  et pour un montant de :" . $hebergement['prix'] . "€ x " . $nb_personne . "personne(s) x " . $nb_jour . "jour(s)";
            $headers = array(
                'From' => $mailfrom,
                'Reply-To' => $mailfrom
            );
            $entetemessage = "Bonjour,\r\n";
            $entetemessage .= "Cher(s) clients,\r\n";
            //construction du message final avant envoi
            $message = wordwrap($message, 70, "\r\n");
            $message = $entetemessage . $message . "\r\n";
            mail($mailto, $sujet, $message, $headers);

            $SESSION['message'] = "Confirmation envoyé par mail";
          
          //  header('Location: index.php');
        }
    } else {
        $SESSION['warning'] = "problème de date pour la reservation";
        echo "pb de date";
    }
} else {
    $SESSION['warning'] = "problème d'identification";
    echo "pb authentification";
}