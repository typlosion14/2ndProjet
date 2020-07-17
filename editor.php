<?php
require_once "php/config.php";
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}
$pass = false;
$id_surv = $_GET["id"];
//On verifie que la personne a bien les droits
$query = "SELECT id,name,state,id_owner FROM survey WHERE id_owner= ? AND id= ? ";
$name_surv = null;

if ($stmt = mysqli_prepare($link, $query)):
    mysqli_stmt_bind_param($stmt, "ss", $_SESSION['id'], $id_surv);
    mysqli_stmt_bind_result($stmt, $id_surv, $name_surv, $state_surv, $id_owner);
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
<script async src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<head>
    <meta charset="UTF-8">
    <title>Editor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="icon" href="../pictures/favi.ico"/>
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/list.css">
    <link rel="stylesheet" href="../css/popup.css">
</head>
<script>
    function closeModal() {
        document.getElementById('overlay').style.display='none';
    }
</script>
<body>
<div id="overlay" class="overlay">
    <div id="popup" class="popup">
        <span onclick="closeModal()" class="btnClose">&times;</span>
    </div>
</div>
<div id="menu">
    <ul>

        <li><img src="../pictures/Logo.png" alt="logo" height="6.5%"></li>
        <li><a href="../home.php">Accueil</a></li>
        <?php echo '<li><a onclick=\'deletesurv(' . $id_surv . ')\'>Supprimer ce sondage</a></li>' ?>
        <?php echo '<li><a onclick=\'newquestion(' . $id_surv . ')\'>Ajouter une question au sondage</a></li>' ?>
        <?php echo '<li><a onclick=\'sharesurv(' . $id_surv . ')\'>Partager le sondage</a></li>' ?>
        <?php echo '<li><a onclick=\'watchsurv(' . $id_surv . ')\'>Voir les résulats</a></li>' ?>
        <li style="float:right"><a href="../logout.php">Logout</a></li>
    </ul>
    <div class="line"></div>
    <a href="#menu"><img class="up" src="../pictures/up.png" alt="Remonter" height="5%"/></a>
</div>
<?php

echo "<div class=\"main\">
    <div class=\"liste\">
        <div class=\"entete\">
<p>$name_surv</p> 
</div>
        <div >

            <ul>";
//Affichage les questions du survey
$qList=array();
$query = "SELECT id,question,choix,optionnel FROM question where id_survey=?";
if ($stmt = mysqli_prepare($link, $query)):
    mysqli_stmt_bind_param($stmt, "s", $id_surv);
    if (mysqli_stmt_execute($stmt)):
        mysqli_stmt_bind_result($stmt, $id_question, $question,$type,$optio);
        while (mysqli_stmt_fetch($stmt)) :
            array_push($qList,array("id"=>$id_question,"question"=>$question,"choix"=>$type,"optio"=>$optio));
        endwhile;
    endif;
endif;
$query2 = "SELECT id,reponse FROM champs where id_question=?";
foreach($qList as $q){
    echo '<li class="question"><p>' . $q["question"] . '</p><input type="image" src="../pictures/Add.png" alt="Ajouter une question"  title="Ajouter une question" height="3%" onclick=\'addrep('.$q["id"].',' . $id_surv . ')\'><input type="image" src="../pictures/Modifier.png" alt="Modifier la question"  title="Modifier la question" height="3%" onclick=\'modifyquestion(' . $q["id"] .')\'><input type="image" src="../pictures/delete.png" alt="Supprimer la question"  title="Supprimer la question" height="3%" onclick="deletequestion(' . $q["id"] . ')"></li>
        <div>
            <ol>';
    if ($stmt2 = mysqli_prepare($link, $query2)):
        mysqli_stmt_bind_param($stmt2, "s", $q["id"]);
        if (mysqli_stmt_execute($stmt2)):
            mysqli_stmt_bind_result($stmt2, $id_rep, $rep);
            while (mysqli_stmt_fetch($stmt2)) :
                echo '<li><label for="' . $id_rep . '">' . $rep . '</label><input  type="image" src="../pictures/Modifier.png" title="Modifier la réponse" alt="Modifier la réponse" height="3%" onclick=\'modifyrep(' . $id_rep . ',"' . $rep . '")\'><input  type="image" type="image" src="../pictures/delete.png" alt="Supprimer la réponse"  title="Supprimer la réponse" height="3%" onclick="deleterep(' . $id_rep . ')"></li>';
            endwhile;
            echo "</ol>
            </div>";
        endif;
    endif;
}
echo "</ul>
    </div>
</div>";

?>
<div class="space"></div>
<script src="../js/bouttonchamps.js"></script>
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

