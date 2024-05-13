<?php

	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\permissionChecker,
		LabSupervisor\functions\lang;

	// Import header
	mainHeader("", true);
?>

<link rel="stylesheet" href="/public/css/index.css">

<?php
	$roleList = permissionChecker(true, "");
	if (in_array(ADMIN, $roleList)) {
		// HTML content specific to admin role
?>
		<div class="boxGroup">
			<div class="mainbox">
				<h2><?= lang("NAVBAR_SESSION") ?></h2>
				<a><?= lang("INDEX_ADMIN_SESSION") ?></a>
				<a class="button" href="/sessions"><i class="ri-slideshow-3-line"></i> <?= lang("NAVBAR_SESSION") ?></a>
			</div>

			<div class="mainbox">
				<h2><?= lang("NAVBAR_USER") ?></h2>
				<a><?= lang("INDEX_ADMIN_USER") ?></a>
				<a class="button" href="/utilisateurs"><i class="ri-folder-line"></i> <?= lang("NAVBAR_USER") ?></a>
			</div>

			<div class="mainbox">
				<h2><?= lang("NAVBAR_LOG") ?></h2>
				<a><?= lang("INDEX_ADMIN_LOG") ?></a>
				<a class="button" href="/logs?trace"><i class="ri-computer-line"></i> <?= lang("NAVBAR_LOG") ?></a>
			</div>

			<div class="mainbox">
				<h2><?= lang("NAVBAR_PROFIL_ACCOUNT") ?></h2>
				<a><?= lang("INDEX_ACCOUNT") ?></a>
				<a class="button" href="/compte"><i class="ri-account-circle-line"></i> <?= lang("NAVBAR_PROFIL_ACCOUNT") ?></a>
			</div>
		</div>
<?php
	} elseif (in_array(STUDENT, $roleList)) {
		// HTML content specific to student role
?>
		<div class="boxGroup">
			<div class="mainbox">
				<h2><?= lang("NAVBAR_SESSION") ?></h2>
				<a><?= lang("INDEX_STUDENT_SESSION") ?></a>
				<a class="button" href="/sessions"><i class="ri-slideshow-3-line"></i> <?= lang("NAVBAR_SESSION") ?></a>
			</div>
			<div class="mainbox">
				<h2><?= lang("NAVBAR_PROFIL_ACCOUNT") ?></h2>
				<a><?= lang("INDEX_ACCOUNT") ?></a>
				<a class="button" href="/compte"><i class="ri-folder-line"></i> <?= lang("NAVBAR_PROFIL_ACCOUNT") ?></a>
			</div>
		</div>
<?php
	} elseif (in_array(TEACHER, $roleList)) {
		// HTML content specific to teacher role
?>
		<div class="boxGroup">
			<div class="mainbox">
				<h2><?= lang("NAVBAR_CLASS") ?></h2>
				<a><?= lang("INDEX_TEACHER_CLASSROOM") ?></a>
				<a class="button" href="/classes"><i class="ri-folder-line"></i> <?= lang("NAVBAR_CLASS") ?></a>
			</div>
			<div class="mainbox">
				<h2><?= lang("NAVBAR_CREATE_SESSION") ?></h2>
				<a><?= lang("INDEX_TEACHER_CREATE_SESSION") ?></a>
				<a class="button" href="/sessioncreation"><i class="ri-computer-line"></i> <?= lang("NAVBAR_CREATE_SESSION") ?></a>
			</div>
			<div class="mainbox">
				<h2><?= lang("NAVBAR_SESSION") ?></h2>
				<a><?= lang("INDEX_TEACHER_SESSION") ?></a>
				<a class="button" href="/sessions"><i class="ri-slideshow-3-line"></i> <?= lang("NAVBAR_SESSION") ?></a>
			</div><div class="mainbox">
				<h2><?= lang("NAVBAR_PROFIL_ACCOUNT") ?></h2>
				<a><?= lang("INDEX_ACCOUNT") ?></a>
				<a class="button" href="/compte"><i class="ri-folder-line"></i> <?= lang("NAVBAR_PROFIL_ACCOUNT") ?></a>
			</div>
		</div>
	</div>
<?php
	}

	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
