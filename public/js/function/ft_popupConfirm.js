function confirmForm(msg) {
	if (confirm(msg)) {
		loading();
		return true;
	}
	return false;
}
