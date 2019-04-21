$(document).ready(function() {
	$("#accountEmail, #accountPersonalInformation, #accountProfessionalInformation, #accountPassword, #accountConfirmPassword").change(checkUpdateButton);
});

function checkUpdateButton() {
	if ($("#accountEmail").val()&&$("#accountPassword").val()&&$("#accountPassword").val()==$("#accountConfirmPassword").val()) {
		$("#accountUpdateBtn").prop("disabled", false);
	}
	else {
		$("#accountUpdateBtn").prop("disabled", true);
	}
}

function updateAccount() {
	console.log("OK");
	$("#accountSubmitResult").load("queries/updateAccount.php", {
		id: $("#accountID").val(),
		email: $("#accountEmail").val(),
		password: $("#accountPassword").val(),
		personalinformation: $("#accountPersonalInformation").val(),
		professionalinformation: $("#accountProfessionalInformation").val(),
	});
	$("#accountSubmitResult").css("visibility", "visible");
}