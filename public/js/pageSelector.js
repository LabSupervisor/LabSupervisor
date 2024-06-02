let pageNumber = document.getElementById("pageNumber");

pageNumber.addEventListener('change', function() {
	loading();

	let url = new URL(window.location.href);
	let params = url.searchParams;

	if (params.has("page")) {
		params.set("page", pageNumber.value);
	} else {
		params.append("page", pageNumber.value);
	}

	window.location.href = url;
});
