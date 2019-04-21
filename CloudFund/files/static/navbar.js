$(document).ready(function() {
	var array = ['one', 'two', 'three', 'four'];
	$("#search-bar").on("input", function() {
		// source: https://www.w3schools.com/howto/howto_js_autocomplete.asp
		closeAllLists();
	});
});

function closeAllLists() {
    var autocomplete = $("#search-bar-autocomplete-list");
	// Autocomplete list exists, so we delete it
	if (autocomplete.length) {
		autocomplete.remove();
	}
}