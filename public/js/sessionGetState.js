setInterval(() => {
	fetch("/connect", {
		method: 'post',
		headers: {
			'Accept': 'application/json',
			'Content-Type': 'application/json'
		},
		body: '{"ask": "get_state", "idSession": ' + sessionId + '}'
	}).then((response) => {
		return response.json()
	}).then((res) => {
		let actionId = document.querySelectorAll("[id=action]");
		let screenshareId = document.getElementById("screenshare");
		let lslinkId = document.getElementById("lslink");
		let pausedTitleId = document.getElementById("pausedTitle");
		switch (res.Response.Status) {
			case 0:
				for (var i = 0; i < actionId.length; i++) {
					actionId[i].style.display = "none";
				}
				screenshareId.style.display = "none";
				lslinkId.style.display = "none";
				pausedTitleId.style.display = "none";
				break;
			case 1:
				for (var i = 0; i < actionId.length; i++) {
					actionId[i].style.display = "";
				}
				screenshareId.style.display = "block";
				lslinkId.style.display = "block";
				pausedTitleId.style.display = "none";
				break;
			case 2:
				for (var i = 0; i < actionId.length; i++) {
					actionId[i].style.display = "none";
				}
				screenshareId.style.display = "block";
				lslinkId.style.display = "block";
				pausedTitleId.style.display = "block";
				break;
		}
	}).catch((error) => {
		console.log(error)
	})
}, 3000);
