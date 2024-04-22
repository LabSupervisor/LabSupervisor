function addChapter() {
	nbChapter++;
	let div = document.createElement('div');

	let inputTitle = document.createElement('input');
	inputTitle.setAttribute("type", "text");
	inputTitle.setAttribute("placeholder", lang("SESSION_CREATE_CHAPTER_TITLE"));
	inputTitle.setAttribute("name", "titleChapter" + nbChapter);
	inputTitle.classList.add('field');
	div.appendChild(inputTitle);

	let inputDescription = document.createElement('textarea');
	inputDescription.setAttribute("name", "chapterDescription" + nbChapter);
	inputDescription.setAttribute("placeholder", lang("SESSION_CREATE_CHAPTER_DESCRIPTION"));
	inputDescription.classList.add('field');
	div.appendChild(inputDescription);

	let btnChapter = document.getElementById('btn-chapter');
	let parentDiv = btnChapter.parentNode;
	parentDiv.insertBefore(div, btnChapter);

	document.getElementById('nbChapter').value = nbChapter;
}
