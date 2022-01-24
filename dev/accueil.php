<?php
 


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!--<link rel="stylesheet" href="radio.css">-->
    <link rel="stylesheet" href="test.css">
    <title>Accueil</title>
</head>

<body>
    <div class="container">
        <div class="a">

            <h1> Gite bonbons Bonbons</h1>

        </div>
        <div class="b"><span>mosaique de gite</span></div>
        <div class="c"><span>mosaique de gite</span></div>
        <div class="d">
            <h3>Formulaire</h2>
                <form method=POST action="search.php">
                    <label for="search">Destination:
                        <input type="text" name="search" id="search">
                    </label>
                    <label for="couchage">
                        <select id="couchage">
                            <?php
                            for ($i = 1; $i <= intval($hebergement['max']); $i++) {
                                echo "<option value=$i><i class='bi bi-person'>$i</i></option>";
                            }
                            ?>
                        </select>
                        <button class="btn btn-primary" type="submit">Recherche</button>
                    </label>
                </form>
        </div>
        <div class="e">coucou</div>
        <div class="f">coucou</div>
        <div class="g">hello</div>
    </div>
</body>

</html>