document.getElementById("themeButton").addEventListener('click', function() {
	let currentTheme = document.getElementById("headerTheme").getAttribute("href");
	let theme = "";
	let icon = "";

	if (currentTheme == "/public/css/colorlight.css") {
		theme = "dark"
		icon = "<i class='ri-sun-line'></i>"
	} else {
		theme = "light"
		icon = "<i class='ri-moon-line'></i>"
	}

	document.getElementById("headerTheme").setAttribute("href", "/public/css/color" + theme + ".css");

	fetch("/connect", {
		method: 'post',
		headers: {
		'Accept': 'application/json',
		'Content-Type': 'application/json'
		},
		body: JSON.stringify({
			"ask": "update_theme",
			"idUser": userId,
			"theme": theme
		})
	}).then((response) => {
		return response.json()
	}).then((res) => {
		document.getElementById("themeButton").innerHTML = icon
	}).catch((error) => {
		console.log(error)
	})
})
