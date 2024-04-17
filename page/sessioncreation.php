<?php

	use LabSupervisor\app\repository\ClassroomRepository,
		LabSupervisor\app\repository\SessionRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang,
		LabSupervisor\functions\permissionChecker;

	// Import header
	mainHeader(lang("NAVBAR_CREATE_SESSION"));

	// Ask for permissions
	permissionChecker(true, array(TEACHER));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/createSession.php');
?>

<link rel="stylesheet" href="/public/css/sessioncreation.css">

<script>
function addToChapterToBeUpdatedList(updatedChapterId){
	// alert(updatedChapterId);

	if(document.querySelector('#_'+updatedChapterId) == null){
		let updatedChaptersInput = document.createElement('input');
		updatedChaptersInput.setAttribute('type', 'hidden');
		updatedChaptersInput.setAttribute('id', '_' + updatedChapterId );
		updatedChaptersInput.setAttribute('name', 'updatedChapters['+updatedChapterId+'][id]');
		updatedChaptersInput.setAttribute('value', updatedChapterId);
		document.querySelector('#formSession').appendChild(updatedChaptersInput);
	}

	if(document.querySelector('#_title_'+updatedChapterId) == null){
		let updatedChapterTitle = document.querySelector('#titleChapter'+updatedChapterId).value;
		updatedChaptersInput = document.createElement('input');
		updatedChaptersInput.setAttribute('type', 'hidden');
		updatedChaptersInput.setAttribute('id', '_title_' + updatedChapterId );
		updatedChaptersInput.setAttribute('name', 'updatedChapters['+updatedChapterId+'][title]');
		updatedChaptersInput.setAttribute('value', updatedChapterTitle);
		document.querySelector('#formSession').appendChild(updatedChaptersInput);
	} else {
		// mettre à jour la value
		let updatedChapterTitle = document.querySelector('#titleChapter'+updatedChapterId).value;
		updatedChaptersInput.setAttribute('value', updatedChapterTitle);
	}

	if(document.querySelector('#_desc_'+updatedChapterId) == null){
		let updatedChapterDesc = document.querySelector('#chapterDescription'+updatedChapterId).value;
		updatedChaptersInput = document.createElement('input');
		updatedChaptersInput.setAttribute('type', 'hidden');
		updatedChaptersInput.setAttribute('id', '_desc_' + updatedChapterId );
		updatedChaptersInput.setAttribute('name', 'updatedChapters['+updatedChapterId+'][desc]');
		updatedChaptersInput.setAttribute('value', updatedChapterDesc);
		document.querySelector('#formSession').appendChild(updatedChaptersInput);
	} else {
		// mettre à jour la value
		let updatedChapterDesc = document.querySelector('#chapterDescription'+updatedChapterId).value;
		updatedChaptersInput.setAttribute('value', updatedChapterDesc);
	}
}

function addChapter(){
	let nbChapter = document.getElementById('nbChapter').value;
	nbChapter++;

	let div = document.createElement('div');
	div.classList.add('chapter-container');

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

	// Bouton de suppression
	let deleteButton = document.createElement('button');
	deleteButton.setAttribute("type", "button");
	deleteButton.classList.add('button', 'chapterButton');
	deleteButton.textContent = '- Chapitre';
	deleteButton.addEventListener('click', function() {
		deleteChapter(this);
	});
	div.appendChild(deleteButton);

	// Insérer la nouvelle zone de chapitre après le dernier chapitre existant
	let lastChapterContainer = document.querySelector('.chapter-container:last-of-type');
	lastChapterContainer.parentNode.insertBefore(div, lastChapterContainer.nextSibling);

	document.getElementById('nbChapter').value = nbChapter;
}

function deleteChapter(button) {
	let nbChapter = document.querySelectorAll('.chapter-container').length;

	if (nbChapter > 1) {
		let chapterContainer = button.parentNode;

		// Récupérer l'ID du chapitre à supprimer en utilisant la classe 'chapter-id'
		let deletedChapterIdInput = chapterContainer.querySelector('.chapter-id');
		console.log('deletedChapterIdInput : ' + deletedChapterIdInput);

		// Si la balise n'existe pas, il faut simplement supprimer le container HTML
		// if(deletedChapterIdInput == null){
		// }
		// Sinon, on continue le traitement de la suppression
		if (deletedChapterIdInput !=null) {
			deletedChapterId = deletedChapterIdInput.value;
			console.log('deletedChapterId : ' + deletedChapterId);

			// Créer un champ caché dans un autre formulaire pour stocker l'ID du chapitre supprimé
			let deletedChaptersInput = document.createElement('input');
			deletedChaptersInput.setAttribute('type', 'hidden');
			deletedChaptersInput.setAttribute('name', 'deletedChapters[]');
			deletedChaptersInput.setAttribute('value', deletedChapterId);
			document.querySelector('#formSession').appendChild(deletedChaptersInput);
		}

		chapterContainer.remove();

	} else {
		alert("Vous ne pouvez pas supprimer tous les chapitres.");
	}
}


</script>

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

			// Champ caché pour stocker les chapitres supprimés

		}
		else  { //create session
		?>
			<div class="chapter-container">
				<input placeholder="<?= lang("SESSION_CREATE_CHAPTER_TITLE") ?>" type="text" id="titleChapter1" class="field" name="titleChapter1">
				<textarea placeholder="<?= lang("SESSION_CREATE_CHAPTER_DESCRIPTION") ?>" id="chapterDescription1" class="field" name="chapterDescription1"></textarea>

				<!-- Delete chapter button -->
				<button type="button" id="delete-chapter" class="button chapterButton" onclick="deleteChapter(this)">- Chapitre</button>
			</div>
		<?php
		}
		?>

		<!-- Field allowing you to keep the number of chapters, updated by the js, sent to the form for chapter management -->
		<input type="hidden" value="<?= $nbChapter ?>" name="nbChapter" id="nbChapter">

		<!-- Add chapter button -->
		<button type="button" id="btn-chapter" class="button chapterButton" onclick="addChapter()">+ Chapitre</button>

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

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
