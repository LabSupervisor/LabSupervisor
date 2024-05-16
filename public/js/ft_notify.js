if (Notification && Notification.permission !== "denied") {
	Notification.requestPermission();
}

function notify(msg) {
	if (Notification.permission === "granted") {
		new Notification(lang("MAIN_TITLE"), {
				body: msg,
				icon: "/public/img/icon/logo.png",
				tag: "soManyNotification"
			}
		);
	}
}
