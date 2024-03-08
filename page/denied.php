<?php
	// Import header
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Accès refusé");
?>

<link rel="stylesheet" href="/public/css/error.css">

<div class="errormain">
	<div class="errorcontent">
		<a class="errortitle">403</a>
		<br>
		<a class="errorsubtitle"><?= lang("ERROR_DENIED") ?></a>
		<br>
		<a href="/">
			<button class="button"><?= lang("ERROR_DENIED_BACK") ?></button>
		</a>
	</div>
</div>
