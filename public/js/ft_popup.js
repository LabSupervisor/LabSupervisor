function popupDisplay(message){
	var popup = document.createElement("div");
	popup.classList.add("errorPopup");

	var icon = document.createElement("i");
	icon.classList.add("ri-error-warning-line");
	popup.appendChild(icon);

	var messageElement = document.createElement("a");
	messageElement.textContent = message;
	popup.appendChild(messageElement);

	var closeButton = document.createElement("button");
	closeButton.classList.add("button");
	closeButton.textContent = "OK";
	closeButton.addEventListener("click", function() {
		popup.remove();
	});

	popup.appendChild(closeButton);
	document.body.appendChild(popup);
}
