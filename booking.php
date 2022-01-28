<?php
//nous sert de passerel pour recuperer les donné utilisateur et les envoyer par email a l utilisateur

//session_start();
require_once('toolformikadev.php');

//doit etre obtenu pour l'identification
$_SESSION['email'] = "jkasperski@free.fr";
$_SESSION['personne'] = 1 /*$_POST['personne']*/;
$_SESSION['user'] = 1;
$_SESSION['id_user'] = 1;
//doit etre obtenu par la recherche


$hebergement = selectHebergementbyIdFull($_POST['id_hebergement']);
$jour_free = selectJourFreebyId($_POST['id_hebergement']);

$sql1 = "SELECT * FROM `jour` WHERE id_periode=:id AND etat=0";
$query1 = $db->prepare($sql1);
$query1->bindValue(':id', $_POST['id_hebergement']);
$query1->execute();
$jour_free = $query1->fetchALL(PDO::FETCH_ASSOC);


//$jour_free = selectJourFreebyId($_POST['id_hebergement']);


echo '<hr>';
echo "date de reservation de l'utilisateur pour l'hebergement n°<br>" . $_POST['id_hebergement'];
echo '<hr>';

$tabReserdisponible = array();
echo "on recupere les jours disponibles pour la periode de l'hebergement:" . $_POST['id_hebergement'] . "//" . $_POST['debut'] . "||" . $_POST['fin'] . "\\<br>";
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
        //mise a jour de l'etat pour la table jour
        $indice['intervalle'] = dateDiff($_POST['debut'], $_POST['fin']);
        for ($i = 0; $i <= $indice['intervalle']; $i++) {
            $value = date("Y-m-d", strtotime($_POST['debut'] . "+ $i days"));
            $compteur = $i + 1;
            echo "valeur à reserver:" . $value . "<br>";
            $sql5 = 'UPDATE `jour` SET etat=1 WHERE id_periode=:id_periode AND date_jour=:date_jour';
            $query5 = $db->prepare($sql5);
            $query5->bindValue(":id_periode", $_POST['id_hebergement']);
            $query5->bindValue(":date_jour", $value);
            $query5->execute();
        }
        $sql6 = "INSERT INTO `reservation` (id_user,id_hebergement,debut,fin) VALUES (:id_user,:id_hebergement,:debut,:fin)";
        $query6 = $db->prepare($sql6);
        $query6->bindValue(":id_user", $_SESSION['id_user']);
        $query6->bindValue(":id_hebergement", $_POST['id_hebergement']);
        $query6->bindValue(":debut", $_POST['debut']);
        $query6->bindValue(":fin", $_POST['fin']);
        $query6->execute();
        //envoyer un mail a l'utilisateur

        //calcul des element du mail
        $prix = $hebergement['prix'];
        $nb_jour = $indice['intervalle'] + 1;
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

            $SESSION['message'] = "mail envoyé";
        }
    } else {
        $SESSION['warning'] = "problème de date pour la reservation";
        echo "pb";
    }
} else {
    $SESSION['warning'] = "problème d'identification";
    echo "pb";
}


var_dump($_POST);
var_dump($_SESSION);