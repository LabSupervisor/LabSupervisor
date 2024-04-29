const grid = document.getElementById('screenshare');
const socket = io('ws://' + videoServerHost +':' + videoServerPort);

// Update video display
function addVideoStream(mediaStream) {
	const video = document.createElement('video');
	video.setAttribute("controls", "true");
	video.srcObject = mediaStream;
	grid.appendChild(video);
	video.play();
}

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
	} catch (e) {
		window.open('','_self').close();
	}
}
