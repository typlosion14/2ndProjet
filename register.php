<?php
// Include config file
require_once "php/config.php";
require_once "php/register.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/myregister.css">
    <link rel="stylesheet" href="https://use.typekit.net/vvn0wga.css">
    <link rel="icon" href="../pictures/favi.ico"/>
</head>
<body>
<!--<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    function onSubmit(token) {
        document.getElementById("demo-form").submit();
    }
</script>-->
<div class="body_center">
    <div class="wrapper">
        <div class="wrapper_content">
            <h2>Inscription</h2>
            <p>S'il vous plaît, remplissez les champs pour vous enregistrez</p>
            <form id="demo-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Username</label><br>
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>Email</label><br>
                    <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Mot de passe</label><br>
                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Réentrez votre mot de passe</label><br>
                    <input type="password" name="confirm_password" class="form-control"
                           value="<?php echo $confirm_password; ?>">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group">
                	<!--
                    <input type="submit" class="btn btn-primary g-recaptcha" value="Valider" data-sitekey="6LedSqQZAAAAAKH0_Ue-g7Bf-q2fOK4OPfHqob3L" data-callback='onSubmit' data-action='submit'>-->
                    <input type="submit" class="btn btn-primary" value="Valider">
                    <input type="reset" class="btn btn-default" value="Vider">
                </div>
                <p class="bottom_fix">Vous avez déjà un compte? <a href="login.php">Connectez-vous</a>.</p>
            </form>
        </div>

    </div>
</div>
</body>
</html>
