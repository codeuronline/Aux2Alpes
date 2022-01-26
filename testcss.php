<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=".\gitebonbon.css">
</head>

<a href="rechercheutilisateur.php"><img class="logo1" src="image/logo.png" width="100px" height="100px" alt="Logo"></a>
<body>
    <!--Login formulaire-->
    <div class='container'>
            <div class='row justify-content-center mt-5'><div class='col-lg-4 col-md-8 col-sm-8'> 
                    <div class='card shadow'>
                        <div class='card-title text-center border-bottom'>
                        </div>
                        <div class='card-body'>
                            <form action='connexion.php' method='post'>
                                <div class='mb-4'>
                                    <label for='mail' class='form-label'>Email</label><br>
                                    <input type='email' class='form-control' id='mail' name='mail' required='required'>
                                </div>
                                <div class='mb-4'>
                                    <label for='password' class='form-label'>Mot de passe</label><br>
                                    <input type='password' class='form-control' id='password' name='password' required='required'>
                                </div>
                                <div class='mb-4'>
                                    <input type='checkbox' class='form-check-input' id='remember'>
                                    <label for='remember'>Se souvenir de moi</label>
                                </div><br>
                                <div class='d-grid'>
                                    <button type='submit' class='btn-inscription-connexion'>Connexion</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class='d-grid-text-center'><br>
                                <a href='inscription.php'><button type='submit' class='btn-inscription-connexion'>Inscription</button></a>
                </div>
            </div>
        </div></body>
</html>