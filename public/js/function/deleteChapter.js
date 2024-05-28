function deleteChapter(button) {
	let nbChapter = document.querySelectorAll('.subform').length;

	if (nbChapter > 1) {
		let subform = button.parentNode;

		// Récupérer l'ID du chapitre à supprimer en utilisant la classe 'chapterId'
		let deletedChapterIdInput = subform.querySelector('.chapterId');
		console.log('deletedChapterIdInput : ' + deletedChapterIdInput);

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

		subform.remove();

	} else {
		alert(lang("SESSION_CREATE_CHAPTER_REMOVE_ERROR"));
	}
}
