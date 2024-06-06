function statusUpdate(status) {
	Object.entries(status.Response).forEach(([participant, indexParticipant]) => {
		Object.entries(status.Response[participant]).forEach(([chapter, indexChapter]) => {

			DOMElement = document.getElementById(participant + "_" + chapter);

			let statusDisplay = "";
			let text = "";
			if (status.Response[participant][chapter] == 0) {
				text = lang("DASHBOARD_STATUS_WAITING");
				statusDisplay = "";
			}
			if (status.Response[participant][chapter] == 1) {
				if (!DOMElement.classList.contains("statusRed")) {
					fetch("/connect", {
						method: 'post',
						headers: {
						'Accept': 'application/json',
						'Content-Type': 'application/json'
						},
						body: JSON.stringify({
							"ask": "get_user_names",
							"idUser": participant,
						})
					}).then((response) => {
						return response.json()
					}).then((res) => {
						notify(res.Response.Names + " " + lang("NOTIFICATION_NEED_HELP"))
					}).catch((error) => {
						console.log(error);
					})
				}
				statusDisplay = "statusRed";
				text = lang("DASHBOARD_STATUS_RED");
			}
			if (status.Response[participant][chapter] == 2) {
				statusDisplay = "statusYellow";
				text = lang("DASHBOARD_STATUS_YELLOW");
			}
			if (status.Response[participant][chapter] == 3) {
				statusDisplay = "statusGreen";
				text = lang("DASHBOARD_STATUS_GREEN");
			}

			DOMElement.className = "statusBall " + statusDisplay;
			DOMElement.title = text;
		})
	})
}
