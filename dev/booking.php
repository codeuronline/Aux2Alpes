<?php
session_start();
require_once('connect.php');
require_once('tools.php');
$_SESSION['mail'] = "jkasperski@free.Fr";
$_SESSION["id_user"] = 1;
echo '<hr>';
var_dump($_SESSION);
echo '<hr>';
echo "date de reservation de l'utilisateur pour l'hebergement n°<br>";
echo '<hr>';
var_dump($_POST);
echo '<hr>';
$sql = 'SELECT date_jour FROM `jour` WHERE `id_periode` = :id AND etat=0';
$query = $db->prepare($sql);
$query->bindValue(':id', $_POST['id_hebergement'], PDO::PARAM_INT);
$query->execute();
$jour_free = $query->fetchALL(PDO::FETCH_ASSOC);
$tabReserdisponible = array();
echo "on recupere les jours disponibles pour la periode de l'hebergement:" . $_POST['id_hebergement'] . "<br>";
echo "<hr>";
var_dump($jour_free);
echo "<hr>";
foreach ($jour_free as $element) {
    array_push($tabReserdisponible, $element['date_jour']);
}
echo "<hr>";
if (in_array($_POST['debutReserv'], $tabReserdisponible)) {
    $indice['debut'] = true;
}
if (in_array($_POST['finReserv'], $tabReserdisponible)) {
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
        $indice['intervalle'] = dateDiff($_POST['debutReserv'], $_POST['finReserv']);
        for ($i = 0; $i <= $indice['intervalle']; $i++) {
            $value = date("Y-m-d", strtotime($_POST['debutReserv'] . "+ $i days"));
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
        $query6->bindValue(":debut", $_POST['debutReserv']);
        $query6->bindValue(":fin", $_POST['finReserv']);
        $query6->execute();
        //envoyer un mail a l'utilisateur
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // on recupere les donnée
            $mailto     = $_SESSION['mail'];
            $mailfrom   = "contact-client@gite.com";
            $sujet      = "Confirmation de Réservation d'un hébergement";
            $message    = "Nous vous confirmons la réservation de l'hébergement(hebergement['nom']pour personne[nb]
             personne(s) pour une durée de hebergement['intervalle'] jours  pour un montant de  hebergement['prix'] x personne['nb_pers'] x personne['nb_jour']";
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
            echo "mail envoyé";
        }

    } else {
        echo "problème de date pour la reservation";
    }
} else {
    echo "problème de date pour la reservation";
}
var_dump($_POST);
var_dump('')

?>