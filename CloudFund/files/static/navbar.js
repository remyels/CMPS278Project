$(document).ready(function() {
		// source: https://www.w3schools.com/howto/howto_js_autocomplete.asp
		$.ajax({
			url: "../files/queries/getUsers.php",
			type: "get",
			success: function (response) {
				var result = JSON.parse(response);
				//console.log(result);
				if(result.length > 0){
					var list = document.getElementById("users");
					for(var i = 0; i < result.length; i++){
						var option = document.createElement("option");
						//console.log(result[i][0] + " " + result[i][1]);
						var text = document.createTextNode(result[i][0] + " " + result[i][1]);
						option.appendChild(text);
						list.appendChild(option);
					}
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			}
		});
			
	closeAllLists();
	
});

function closeAllLists() {
    var autocomplete = $("#search-bar-autocomplete-list");
	// Autocomplete list exists, so we delete it
	if (autocomplete.length) {
		autocomplete.remove();
	}
}