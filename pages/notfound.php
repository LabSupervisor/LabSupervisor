<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Page non trouvé");
?>

<h1>404 not found</h1>

<a href="<?="http://" . $_SERVER["SERVER_NAME"]?>">
	<button>Retourner à l'accueil</button>
</a>
