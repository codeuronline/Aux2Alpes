<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="gitebonbon.css">
</head>


<a href="index.php"><img class="logo1" src="image/logo.png" width="100px" height="100px" alt="Logo"></a>


<body class='main-bg'>
<?php
    include 'message.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include 'connexion.php';
    } else {
        echo "<div class='container'>
            <div class='row justify-content-center mt-5'>";
        if (isset($_GET['reg_err'])) {

            switch ($_GET['reg_err']) {
                case 'mail':
                    echo MSG_MAIL_INVALID;
                    break;
                case 'password':
                    echo MSG_PASSWORD_INVALID;
                    break;
                case 'password':
                    echo MSG_PASSWORD_NOT_IDENTICAL;
                    break;
                case 'mail_length':
                    echo MSG_MAIL_LENGTH;
                    break;
                case 'already':
                    echo MSG_MAIL_ALREADY;
                    break;
                case 'pseudo_length':
                    echo MSG_NAME_LENGTH;
                    break;
                case 'Success':
                    echo MSG_SUCCESS_ACCOUNT_CREATED;
                    
                default:
                    
                    break;
            }
        }
    }
    ?>
        <div class='container'>
            <div class='row1'>
                <div class=col-mb-4>
                            <form action='validationformulaire.php' method='post'>
                                <!--<form action='validationformulaire.php' method='post'>-->
                                <div class='mb-4'>
                                    <label for='name' class='form-label'>Nom</label><br>
                                    <input type='text' class='form-control' id='name' placeholder='Votre nom' required
                                        pattern="^[A-Za-z '-]+$" maxlength="20" name='name'>
                                </div>
                                <div class='mb-4'>
                                    <label for='mail' class='form-label'>Email</label><br>
                                    <input type='email' class='form-control' id='mail' placeholder='Votre adresse Email'
                                        required='required' name='mail'>
                                </div>
                                <div class='mb-4'>
                                    <label for='password' class='form-label'>Mot de passe</label><br>
                                    <input type='password' class='form-control' id='password'
                                        placeholder='Votre mot de passe' required='required' name='password'>
                                </div>
                                <div class='mb-4'>
                                    <label for='password_retype' class='form-label'>Confirmation mot de passe</label><br>
                                    <input type='password' class='form-control' id='password_retype'
                                        placeholder='Retapez votre mot de passe' required='required' name='password_retype'>
                                </div>
                                <div class='mb-4'>
                                    <input type='checkbox' class='form-check-input' id='form-cgv' required='required'>
                                    <label for='form-cgv'>J'ai lu les conditions d'utilisation</label><br>
                                    <button type='submit' class='btn-inscription-connexion'>Inscription</button>
                            </form>
                        </div>
                    </div>
                </div>
</body>
</html>