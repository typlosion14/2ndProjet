<?php
require_once "php/config.php";
//require_once "php/load_all_forms.php";
session_start();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$id_user = $_SESSION['id'];
?>
<html lang="en">
<script async src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.typekit.net/vvn0wga.css">
    <link rel="icon" href="pictures/favi.ico"/>
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
<div id="menu">
    <ul>
        <li><img src="pictures/Logo.png"  height="6%"/></li>
        <li><a href="home.php">Accueil</a></li>
        <?php echo "<li><a onclick='newsurv()'>Créer un nouveau survey</a></li>" ?>
        <li><a href="LandingPage.html">En savoir plus</a></li>
        <li style="float:right"><a href="logout.php"><img  src="pictures/logout.png" alt="Déconnexion" title="Déconnexion" height="3%"></a></li>
        </li>
    </ul>
    <div class="line"></div>
    <a href="#menu"><img class="up" src="../pictures/up.png" alt="Remonter" height="5%"/></a>
</div>
<?php

$querys = "SELECT DISTINCT id,name,id_owner FROM survey where id_owner=?";
//Query execution
if ($stmt = mysqli_prepare($link, $querys)):
    mysqli_stmt_bind_param($stmt, "s", $id_user);
    mysqli_stmt_bind_result($stmt, $id_surv, $name_surv, $id_owner);
    if (mysqli_stmt_execute($stmt)) {
        echo "<div class=\"block\">
                                <ul>";
        while (mysqli_stmt_fetch($stmt)) :
                echo("<li><a onclick=\"modifysurv($id_surv)\"> <p> $name_surv </p></a></li>\n");
        endwhile;
        echo "</ul>
                            </div>";
    }
endif;
?>

<div class="space"></div>
<script src="js/bouttonform.js"></script>

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
