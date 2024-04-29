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
		switch (res.Response.Status) {
			case 0:
				document.getElementById("sessionState").style.display = "block";
				document.getElementById("sessionMain").style.display = "none";
				break;
			case 1:
				document.getElementById("sessionState").style.display = "none";
				document.getElementById("sessionMain").style.display = "block";
				document.getElementById("statusBox").style.display = "block";
				document.getElementById("statusBoxPaused").style.display = "none";
				break;
			case 2:
				document.getElementById("sessionState").style.display = "none";
				document.getElementById("sessionMain").style.display = "block";
				document.getElementById("statusBox").style.display = "none";
				document.getElementById("statusBoxPaused").style.display = "block";
				break;
		}
	}).catch((error) => {
		console.log(error)
	})
}, 3000);
