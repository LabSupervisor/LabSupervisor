function updateChapter(updatedChapterId){

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
