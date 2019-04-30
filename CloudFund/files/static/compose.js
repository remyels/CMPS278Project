$(document).ready(function() {
    $("#compose-textarea").wysihtml5();
	$("#compose-textarea, #inputSubject").change(checkSendBtn);
	$("#sendBtn").click(sendMsg);
});

function checkSendBtn() {			
	$("#send-icon").attr("class", "fa fa-paper-plane");
	$("#send-message").html("Send");
	$("#sendBtn").attr("class", "btn btn-primary");
	if ($("#compose-textarea").val()&&$("#inputSubject").val()) {
		$("#sendBtn").prop("disabled", false);
	}
}

function sendMsg() {
	$.ajax({
		url: "queries/sendMessage.php",
		type: "post",
		data: {to: $("#toUser option:selected").val(), subject: $("#inputSubject").val(), message: $("#compose-textarea").val(), datetime: moment().format("YYYY-MM-DD HH:mm:ss");},
		success: function(response) {
			if (response) {
				$("#sendBtn").prop("disabled", true);
				$("#compose-textarea").val("");
				$("#inputSubject").val("");
				$("#send-icon").attr("class", "fa fa-check");
				$("#send-message").html("Sent!");
				$("#sendBtn").attr("class", "btn btn-success");
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus);
		   console.log(errorThrown);
        },
	})
}