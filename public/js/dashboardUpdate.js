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
}, 3000);
