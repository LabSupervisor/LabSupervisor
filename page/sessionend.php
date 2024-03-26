<?php
	// Import header
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader(lang("SESSION_END"));
?>

<link rel="stylesheet" href="/public/css/error.css">

<div class="errormain">
	<div class="errorcontent">
		<a class="errortitle"><?= lang("SESSION_END") ?></a>
		<br>
		<a class="errorsubtitle"><?= lang("SESSION_END_MESSAGE") ?></a>
		<br>
		<a href="/sessions">
			<button class="button"><?= lang("SESSION_END_BACK") ?></button>
		</a>
	</div>
</div>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/ft_footer.php');
?>