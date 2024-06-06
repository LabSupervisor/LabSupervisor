const shareButton = document.getElementById('shareButton');
const grid = document.getElementById('videogrid');
let data = [];

// Start sharing
shareButton.addEventListener('click', async () => {
	// Ask web browser
	const mediaStream = await navigator.mediaDevices.getDisplayMedia({
		video: {
			displaySurface: 'monitor'
		},
		audio: false
	});

	// Create peer connection
	const peer = new Peer();

	// Listen
	peer.on('call', call => {
		call.answer(mediaStream);
	});

	// Create peer connection
	peer.on('open', function (id) {
		console.log('Personal peer ID: ' + id);
		fetch("/connect", {
			method: 'post',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({
				"ask": "add_screenshare",
				"idUser": userId,
				"idSession": sessionId,
				"idScreenshare": id
			})
		}).then((response) => {
			return response.json()
		}).catch((error) => {
			console.log(error)
		})
	});
});
