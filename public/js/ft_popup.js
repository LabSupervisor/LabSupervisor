function popupDisplay(message){
	var popup = document.createElement("div");
	popup.classList.add("error-popup");
	popup.textContent = message;
	var closeButton = document.createElement("button");
	closeButton.classList.add("button");
	closeButton.textContent = "OK";
	closeButton.addEventListener("click", function() {
		popup.remove();
	});
	popup.appendChild(closeButton);
	document.body.appendChild(popup);
}
