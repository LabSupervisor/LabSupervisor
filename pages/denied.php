<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Accès refusé");
?>

<h1>Access denied.</h1>

<a href="<?="http://" . $_SERVER["SERVER_NAME"]?>">
	<button>Retourner à l'accueil</button>
</a>
