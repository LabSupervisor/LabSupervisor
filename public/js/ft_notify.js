if (Notification && Notification.permission !== "denied") {
	Notification.requestPermission();
}

function notify(msg) {
	if (Notification?.permission === "granted") {
		new Notification(msg);
	}
}
