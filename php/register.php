<?php
require_once "config.php";

// Creation de variable pour les erreurs etc...
$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $email_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Verification du pseudo
    if (empty(trim($_POST["username"]))) {
        $username_err = "<br>S'il vous plaît rentrer un pseudo.";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = trim($_POST["username"]);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "<br>Ce nom d'utilisateur est déjà pris.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    //Verification de l'email
    if (empty(trim($_POST["email"]))) {
        $email_err = "<br>S'il vous plaît rentrer une adresse email valide.";
    } else {
        $sql = "SELECT id FROM users WHERE mail = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            $param_email = trim($_POST["email"]);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)) {
                    if (mysqli_stmt_num_rows($stmt) == 1)
                        $email_err = "<br>Cet email est déjà utilisé.";
                    else
                        $email = trim($_POST["email"]);
                } else
                    $email_err = "<br>Ceci n'est pas un email.";
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    //Verification du mot de passe
    if (empty(trim($_POST["password"]))) {
        $password_err = "<br>S'il vous plaît rentrez un mot de passe.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "<br>Le mot de passe doit contenir au moins 6 caractères.";
    } else {
        $password = trim($_POST["password"]);
    }
    //Verification captcha
    // Ma clé privée
    $secret = "6LedSqQZAAAAAAgYM4ofeNMRXjerANGqLJVaPqJO";
    // Paramètre renvoyé par le recaptcha
    $response = $_POST['g-recaptcha-response'];
    // On récupère l'IP de l'utilisateur
    $remoteip = $_SERVER['REMOTE_ADDR'];
    $api_url = "https://www.google.com/recaptcha/api/siteverify?secret="
        . $secret
        . "&response=" . $response
        . "&remoteip=" . $remoteip ;
    $decode = json_decode(file_get_contents($api_url), true);

    if ($decode['success'] == false) {
        // C'est un robot ou le code de vérification est incorrecte
        $username_err = "<br>S'il vous plaît ne soyez pas un robot.";
    }else{
        if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "<br>S'il vous plaît confirmez le mot de passe.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($password != $confirm_password)) {
                $confirm_password_err = "<br>Les mots de passe ne correspondent pas.";
            }
        }
        //Si aucune erreur alors on envoie
        if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {

            $sql = "INSERT INTO users (username,mail, password,creation_date) VALUES (?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_email, $param_password,date('Y-m-d'));

                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Mot de passe crypté

                if (mysqli_stmt_execute($stmt)) {
                    // Redirect to login page
                        header("location: login.php");
                } else {
                    echo "<br>Something went wrong. Please try again later.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
    }
    // Close connection
    mysqli_close($link);
}
?>