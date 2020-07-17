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
$query = "SELECT survey.id,name,state,id_owner,users.abonnement FROM survey INNER JOIN users on users.id=survey.id_owner WHERE id_owner= ? AND survey.id= ?";
$name_surv = null;
if(!$_SESSION['id'] ==5 and !$_SESSION['id'] ==1){
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "ss", $_SESSION['id'], $id_surv);
        mysqli_stmt_bind_result($stmt, $id_surv, $name_surv, $state_surv, $id_owner, $abonnement);
        if (mysqli_stmt_execute($stmt)) {
            while (mysqli_stmt_fetch($stmt)) :
                $pass = true;
            endwhile;
        }
    }
    if (!$pass):
        header("location:../home.php");
    endif;
    if($abonnement!=1){
        if($abonnement==2){
            header("location:../analyticsPro.php/?id=".$id_surv);
        }else{
            header("location:../donnemoitonargent.php/?id=".$id_surv);
        }
    }
}else{
        if ($stmt = mysqli_prepare($link, $query)):
            mysqli_stmt_bind_param($stmt, "ss",$_SESSION['id'], $id_surv);
            mysqli_stmt_bind_result($stmt, $id_surv, $name_surv, $state_surv, $id_owner,$abonnement);
            if (mysqli_stmt_execute($stmt)) {
                while (mysqli_stmt_fetch($stmt)) :
                    $pass = true;
                endwhile;
            }
        endif;
}
$qList=array();
$query = "SELECT id,question,choix,optionnel,total_r FROM question where id_survey=?";
if ($stmt = mysqli_prepare($link, $query)):
    mysqli_stmt_bind_param($stmt, "s", $id_surv);
    if (mysqli_stmt_execute($stmt)):
        mysqli_stmt_bind_result($stmt, $id_question, $question,$type,$optio,$total_r);
        while (mysqli_stmt_fetch($stmt)) :
            array_push($qList,array("id"=>$id_question,"question"=>$question,"choix"=>$type,"optio"=>$optio,"total_a"=>$total_r));
        endwhile;
    endif;
endif;
$rList=array();
$query = "SELECT id,reponse,amount_answer FROM champs where id_question=?";
foreach($qList as $q){
    if ($stmt = mysqli_prepare($link, $query)):
        mysqli_stmt_bind_param($stmt, "s", $q["id"]);
        if (mysqli_stmt_execute($stmt)):
            mysqli_stmt_bind_result($stmt, $id_rep,$text,$total_a);
            while (mysqli_stmt_fetch($stmt)) :
                array_push($rList,array("id"=>$id_rep,"id_q"=>$q["id"],"reponse"=>$text,"total_a"=>$total_a));
            endwhile;
        endif;
    endif;
}
?>
<html lang="en">
<script async src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<head>
    <meta charset="UTF-8">
    <title>Analytics</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="icon" href="../pictures/favi.ico"/>
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/home.css">
    <link href="../css/pro.css" rel="stylesheet" >
</head>
<div id="menu">
    <ul>
        <li><img src="../pictures/Logo.png"  height="6%"/li>
        <li><p class="analyse">Mode Analyse</p></li>
        <li style="float:right"><a href="logout.php">Logout</a></li>
    </ul>
    <div class="line"></div>
</div>
<div class="middle">
    <a href="../home.php"/><img class="ret" src="../pictures/retour.png" alt="retour" height="5%"></a>
    <h1>Analysez les réponses à vos questions !</h1>
</div>
<?php
foreach($qList as $q){
    echo '<div class="main">
    <div class="liste">
        <div class="entete"> ';
    echo'<p>'.$q['question'].' '.$q['total_a'].' personne(s) ont répondu(s).</p>';
    echo'</div><div><ul>';
    foreach($rList as $r){
        if($r["id_q"]===$q['id']){
            echo'<li>&lsaquo;&lsaquo;'.$r['reponse'].'&rsaquo;&rsaquo; '.$r['total_a'].' personne(s) ont répondu(s) cette réponse.</li>';
        }
    }
    echo "</ul> </div>
</div>";
}

?>
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
