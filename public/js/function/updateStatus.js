async function setStatus(idchapter, status) {
	await fetch("/connect", {
		method: 'post',
		headers: {
			'Accept': 'application/json',
			'Content-Type': 'application/json'
		},
		body: JSON.stringify({
			"ask": "update_status",
			"idSession": sessionId,
			"idChapter": idchapter,
			"idUser": userId,
			"idState": status
		})
	}).then((response) => {
		return response.json()
	}).then(() => {
		DOMElement = document.getElementById("statusBall_" + idchapter);

		let statusDisplay = "";
		if (status == 0) {
			statusDisplay = "";
		}
		if (status == 1) {
			statusDisplay = "statusRed";
		}
		if (status == 2) {
			statusDisplay = "statusYellow";
		}
		if (status == 3) {
			statusDisplay = "statusGreen";
		}

		DOMElement.className = "statusBall " + statusDisplay;
	}).catch((error) => {
		console.log(error)
	})

	fetch("/connect", {
		method: 'post',
		headers: {
			'Accept': 'application/json',
			'Content-Type': 'application/json'
		},
		body: '{"ask": "get_status_percent", "idSession": ' + sessionId + ', "idUser": ' + userId + '}'
	}).then((response) => {
		return response.json()
	}).then((res) => {
		let percentValue = document.getElementById("percentValue")
		let percentBar = document.getElementById("percentBar")

		percentValue.textContent = res.Response.Percent + "%"
		percentBar.style.width = res.Response.Percent + "%"
	}).catch((error) => {
		console.log(error)
	})
}
