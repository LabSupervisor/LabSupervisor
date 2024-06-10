function validatePageNumber(input, maxPages) {
	let value = parseInt(input.value, 10);
	if (isNaN(value) || value < 0) {
		input.value = 1;
	} else if (value > maxPages) {
		input.value = maxPages;
	}
}
