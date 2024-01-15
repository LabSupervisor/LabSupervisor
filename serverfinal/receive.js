const socket = new WebSocket("ws://localhost:3000");
const remoteVideo = document.getElementById("remoteVideo");
const playButton = document.getElementById("play");
const stream = new MediaStream();
remoteVideo.srcObject = stream;

socket.addEventListener("open", () => {
	console.log('Connexion WebSocket établie avec succès');
});

let video;
playButton.addEventListener("click", () => {
	socket.addEventListener("message", (event) => {
		stream.srcObject = event.data;
		// const videoBlob = new Blob([event.data], { type: "video/webm" });
		// const videoUrl = URL.createObjectURL(videoBlob);
		// if (video)
		// 	video.remove();
		// video = document.createElement("video");
		// video.setAttribute("autoplay", true);
		// video.src = videoUrl;
		// document.body.appendChild(video);
		// video.play();
		// console.log(video.captureStream().getVideoTracks());
		// stream.addTrack(video.captureStream().getVideoTracks()[0]);
	});
})

socket.addEventListener("close", () => {
  console.log("Connexion WebSocket fermée");
});
