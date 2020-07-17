<?php
require_once "../php/config.php";
if($_POST['type']=="Edit"){
    $champs=$_POST['champs'];
    $choix=$_POST['choix'];
    $optio=$_POST['optionnel'];
    if($champs!="" and $champs!=null){
        //Modification d'une question
        $query = "UPDATE question SET question=?,optionnel=?,choix=? WHERE id=?";
        if ($stmt = mysqli_prepare($link, $query)):
            mysqli_stmt_bind_param($stmt, "ssss", $champs, $optio, $choix, $_POST['id']);
            mysqli_stmt_execute($stmt);
        endif;
    }else{
        echo"error";
    }
}else{
    $champs=$_POST['champs'];
    $choix=$_POST['choix'];
    $optio=$_POST['optionnel'];
    $id_survey=$_POST['id'];
    session_start();
    $id_user = $_SESSION["id"];
    if($champs!="" and $champs!=null){
        //Récupère le type d'abonnement
        $query="SELECT abonnement from users where id=".$id_user;
        if ($result = mysqli_query($link, $query)) {

            $abonnement=mysqli_fetch_row($result)[0];

            /* Libération du jeu de résultats */
            mysqli_free_result($result);
        }
        //On verifie le nombre de question
        $questionb=0;
        $query="SELECT id from question where id_survey=".$id_survey;
        if ($result = mysqli_query($link, $query)) {
            $questionnb=mysqli_num_rows($result);
        }
        if($abonnement==0 and $questionnb>=20){
            //AlertBox PAYE
            echo"PAYE";
        }else {
            //Creation d'une question
            $query = "INSERT INTO question (id,question,id_survey,optionnel,choix) VALUES (NULL,?,?,?,?)";
            if ($stmt = mysqli_prepare($link, $query)):
                mysqli_stmt_bind_param($stmt, "ssss", $champs, $id_survey,$optio, $choix);
                mysqli_stmt_execute($stmt);
            endif;
        }
    }else{
    echo"error";
    }
}
