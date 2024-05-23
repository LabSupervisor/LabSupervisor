// document.getElementById("themeButton").onclick = function() {
// 	let currentTheme = document.getElementById("headerTheme").getAttribute("href");
// 	let theme = "";
// 	let icon = "";

// 	if (currentTheme == "/public/css/theme/light.css") {
// 		theme = "dark"
// 		icon = "<i class='ri-sun-line'></i>"
// 	} else {
// 		theme = "light"
// 		icon = "<i class='ri-moon-line'></i>"
// 	}

// 	document.getElementById("headerTheme").setAttribute("href", "/public/css/theme/" + theme + ".css");
// 	document.getElementById("navbarTitle").textContent = lang("MAIN_TITLE");

// 	fetch("/connect", {
// 		method: 'post',
// 		headers: {
// 		'Accept': 'application/json',
// 		'Content-Type': 'application/json'
// 		},
// 		body: JSON.stringify({
// 			"ask": "update_theme",
// 			"idUser": userId,
// 			"theme": theme
// 		})
// 	}).then((response) => {
// 		return response.json()
// 	}).then((res) => {
// 		document.getElementById("themeButton").innerHTML = icon
// 	}).catch((error) => {
// 		console.log(error)
// 	})
// }

document.querySelectorAll('.themeColor').forEach(div => {
	div.addEventListener('click', function() {
		const classes = this.className.split(' ');
		const filteredClasses = classes.filter(c => c !== 'themeColor');

		let theme = ""
		filteredClasses.forEach(cls => {
			const modifiedClass = cls.replace('theme', '');
			theme = modifiedClass.charAt(0).toLowerCase() + modifiedClass.slice(1);
		});

		document.getElementById("headerTheme").setAttribute("href", "/public/css/theme/" + theme + ".css");
		document.getElementById("navbarTitle").textContent = lang("MAIN_TITLE");

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
});

document.getElementById("themeRedLight").addEventListener("auxclick", function(e) {
	if (e.button === 1) {
		document.getElementById("headerTheme").setAttribute("href", "/public/css/theme/extraDark.css");
		document.getElementById("navbarTitle").textContent = "UwU";

		confetti({
			particleCount: 50,
			origin: { y: 0 },
			spread: 1000,
			scalar: 10,
			shapes: ["emoji"],
			shapeOptions: {
				emoji: {
					value: ["🦄", "🌈"],
				},
			},
		});
	}
});
