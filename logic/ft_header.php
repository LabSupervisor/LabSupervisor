<?php
	function mainHeader($title) {
		echo <<<EOT
			<html lang="fr">
			<head>
				<meta charset="UTF-8">
				<title>$title</title>
				<link rel="stylesheet" href="../public/css/main.css">
				<link rel="stylesheet" href="../public/css/navbar.css">
				<link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
				<link rel="icon" href="../public/img/logo.ico" />
			</head>
		EOT;
		require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_navbar.php");
	}
?>
