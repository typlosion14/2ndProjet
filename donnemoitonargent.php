<?php
require_once "php/config.php";
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}
$pass = false;
//On verifie que la personne a bien les droits
$query = "SELECT abonnement FROM users  WHERE id= ?";

if ($stmt = mysqli_prepare($link, $query)):
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['id']);
    mysqli_stmt_bind_result($stmt, $abonnement);
    if (mysqli_stmt_execute($stmt)) {
        while (mysqli_stmt_fetch($stmt)) :
            $pass = true;
        endwhile;
    }
endif;

if (!$pass):
    header("location:../home.php");
endif;
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Abonnement</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.typekit.net/vvn0wga.css">
    <link rel="icon" href="pictures/favi.ico"/>
    <link href="css/money.css" rel="stylesheet">

</head>
<body>
<a href="home.php"><img src="pictures/official.png" height="10%"></a>
<div class="offre_content">
    <h1>Nos offres d'abonnement</h1>
    <div class="title_line">
        <p class="first_title">Offre gratuite</p>
        <p>Offre personnel</p>
        <p>Offre professionnel</p>
    </div>
    <div class="line1">
        <strong  >Creation de sondage</strong>
        <p>1</p>
        <p>20</p>
        <p>Illimité</p>
    </div>
    <div class="line2">
        <strong >Partage de sondage</strong>
        <p>Illimité</p>

    </div>
    <div class="line1">
        <strong class="as" >Accès aux statistiques</strong>
        <p>Partiel</p>
        <p>Partiel</p>
        <p>Complet</p>
    </div>

    <div class="line1">
        <strong >Sans publicté</strong>
        <p>Non</p>
        <p>Non</p>
        <p>Oui</p>
    </div>

    <div class="tarif_offer">
        <strong >Prix du forfait</strong>
        <div class="offer1">
            <p class="moulaga">Gratuit</p>
            <p> </p>
            <p>(sans fin)</p>
            <div class="perso">
                <button id="Free" type="button"><a href="home.php">Accueil</a></button>
            </div>
        </div>
        <div class="offer2">
            <p class="moulaga">5.99€</p>
            <p>par mois</p>
            <div class="pro">
                <a href="thanks_achat.html"><button id="Perso" type="button">Commencer</button></a>
            </div>
        </div>
        <div class="offer3">
            <p class="moulaga">15.99€</p>
            <p>par mois</p>
            <div class="pro">
                <a href="thanks_achat.html"><button id="Pro"  type="button">Commencer</button></a>
            </div>
        </div>


    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/argent.js"></script>
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