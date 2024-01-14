const express = require("express");
const http = require("http");
const WebSocket = require("ws");

const app = express();
const server = http.createServer(app);
const wss = new WebSocket.Server({ server });

wss.on("connection", (ws) => {
	console.log("Client connected");

	ws.on("message", (message) => {
		wss.clients.forEach((client) => {
		if (client !== ws && client.readyState === WebSocket.OPEN) {
			client.send(message);
			console.log(message);
		}
		});
	});

	ws.on("close", () => {
		console.log("Client disconnected");
	});
});

server.listen(3000, () => {
	console.log("Server start on :3000");
});
