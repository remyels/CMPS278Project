<?php

include '../../connect/connectPDO.php';

session_start();

if (isset($_POST['commentid'])&&!empty($_POST['commentid'])) {
	$commentid = $db->quote($_POST['commentid']);
	$reacterid = $db->quote($_SESSION['LoggedInUserID']);
	$query = $db->prepare("SELECT * FROM reactcomment WHERE ReacterID = $reacterid AND CommentID = $commentid;");
	$query->execute();
	$numrows = $query->rowCount();
	
	if ($numrows==0) {
		// first time you react to this post
		$exec = $db->exec("INSERT INTO reactcomment VALUES($commentid, $reacterid, 1);");
		if ($exec)
			echo 1;
		else echo 0;
	}
	else {
		// you have already reacted to this post, so either already liked or already disliked
		$row = $query->fetch();
		
		if ($row['IsLike']==1) {
			// it was already a like, so now you are undoing the like
			$query = $db->exec("DELETE FROM reactcomment WHERE ReacterID = $reacterid AND CommentID = $commentid;");
			
			if ($query) {
				echo 2;
			}
			else {
				echo 0;
			}
		}
		else {
			// reaction found but it is a dislike
			$query = $db->exec("UPDATE reactcomment SET IsLike=1 WHERE ReacterID = $reacterid AND CommentID = $commentid;");
		
			if ($query) {
				echo 3;
			}
			else {
				echo 0;
			}
		}
	}
}
else {
	echo 0;
}