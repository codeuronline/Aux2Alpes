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
    <title>Se connecter</title>
</head>

<body class='main-bg'>

    <!--Login formulaire-->
    <?php
    include 'message.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include 'connexion.php';
    } else {
        echo "<div class='container'>
            <div class='row justify-content-center mt-5'>";
        if (isset($_GET['login_err'])) {

            switch ($_GET['login_err']) {
                case 'mail':
                    echo MSG_MAIL_INVALID;
                    break;
                case 'password':
                    echo MSG_PASSWORD_INVALID;
                    break;
                case 'mail_length':
                    echo MSG_MAIL_LENGTH;
                    break;
                case 'already':
                    echo MSG_NO_REGISTER;
                    break;
                case 'pseudo_length':
                    echo MSG_NAME_LENGTH;
                    break;
                case 'success':
                    echo MSG_SUCCESS_CONNECTION;
                    
                default:
                    
                    break;
            }
        }
        echo "<div class='col-lg-4 col-md-8 col-sm-8'> 
                    <div class='card shadow'>
                        <div class='card-title text-center border-bottom'>
                            <h2 class='p-3'>Se connecter</h2>
                        </div>
                        <div class='card-body'>
                            <form action='connexion.php' method='post'>
                                <div class='mb-4'>
                                    <label for='mail' class='form-label'>Email</label>
                                    <input type='email' class='form-control' id='mail' name='mail' required='required'>
                                </div>
                                <div class='mb-4'>
                                    <label for='password' class='form-label'>Mot de passe</label>
                                    <input type='password' class='form-control' id='password' name='password' required='required'>
                                </div>
                                <div class='mb-4'>
                                    <input type='checkbox' class='form-check-input' id='remember'>
                                    <label for='remember'>Se souvenir de moi</label>
                                </div>
                                <div class='d-grid'>
                                    <button type='submit' class='btn main-bg text-light'>Connexion</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class='d-grid text-center'>
                                <a href='inscription.php'><button type='submit' class='btn main-bg text-light text-decoration-underline'>S'inscrire ?</button></a>
                            </div>
            </div>
        </div>";
    }
    ?>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</html>