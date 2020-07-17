<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: home.php");
    exit;
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="css/Landing_Style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.typekit.net/vvn0wga.css">
    <link rel="icon" href="pictures/favi.ico"/>
    <title>Landing Page</title>
</head>
<body>
<div class="content">
    <div class="top_content">
        <div class="toplp">
            <img class="title" src="pictures/Logo.png" height="18%" width="18%">
            <a  class="connect" href="login.php"><p>Se connecter</p></a>
        </div>

        <div>
            <img  class="survey" src="pictures/plume.png" height="32%" width="32%">
        </div>

        <div class="text_content">
            <h1>Créez vos propres formulaires</h1>
            <p>Ensemble, trouvons les réponses à vos questions.<br>
                Bénéficiez de l'offre gratuite Online Survey.</p>
        </div>
        <div class="button_content">

            <a href="register.php"><input class="button" type="button" value="Commencer maintenant"></a>
            <p>Essayez Online Survey gratuitement, pas de carte de crédit requise</p>
        </div>



    </div>

    <div class="bottom_content">
        <div class="triangle">

        </div>
        <div class="title_bottom">
            <h2>Découvrez notre outil de création d'enquêtes en ligne</h2>
        </div>
        <div class="avantages">

            <div class="content_1">
                <img  class="picture" src="pictures/Easy.png" height="15%" >
                <h2>Facile à prendre en main
                    et instinctif</h2>
                <p>Que vous soyez un particulier ou une
                    entreprise, créez vos questions en toute
                    simplicité avec Online Survey. </p>
            </div>


            <div class="content_3">
                <img class="picture" src="pictures/Proximity.png" height="15%" >
                <h2>Partagez vos sondages</h2>
                <p>Chaque sondage génère un lien afin que vous puissiez le partager à d'autre personne. Celles-ci pourront répondre à votre sondage en toute simplicité.</p>
            </div>

            <div class="content_2">

                <img class="picture" src="pictures/Visibilité.png" height="15%">
                <h2>Observez les réponses à
                    chacune de vos questions </h2>
                <p>Nous mettons à votre disposition l'outil
                    Survey Analyser permettant d'avoir accès
                    aux résultats de vos propres formulaires. </p>
            </div>

        </div>

    </div>
</div>
</body>
<footer>
    <ul>
        <li>© 2020 Online Survey </li>
        <li>Confidentialité des données et vie privée</li>
        <li>Ne pas vendre mes données
        <li>Mentions légales</li>
        <li>Conditions d'utilisation</li>
        <li>Politique et confidentialité</li>
        </ul>
</footer>
</html>
