function updateClassroom(updatedClassroomId) {
    let updatedClassroomInput = document.querySelector('#_classroom');
    if (updatedClassroomInput === null) {
        updatedClassroomInput = document.createElement('input');
        updatedClassroomInput.setAttribute('type', 'hidden');
        updatedClassroomInput.setAttribute('id', '_classroom');
        updatedClassroomInput.setAttribute('name', 'classroomChange');
		updatedClassroomInput.setAttribute('value', updatedClassroomId);
        document.querySelector('#formSession').appendChild(updatedClassroomInput);
    }
    updatedClassroomInput.setAttribute('value', updatedClassroomId);
}
