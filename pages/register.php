<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">
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

<div class="RegisterDiv"> 
    <form action="register.php" method="post">
        <h2>Inscription</h2>
        <input type="email" name="email" placeholder="Email" class="Email" required=""><br>
        <div class="PasswordContainer">
            <input type="password" id="password" name="password" placeholder="Mot de passe" class="Password" required=""><br>
            <button type="button" id="showPasswordButton" class="ShowPasswordButton" onclick="togglePasswordVisibility()">
                <i id="eyeIcon" class="ri-eye-off-line"></i>
            </button>
        </div>
        <input type="text" name="name" placeholder="Prenom" class="Name" required=""><br>   
        <input type="text" name="surname" placeholder="Nom" class="Surname" required=""><br>
        <input type="date" name="birthdate" class="Birthdate" required=""><br>
        <input type="submit" name="register" value="Creer une compte" class="register-button">
        <a href="http://labsupervisor.fr/pages/login.php" class="login-link">
            Déjà un compte ?
        </a>
    </form>
</div>

<script> // Password Hide/Show script (same in login)
function togglePasswordVisibility() {
    var passwordInput = document.getElementById('password');
    var eyeIcon = document.getElementById('eyeIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.className = 'ri-eye-line';
    } else {
        passwordInput.type = 'password';
        eyeIcon.className = 'ri-eye-off-line'; 
    }
}
</script>
