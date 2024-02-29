<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Création de session");

	permissionChecker(true, false, true, false);

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/createSession.php');
?>

<link rel="stylesheet" href="../public/css/sessioncreation.css">

<script>
	var nbChapter = 1;

	// Update chapter count
	function addChapter() {
    nbChapter++;
    let div = document.createElement('div');
    div.classList.add('buttonC');

    // Division Line
    let line = document.createElement('hr');
    div.appendChild(line);

    // Title + strong1, firstbox class
    let title = document.createElement('strong');
    title.innerHTML = "Titre : ";
    title.classList.add('strong1');
    div.appendChild(title);

    let inputTitle = document.createElement('input');
    inputTitle.setAttribute("type", "text");
    inputTitle.setAttribute("name", "titleChapter" + nbChapter);
    inputTitle.classList.add('firstbox');
    div.appendChild(inputTitle);

    // Description + strong2, secondbox class
    let description = document.createElement('strong');
    description.innerHTML = ' Description : ';
    description.classList.add('strong2');
    div.appendChild(description);

    let inputDescription = document.createElement('textarea');
    inputDescription.setAttribute("name", "chapterDescription" + nbChapter);
    inputDescription.classList.add('secondbox');
    div.appendChild(inputDescription);

    let btnChapter = document.getElementById('btn-chapter');
    let parentDiv = btnChapter.parentNode;
    parentDiv.insertBefore(div, btnChapter);

    document.getElementById('nbChapter').value = nbChapter;
}

</script>

<form class="sessions" method="post">
	<input type="hidden" value="1" name="nbChapter" id="nbChapter">
	<fieldset>
		<legend> Information </legend>
		<strong class="strong1"> Titre : </strong>
		<input type="text" id="titleSession" class="firstbox" name="titleSession" required>
		<strong class="strong2"> Description : </strong>
		<textarea id="descriptionSession" class="secondbox" name="descriptionSession"></textarea>
	</fieldset>
	<fieldset>
		<legend> Participants </legend>
		<strong> Classes : </strong>

		<?php
		$db = dbConnect();

		$queryClass = "SELECT id, name FROM classroom";
		$queryClassPrep = $db->prepare($queryClass);
		if ($queryClassPrep->execute()) {
			$tabClass = $queryClassPrep->fetchAll();
		}
		?>

		<div class="custom-select">
			<span class="ri ri-arrow-down-wide-line"></span>
			<select name="classes" id="classes">
				<?php
				for ($i = 0; $i < count($tabClass); $i++) {
					?>
					<option value="<?php echo $tabClass[$i]["id"]; ?>"><?php echo $tabClass[$i]["name"]; ?></option>
					<?php
				}
				?>
			</select>
		</div>

	</fieldset>
	<fieldset>
   		<legend>Chapitres</legend>
   			<div class="buttonC">
			<strong class="strong1">Titre :</strong>
  			<input type="text" id="titleChapter1" class="firstbox" name="titleChapter1">
   			<strong class="strong2">Description :</strong>
   			<textarea id="chapterDescription1" class="secondbox" name="chapterDescription1"></textarea>
    		</div>
			<button type="button" id="btn-chapter" class="button chapterButton" onclick="addChapter()">+ Chapitre</button>
	</fieldset>
	<fieldset>
		<legend> Date </legend>
		<strong> Date : </strong>
		<input type="datetime-local" id="date" name="date"  required>
	</fieldset>
	<input type="submit" name="saveSession" class="button" value="Enregistrer">
</form>
