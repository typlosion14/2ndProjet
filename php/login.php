<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: home.php");
    exit;
}

require_once "config.php";

// Creation de variable pour les erreurs etc...
$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verification de l'username
    if (empty(trim($_POST["login"]))) {
        $username_err = "<br>S'il vous plaît rentrez un pseudo.";
    } else {
        $username = trim($_POST["login"]);
    }

    // Verification du pseudo
    if (empty(trim($_POST["password"]))) {
        $password_err = "<br>S'il vous plait rentrez un mot de passe.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Envoie de l'username et du password si pas d'erreur
    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password,mail FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            $param_username = $username;
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_store_result($stmt);

                // On verifie si y'a un utilisateur et si oui on verifie le mot de passe
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $mail);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Mot de passe bon on commence une session
                            session_start();

                            // Et on stocke les infos dans la session
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["mail"] = $mail;


                            header("location: home.php");
                        } else {
                            $password_err = "<br>Le mot de passe que tu as entré n'est pas correct.";
                        }
                    }
                } else {
                    $username_err = "<br>Pas de compte trouvé avec cet username.";
                }
            } else {
                echo "<br>Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>
