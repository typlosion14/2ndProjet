<?php
// Include config file
require_once "php/config.php";
require_once "php/login.php";
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/mylogin.css">
    <link rel="stylesheet" href="https://use.typekit.net/vvn0wga.css">
    <link rel="icon" href="../pictures/favi.ico"/>
</head>
<body>
<div class="wrapper">
    <div class="wrapper_content">
        <h2>Connexion</h2>
        <p>S'il vous plaît rentrez vos identifiants.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label><br>
                <input type="text" name="login" class="form-control" value="<?php echo $username; ?>" autocomplete="on">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Mot de Passe</label><br>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>

            <input type="submit" class="submit" value="Se connecter" />

            <p class="bottom_fix">Vous n'avez pas de compte? <a href="register.php">Enregistrez-vous</a>.</p>

        </form>
    </div>

</div>
</body>
</html>
