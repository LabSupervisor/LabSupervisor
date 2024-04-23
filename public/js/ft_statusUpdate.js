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
