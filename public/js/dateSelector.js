let date = document.getElementById("date");

date.addEventListener('change', function() {
	loading();

	let url = new URL(window.location.href);
	let params = url.searchParams;

	if (params.has("date")) {
		params.set("date", date.value);
	} else {
		params.append("date", date.value);
	}

	window.location.href = url;
});
