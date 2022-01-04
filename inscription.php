<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="CSS\style.css">
    <title>Inscription</title>
</head>

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
            <div class='row justify-content-center mt-5'>
                <div class='col-lg-4 col-md-8 col-sm-8'>
                    <div class='card shadow'>
                        <div class='card-title text-center border-bottom'>
                            <h2 class='p-3'>Inscription</h2>
                        </div>
                        <div class='card-body'>
                            <form action='validationformulaire.php' method='post'>
                                <!--<form action='validationformulaire.php' method='post'>-->
                                <div class='mb-4'>
                                    <label for='name' class='form-label'>Nom</label>
                                    <input type='text' class='form-control' id='name' placeholder='Votre nom' required
                                        pattern="^[A-Za-z '-]+$" maxlength="20" name='name'>
                                </div>
                                <div class='mb-4'>
                                    <label for='mail' class='form-label'>Email</label>
                                    <input type='email' class='form-control' id='mail' placeholder='Votre adresse Email'
                                        required='required' name='mail'>
                                </div>
                                <div class='mb-4'>
                                    <label for='password' class='form-label'>Mot de passe</label>
                                    <input type='password' class='form-control' id='password'
                                        placeholder='Votre mot de passe' required='required' name='password'>
                                </div>
                                <div class='mb-4'>
                                    <label for='password_retype' class='form-label'>Confirmation mot de passe</label>
                                    <input type='password' class='form-control' id='password_retype'
                                        placeholder='Retapez votre mot de passe' required='required' name='password_retype'>
                                </div>
                                <div class='mb-4'>
                                    <input type='checkbox' class='form-check-input' id='form-cgv' required='required'>
                                    <label for='form-cgv'>J'ai lu les conditions d'utilisation</label>
                                </div>
                                <div class='d-grid'>
                                    <button type='submit' class='btn main-bg text-light'>S'inscrire</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class='d-grid text-center'>
                                    <a href='enregistrement.php'><button type='submit' class='btn main-bg text-light text-decoration-underline'>Se connecter ?</button></a>
                                </div>
                </div>
            </div>
        </div>


</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</html>