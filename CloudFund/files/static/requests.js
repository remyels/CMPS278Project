function acceptFriend(clickedid){
	var from = clickedid.substring(6);
	//console.log(from);
	var params = "UserIDFrom="+from;

	$.ajax({
        url: "../files/queries/acceptRequests.php",
        type: "post",
        data: params,
        success: function (response) {
			if(response.includes("true")) {
				//we should get the name and inform the user whom did he accept bas for now mashina its 3 am i'll fix it bokra
				var rowid = "row" + from;
				$("#" + rowid).fadeOut();
				var numleft = response.split(" ")[1];
				if (numleft==0) {
					$("#requests-container").css("visibility", "hidden");
					$("#header-message").html("You don't have any friend requests left!");
				}
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
			if(response.includes("true")){
				//we should get the name and inform the user whom did he accept bas for now mashina its 3 am i'll fix it bokra
				var rowid = "row" + from;
				$("#" + rowid).fadeOut();
				var numleft = response.split(" ")[1];
				if (numleft==0) {
					$("#requests-container").css("visibility", "hidden");
					$("#header-message").html("You don't have any friend requests left!");
				}
			}
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
}