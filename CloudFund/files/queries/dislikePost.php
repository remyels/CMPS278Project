<?php

include '../../connect/connectPDO.php';

session_start();

if (isset($_POST['postid'])&&!empty($_POST['postid'])) {
	$postid = $db->quote($_POST['postid']);
	$reacterid = $db->quote($_SESSION['LoggedInUserID']);
	$query = $db->prepare("SELECT * FROM reactpost WHERE ReacterID = $reacterid AND PostID = $postid;");
	$query->execute();
	$numrows = $query->rowCount();
	
	if ($numrows==0) {
		// first time you react to this post
		$exec = $db->exec("INSERT INTO reactpost VALUES($reacterid, $postid, 0);");
		if ($exec)
			echo 1;
		else echo 0;
	}
	else {
		// you have already reacted to this post, so either already liked or already disliked
		$row = $query->fetch();
		
		if ($row['IsLike']==0) {
			// it was already a dislike, so now you are undoing the dislike
			$query = $db->exec("DELETE FROM reactpost WHERE ReacterID = $reacterid AND PostID = $postid;");
			
			if ($query) {
				echo 2;
			}
			else {
				echo 0;
			}
		}
		else {
			// reaction found but it is a like
			$query = $db->exec("UPDATE reactpost SET IsLike=0 WHERE ReacterID = $reacterid AND PostID = $postid;");
		
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