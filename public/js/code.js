const konamiCode = ["ArrowUp", "ArrowUp", "ArrowDown", "ArrowDown",	"ArrowLeft", "ArrowRight", "ArrowLeft", "ArrowRight", "b", "a"];

let konamiIndex = 0;
let konami = false;

document.addEventListener('keydown', function checkKonamiCode(event) {
	if (event.key === konamiCode[konamiIndex]) {
		konamiIndex++;
		if (konamiIndex === konamiCode.length) {
			document.body.style.backgroundImage = 'url("/public/img/background/wait.png")';
			document.getElementById("navbarTitle").textContent = "LinkSupervisor";
			konamiIndex = 0;
			konami = true;
		}
	} else {
		konamiIndex = 0;
	}

	if (event.key === " ") {
		if (konami == true) {
			let rdm = Math.floor(Math.random() * 3)
			let audio = new Audio("/public/sound/jump" + (rdm +1) + ".mp3")
			audio.volume = 0.2;
			audio.play()
		}
	}
});
