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
	inputSurname.setAttribute("placeholder", lang("MAIN_NAME"));
	inputSurname.setAttribute("value", surname);

	var inputName = document.createElement("input");
	inputName.setAttribute("type", "text");
	inputName.setAttribute("id", "name");
	inputName.setAttribute("name", "name");
	inputName.setAttribute("class", "name");
	inputName.setAttribute("placeholder", lang("MAIN_NAME"));
	inputName.setAttribute("value", name);

	var selectClassroom = document.createElement("select");
	selectClassroom.setAttribute("id", "classroom");
	selectClassroom.setAttribute("name", "classroom_" + userId);
	selectClassroom.setAttribute("class", "classroom");
	if (roleIdUser == 3) {
		selectClassroom.setAttribute("multiple", "multiple");
	}
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
		option.value = classrooms[i].id;
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
		option.value = roles[i].id;
		if (roles[i].id == roleIdUser) {
			// Select option for actual role
			option.selected = true;
		}
		selectRole.add(option);
	}

	// Create a span element for "Aucune classe"
	var noClassSpan = document.createElement("span");
	noClassSpan.textContent = lang("USER_UPDATE_CLASS_EMPTY");
	noClassSpan.setAttribute("id", "noClass");

    // Add event listener to change the classroom select element based on role
    selectRole.addEventListener('change', function() {
        if (selectRole.value == '3') { // Assuming 3 is the id for the professor role
            selectClassroom.setAttribute("multiple", "multiple");
            classRoomElement.replaceChildren(selectClassroom);
        } else if (selectRole.value == '1') { // Assuming 1 is the id for the admin role
            classRoomElement.replaceChildren(noClassSpan);
        } else {
            selectClassroom.removeAttribute("multiple");
            classRoomElement.replaceChildren(selectClassroom);
        }
	});

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

	confirmButton = document.createElement("button");
	confirmButton.setAttribute("type", "submit");
	confirmButton.setAttribute("name", "modify");
	confirmButton.setAttribute("class", "button");
	confirmButton.setAttribute("title", lang("USER_UPDATE_SAVE"));

	var icon = document.createElement("i");
	icon.classList.add("ri-save-2-line");
	confirmButton.appendChild(icon);

	modifyButton.parentNode.replaceChild(confirmButton, modifyButton);
}

