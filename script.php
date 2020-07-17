<?php
include "php/config.php";
#include "/var/www/html/php/config.php";
$query = "SELECT id,username,mail,abonnement_date FROM users where abonnement_date=?";

$dateSub27=date_create();
date_sub($dateSub27,date_interval_create_from_date_string("1 month - 3 day"));
$dateSub27=date_format($dateSub27,"Y-m-d");

$dateSub1m=date_create();
date_sub($dateSub1m,date_interval_create_from_date_string("1 month"));
$dateSub1m=date_format($dateSub1m,"Y-m-d");

$dateSub364=date_create();
date_sub($dateSub364,date_interval_create_from_date_string("1 year - 3 day"));
$dateSub364=date_format($dateSub364,"Y-m-d");

$dateList=array($dateSub27,$dateSub1m,$dateSub364);
$userList=array(array(),array(),array());
$i=0;
foreach ($dateList as $dateS){
    if ($stmt = mysqli_prepare($link, $query)):
        mysqli_stmt_bind_param($stmt, "s", $dateS);
        if (mysqli_stmt_execute($stmt)):
            mysqli_stmt_bind_result($stmt, $id, $username, $mail,$date);
            while (mysqli_stmt_fetch($stmt)) :
                array_push($userList[$i],array("id"=>$id,"username"=>$username,"mail"=>$mail,"date"=>$date));
            endwhile;
        endif;
    endif;
    $i++;
}
var_dump($dateList);
var_dump($userList);
#Envoyer un mail "Attention il ne vous reste plus que 3 jours d'abonnement!"
$entete  = 'MIME-Version: 1.0' . "\r\n";
$entete .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$entete .= "From: survey-online.com \r\n";
foreach ($userList[0] as $user){
    $message = "<h1>Message envoyé pour vous avertir</h1><br><h2>Informations</h2></br>
    <p>Votre compte n'aura plus d'abonnement d'ici 3 jours,veuillez cliquer sur <a href='https://www.danganronpa-online.games/donnemoitonargent.php'>ce lien</a></p>";

    $retour = mail($user['mail'], 'Avertissement abonnement de Survey-Online.com', $message, $entete);

}
#Envoyer un mail "Attention, vous n'avez plus d'abonnement"
foreach ($userList[1] as $user){
    $message = "<h1>Message envoyé pour vous avertir</h1><br><h2>Informations</h2></br>
    <p>Votre compte n'aura plus d'abonnement,veuillez cliquer sur <a href='https://www.danganronpa-online.games/donnemoitonargent.php'>ce lien</a></p>";

    $retour = mail($user['mail'], 'Avertissement abonnement de Survey-Online.com', $message, $entete);
    $query="UPDATE users SET abonnement=0 where id=?"
    if ($stmt = mysqli_prepare($link, $query)):
        mysqli_stmt_bind_param($stmt, "s", $user['id']);
        mysqli_stmt_execute($stmt);
    endif;
}
/*#Envoyer un mail "Attention, tous vos surveys vont être supprimer"
foreach ($userList[2] as $user){
    $message = "<h1>Message envoyé pour vous avertir</h1><br><h2>Informations</h2></br>
    <p>Votre compte n'a plus d'abonnement depuis 1 an,vous allez perdre tous vos surveys,veuillez cliquer sur <a href='https://www.danganronpa-online.games/donnemoitonargent.php'>ce lien</a></p>";

    $retour = mail($mail, 'Avertissement database de Survey-Online.com', $message, $entete);
}
$dateSub1y=date_create();
date_sub($dateSub1y,date_interval_create_from_date_string("1 year"));
$dateSub1y=date_format($dateSub364,"Y-m-d");

$query = "SELECT survey.id FROM survey INNER JOIN users ON users.id = survey.id_owner where users.abonnement_date=?";
$surveyList=array();
if ($stmt = mysqli_prepare($link, $query)):
    mysqli_stmt_bind_param($stmt, "s", $dateSub1y);
    if (mysqli_stmt_execute($stmt)):
        mysqli_stmt_bind_result($stmt, $id);
        while (mysqli_stmt_fetch($stmt)) :
            array_push($surveyList,$id);
        endwhile;
    endif;
endif;
$querys=array("DELETE FROM `champs` WHERE `id_survey`=?","DELETE FROM question WHERE `id_survey`=?","DELETE FROM survey WHERE id=?");
foreach ($querys as $query){
    foreach ($surveyList as $id){
        if ($stmt = mysqli_prepare($link, $query)):
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
        endif;
    }
}*/