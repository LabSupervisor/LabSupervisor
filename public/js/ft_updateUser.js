function updateUser(userId, classroomIdUser, roleIdUser) {
	var form = document.getElementById("form");
	var surnameElement = document.getElementById("surname_" + userId);
	var nameElement = document.getElementById("name_" + userId);
	var classRoomElement = document.getElementById("classroom_" + userId);
	var roleElement = document.getElementById("role_" + userId);
	var surname = surnameElement.innerHTML;
	var name = nameElement.innerHTML;

	var modifyButtonDisable = document.getElementsByClassName("modifybutton");

	// Disable all modify buttons
	for (let i = 0; i < modifyButtonDisable.length; i++) {
		const element = modifyButtonDisable[i];
		element.setAttribute("disabled", "true");
	}

	var inputSurname = document.createElement("input");
	inputSurname.setAttribute("type", "text");
	inputSurname.setAttribute("id", "surname");
	inputSurname.setAttribute("name", "surname");
	inputSurname.setAttribute("class", "surname");
	inputSurname.setAttribute("placeholder", lang("USER_UPDATE_SURNAME"));
	inputSurname.setAttribute("value", surname);

	var inputName = document.createElement("input");
	inputName.setAttribute("type", "text");
	inputName.setAttribute("id", "name");
	inputName.setAttribute("name", "name");
	inputName.setAttribute("class", "name");
	inputName.setAttribute("placeholder", lang("USER_UPDATE_NAME"));
	inputName.setAttribute("value", name);

	var selectClassroom = document.createElement("select");
	selectClassroom.setAttribute("id", "classroom");
	selectClassroom.setAttribute("name", "classroom_" + userId);
	selectClassroom.setAttribute("class", "classroom");

	var optionNone = document.createElement("option");
	optionNone.text = lang("USER_UPDATE_CLASS_EMPTY");
	optionNone.value = "0";

	// Add the "no class" option to the top of the drop-down menu
	selectClassroom.insertBefore(optionNone, selectClassroom.firstChild);

	var selectRole = document.createElement("select");
	selectRole.setAttribute("id", "role");
	selectRole.setAttribute("name", "role_" + userId);
	selectRole.setAttribute("class", "role");

	// Add options to select menu
	for (var i = 0; i < classrooms.length; i++) {
		var option = document.createElement("option");
		// Use "name" property
		option.text = classrooms[i].name;
		option.value = classrooms[i].id ;
		if (classrooms[i].id == classroomIdUser) {
			// Select option for actual classroom
			option.selected = true;
		}
		selectClassroom.add(option);
	}

	// Add options to select menu
	for (var i = 0; i < roles.length; i++) {
		var option = document.createElement("option");
		// Use "name" property
		option.text = lang("MAIN_ROLE_" + roles[i].name.toUpperCase());
		option.value = roles[i].id ;
		if (roles[i].id == roleIdUser) {
			// Select option for actual role
			option.selected = true;
		}
		selectRole.add(option);
	}

	surnameElement.replaceChildren(inputSurname);
	nameElement.replaceChildren(inputName);
	classRoomElement.replaceChildren(selectClassroom);
	roleElement.replaceChildren(selectRole);

	var inputUserId = document.createElement("input");
	inputUserId.setAttribute("type", "hidden");
	inputUserId.setAttribute("name", "userId");
	inputUserId.setAttribute("value", userId);

	form.appendChild(inputUserId);

	var modifyButton = document.getElementById("modify_" + userId);

	confirmButton = document.createElement("input");
	confirmButton.setAttribute("type", "submit");
	confirmButton.setAttribute("name", "modify");
	confirmButton.setAttribute("class", "button");
	modifyButton.parentNode.replaceChild(confirmButton, modifyButton);
}

