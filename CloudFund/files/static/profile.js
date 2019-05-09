$(document).ready(function() {
	$("#addFriendBtn").click(addFriend);
	$("a[id^='anchorlike']").click(likePost);
	$("a[id^='anchordislike']").click(dislikePost);
	$("a[id^='commentanchorlike']").click(likeComment);
	$("a[id^='commentanchordislike']").click(dislikeComment);
	$("textarea[id^='comment-content']").keyup(checkCommentBtn);
	$("button[id^='commentBtn']").click(insertComment);
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

function collapse(elem) {
	$("#"+$(elem).attr('id').replace("anchorcomment", "commentbox")).collapse("toggle");
}

function checkCommentBtn() {
	var postid = $(this).attr("id").replace("comment-content", "");
	if ($(this).val()) {
		$("#commentBtn"+postid).prop("disabled", false);
	}
	else {
		$("#commentBtn"+postid).prop("disabled", true);
	}
}

function insertComment() {
	var pid = $(this).attr("id").replace("commentBtn", "");
	var commentcontent = $("#comment-content"+pid).val();
	
	$.ajax({
		url: "queries/insertComment.php",
		type: "post",
		data: {postid: pid, content: commentcontent},
		success: function(response) {
			var result = JSON.parse(response);
			$("#comment-area"+pid).before($("<div class='well'><div class='media'><p class='text-left'><img width='30px' height='30px' src='"+result['ProfilePicture']+"'> "+result['FirstName']+" "+ result['LastName']+"</p><div class='media-body'><p class='undo'>"+result['Content']+"</p><ul class='text-left list-inline list-unstyled'><li><a id='commentanchorlike"+result['CommentID']+"'><i class='fa fa-thumbs-up'></i> Like (<span id='commentnumlikes" + result['CommentID']+"'>0</span>)</a></li><li>|</li><li><a id='commentanchordislike"+result['CommentID']+"'><i class='fa fa-thumbs-down'></i> Dislike (<span id='commentnumdislikes" + result['CommentID']+"'>0</span>)</a></li><li class='pull-right'>Posted on: "+result['CommentDate']+"</li></ul></div></div></div>"));
			$("#comment-content"+pid).val("");
			$("#commentBtn"+pid).prop("disabled", true);
			$("#numcomments"+pid).load("queries/getNumComments.php", {
				postid: pid,
			});
		}
	});
}

function likeComment() {
	var section = $(this);
	var id = $(this).attr("id").replace("commentanchorlike", "");
	$.ajax({
		url: "queries/likeComment.php",
		type: 'post',
		data: {commentid: id},
		success: function(response) {
			//console.log("php returned "+response);
			$("#commentnumlikes"+id).load("queries/getCommentReactions.php", {
				mode: "likes",
				commentid: id,
			});
			$("#commentnumdislikes"+id).load("queries/getCommentReactions.php", {
				mode: "dislikes",
				commentid: id, 
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
				console.log(response);
				//alert("Error, please refresh");
			}
		}
	});
}

function dislikeComment() {
	var section = $(this);
	var id = $(this).attr("id").replace("commentanchordislike", "");
	$.ajax({
		url: "queries/dislikeComment.php",
		type: 'post',
		data: {commentid: id},
		success: function(response) {
			//console.log("php returned "+response);
			$("#commentnumlikes"+id).load("queries/getCommentReactions.php", {
				mode: "likes",
				commentid: id,
			});
			$("#commentnumdislikes"+id).load("queries/getCommentReactions.php", {
				mode: "dislikes",
				commentid: id,
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
