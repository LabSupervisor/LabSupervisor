<?php

	use
		LabSupervisor\app\repository\ClassroomRepository,
		LabSupervisor\app\repository\SessionRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang;

	// Import header
	mainHeader(lang("NAVBAR_CREATE_SESSION"), true);

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/createSession.php');

	$idProv = 1;
?>

<link rel="stylesheet" href="/public/css/form.css">

<div class="mainbox mainform">
	<a class="back" href="/sessions"><i class="ri-arrow-left-line"></i> <?= lang("MAIN_BUTTON_BACK") ?></a>
	<form id="formSession" method="post" onsubmit="loading()">
		<div class="row">
			<div class="column">
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
					<select id="classroomSelect" name="classes" onchange="updateClassroom(this.value)">
					<?php
						$classrooms = ClassroomRepository::getClassrooms();
						foreach ($classrooms as $value) {
							if ($value["active"] == 1) {
								if (isset($_POST['sessionId'])) {
									if ($value["id"] == SessionRepository::getClassroom($_POST['sessionId'])) {
										echo "<option selected='selected' value=" . $value["id"] . ">" . htmlspecialchars($value["name"]) . "</option>";
									} else {
										echo "<option value=" . $value["id"] . ">" . htmlspecialchars($value["name"]) . "</option>";
									}
								} else {
									echo "<option value=" . $value["id"] . ">" . htmlspecialchars($value["name"]) . "</option>";
								}
							}
						}
					?>
					</select>
				</div>
			</div>

			<!-- Chapters -->
			<div class="column">
				<div>
					<h2><i class="ri-bookmark-line"></i> <?= lang("SESSION_CREATE_TITLE_CHAPTER") ?></h2>
				</div>

				<div id="fieldsContainer">
					<?php
					$nbChapter = 1;

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
						<button type="button" class="button chapterButton" onclick="deleteChapter(this)"><?= lang("SESSION_CREATE_CHAPTER_REMOVE") ?></button>
					</div>
					<?php
						}
						//create session
					} else {

					?>
					<!-- <div id="fieldsContainer"> -->
					<div class="subform">
						<input type="text" placeholder="<?= lang("SESSION_CREATE_CHAPTER_TITLE") ?>" name="addChapters[0][title]" class="field">
						<textarea name="addChapters[0][desc]" placeholder="<?= lang("SESSION_CREATE_CHAPTER_DESCRIPTION") ?>" class="field"></textarea>

						<!-- Delete chapter button -->
						<button type="button" class="button chapterButton" onclick="deleteChapter(this)"><?= lang("SESSION_CREATE_CHAPTER_REMOVE") ?></button>
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

				</div>
			</div>

			<div class="column">
				<!-- Date -->
				<div>
					<h2><i class="ri-calendar-2-line"></i> <?= lang("SESSION_CREATE_TITLE_DATE") ?></h2>
				</div>
				<div>
					<input type="datetime-local" id="date" name="date" value="<?= isset($sessionData) ? $sessionData['date'] : "" ?>" required>
				</div>

				<!-- State -->
			<?php
				if (!isset($_POST['sessionId'])) {
			?>
				<div>
					<h2><i class="ri-door-open-line"></i> <?= lang("SESSION_CREATE_STATE") ?></h2>
				</div>
				<div>
					<label class="checkboxContainer"><?= lang("SESSION_CREATE_STATE_OPEN") ?>
						<input class="checkbox" type="checkbox" name="state">
						<span class="checkmark"></span>
					</label>
				</div>
			<?php
				}
			?>
			</div>
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
			<button class="button" type="submit" name="saveSession"><i class="ri-save-2-line"></i> <?= lang("SESSION_CREATE_SUBMIT") ?></button>
		</div>

		<?php
			}
		?>
	</form>

	<?php
		if (isset($_POST['sessionId'])) {
	?>

	<form method="POST" onsubmit="return confirmForm('<?= lang('SESSION_CREATE_DELETE_CONFIRMATION') ?>');">
		<button class="link" type="submit" name="deleteSession" value="<?= $_POST['sessionId'] ?>"><i class="ri-delete-bin-line"></i> <?= lang("SESSION_CREATE_DELETE") ?></button>
	</form>

	<?php } ?>
</div>

<script>
	var nbChapter = 1;
</script>

<script src="/public/js/ft_popup.js"></script>
<script src="/public/js/ft_addChapter.js"></script>
<script src="/public/js/ft_updateClassroom.js"></script>
<script src="/public/js/ft_updateChapter.js"></script>
<script src="/public/js/ft_deleteChapter.js"></script>
<script src="/public/js/ft_loading.js"></script>
<script src="/public/js/ft_popupConfirm.js"></script>

<?php
	if (isset($_POST["titleSession"])) {
		echo '<script> popupDisplay("' . lang('SESSION_CREATE_UPDATE_NOTIFICATION') .'"); </script>';
	}

	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
