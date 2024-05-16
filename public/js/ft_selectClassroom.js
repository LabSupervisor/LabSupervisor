function selectClass(id) {
	let url = new URL(window.location.href);
	let params = url.searchParams;

	if (params.has("id")) {
		params.set("id", id);
	} else {
		params.append("id", id);
	}

	window.location.href = url;
}
