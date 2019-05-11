$(document).ready(function() {
	updateUnread();
	$(".message-click").click(readMessage);
	$(".message-sent-click").click(getMessageSent);
	$("#backBtn").click(goBack);
	$(".folder").click(switchMenu);
	$("#deleteBtn").click(deleteMessage);
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
			$("#deleteBtn").data("id", anchor.data("id"));
			anchor.find(".new-message").css("visibility", "hidden");
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
	
	switchMenus($(this).attr("id"));
}

function switchMenus(id) {
	switch (id) {
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

function deleteMessage() {
	switchMenus("inbox");
	$.ajax({
		url: "queries/deleteMessage.php",
		type: "get",
		success: function(response) {
			var result = JSON.parse(response);			
			var firstname;
			var lastname;
			var subject;
			var date;
		
			$("#deleted-messages tbody").append("<tr id='"+dataid+"'><td><div class='icheckbox_flat-blue' aria-checked='false' aria-disabled='false' style='position: relative;'><input type='checkbox' style='position: absolute; opacity: 0;'><ins class='iCheck-helper' style='position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;'></ins></div></td><td class='mailbox-name notranslate'>From: "+firstname+" "+lastname+"</td><td class='mailbox-subject notranslate'><b>"+subject+"</b></td><td class='mailbox-attachment'></td><td class='mailbox-date'>"+date+"</td></tr>");
		}
	});
	var dataid = $(this).data("id");
	$("#"+dataid).remove();
	// after deletion check if empty
	if (!$("#all-messages tbody").html().trim()) {
		$("#all-messages tbody").append($("<tr><td class='mailbox-subject undo'>You have no messages</td></tr>"));
	}
	
	// we also need to add to trash; first, check if trash is empty
	if ($("#deleted-messages").find(".no-deleted")) {
		$(".no-deleted").remove();
	}
}