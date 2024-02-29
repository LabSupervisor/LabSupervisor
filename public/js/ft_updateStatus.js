function setStatus(idchapter,status){
	document.getElementById("chapter").value = idchapter;
	document.getElementById("status").value = status;
	let form = document.getElementById("formupdate");
	form.submit();
}
