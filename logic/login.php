<?php
if (isset($_POST["login"])) {
	if (UserRepository::getId($_POST['email'])) {
		// Check if password correspond to database
		if (UserRepository::verifyPassword($_POST['email'], $_POST['password'])) {
			// Connect user
			$_SESSION['login'] = $_POST['email'];
			header("Location: /");
		}
	}
	// Default error
	echo '<script>
	var popup = document.createElement("div");
	popup.classList.add("custom-popup");
	popup.textContent = " ' . lang("LOGIN_ERROR_NOTFOUND") . ' ";

	var closeButton = document.createElement("button");
	closeButton.classList.add("button");
	closeButton.textContent = "OK";
	closeButton.addEventListener("click", function() {
		popup.remove();
	});

	popup.appendChild(closeButton);
	document.body.appendChild(popup);
	</script>';
}
