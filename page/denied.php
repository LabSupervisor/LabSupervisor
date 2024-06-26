<?php

	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang;

	// Import header
	mainHeader(lang("ERROR_DENIED"), true);

	http_response_code(403);
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

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
