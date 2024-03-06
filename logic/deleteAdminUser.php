<?php
if (isset($_POST['send'])) {
    $userIdToDelete = $_POST['userId'];
	$emailToDelete =  UserRepository::getEmail($userIdToDelete) ;
    // echo "ID de l'utilisateur à supprimer : " . $userIdToDelete;
	// echo " test récupération email : " . $emailToDelete . "<br />";
	UserRepository::delete($emailToDelete) ;
	header("Refresh:0");
}
?>
