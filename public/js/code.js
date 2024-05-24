const konamiCode = ["ArrowUp", "ArrowUp", "ArrowDown", "ArrowDown",	"ArrowLeft", "ArrowRight", "ArrowLeft", "ArrowRight", "b", "a"];

let konamiIndex = 0;

document.addEventListener('keydown', function checkKonamiCode(event) {
	if (event.key === konamiCode[konamiIndex]) {
		konamiIndex++;
		if (konamiIndex === konamiCode.length) {
			document.body.style.backgroundImage = 'url("/public/img/background/wait.png")';
			document.getElementById("navbarTitle").textContent = "LinkSupervisor";
			konamiIndex = 0;
		}
	} else {
		konamiIndex = 0;
	}
});
