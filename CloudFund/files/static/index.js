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
		console.log("Uploading image");
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
				console.log(response);
				if (response) {
					//console.log(response);
					var result = JSON.parse(response);
					$("#posts").prepend($("<div class='col-md-12 column'><div class='container-fluid'><div class='well'><div class='media'><p class='text-left'><img width='30px' height='30px' src='"+result['ProfilePicture']+"'>"+result['FirstName']+" "+result['LastName']+"</p><div class='media-body'><img style='float: left; margin-right: 10px;' class='media-object' src='"+result['Image']+"'><p class='undo'>"+result['Content']+"</p></div><br /><div class='media-body'><ul style='clear: left;' class='list-inline list-unstyled'><li><a id='anchorlike"+result['PostID']+"'><i class='fa fa-thumbs-up'></i> Like (<span id='numlikes"+result['PostID']+"'>0</span>)</a></li><li>|</li><li><a id='anchordislike"+result['PostID']+"'><i class='fa fa-thumbs-down'></i> Dislike (<span id='numdislikes"+result['PostID']+"'>0</span>)</a></li><li>|</li><li><a onclick='collapse(this)' id='anchorcomment"+result['PostID']+"'><i class='fa fa-comments'></i> Comment (<span id='numcomments"+result['PostID']+"'>0</span>)</a></li><li class='pull-right'>Posted on: "+result['PostDate']+"</li></ul></div></div></div></div></div><div class='row clearfix'><div class='col-md-1'></div><div class='col-md-10 column'><div class='container-fluid'><div class='collapse' id='commentbox"+result['PostID']+"'><div id='comment-area"+result['PostID']+"' class='well'><div class='media'><p class='text-left'><strong>Add a comment</strong></p><div class='media-body'><textarea id='comment-content"+result['PostID']+"' class='form-control'></textarea><ul class='text-left list-inline list-unstyled'><li class='pull-right'><button id='commentBtn"+result['PostID']+"' style='margin: 10px;' class='btn btn-default' disabled><i class='fa fa-comment'></i> Comment</button></li></ul></div></div></div></div></div></div></div>"));
					
					$("#status-content").val("");
					$("#image").val("");
					
					$("#anchorlike"+result['PostID']).click(likePost);
					$("#anchordislike"+result['PostID']).click(dislikePost);
					$("#comment-content"+result['PostID']).keyup(checkCommentBtn);
					$("#commentBtn"+result['PostID']).click(insertComment);
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
		console.log("Uploading video");
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
					var result = JSON.parse(response);
					$("#posts").prepend($("<div class='col-md-12 column'><div class='container-fluid'><div class='well'><div class='media'><p class='text-left'><img width='30px' height='30px' src='"+result['ProfilePicture']+"'> "+result['FirstName']+" "+result['LastName']+"</p><div class='media-body'><video class='media-object' style='margin-bottom: 10px; margin-right: 10px; float: left;' width='320' height='240' controls><source src='"+result['Video']+"' type='video/mp4'>Your browser does not support the video tag.</video><p class='undo'>"+result['Content']+"</p><ul style='clear: left;' class='text-left list-inline list-unstyled'><li><a onclick='likePost(this)' id='anchorlike"+result['PostID']+"'><i class='fa fa-thumbs-up'></i> Like (<span id='numlikes"+result['PostID']+"'>0</span>)</a></li><li>|</li><li><a id='anchordislike"+result['PostID']+"'><i class='fa fa-thumbs-down'></i> Dislike (<span id='numdislikes"+result['PostID']+"'>0</span>)</a></li><li>|</li><li><a onclick='collapse(this)' id='anchorcomment"+result['PostID']+"'><i class='fa fa-comments'></i> Comment (<span id='numcomments"+result['PostID']+"'>0</span>)</a></li><li class='pull-right'>Posted on: "+result['PostDate']+"</li></ul></div></div></div></div><div class='row clearfix'><div class='col-md-1'></div><div class='col-md-10 column'><div class='container-fluid'><div class='collapse' id='commentbox"+result['PostID']+"'><div id='comment-area"+result['PostID']+"'class='well'><div class='media'><p class='text-left'><strong>Add a comment</strong></p><div class='media-body'><textarea id='comment-content"+result['PostID']+"' class='form-control'></textarea><ul class='text-left list-inline list-unstyled'><li class='pull-right'><button id='commentBtn"+result['PostID']+"' style='margin: 10px;' class='btn btn-default' disabled><i class='fa fa-comment'></i> Comment</button></li></ul></div></div></div></div></div></div></div>"));
					
					$("#status-content").val("");
					$("#video").val("");
					
					$("#anchorlike"+result['PostID']).click(likePost);
					$("#anchordislike"+result['PostID']).click(dislikePost);
					$("#comment-content"+result['PostID']).keyup(checkCommentBtn);
					$("#commentBtn"+result['PostID']).click(insertComment);
					
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
		console.log("Uploading status");
		$.ajax({
			url: "queries/postStatus.php",
			type: 'post',
			data: {statuscontent: $("#status-content").val(), privacy: $("input[name='privacy']:checked").val()},	
			success: function(response) {
				if (response) {
					//console.log(response);
					var result = JSON.parse(response);
					$("#posts").prepend($("<div class='col-md-12 column'><div class='container-fluid'><div class='well'><div class='media'><p class='text-left'><img width='30px' height='30px' src='"+result['ProfilePicture']+"'> "+result['FirstName']+" "+result['LastName']+"</p><div class='media-body'><p class='undo'>"+result['Content']+"</p><ul class='text-left list-inline list-unstyled'><li><a onclick='likePost(this)' id='anchorlike"+result['PostID']+"'><i class='fa fa-thumbs-up'></i> Like (<span id='numlikes"+result['PostID']+"'>0</span>)</a></li><li>|</li><li><a id='anchordislike"+result['PostID']+"'><i class='fa fa-thumbs-down'></i> Dislike (<span id='numdislikes"+result['PostID']+"'>0</span>)</a></li><li>|</li><li><a onclick='collapse(this)' id='anchorcomment"+result['PostID']+"'><i class='fa fa-comments'></i> Comment (<span id='numcomments"+result['PostID']+"'>0</span>)</a></li><li class='pull-right'>Posted on: "+result['PostDate']+"</li></ul></div></div></div></div><div class='row clearfix'><div class='col-md-1'></div><div class='col-md-10 column'><div class='container-fluid'><div class='collapse' id='commentbox"+result['PostID']+"'><div id='comment-area"+result['PostID']+"'class='well'><div class='media'><p class='text-left'><strong>Add a comment</strong></p><div class='media-body'><textarea id='comment-content"+result['PostID']+"' class='form-control'></textarea><ul class='text-left list-inline list-unstyled'><li class='pull-right'><button id='commentBtn"+result['PostID']+"' style='margin: 10px;' class='btn btn-default' disabled><i class='fa fa-comment'></i> Comment</button></li></ul></div></div></div></div></div></div></div>"));
					
					$("#status-content").val("");
					
					// attach handlers to what we inserted
					$("#anchorlike"+result['PostID']).click(likePost);
					$("#anchordislike"+result['PostID']).click(dislikePost);
					$("#comment-content"+result['PostID']).keyup(checkCommentBtn);
					$("#commentBtn"+result['PostID']).click(insertComment);
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
	if ($("#status-content").val() || $("#image").val() || $("#video").val()) {
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