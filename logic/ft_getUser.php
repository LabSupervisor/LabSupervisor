<?php
	function getUser($email) {
		$db = dbConnect();

		// Get user ID query
		$queryUserId = "SELECT * FROM user WHERE email = :email";

		// Get user ID
		$queryPrepUserId = $db->prepare($queryUserId);
		$queryPrepUserId->bindParam(':email', $email, \PDO::PARAM_STR);
		$queryPrepUserId->execute();
		return($queryPrepUserId->fetchAll(PDO::FETCH_ASSOC));
	}
?>
