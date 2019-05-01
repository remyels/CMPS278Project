$(document).ready(function() {
	checkIfPosted();
    $("#compose-textarea").wysihtml5();
	$("#inputSubject").bind('change keyup', checkSendBtn);
	$("#sendBtn").click(sendMsg);
});

function checkSendBtn() {
	$("#send-icon").attr("class", "fa fa-paper-plane");
	$("#send-message").html(" Send");
	$("#sendBtn").attr("class", "btn btn-primary");
	if ($("#toUser option:selected").val()&&$("#inputSubject").val()) {
		$("#sendBtn").prop("disabled", false);
	}
	else {
		$("#sendBtn").prop("disabled", true);
	}
}

function sendMsg() {
	$.ajax({
		url: "queries/sendMessage.php",
		type: "post",
		data: {to: $("#toUser option:selected").val(), subject: $("#inputSubject").val(), message: $("#compose-textarea").val(), datetime: moment().format("YYYY-MM-DD HH:mm:ss")},
		success: function(response) {
			if (response) {
				$("#sendBtn").prop("disabled", true);
				$("#inputSubject").val("");
				$("#send-icon").attr("class", "fa fa-check");
				$("#send-message").html(" Sent!");
				$("#sendBtn").attr("class", "btn btn-success");
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus);
		   console.log(errorThrown);
        },
	})
}

function checkIfPosted() {
	if ($("#PostedUserID").val()) {
		$("#toUser").val($("#PostedUserID").val());
	}
}