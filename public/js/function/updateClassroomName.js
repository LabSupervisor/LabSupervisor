function modifyName(name) {
	var input = document.createElement("input");
	input.setAttribute("class", "modifyClassroomInput");
	input.setAttribute("type", "text");
	input.setAttribute("name", "modifyName");
	input.setAttribute("maxlength", 50);
	input.setAttribute("placeholder", lang("CLASSROOM_ADD_CLASSROOM_PLACEHOLDER"));
	input.setAttribute("value", name);

	document.getElementById("modifyNameButton").remove();
	document.getElementById("modifyNameTitle").remove();

	document.getElementById("modifyNameForm").appendChild(input);

	var save = document.createElement("button");
	save.setAttribute("class", "button");
	save.setAttribute("type", "submit");

	var icon = document.createElement("i");
	icon.classList.add("ri-save-2-line");
	save.appendChild(icon);

	document.getElementById("modifyNameForm").appendChild(save);
}
