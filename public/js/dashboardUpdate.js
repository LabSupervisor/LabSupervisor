setInterval(() => {
	fetch("/connect", {
		method: 'post',
		headers: {
		'Accept': 'application/json',
		'Content-Type': 'application/json'
		},
		body: JSON.stringify({
			"ask": "get_status",
			"idSession": idSession,
		})
	}).then((response) => {
		return response.json()
	}).then((res) => {
		statusUpdate(res)
	}).catch((error) => {
		console.log(error);
	})

	fetch("/connect", {
		method: 'post',
		headers: {
			'Accept': 'application/json',
			'Content-Type': 'application/json'
		},
		body: '{"ask": "get_all_status_percent", "idSession": ' + idSession + '}'
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
}, 3000);
