<?php
require_once "php/config.php";
$id_surv = $_GET["id"];
//On verifie que la personne a bien les droits
$query = "SELECT id,name,state,id_owner FROM survey WHERE id= ? ";
$name_surv = null;

if ($stmt = mysqli_prepare($link, $query)):
    mysqli_stmt_bind_param($stmt, "s", $id_surv);
    mysqli_stmt_bind_result($stmt, $id_surv, $name_surv, $state_surv, $id_owner);
    if (mysqli_stmt_execute($stmt)) {
        while (mysqli_stmt_fetch($stmt)) :
        endwhile;
    }
endif;
if($id_surv=="" or $id_surv==null){
    header("location:../home.php");
}

session_start();
$text=(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)?"Login/Register":"Logout";
?>
<html lang="en">
<script async src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<head>
    <meta charset="UTF-8">
    <title>Survey</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/list.css">
    <link rel="icon" href="../pictures/favi.ico"/>
</head>
<body>
<div id="menu">
    <ul>
        <li><img src="../pictures/Logo.png"  height="7%"/></li>
        <li><a href="../home.php">Accueil</a></li>
        <?php echo '<li><a onclick=\'sharesurv(' . $id_surv . ')\'>Partager le survey</a></li>' ?>
        <?php echo'<li style="float:right"><a href="../logout.php">'.$text.'</a></li>'?>
    </ul>
    <div class="line"></div>
</div>
<?php
if(isset($_GET["error"])){
    //Afficher erreur
    $query="SELECT question from question where id=?";
    if ($stmt = mysqli_prepare($link, $query)):
        mysqli_stmt_bind_param($stmt, "s", $_GET["error"]);
        mysqli_stmt_bind_result($stmt, $text);
        if (mysqli_stmt_execute($stmt)) {
            while (mysqli_stmt_fetch($stmt)) :
                echo"<script>alert(\"La question: $text est obligatoire\")</script>";
            endwhile;
        }
    endif;
}
echo "<div class=\"main\">
    <div class=\"liste\">
        <div class=\"entete\">  
<p>$name_surv</p> 
</div>
        <div><form action=\"../php/send_form.php/?id=".$id_surv."\" method=\"post\">
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
    $qtxt= '<li><p>' . $q["question"];
    if($q["optio"]=="0"){
        $qtxt.="<span> *</span>";
    }
    echo $qtxt.'</p></li>
        <div>
            <ol>';
    if ($stmt2 = mysqli_prepare($link, $query2)):
        mysqli_stmt_bind_param($stmt2, "s", $q["id"]);
        if (mysqli_stmt_execute($stmt2)):
            mysqli_stmt_bind_result($stmt2, $id_rep, $rep);
            while (mysqli_stmt_fetch($stmt2)) :
                $rfield='<li><input type="';
                $rfield.=($q["choix"] == "0")?'checkbox" ':'radio" ';
                //$rfield.=($q["optio"] == "1")?'required" ':'';
                echo $rfield.' id="' . $id_rep . '" name="' . $id_rep . '"><label for="' . $id_rep . '">' . $rep . '</label></li>';
            endwhile;
            echo "</ol>
            </div>";
        endif;
    endif;
}
echo "</ul>
    <p><input  style=' background-color: #00A9E9;
    color: white;
    font-size: 0.8em;
    padding: 4px 7px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    text-align: center;' type=\"submit\" value=\"OK\"></p>
</form> </div>
</div>";

?>
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

