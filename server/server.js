const express = require("express");
const http = require("http");
const { Server } = require("socket.io");

const app = express();
const server = http.createServer(app);

let activeScreenshare = [];

// Create server
const io = new Server(server, {
	cors: {
		origin: "*",
		methods: ["GET", "POST"],
	},
});

// On client connect
io.on("connection", socket => {
	console.log(socket.id + " connected!");
	activeScreenshare["id"] += socket.id;

	console.log(activeScreenshare);

	// Emit screenshare
	// socket.on("share", data => {
	// 	socket.broadcast.emit("new", data);
	// });

	// On client disconnect
	socket.on("disconnect", () => {
		console.log(socket.id + " disconnected!");
		// activeScreenshare["id"].splice(activeScreenshare["id"].indexOf(socket.id), 1);
		activeScreenshare = activeScreenshare.filter(element => element.id !== socket.id);
	});

	socket.on("screenshare", data => {
		console.log(data);
		console.log(JSON.stringify(data));
	});

	socket.on("get", data => {
		socket.emit("send", activeScreenshare[data]);
	})
});

const PORT = process.env.PORT || 3000;

// Log server port
server.listen(PORT, () => {
	console.log("Server listening on port " + PORT);
});
