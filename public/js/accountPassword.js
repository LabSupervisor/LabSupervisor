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

// Change div display
document.getElementById('showDeleteForm').addEventListener('click', function() {
	document.getElementById('confirmationForm').style.display = 'flex';
	document.getElementById('updateCase').style.display = 'none';
});

document.getElementById('cancel').addEventListener('click', function() {
	document.getElementById('confirmationForm').style.display = 'none';
	document.getElementById('updateCase').style.display = 'block';
});
