$(document).ready(function() {
	$("#addFriendBtn").click(addFriend);
});

function addFriend() {
	var btn = $(this);
	$.ajax({
		url: "queries/addFriend.php",
		type: "post",
		data: {id: $("#ProfileID").val()},
		success: function(response) {
			console.log(response);
			if (response) {
				btn.removeClass("btn-default");
				btn.addClass("btn-success");
				btn.prop("disabled", true);
				$("#addFriendBtn").html("<i class='fa fa-check'></i> Request sent");
			}
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