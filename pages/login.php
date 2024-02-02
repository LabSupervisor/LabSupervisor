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

<h2>User Login</h2>
<form action="login.php" method="post">
	Username: <input type="text" name="username"><br>
	Password: <input type="password" name="password"><br>
	<input type="submit" value="Login">
</form>

<a href="<?="https://" . $_SERVER["SERVER_NAME"] . "/register.php"?>">
	<button>Pas encore de compte ?</button>
</a>
