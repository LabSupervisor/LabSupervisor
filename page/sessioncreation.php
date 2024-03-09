<?php
	// Import header
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Création de session");

	// Ask for permissions
	permissionChecker(true, array(teacher));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/createSession.php');
?>

<link rel="stylesheet" href="/public/css/sessioncreation.css">

<script>
	// Update chapter count
	var nbChapter = 1;

	function addChapter() {
		nbChapter++;
		let div = document.createElement('div');

		let inputTitle = document.createElement('input');
		inputTitle.setAttribute("type", "text");
		inputTitle.setAttribute("placeholder", "<?= lang("SESSION_CREATE_CHAPTER_TITLE") ?>");
		inputTitle.setAttribute("name", "titleChapter" + nbChapter);
		inputTitle.classList.add('field');
		div.appendChild(inputTitle);

		let inputDescription = document.createElement('textarea');
		inputDescription.setAttribute("name", "chapterDescription" + nbChapter);
		inputDescription.setAttribute("placeholder", "<?= lang("SESSION_CREATE_CHAPTER_DESCRIPTION") ?>");
		inputDescription.classList.add('field');
		div.appendChild(inputDescription);

		let btnChapter = document.getElementById('btn-chapter');
		let parentDiv = btnChapter.parentNode;
		parentDiv.insertBefore(div, btnChapter);

		document.getElementById('nbChapter').value = nbChapter;
	}
</script>

<div class="mainbox maindiv">
	<form class="sessions" method="post">
		<input type="hidden" value="1" name="nbChapter" id="nbChapter">

		<!-- Main informations -->
		<h2><?= lang("SESSION_CREATE_TITLE_INFORMATION") ?></h2>
		<input type="text" placeholder="<?= lang("SESSION_CREATE_INFORMATION_TITLE") ?>" id="titleSession" class="field" name="titleSession" required>
		<textarea placeholder="<?= lang("SESSION_CREATE_INFORMATION_DESCRIPTION") ?>" id="descriptionSession" class="field" name="descriptionSession"></textarea>

		<!-- Participants -->
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
		<input placeholder="<?= lang("SESSION_CREATE_CHAPTER_TITLE") ?>" type="text" id="titleChapter1" class="field" name="titleChapter1" required>
		<textarea placeholder="<?= lang("SESSION_CREATE_CHAPTER_DESCRIPTION") ?>" id="chapterDescription1" class="field" name="chapterDescription1"></textarea>

		<!-- Add chapter button -->
		<button type="button" id="btn-chapter" class="button chapterButton" onclick="addChapter()">+ Chapitre</button>

		<!-- Date -->
		<h2><?= lang("SESSION_CREATE_TITLE_DATE") ?></h2>
		<input type="datetime-local" id="date" name="date" required>

		<!-- Send -->
		<input type="submit" name="saveSession" class="button save" value="<?= lang("SESSION_CREATE_SUBMIT") ?>">
	</div>
</form>
