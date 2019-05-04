$(window).on('load',function(){
	$('#passwordResetModal').modal('show');
});

$(document).ready(function() {
	$("#resetPassword, #resetPasswordConfirm").keyup(checkReset);
	$("#resetPasswordBtn").prop('disabled', true);
	$("#resetPasswordBtn").click(resetPasswordSubmit);
});	

function checkReset() {
	if ($("#resetPassword").val() && $("#resetPassword").val()==$("#resetPasswordConfirm").val()) {
		$("#resetPasswordBtn").prop('disabled', false);
	}
	else {
		$("#resetPasswordBtn").prop('disabled', true);
	}
}

function resetPasswordSubmit() {
	$("#resetPasswordResult").load("queries/resetPasswordThroughEmail.php", {
		email: $("#resetEmail").val(),
		password: $("#resetPassword").val(),
		hash: $("#resetHash").val(),
	}, function() {
		$("#resetPasswordResult").attr("style", "");
		$("#resetPasswordResult").attr("style", "text-align: center;");
	});
	setInterval(function() { window.location = "index.php" }, 3000);
}

