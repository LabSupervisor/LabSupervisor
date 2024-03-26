setInterval(() => {
	fetch("/connect", {
		method: 'post',
		headers: {
		'Accept': 'application/json',
		'Content-Type': 'application/json'
		},
		body: JSON.stringify({
			"ask": "get_state",
			"idSession": sessionId
		})
	}).then((response) => {
		return response.json()
	}).then((res) => {
		if (res.Response.Status == 0) {
			window.location = "/sessionend";
		}
	}).catch((error) => {
		console.log(error)
	})
}, 3000);
