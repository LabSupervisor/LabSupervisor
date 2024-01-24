<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Création de compte");
?>

<?php
	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/register.php');
?>

<h2>User Registration</h2>
<form action="" method="post">
	Email: <input type="email" name="email" required><br>
	Password: <input type="password" name="password" required><br>
	Name: <input type="text" name="name" required><br>
	Surname: <input type="text" name="surname" required><br>
	Birthdate: <input type="date" name="birthdate" required><br>
	<input type="submit" value="Register">
</form>
