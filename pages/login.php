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
        <h2>Connexion</h2>
        <input type="text" id="username" name="username" class="Username" placeholder="Adresse email" required autofocus><br>
        <div class="PasswordContainer">
            <input type="password" id="password" name="password" placeholder="Mot de passe" class="Password" required><br>
            <button type="button" id="showPasswordButton" class="ShowPasswordButton" onclick="togglePasswordVisibility()">
                <i id="eyeIcon" class="ri-eye-off-line"></i>
            </button>
        </div>
        <div class="LoginDivButons">
            <input type="submit" value="Se connecter" class="button">
            <a href="http://labsupervisor.fr/pages/register.php" class="register-link">
                Pas encore de compte ?
            </a>
        </div>
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
