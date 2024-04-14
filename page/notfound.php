<?php

	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang;

	// Import header
	mainHeader(lang("ERROR_NOTFOUND"));

	http_response_code(404);
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

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
