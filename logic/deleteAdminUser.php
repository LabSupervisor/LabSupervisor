<?php
if (isset($_POST['send'])) {
	// Delete user
	UserRepository::delete(UserRepository::getEmail($_POST['userId']));
	header("Refresh:0");
}
