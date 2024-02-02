<link rel="stylesheet" href="../public/css/register.css">
<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Création de compte");
?>

<?php
	if (isset($_SESSION["login"]))
		header("Location: /");
?>

<?php
	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/register.php');
?>

<div class="RegisterDiv"	
	<form action="" method="post">
	<h2>User Registration</h2>
	<label for="email">Email:</label>
		<input type="email" name="email" placeholder="Email" required><br>
	<label for="password">Password:</label>
		<input type="password" name="password" placeholder="Password" required><br>
	<label for="text">Name:</label>
		<input type="text" name="name" placeholder="Name" required><br>
	<label for="email">Surname:</label>
		<input type="text" name="surname" placeholder="Surname" required><br>
	<label for="email">Birthdate:</label>
		<input type="date" name="birthdate" placeholder="Birthdate" required><br>
		<input type="submit" name="register" value="Register">
	</form>

	<a href="<?="http://" . $_SERVER["SERVER_NAME"] . "/pages/login.php"?>">
		<button>Déjà un compte ?</button>
	</a>
</div>
