// Side menu, display classroom's students
function selectClass(id) {
	try	{
		// Classroom's name
		document.querySelector('.classname[selected]').removeAttribute('selected');
		document.getElementById('class-'+id).setAttribute('selected','');

		// Classroom's students
		document.querySelector('.content-class[selected]').removeAttribute('selected');
		document.getElementById('content-class-'+id).setAttribute('selected','');
	} catch(e) {
		console.error(e.stack);
	}
}
