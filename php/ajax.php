<?php
include "config.php";
session_start();
$id_user = $_SESSION["id"];
$abonnement=0;
$query="SELECT abonnement from users where id=".$id_user;
if ($result = mysqli_query($link, $query)) {

    $abonnement=mysqli_fetch_row($result)[0];

    /* Libération du jeu de résultats */
    mysqli_free_result($result);
}
if (isset($_POST['removesurv'])) {
    //Supression d'un survey avec ces questions et ces reponses
    $querys = array("DELETE FROM survey WHERE id = ?", "DELETE FROM champs WHERE id_survey=?" , "DELETE FROM question WHERE id_survey=?");
    foreach ($querys as $Query):
        if ($stmt = mysqli_prepare($link, $Query)):
            mysqli_stmt_bind_param($stmt, "s", $_POST['removesurv']);
            mysqli_stmt_execute($stmt);
        endif;
    endforeach;

} else if (isset($_POST['createsurv'])) {
    $query="SELECT id from survey where id_owner = ".$id_user;

    $surveylist = 0;
    if ($result = mysqli_query($link, $query)) {
        $surveylist=mysqli_num_rows($result);
    }
    if(($abonnement==0 and $surveylist>=1) or ($abonnement==1 and $surveylist>=10)){
        //AlertBox PAYE
        echo"PAYE";
    }else{
        //Creation d'un survey
        $query = "INSERT INTO `survey` (`id`, `name`, `id_owner`, `state`) VALUES (NULL, ?, ?, '0')";
        if ($stmt = mysqli_prepare($link, $query)):
            mysqli_stmt_bind_param($stmt, "ss", $_POST['createsurv'], $id_user);
            mysqli_stmt_execute($stmt);
        endif;
    }
} else if (isset($_POST['createquestion'])) {
    $query="SELECT id from question where id_survey=".$_POST['id'];
    $questionnb = 0;
    if ($result = mysqli_query($link, $query)) {
        $questionnb=mysqli_num_rows($result);
    }
    if($abonnement==0 and $questionnb>=20){
        //AlertBox PAYE
        echo"PAYE";
    }else {
        //Creation d'une question
        $query = "INSERT INTO question (id,question,id_survey,optionnel) VALUES (NULL,?,?,?)";
        if ($stmt = mysqli_prepare($link, $query)):
            mysqli_stmt_bind_param($stmt, "sss", $_POST['createquestion'], $_POST['id'], $_POST['optio']);
            mysqli_stmt_execute($stmt);
        endif;
    }
} else if (isset($_POST['removequestion'])) {
    //Suppression d'une question et de ses reponses
    $querys = array("DELETE FROM question where id=?","DELETE FROM champs where id_survey=?");
    foreach ($querys as $query):
        if ($stmt = mysqli_prepare($link, $query)):
            mysqli_stmt_bind_param($stmt, "s", $_POST['removequestion']);
            mysqli_stmt_execute($stmt);
        endif;
    endforeach;
} else if (isset($_POST['updatequestion_name'])) {
    //Modification d'une question
    $query = "UPDATE question SET question=?,optionnel=?,choix=? WHERE id=?";
    if ($stmt = mysqli_prepare($link, $query)):
        mysqli_stmt_bind_param($stmt, "ssss", $_POST['updatequestion_name'], $_POST['updatequestion_optio'], $_POST['choix'], $_POST['id']);
        mysqli_stmt_execute($stmt);
    endif;
} else if (isset($_POST['createrep'])) {
    //Creation d'une reponse

    $query = "INSERT INTO champs (id,reponse,id_question,id_survey) VALUES (NULL,?,?,?)";
    if ($stmt = mysqli_prepare($link, $query)):
        mysqli_stmt_bind_param($stmt, "sss",  $_POST['createrep'],$_POST['id_q'],$_POST['id_s']);
        mysqli_stmt_execute($stmt);
    endif;
} else if (isset($_POST['removerep'])) {
    //Suppression d'une reponse
    $query = "DELETE FROM champs where id=?";
    if ($stmt = mysqli_prepare($link, $query)):
        mysqli_stmt_bind_param($stmt, "s", $_POST['removerep']);
        mysqli_stmt_execute($stmt);
    endif;
} else if (isset($_POST['modifyrep'])) {
    //Modification d'une reponse
    $query = "UPDATE champs SET reponse=? WHERE id=?";
    if ($stmt = mysqli_prepare($link, $query)):
        mysqli_stmt_bind_param($stmt, "ss", $_POST['text'], $_POST['modifyrep']);
        mysqli_stmt_execute($stmt);
    endif;
} else if (isset($_POST['argent'])) {
    $abo_id=$_POST['argent'];
    $date=date("Y-m-d");
    var_dump($date);
    $query= "UPDATE users SET abonnement=?,abonnement_date=? where id=?";
    if ($stmt = mysqli_prepare($link, $query)):
        mysqli_stmt_bind_param($stmt, "sss", $abo_id,$date, $id_user);
        mysqli_stmt_execute($stmt);
    endif;
} else if (isset($_POST['PopupEditor'])){
    $questionid=$_POST['PopupEditor'];
    $query = "SELECT question,optionnel,choix FROM question where id=?";
    if ($stmt = mysqli_prepare($link, $query)):

        mysqli_stmt_bind_param($stmt, "s", $questionid);
        if (mysqli_stmt_execute($stmt)):
            mysqli_stmt_bind_result($stmt, $champs,$optio,$choix);
            mysqli_stmt_fetch($stmt);
        endif;
    endif;
    echo"<span onclick=\"closeModal()\" class=\"btnClose\">&times;</span>";
    echo"<form id='myForm' style='padding-bottom:1.5em;display: block;width: 20%;height:auto;background-color: #F3F3F3;margin-left: 40%;border-radius: 10px;' action='' method=\"post\" onsubmit='return false;'>";

    echo"<input type=\"text\" style='width:70%;text-align:center;border-radius:4px;border-color: #00A9E9; font-size1.1em;position:relative;display:block;margin-left: auto;margin-right: auto;top: 30px;''id=\"champs\" name=\"champs\" value=\"$champs\" required>";
    echo'<br><p style="margin-top: 1em;text-align: center;font-size: 1.1em;color: #00A9E9;">Optionnelle ?</p>';
    if($optio==0){//Pas optionnel
        echo'
<div>
<div style="display: inline-flex;font-size: 1.1em;position: relative;top: -15px;align-content: center;width: 100%;height: 2%">
<br><p style="color: #00A9E9;margin-left:42%;">Oui:</p>
<input type="radio" style="margin-left:4%;margin-top: 7px;" class="optio" name="optionnel" value=1>
</div>
';
        echo'
<div style="display: inline-flex;font-size: 1.1em;position: relative;top: -10px;align-content: center;width: 100%;height: 2%">
<br><p style="color: #00A9E9;margin-left:42%;">Non:</p>
<input type="radio" style="margin-left:3%;margin-top: 7px;" class="optio" name="optionnel" value=0 checked>
</div>
';
    }else{
        echo'
<div>
<div style="display: inline-flex;font-size: 1.1em;position: relative;top: -15px;align-content: center;width: 100%;height: 2%">
<br><p style="color: #00A9E9;margin-left:42%;">Oui:</p>
<input type="radio" style="margin-left:4%;margin-top: 7px;" class="optio" name="optionnel" value=1 checked>
</div>
';
        echo'
<div style="display: inline-flex;font-size: 1.1em;position: relative;top: -10px;align-content: center;width: 100%;height: 2%">
<br><p style="color: #00A9E9;margin-left:42%;">Non:</p>
<input type="radio" style="margin-left:3%;margin-top: 7px;" class="optio" name="optionnel" value=0 >
</div>
';
    }
    echo'<br><p style="margin-top: 0.5em;text-align: center;font-size: 1.1em;color: #00A9E9;">Choix ?</p>';
    if($choix==1){//Choix multiple
        echo'
<div style="display: inline-flex;font-size: 1.1em;position: relative;top: -15px;align-content: center;width: 100%;height: 2%">
<br><p style="color: #00A9E9;margin-left:42%;">Multiple:</p>
<input type="radio" style="margin-left:1.8%;margin-top: 7px;"  class="choix" name="choix" value=0>
</div>
';
        echo'
<div style="display: inline-flex;font-size: 1.1em;position: relative;top: -10px;align-content: center;width: 100%;height: 2%">
<br><p style="color: #00A9E9;margin-left:42%;">Unique:</p>
<input type="radio" style="margin-left:3%;margin-top: 7px;" class="choix" name="choix" value=1 checked>
</div>
';
    }else{
        echo'
<div style="display: inline-flex;font-size: 1.1em;position: relative;top: -15px;align-content: center;width: 100%;height: 2%">
<br><p style="color: #00A9E9;margin-left:42%;">Multiple:</p>
<input type="radio" style="margin-left:1.8%;margin-top: 7px;"  class="choix" name="choix" value=0 checked>
</div>
';
        echo'
<div style="display: inline-flex;font-size: 1.1em;position: relative;top: -10px;align-content: center;width: 100%;height: 2%">
<br><p style="color: #00A9E9;margin-left:42%;">Unique:</p>
<input type="radio" style="margin-left:3%;margin-top: 7px;" class="choix" name="choix" value=1 >
</div>
';
    }
    echo"<br><input style='font-size:1.1em;margin-left:40%;margin-top:10px; background-color: #00A9E9;color:#FFFFFF;border-radius: 4px;border: none;' onclick=\"sendForm($questionid)\" type=\"submit\" class=\"submit\" value=\"Modifier\" />";
    echo"</form>";
} else if (isset($_POST['PopupCreator'])){
    $surveyid=$_POST['PopupCreator'];
    echo"<span onclick=\"closeModal()\" class=\"btnClose\">&times;</span>";
    echo"<form id='myForm' style='padding-bottom:1.5em;display: block;width: 20%;height:auto;background-color: #F3F3F3;margin-left: 40%;border-radius: 10px;' action='' method=\"post\" onsubmit='return false;'>";
    echo"<input type=\"text\" id=\"champs\" name=\"champs\"  style='width:70%;text-align:center;border-radius:4px;border-color: #00A9E9; font-size1.1em;position:relative;display:block;margin-left: auto;margin-right: auto;top: 30px;' placeholder='Question' required>";
    echo'<br><p style="margin-top: 1em;text-align: center;font-size: 1.1em;color:#00A9E9;">Optionnelle ?</p>';
    echo'
<div>
<div style="display: inline-flex;font-size: 1.1em;position: relative;top: -15px;align-content: center;width: 100%;height: 2%">
<br><p style="color:#00A9E9;margin-left:42%;">Oui:</p>
<input type="radio" style="margin-left:4%;margin-top: 7px;" class="optio" name="optionnel" value=1>
</div>
';
    echo'
<div style="display: inline-flex;font-size: 1.1em;position: relative;top: -10px;align-content: center;width: 100%;height: 2%">
<br><p style="color:#00A9E9;margin-left:42%;">Non:</p>
<input type="radio" style="margin-left:3%;margin-top: 7px;" class="optio" name="optionnel" value=0 checked>
</div>
';
    echo'<br><p style="margin-top: 0.5em;text-align: center;font-size: 1.1em;color: #00A9E9;">Choix ?</p>';
    echo'
<div style="display: inline-flex;font-size: 1.1em;position: relative;top: -15px;align-content: center;width: 100%;height: 2%">
<br><p style="color: #00A9E9;margin-left:42%;">Multiple:</p>
<input type="radio" style="margin-left:1.8%;margin-top: 7px;"  class="choix" name="choix" value=0>
</div>
';
    echo'
<div style="display: inline-flex;font-size: 1.1em;position: relative;top: -10px;align-content: center;width: 100%;height: 2%">
<br><p style="color: #00A9E9;margin-left:42%;">Unique:</p>
<input type="radio" style="margin-left:3%;margin-top: 7px;" class="choix" name="choix" value=1 checked>
</div>
';
    echo"<br><input style='font-size:1.1em;margin-left:40%;margin-top:10px; background-color: #00A9E9;color:#FFFFFF;border-radius: 4px;border: none;' onclick=\"sendFormCrea($surveyid)\" type=\"submit\" class=\"submit\" value=\"Modifier\" />";
    echo"</form>";
}
?>