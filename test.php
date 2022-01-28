<form method="POST" action="booking1.php">

    <?php //ici pour demander a l utilisateur de s'enregristré  

    $_SESSION['id_user'] = 2;

    if (!(@$_SESSION['id_user'])) {

        echo  "<label><input placeholder='prenom' type='text'></label><br>";
        echo  "<label><input placeholder='nom' type='text'></label><br>";
        echo  "<label><input placeholder='mail' type='email'></label><br>";
    }
    echo "<input type='hidden' name='personne' value='1'>";
    echo "<input type='hidden' name='id_hebergement' value='38'>"; ?>
    <input type='date' value='<?= date('Y-m-d') ?>' name='debut'>
    <input type='date' value='' name='fin'>
    <button class=btn-inscription-connexion type='submit' class='bg-text-light'>Reservation</button>

</form>