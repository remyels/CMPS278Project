function acceptFriend(clickedid){
	var from = clickedid.substring(6);
	//console.log(from);
	var params = "UserIDFrom="+from;

	$.ajax({
        url: "../files/queries/acceptRequests.php",
        type: "post",
        data: params,
        success: function (response) {
			var result = JSON.parse(response);
			if(result == "true"){
				//we should get the name and inform the user whom did he accept bas for now mashina its 3 am i'll fix it bokra
				alert("You accepted!");
				var rowid = "row" + from;
				$("#" + rowid).fadeOut();
			}
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
}

function rejectFriend(clickedid){
	var from = clickedid.substring(6);
	//console.log(from);
	var params = "UserIDFrom="+from;

	$.ajax({
        url: "../files/queries/rejectRequests.php",
        type: "post",
        data: params,
        success: function (response) {
			var result = JSON.parse(response);
			if(result == "true"){
				//we should get the name and inform the user whom did he accept bas for now mashina its 3 am i'll fix it bokra
				alert("You rejected!");
				var rowid = "row" + from;
				$("#" + rowid).fadeOut();
			}
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
}