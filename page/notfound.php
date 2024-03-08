<?php
	// Import header
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Page non trouvé");
?>

<link rel="stylesheet" href="/public/css/error.css">

<div class="errormain">
	<div class="errorcontent">
		<a class="errortitle">404</a>
		<br>
		<a class="errorsubtitle"><?= lang("ERROR_NOTFOUND") ?></a>
		<br>
		<a href="/">
			<button class="button"><?= lang("ERROR_NOTFOUND_BACK") ?></button>
		</a>
	</div>
</div>
