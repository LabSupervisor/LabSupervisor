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
					value: ["🦄", "🌈", "✨"],
				},
			},
		});

		for (let i = 0; i < 50; i++) {
			var particle = document.createElement("span");
			particle.setAttribute("class", "particle");
			document.getElementById("main").appendChild(particle);
		}

		function rand(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		}

		Array.from(document.getElementsByClassName('particle')).forEach(element => {
			setInterval(() => {
				element.style.left = rand(0, 100) + "%";
				element.style.top = rand(0, 100) + "%";
				let size = rand(3, 5);
				element.style.height = size + "px";
				element.style.width = size + "px";
				element.style.transform = "rotate(" + rand(0, 90) + "deg)";
			}, 150)
		});
	}
});
