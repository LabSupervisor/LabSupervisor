<link rel="stylesheet" href="../public/css/login.css">
<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Connexion");
?>

<?php
	if (isset($_SESSION["login"]))
		header("Location: /");
?>

<?php
	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/login.php');
?>

<div class="LoginDiv">
    <form action="login.php" method="post">
        <h2>Enregistrement</h2>    
        <input type="text" id="username" name="username" class="Username" placeholder="Adresse email"><br>
        <input type="password" id="password" name="password" class="Password" placeholder="Mot de passe"><br>
        <div class="LoginDivButons">
            <input type="submit" value="Se connecter" class="login-button">
            <a href="http://labsupervisor.fr/pages/register.php" class="register-link">
                Pas encore de compte ?
            </a>
        </div>
    </form>
</div>
