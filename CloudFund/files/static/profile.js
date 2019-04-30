$(document).ready(function() {
	$("#addFriendBtn").click(addFriend);
});

function addFriend() {
	var btn = $(this);
	console.log("OK");
	$.ajax({
		url: "queries/addFriend.php",
		type: "post",
		data: {id: $("ProfileUserID").val()},
		success: function(response) {
			btn.removeClass("btn-default");
			btn.addClass("btn-success");
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
			btn.removeClass("btn-default");
			btn.addClass("btn-danger");
			btn.prop("disabled", true);
			$("#addFriendBtn").html("Error");
		}
	});
}