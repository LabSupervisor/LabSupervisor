// Password Hide/Show script
function togglePasswordVisibility(inputId, eyeIconId) {
	var passwordInput = document.getElementById(inputId);
	var eyeIcon = document.getElementById(eyeIconId);

	if (passwordInput.type === 'password') {
		passwordInput.type = 'text';
		eyeIcon.className = 'ri-eye-line';
	} else {
		passwordInput.type = 'password';
		eyeIcon.className = 'ri-eye-off-line';
	}
}
