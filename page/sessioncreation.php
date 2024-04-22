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

<link rel="stylesheet" href="/public/css/sessioncreation.css">

<div class="mainbox maindiv">
	<form id="formSession" class="sessions" method="post">
		<!-- Main informations -->
		<h2><?= lang("SESSION_CREATE_TITLE_INFORMATION") ?></h2>
		<input type="text" placeholder="<?= lang("SESSION_CREATE_INFORMATION_TITLE") ?>" id="titleSession" class="field" name="titleSession" value="<?= isset($sessionData) ? $sessionData[0]['title'] : "" ?>" required>

		<textarea placeholder="<?= lang("SESSION_CREATE_INFORMATION_DESCRIPTION") ?>" id="descriptionSession" class="field" name="descriptionSession" required><?= isset($sessionData) ? $sessionData[0]['description'] : "" ?></textarea>

		<!-- Participants -->

		<!-- TODO : update session user (classe/users?) -->
		<h2><?= lang("SESSION_CREATE_TITLE_PARTICIPANT") ?></h2>
		<div class="custom-select">
			<select name="classes" id="classes" class="field">
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
		<h2><?= lang("SESSION_CREATE_TITLE_CHAPTER") ?></h2>

		<?php
		$nbChapter = 1 ;

		// Check session exist (BD)
		if (isset($_POST['sessionId'])) {
			$tabChapter = SessionRepository::getActiveChapter($_POST['sessionId']);
			$nbChapter = count($tabChapter);

			// Print field exist chapter (BD)
			foreach ($tabChapter as $i => $chapter) {
				?>
				<div class="chapter-container" id="<?= $chapter["id"] ?>">
					<!-- id chapter -->
					<input type="hidden" class="chapter-id" id="idChapter<?= $chapter["id"] ?>" value="<?= $chapter["id"] ?>"/>

					<input placeholder="<?= lang("SESSION_CREATE_CHAPTER_TITLE") ?>" type="text" id="titleChapter<?= $chapter["id"] ?>" class="field" value="<?= $chapter["title"] ?>" onchange="addToChapterToBeUpdatedList(this.parentNode.id)">

					<textarea placeholder="<?= lang("SESSION_CREATE_CHAPTER_DESCRIPTION") ?>"
					id="chapterDescription<?= $chapter["id"] ?>" class="field" onchange="addToChapterToBeUpdatedList(this.parentNode.id)" ><?= $chapter["description"] ?></textarea>

					<!-- Delete chapter button -->
					<button type="button" class="button chapterButton" onclick="deleteChapter(this)">- Chapitre</button>
				</div>
				<?php
			}

			// Champ caché pour stocker les chapitres supprimés //HEIN?

		}
		else  { //create session
		?>
			<div class="chapter-container">

			</div>
		<?php
		}
		?>

		<!-- Field allowing you to keep the number of chapters, updated by the js, sent to the form for chapter management -->
		<input type="hidden" value="<?= $nbChapter ?>" name="nbChapter" id="nbChapter">

		<!-- Add chapter button -->
		<button type="button" id="btn-chapter" class="button chapterButton" data-id="1" onclick="addHTMLChapter('<?= lang("SESSION_CREATE_CHAPTER_TITLE") ?>', '<?= lang("SESSION_CREATE_CHAPTER_DESCRIPTION") ?>', this)">+ Chapitre</button>

		<!-- Date -->
		<h2><?= lang("SESSION_CREATE_TITLE_DATE") ?></h2>
		<input type="datetime-local" id="date" name="date" value="<?= isset($sessionData) ? $sessionData[0]['updatedate'] : "" ?>">

		<!-- Send -->
		<?php
			if (isset($_POST['sessionId'])) {
		?>
			<input type="hidden" name="idSession" value="<?=$_POST['sessionId'] ?>" />
			<input type="submit" name="updateSession" class="button save" value="Mettre à jour">
		<?php } else {  ?>
			<input type="submit" name="saveSession" class="button save" value="<?= lang("SESSION_CREATE_SUBMIT") ?>">
		<?php } ?>
	</form>
</div>

<script>
	var nbChapter = 1;
</script>

<script src="/public/js/ft_lang.js"></script>
<script src="/public/js/ft_addChapter.js"></script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
