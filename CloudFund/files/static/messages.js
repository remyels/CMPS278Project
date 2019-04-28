$(document).ready(function() {
	$(".message-click").click(readMessage);
	$("#backBtn").click(goBack);
});

function readMessage() {
	
	var anchor = $(this);
	
	$.ajax({
		url: "queries/getMessageDetails.php",
		type: "get",
		data: {id: $(this).data("id")},
		success: function(response) 
		{
			if (response=="Error") {			
				$("#subject").html("Error getting subject");
				$("#date").html("");
				$("#first-name").html("-");
				$("#last-name").html("");
				$("#message-content").html("Error getting message: you either don't have permissions to access this message or this message no longer exists.");
			}
			else {
				var result = JSON.parse(response);
				var subject = result['subject'];
				var date = result['date'];
				var from = result['from'];
				var message = result['message'];
				
				$("#subject").html(subject);
				$("#date").html(date);
				$("#first-name").html(from.split(" ")[0]);
				$("#last-name").html(from.split(" ")[1]);
				$("#message-content").html(message);				
			}
			
			anchor.find(".new-message").remove();
			$("#all-messages").fadeOut(1000, function() { $("#selected-message").fadeIn(1000); });
		},
		error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus);
		   console.log(errorThrown);
        },
	});
}

function goBack() {
	$("#selected-message").fadeOut(1000, function() { $("#all-messages").fadeIn(1000); });
}