$(document).ready(function() {
	updateUnread();
	$(".message-click").click(readMessage);
	$(".message-sent-click").click(getMessageSent);
	$("#backBtn").click(goBack);
	$(".folder").click(switchMenu);
});

function readMessage() {
	
	var anchor = $(this);
	
	$.ajax({
		url: "queries/getMessageDetails.php",
		type: "get",
		data: {id: $(this).data("id"), mode: "received"},
		success: function(response) 
		{
			console.log(response);
			if (response=="Error") {			
				$("#subject").html("Error getting subject");
				$("#destination").html("From: ");
				$("#date").html("");
				$("#name").html("-");
				$("#message-content").html("Error getting message: you either don't have permissions to access this message or this message no longer exists.");
			}
			else {
				var result = JSON.parse(response);
				var subject = result['subject'];
				var date = result['date'];
				var from = result['from'];
				var message = result['message'];
				
				$("#subject").html(subject);
				$("#destination").html("From: ");
				$("#date").html(date);
				$("#name").html(from);
				$("#message-content").html(message);				
			}
			
			$("#deleteBtn").css("display", "inline");
			anchor.find(".new-message").remove();
			$("#number-unread").load("queries/getNumberOfUnreadMessages.php");
			$("#all-messages").fadeOut(1000, function() { $("#selected-message").fadeIn(1000); });
		},
		error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus);
		   console.log(errorThrown);
        },
	});
}

function getMessageSent() {
	$.ajax({
		url: "queries/getMessageDetails.php",
		type: "get",
		data: {id: $(this).data("id"), mode: "sent"},
		success: function(response) 
		{
			if (response=="Error") {			
				$("#subject").html("Error getting subject");
				$("#destination").html("To: ");
				$("#date").html("");
				$("#name").html("-");
				$("#message-content").html("Error getting message: you either don't have permissions to access this message or this message no longer exists.");
			}
			else {
				var result = JSON.parse(response);
				var subject = result['subject'];
				var date = result['date'];
				var to = result['to'];
				var message = result['message'];
				
				$("#subject").html(subject);
				$("#destination").html("To: ");
				$("#date").html(date);
				$("#name").html(to);
				$("#message-content").html(message);				
			}
			
			$("#deleteBtn").css("display", "none");
			$("#sent-messages").fadeOut(1000, function() { $("#selected-message").fadeIn(1000); });
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

function switchMenu() {
	$(".box li.active").removeClass("active");
	$(this).parent().addClass("active");
	
	switch ($(this).attr("id")) {
		case "inbox":
			$("#selected-message, #sent-messages, #deleted-messages").fadeOut(1000).promise().done(function() { $("#all-messages").fadeIn(1000); });
			console.log("inbox");
			break;
		case "sent":
			$("#all-messages, #selected-message, #deleted-messages").fadeOut(1000).promise().done(function() { $("#sent-messages").fadeIn(1000); });
			console.log("sent");
			break;
		case "trash":
			$("#all-messages, #selected-message, #sent-messages").fadeOut(1000).promise().done(function() { $("#deleted-messages").fadeIn(1000); });
			console.log("trash");
	}
}

function updateUnread() {
	$("#number-unread").load("queries/getNumberOfUnreadMessages.php");
}