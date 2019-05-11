window.onload = function() {
    $("#loginBtn").prop("disabled", true);
    $("#signUpBtn").prop("disabled", true);
	$("#forgotPassword").click(forgotPassword);
	$("#postStatus").click(postStatus);
	$("#status-content, #image, #video").on("change input", checkPostBtn);
	$("#image, #video").on("change input", deleteOtherMediaType);
};

$("#inputEmailAddress, #inputPassword").keyup(function() {
	checkLogin();
});

$("#inputSignUpFirstName, #inputSignUpLastName, #inputSignUpEmailAddress, #inputSignUpPassword, #inputSignUpRepeatPassword").keyup(function() {
	checkSignUp();
});

function checkLogin() {
    if ($("#inputEmailAddress").val()&&$("#inputPassword").val()&&validEmail($("#inputEmailAddress").val())) {
        $("#loginBtn").prop("disabled", false);
    }
    else {
        $("#loginBtn").prop("disabled", true);
    }
}

function checkSignUp() {
    if ($("#inputSignUpFirstName").val()&&$("#inputSignUpLastName").val()&&$("#inputSignUpEmailAddress").val()&&validEmail($("#inputSignUpEmailAddress").val())&&$("#inputSignUpRepeatPassword").val()&&$("#inputSignUpRepeatPassword").val()==$("#inputSignUpPassword").val())
    {
        $("#signUpBtn").prop("disabled", false);
    }
    else {
        $("#signUpBtn").prop("disabled", true);
    }
}

function validEmail(email) {
    let pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(email);
}

function forgotPassword() {
	$(this).css("display", "none");
	$("#login-password-form-group").remove();
	//$("#loginModal form-group input").attr("placeholder", "Email address associated with your account")
	$("#loginBtn").off("click");
	$("#loginBtn").click(resetPassword);
	$("#loginBtn").html("Reset");
}

function resetPassword() {
	$("#loginResult").load("queries/resetEmail.php", { 
		email: $("#inputEmailAddress").val(),
	});
}

function uploadMedia(btn) {
	var inputid = $(btn).attr("id").replace("upload-", "");
	$("input[id='"+inputid+"']").click();
}

function postStatus() {
	if ($("#image").val()) {
		var fd = new FormData();
		var files = $("#image")[0].files[0];
		fd.append('file', files);
		
		fd.append('status', $("#status-content").val());
		fd.append('mode', 'image');
		fd.append('privacy', $("input[name='privacy']:checked").val());
		
		$.ajax({
			url: "queries/postStatus.php",
			type: 'post',
			data: fd,	
			processData: false,
			contentType: false,
			success: function(response) {
				if (response) {
					console.log(response);
					
					// prepend $("sadsa:first")
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
	else if ($("#video").val()) {
		var fd = new FormData();
		var files = $("#video")[0].files[0];
		fd.append('file', files);
		
		fd.append('status', $("#status-content").val());
		fd.append('mode', 'video');
		fd.append('privacy', $("input[name='privacy']:checked").val());
		
		$.ajax({
			url: "queries/postStatus.php",
			type: 'post',
			data: fd,	
			processData: false,
			contentType: false,
			success: function(response) {
				if (response) {
					console.log(response);
					
					
					
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
	else {
		$.ajax({
			url: "queries/postStatus.php",
			type: 'post',
			data: {statuscontent: $("#status-content").val(), privacy: $("input[name='privacy']:checked").val()},	
			success: function(response) {
				if (response) {
					// here, post should be prepended
					
					alert(response);
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
}

function checkPostBtn() {
	if ($("#status-content").val() || $("#image").val()) {
		$("#postStatus").removeClass("disabled");
	}
	else {
		$("#postStatus").addClass("disabled");	
	}
}

function deleteOtherMediaType() {
	if ($("#image").val()) {
		$("#video").val("");
	}
	else {
		$("#image").val("");
	}
}