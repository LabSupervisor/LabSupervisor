// Side menu, display classroom's students
function selectClass(id) {
	try	{
		// Classroom's name
		document.querySelector(".classname[selected]").removeAttribute("selected");
		document.getElementById("classroom_" + id).setAttribute("selected","");

		// Classroom's students
		document.querySelector(".contentClassroom[selected]").removeAttribute("selected");
		document.getElementById("contentClassroom_" + id).setAttribute("selected","");
	} catch(e) {
		console.error(e.stack);
	}
}
