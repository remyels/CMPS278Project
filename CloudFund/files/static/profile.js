$(document).ready(function() {
	$("#addFriendBtn").click(addFriend);
	$("a[id^='anchorlike']").click(likePost);
	$("a[id^='anchordislike']").click(dislikePost);
	$("a[id^='anchorcomment']").click(commentPost);
	$('.nav-tabs a[href^="#panel-"]').click(hideComments);
});

function addFriend() {
	var btn = $(this);
	$.ajax({
		url: "queries/addFriend.php",
		type: "post",
		data: {id: $("#ProfileID").val()},
		success: function(response) {
			console.log(response);
			if (response) {
				btn.removeClass("btn-default");
				btn.addClass("btn-success");
				btn.prop("disabled", true);
				$("#addFriendBtn").html("<i class='fa fa-check'></i> Request sent");
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
			btn.removeClass("btn-default");
			btn.addClass("btn-danger");
			btn.prop("disabled", true);
			$("#addFriendBtn").html("Error");
		}
	});
}

function likePost() {
	var section = $(this);
	var id = $(this).attr("id").replace("anchorlike", "");
	$.ajax({
		url: "queries/likePost.php",
		type: 'post',
		data: {postid: id},
		success: function(response) {
			//console.log("php returned "+response);
			$("#numlikes"+id).load("queries/getPostReactions.php", {
				mode: "likes",
				postid: id,
			});
			$("#numdislikes"+id).load("queries/getPostReactions.php", {
				mode: "dislikes",
				postid: id,
			});
			if (response == 1) {
				// first time you react to this post
				section.addClass("clicked");
			}
			else if (response == 2) {
				// already reacted and it was a like, so you remove clicked
				section.removeClass("clicked");
				
			}
			else if (response == 3) {
				// already reacted and it was a dislike, so you remove the dislike and you add the like
				var dislikeanchor = $("#"+section.attr("id").replace("like", "dislike"));
				//console.log("should remove color from "+dislikeanchor.attr("id"));
				dislikeanchor.removeClass("clicked");
				section.addClass("clicked");
			}
			else {
				alert("Error, please refresh");
			}
		}
	});
}

function dislikePost() {
	var section = $(this);
	var id = $(this).attr("id").replace("anchordislike", "");
	$.ajax({
		url: "queries/dislikePost.php",
		type: 'post',
		data: {postid: id},
		success: function(response) {
			//console.log("php returned "+response);
			$("#numlikes"+id).load("queries/getPostReactions.php", {
				mode: "likes",
				postid: id,
			});
			$("#numdislikes"+id).load("queries/getPostReactions.php", {
				mode: "dislikes",
				postid: id,
			});
			if (response == 1) {
				// first time you react to this post
				section.addClass("clicked");
			}
			else if (response == 2) {
				// already reacted and it was a dislike, so you remove clicked
				section.removeClass("clicked");
				
			}
			else if (response == 3) {
				// already reacted and it was a like, so you remove the like and you add the dislike
				var likeanchor = $("#"+section.attr("id").replace("dislike", "like"));
				//console.log("should remove color from "+likeanchor.attr("id"));
				likeanchor.removeClass("clicked");
				section.addClass("clicked");
			}
			else {
				alert("Error, please refresh");
			}
		}
	});
}

function commentPost() {
	var id = $(this).attr("id").replace("anchorcomment", "");
	$('.nav-tabs a[href="#special-panel-123456"]').tab('show');
	$("#comments-tab").removeClass("hidden");
	$("#comments-tab").addClass("active");
}

function hideComments() {
	$("#comments-tab").addClass("hidden");
}