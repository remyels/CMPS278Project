$(document).ready(function() {
	$(function() {
		$('input[type=file]').change(function(){
			var t = $(this).val();
			var labelText = 'File : ' + t.substr(12, t.length);
			$(this).prev('label').text(labelText);
		})
	});
	$("#profile-picture").css("height", 100);
	$("#profile-picture").css("width", 100);
	$("#accountEmail, #accountPersonalInformation, #accountProfessionalInformation, #accountPassword").change(checkUpdateButton);
	$("#uploadProfileBtn").click(uploadImage);
	$("#deleteProfileBtn").click(deleteImage);
});

function checkUpdateButton() {
	if ($("#accountEmail").val()&&$("#accountPassword").val()&&$("#accountPassword").val()) {
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

function uploadImage() {
	var fd = new FormData();
	var files = $("#pic")[0].files[0];
	fd.append('file', files);
	
	$.ajax({
		url: 'queries/uploadProfile.php',
		type: 'post',
		data: fd,	
		processData: false,
		contentType: false,
		success: function(response) {
			if (response) {
				document.location.reload();
			}
			else {
				alert("Failed to upload, please try again!");
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus);
		   console.log(errorThrown);
        },
	});
}

function deleteImage() {
	if ($("#profile-picture").hasClass("haspic")) 
	{
		$.ajax({
		url: 'queries/deleteProfile.php',
		type: 'post',
		data: {id : $("#userid").val()},
		success: function(response) {
			if (response) {
				document.location.reload();
			}
			else {
				alert("Failed to delete, please try again!");
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus);
		   console.log(errorThrown);
        },
	});
	}
}