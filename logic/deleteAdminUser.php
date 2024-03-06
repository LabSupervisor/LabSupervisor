<?php
if (isset($_POST['send'])) {
	UserRepository::delete(UserRepository::getEmail($_POST['userId'])) ;
	header("Refresh:0");
}
