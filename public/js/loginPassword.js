// Password Hide/Show script
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
