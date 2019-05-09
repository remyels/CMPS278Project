<?php

include ("../../connect/connectPDO.php");

session_start();

if (isset($_POST['mode'])&&!empty($_POST['mode'])) {
	
}
else {
	// Plain post
	if (isset($_POST['statuscontent'])&&!empty($_POST['statuscontent'])&&isset($_POST['statuscontent'])&&!empty($_POST['statuscontent'])) {
		$userid = $db->quote($_SESSION['LoggedInUserID']);
		$privacy = $db->quote($_POST['privacy']);
		$time = $db->quote(date("Y-m-d H:i:s", strtotime("now + 3 hours")));
		$statuscontent = $db->quote($_POST['statuscontent']);
		
		$query = "INSERT INTO post(PostID, UserID, Type, LevelOfAccess, Content, DateTimeOfPost) VALUES(NULL, $userid, 1, $privacy, $statuscontent, $time)";
		$exec = $db->exec($query);
		
		if ($exec) {
			$query = $db->prepare("SELECT * from user WHERE UserID = $userid;");
			
			$query->execute();
			$row = $query->fetch();
			
			$result = array();
			
			$postid = $db->lastInsertId();
			$result['PostID'] = $postid;
			$result['FirstName'] = $row['FirstName'];
			$result['LastName'] = $row['LastName'];
			if ($row['ProfilePicture']=="") {
				$result['ProfilePicture'] = "static/images/emptyuser.jpg";
			}
			else {
				$result['ProfilePicture'] = $row['ProfilePicture'];
			}
			
			echo json_encode($result);
		}
	}
	else {
		echo 0;
	}
}
















?>