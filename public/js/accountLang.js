let select = document.getElementById("lang");

select.addEventListener('change', function() {
	fetch("/connect", {
		method: 'post',
		headers: {
		'Accept': 'application/json',
		'Content-Type': 'application/json'
		},
		body: JSON.stringify({
			"ask": "update_lang",
			"idUser": userId,
			"lang": select.value
		})
	}).then((response) => {
		return response.json()
	}).catch((error) => {
		console.log(error)
	})

	window.location.reload();
});
