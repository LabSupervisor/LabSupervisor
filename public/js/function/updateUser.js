function updateUser(userId, classroomIdUser, roleIdUser) {
	var currentClassId ;

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

	// Create a span element for "Aucune classe"
	var noClassSpan = document.createElement("span");
	noClassSpan.textContent = lang("USER_UPDATE_CLASS_EMPTY");
	noClassSpan.setAttribute("id", "noClass");

	var selectClassroom = document.createElement("select");
	selectClassroom.setAttribute("id", "classroom");
	selectClassroom.setAttribute("name", "classroom_" + userId);
	selectClassroom.setAttribute("class", "classroom");
	var optionNone = document.createElement("option");
	optionNone.text = lang("USER_UPDATE_CLASS_EMPTY");
	optionNone.value = "0";

	// Add the "no class" option to the top of the drop-down menu
	selectClassroom.appendChild(optionNone);

	var selectRole = document.createElement("select");
	selectRole.setAttribute("id", "role");
	selectRole.setAttribute("name", "role_" + userId);
	selectRole.setAttribute("class", "role");

	// Add options to select menu
	for (var i = 0; i < classrooms.length; i++) {
		var option = document.createElement("option");
		option.text = classrooms[i].name;
		option.value = classrooms[i].id;
		if (roleIdUser != 3 && classrooms[i].id == classroomIdUser) {
			// Select option for actual classroom, but not for professor
			option.selected = true;
		}
		selectClassroom.add(option);
	}

	currentClassId = classroomIdUser;

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

	if (roleIdUser == 3) {
		fetch("/connect", {
			method: 'post',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json'
			},
			body: '{"ask": "get_teacher_classroom", "idUser":' + userId + '}'
		}).then((response) => {
			return response.json()
		}).then((classroomTeacher) => {
			// Set multiple and required attributes
			selectClassroom.setAttribute("multiple", "multiple");
			selectClassroom.setAttribute("required", "required");

			// Deselect all options first
			for (var i = 0; i < selectClassroom.options.length; i++) {
				selectClassroom.options[i].selected = false;
			}

			// Select the classes for the teacher
			classroomTeacher.forEach(function (classroom) {
				for (var i = 0; i < selectClassroom.options.length; i++) {
					if (selectClassroom.options[i].value == classroom.id) {
						selectClassroom.options[i].selected = true;
					}
				}
			});
		}).catch((error) => {
			console.log(error)
		})
	}

	// Add event listener to change the classroom select element based on role
	selectRole.addEventListener('change', function() {
		if (selectRole.value == '3') {
			selectClassroom.setAttribute("multiple", "multiple");
			selectClassroom.setAttribute("required", "required");
			// Deselect all other options
			for (var i = 0; i < selectClassroom.options.length; i++) {
				selectClassroom.options[i].selected = false;
			}
			fetch("/connect", {
				method: 'post',
				headers: {
					'Accept': 'application/json',
					'Content-Type': 'application/json'
				},
				body: '{"ask": "get_teacher_classroom", "idUser":' + userId + '}'
			}).then((response) => {
				return response.json()
			}).then((classroomTeacher) => {
				// Set multiple and required attributes
				selectClassroom.setAttribute("multiple", "multiple");
				selectClassroom.setAttribute("required", "required");

				if (classroomTeacher.length == 0) {
					optionNone.selected = true; // Select "Aucune classe"
				} else {
					// Deselect all options first
					for (var i = 0; i < selectClassroom.options.length; i++) {
						selectClassroom.options[i].selected = false;
					}

					// Select the classes for the teacher
					classroomTeacher.forEach(function (classroom) {
						for (var i = 0; i < selectClassroom.options.length; i++) {
							if (selectClassroom.options[i].value == classroom.id) {
								selectClassroom.options[i].selected = true;
							}
						}
					});
				}
			}).catch((error) => {
				console.log(error)
			})

			classRoomElement.replaceChildren(selectClassroom);
		} else if (selectRole.value == '1') {
			classRoomElement.replaceChildren(noClassSpan);
		} else if (selectRole.value == '2') {
			// Remove multiple and required attributes
			selectClassroom.removeAttribute("multiple");

			if (currentClassId != 0) {
				for (var i = 0; i < classrooms.length; i++) {
					var option = document.createElement("option");
					option.text = classrooms[i].name;
					option.value = classrooms[i].id;
					if (roleIdUser != 3 && classrooms[i].id == classroomIdUser) {
						// Select option for actual classroom, but not for professor
						option.selected = true;
					}
					selectClassroom.add(option);
				}
			} else {
				optionNone.selected = true; // Select "Aucune classe"
			}

			classRoomElement.replaceChildren(selectClassroom);
		}
	});

	if (roleIdUser == 1) {
		classRoomElement.replaceChildren(noClassSpan);
	} else {
		classRoomElement.replaceChildren(selectClassroom);
	}

	surnameElement.replaceChildren(inputSurname);
	nameElement.replaceChildren(inputName);
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
