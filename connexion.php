
<?php



/*connexion a la table inscription*/
$serveur = "localhost";
$table = "inscription";
$namedb = "mamusique";
$user = "root";
$pass = "";

try {
    $bdd = new PDO("mysql:host=$serveur;dbname=$namedb", $user, $pass);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
}

if (!empty($_POST['mail']) && !empty($_POST['password'])) {
    
    $mail = htmlspecialchars($_POST['mail']);
    $password = htmlspecialchars($_POST['password']);

    $mail = strtolower($mail);

    $check = $bdd->prepare("SELECT name, mail, password FROM $table WHERE mail = ?");
    $check->execute(array($mail));
    $data = $check->fetch();
    $row = $check->rowCount();

    if ($row == 1) {
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            if (hash_equals(hash('sha256', $password), $data['password'])) {
                    $_SESSION['user'] = $data['mail'];
                $_SESSION['name'] = $data['name'];
                    header('Location: index.php');
                    
            } else {
                header('Location: enregistrement.php?login_err=password');
            }
        } else {
            header('Location: enregistrement.php?login_err=email');
        }
    } else {
        header('Location: enregistrement.php?login_err=already');
    }
} else {
    header('Location: enregistrement.php?login_err=no_register');
}


?>
