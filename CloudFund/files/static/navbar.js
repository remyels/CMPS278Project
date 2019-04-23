$(document).ready(function() {
		// source: https://www.w3schools.com/howto/howto_js_autocomplete.asp
		$.ajax({
			url: "../files/queries/getUsers.php",
			type: "get",
			async: false,
			success: function (response) {
				var result = JSON.parse(response);
				//console.log(result);
				if(result.length > 0){
					var datalist = document.getElementById("users");
					for(var i = 0; i < result.length; i++) {
						var opt = document.createElement("option");
						opt.id = "user"+result[i]['UserID'];
						opt.innerHTML = result[i]['FirstName'] + " " + result[i]['LastName'];
						datalist.appendChild(opt);
					}
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			}
		});
});