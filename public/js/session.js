function addToChapterToBeUpdatedList(updatedChapterId){

	// si updatedChapterId est vide, il a un idProv donc
	// rediriger vers addToChapterToBeAddList(idProv) si le chapitre n'existe pas?

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
		// update value
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
		// update value
		let updatedChapterDesc = document.querySelector('#chapterDescription'+updatedChapterId).value;
		updatedChaptersInput.setAttribute('value', updatedChapterDesc);
	}
}

function addHTMLChapter(title, description, button){
	let newIdChapter = parseInt(button.getAttribute("data-id"));
	// mettre à jour le bouton pour incrémenter l'id si jamais il est de nouveau cliqué
	button.setAttribute("data-id", newIdChapter + 1);
	let nbChapter = document.getElementById('nbChapter').value;
	nbChapter++;

	let div = document.createElement('div');
	div.classList.add('chapter-container');

	let inputTitle = document.createElement('input');
	inputTitle.setAttribute("type", "text");
	inputTitle.setAttribute("placeholder", title);
	inputTitle.setAttribute("name", "addChapters[" + newIdChapter +"][title]");
	inputTitle.classList.add('field');
	div.appendChild(inputTitle);

	let inputDescription = document.createElement('textarea');
	inputDescription.setAttribute("name", "addChapters[" + newIdChapter +"][desc]");
	inputDescription.setAttribute("placeholder", description);
	inputDescription.classList.add('field');
	div.appendChild(inputDescription);

	// Delete button
	let deleteButton = document.createElement('button');
	deleteButton.setAttribute("type", "button");
	deleteButton.classList.add('button', 'chapterButton');
	deleteButton.textContent = '- Chapitre';
	deleteButton.addEventListener('click', function() {
		deleteChapter(this);
	});
	div.appendChild(deleteButton);

	// Insert the new chapter zone after the last existing chapter
	let lastChapterContainer = document.querySelector('.chapter-container:last-of-type');
	lastChapterContainer.parentNode.insertBefore(div, lastChapterContainer.nextSibling);

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
