<?php
require_once "config.php";

if (isset($_GET['id'])){
    $id_surv=$_GET['id'];
    $pass=True;
    // On recupére toutes les questions du survey
    $qList=array();
    $query = "SELECT id,choix,optionnel FROM question where id_survey=?";
    if ($stmt = mysqli_prepare($link, $query)):
        mysqli_stmt_bind_param($stmt, "s", $id_surv);
        if (mysqli_stmt_execute($stmt)):
            mysqli_stmt_bind_result($stmt, $id_question,$type,$optio);
            while (mysqli_stmt_fetch($stmt)) :
                array_push($qList,array("id"=>$id_question,"choix"=>$type,"optio"=>$optio));
            endwhile;
        endif;
    endif;
    // On recupére toutes les reponses des questions du survey
    $rList=array();
    $query = "SELECT id FROM champs where id_question=?";
    foreach($qList as $q){
        if ($stmt = mysqli_prepare($link, $query)):
            mysqli_stmt_bind_param($stmt, "s", $q["id"]);
            if (mysqli_stmt_execute($stmt)):
                mysqli_stmt_bind_result($stmt, $id_rep);
                while (mysqli_stmt_fetch($stmt)) :
                    array_push($rList,array("id"=>$id_rep,"id_q"=>$q["id"]));
                endwhile;
            endif;
        endif;
    }
    // On recupere les id des questions qui ont au moins un réponse et les ids des reponses
    $rListOn=array();
    $qrlist=array();
    foreach($rList as $r){
        if(isset($_POST[$r["id"]]) and $_POST[$r["id"]]=="on"){
            if(!in_array($r['id_q'],$qrlist)){
                array_push($qrlist,$r['id_q']);
            }
            if(!in_array($r["id"],$rListOn)){
                array_push($rListOn,$r["id"]);
            }
        }
    }
    // On verifie que les questions obligatoires sont bien repondus
    foreach($qList as $q){
        if($q['optio']=="0" and !in_array($q['id'],$qrlist)){
            header("location:../../viewer.php/?id=".$id_surv."&error=".$q['id']);
            $pass=false;
        }
    }
    if($pass){
        // Maintenant que les questions sont valides on inscrit les resultats
        foreach($rListOn as $r){
            $query = "UPDATE champs SET amount_answer=amount_answer+1 WHERE id=?";
            if ($stmt = mysqli_prepare($link, $query)):
                mysqli_stmt_bind_param($stmt, "s",$r);
                mysqli_stmt_execute($stmt);
            endif;
        }
        // Et on inscrit le fait qu'il est repondu aux questions
        foreach($qrlist as $qr){
            $query = "UPDATE question SET total_r=total_r+1 WHERE id=?";
            if ($stmt = mysqli_prepare($link, $query)):
                mysqli_stmt_bind_param($stmt, "s",$qr);
                mysqli_stmt_execute($stmt);
            endif;
        }
        if($pass){
            header("location:../../thanks.php");
        }
    }
}else{
    header("location:../../home.php");
}
