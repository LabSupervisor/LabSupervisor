<?php

	use LabSupervisor\app\repository\ClassroomRepository,
		LabSupervisor\app\repository\SessionRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang,
		LabSupervisor\functions\permissionChecker;

	// Import header
	mainHeader(lang("NAVBAR_CREATE_SESSION"), true);

	// Ask for permissions
	permissionChecker(true, array(TEACHER));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/createSession.php');

	$idProv = 1;
?>

<link rel="stylesheet" href="/public/css/form.css">

<form id="formSession" class="mainbox mainform" method="post">
	<!-- Main informations -->
	<div>
		<h2><i class="ri-information-line"></i> <?= lang("SESSION_CREATE_TITLE_INFORMATION") ?></h2>
	</div>
	<div>
		<input type="text" placeholder="<?= lang("SESSION_CREATE_INFORMATION_TITLE") ?>" id="titleSession" name="titleSession" value="<?= isset($sessionData) ? $sessionData['title'] : "" ?>" required>
	</div>
	<div>
		<textarea placeholder="<?= lang("SESSION_CREATE_INFORMATION_DESCRIPTION") ?>" id="descriptionSession" name="descriptionSession"><?= isset($sessionData) ? $sessionData['description'] : "" ?></textarea>
	</div>

	<!-- Participants -->
	<div>
		<h2><i class="ri-group-line"></i> <?= lang("SESSION_CREATE_TITLE_PARTICIPANT") ?></h2>
	</div>
	<div>
		<select name="classes">
		<?php
			$classrooms = ClassroomRepository::getClassrooms();
			foreach ($classrooms as $value) {
				if ($value["active"] == 1) {
					echo "<option value=" . $value["id"] . ">" . $value["name"] . "</option>";
				}
			}
		?>
		</select>
	</div>

	<!-- Chapters -->
	<div>
		<h2><i class="ri-bookmark-line"></i> <?= lang("SESSION_CREATE_TITLE_CHAPTER") ?></h2>
	</div>

	<?php
	$nbChapter = 1 ;

	// Check session exist
	if (isset($_POST['sessionId'])) {
		$tabChapter = SessionRepository::getActiveChapter($_POST['sessionId']);

		// Print field exist chapter
		foreach ($tabChapter as $i => $chapter) {
	?>

	<div class="subform" id="<?= $chapter["id"] ?>">
		<!-- id chapter -->
		<input type="hidden" class="chapterId" id="idChapter<?= $chapter["id"] ?>" value="<?= $chapter["id"] ?>"/>

		<input placeholder="<?= lang("SESSION_CREATE_CHAPTER_TITLE") ?>" type="text" id="titleChapter<?= $chapter["id"] ?>" value="<?= $chapter["title"] ?>" onchange="updateChapter(this.parentNode.id)" required>

		<textarea placeholder="<?= lang("SESSION_CREATE_CHAPTER_DESCRIPTION") ?>"id="chapterDescription<?= $chapter["id"] ?>" onchange="updateChapter(this.parentNode.id)" ><?= $chapter["description"] ?></textarea>

		<!-- Delete chapter button -->
		<button type="button" class="button chapterButton" onclick="deleteChapter(this)">- Chapitre</button>
	</div>

	<?php
		}
	//create session
	} else {
	?>

	<div class="subform">
	</div>

	<?php } ?>

	<!-- Field allowing you to keep the number of chapters, updated by the js, sent to the form for chapter management -->
	<div>
		<input type="hidden" value="<?= $nbChapter ?>" name="nbChapter" id="nbChapter">
	</div>

	<!-- Add chapter button -->
	<div>
		<button class="button" type="button" id="btn-chapter" dataid="1" onclick="addHTMLChapter('<?= lang("SESSION_CREATE_CHAPTER_TITLE") ?>', '<?= lang("SESSION_CREATE_CHAPTER_DESCRIPTION") ?>', this)"><?= lang("SESSION_CREATE_CHAPTER_ADD") ?></button>
	</div>

	<!-- Date -->
	<div>
		<h2><i class="ri-calendar-2-line"></i> <?= lang("SESSION_CREATE_TITLE_DATE") ?></h2>
	</div>
	<div>
		<input type="datetime-local" id="date" name="date" value="<?= isset($sessionData) ? $sessionData['date'] : "" ?>" required>
	</div>

	<!-- Send -->
	<?php
		if (isset($_POST['sessionId'])) {
	?>

	<div>
		<input type="hidden" name="idSession" value="<?= $_POST['sessionId'] ?>" />
		<button type="submit" name="updateSession" class="button save"><i class="ri-loop-left-line"></i> <?= lang("SESSION_CREATE_UPDATE") ?></button>
	</div>

	<?php
		} else {
	?>

	<div>
		<button class="button" type="submit" name="saveSession"><?= lang("SESSION_CREATE_SUBMIT") ?></button>
	</div>

	<?php
		}
	?>
</form>

<script>
	var nbChapter = 1;
</script>

<script src="/public/js/ft_lang.js"></script>
<script src="/public/js/ft_addChapter.js"></script>
<script src="/public/js/ft_updateChapter.js"></script>
<script src="/public/js/ft_deleteChapter.js"></script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
