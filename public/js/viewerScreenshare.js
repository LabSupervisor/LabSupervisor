const grid = document.getElementById('screenshare');
const socket = io('ws://localhost:3000');

// Update video display
function addVideoStream(mediaStream) {
	const video = document.createElement('video');
	video.setAttribute("controls", "true");
	video.srcObject = mediaStream;
	grid.appendChild(video);
	video.play();
}

startScrenshare();

async function startScrenshare() {
	const mediaStream = await navigator.mediaDevices.getDisplayMedia({
		video: {
			displaySurface: 'monitor'
		},
		audio: false
	});

	// Create peer connection
	const peer = new Peer();

	// Create peer connection
	peer.on('open', function () {
		socket.emit('get', requestId);
	});

	socket.on('response', id => {
		console.log(id);
		const call = peer.call(id, mediaStream);
		call.on('stream', stream => {
			addVideoStream(stream);
		});
	});
}
