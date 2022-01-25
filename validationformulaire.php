<?php

$serveur = "localhost";
$table = "utilisateur";
$namedb = "hebergementdb";
$user = "root";
$pass = "";

try {
    $bdd = new PDO("mysql:host=$serveur;dbname=$namedb", $user, $pass);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}

if (isset($_POST['name']) && isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['password_retype'])) {
    $nom = htmlspecialchars($_POST["name"]);
    $mail = htmlspecialchars($_POST["mail"]);
    $password = htmlspecialchars($_POST['password']);
    $password_retype = htmlspecialchars($_POST['password_retype']);
    $mail = strtolower($mail);

    $check = $bdd->prepare("SELECT name, mail, password FROM $table WHERE mail = ?");
    $check->execute(array($mail));
    $data = $check->fetch();
    $row = $check->rowCount();

    if ($row == 0) {
        if (strlen($nom) <= 100) {
            if (strlen($mail) <= 100) {
                if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                    if ($password == $password_retype) {
                        try {
                            $password = hash('sha256', $password);
                            $inser = $bdd->prepare("INSERT INTO $table(name,mail,password) VALUES(:name, :mail, :password)");
                            $inser->execute(array(
                                ':name' => $nom,
                                ':mail' => $mail,
                                ':password' => $password
                            ));
                            header('Location:inscription.php?reg_err=Success');
                        } catch (PDOException $e) {
                            echo 'Erreur : ' . $e->getMessage();
                        }
                    } else {
                        header('Location: inscription.php?reg_err=password');
                    }
                } else {
                    header("Location: inscription.php?reg_err=mail");
                }
            } else {
                header("Location: inscription.php?reg_err=mail_length");
            }
        } else {
            header("Location : inscription.php?reg_err=pseudo_length");
        }
    } else {
        header('Location: inscription.php?reg_err=already');
    }
}
/*
if (
    !empty($nom)
    && strlen($nom) <= 20
    && preg_match("/^[A-Za-z '-]+$/", $nom)
    && !empty($mail)
    && filter_var($mail, FILTER_VALIDATE_EMAIL)
) {

    try {
        $dbco = new PDO("mysql:host=$serveur;dbname=$namedb", $user, $pass);
        $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sth = $dbco->prepare("
        INSERT INTO inscription (name, mail, password)
        VALUES(:nom, :mail, :password)");
        $sth->bindParam(':nom', $nom);
        $sth->bindParam(':mail', $mail);
        $sth->bindParam(':password', $password);
        $sth->execute();
        //creation identification
        header("Location:index.php");

    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
} else {
    header("Location:enregistrement.php");
}*/