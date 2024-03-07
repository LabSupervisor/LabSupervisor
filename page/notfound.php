<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Page non trouvé");
?>

<link rel="stylesheet" href="../public/css/error.css">

<div class="errormain">
	<div class="errorcontent">
		<a class="errortitle">404</a>
		<br>
		<a class="errorsubtitle">La page demandée n'existe pas.</a>
		<br>
		<a href="/">
			<button class="button">Retourner à l'accueil</button>
		</a>
	</div>
</div>
