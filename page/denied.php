<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Accès refusé");
?>

<link rel="stylesheet" href="../public/css/error.css">

<div class="errormain">
	<div class="errorcontent">
		<a class="errortitle">403</a>
		<br>
		<a class="errorsubtitle">Accès refusé.</a>
		<br>
		<a href="/">
			<button class="button">Retourner à l'accueil</button>
		</a>
	</div>
</div>
