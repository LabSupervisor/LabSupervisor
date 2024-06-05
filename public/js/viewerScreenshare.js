const grid = document.getElementById('screenshare');

// Update video display
function addVideoStream(mediaStream) {
	const video = document.createElement('video');
	video.setAttribute("controls", "true");
	video.srcObject = mediaStream;
	grid.appendChild(video);
	video.play();
}

fetch("/connect", {
	method: 'post',
	headers: {
	'Accept': 'application/json',
	'Content-Type': 'application/json'
	},
	body: JSON.stringify({
		"ask": "get_screenshare",
		"idUser": requestId,
		"idSession": idSession
	})
}).then((response) => {
	return response.json()
}).then((res) => {
	respondId = res.Response.Screenshare;
}).catch((error) => {
	console.log(error);
})

if (navigator.userAgent.includes("Firefox")) {
	document.getElementById('firefoxButton').style.display = 'flex';
} else {
	startScrenshare();
}

async function startScrenshare() {
	try {
		document.getElementById('firefoxButton').style.display = 'none';

		const mediaStream = await navigator.mediaDevices.getDisplayMedia({
			video: {
				displaySurface: 'monitor'
			},
			audio: false
		});

		var peer = new Peer();

		// Create peer connection
		peer.on('open', function () {
			const call = peer.call(respondId, mediaStream);
			call.on('stream', stream => {
				addVideoStream(stream);
			});
		});

		peer.on("error", function(error) {
			console.log(error);
		});
	} catch (e) {
		window.open('','_self').close();
	}
}
